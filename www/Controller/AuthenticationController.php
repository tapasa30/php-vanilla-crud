<?php

namespace Controller;

use Service\AuthenticationService;
use Service\TemplateService;

class AuthenticationController {

	private $authService;
    private $templateService;

	public function __construct() {
		$this->authService = new AuthenticationService();
        $this->templateService = new TemplateService();
	}

	public function userLogin() {
	    if ($this->authService->canAccessSite()) {
            return header('Location: index.php?controller=user&action=list');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            return $this->templateService->renderTemplate(
                'authentication/loginForm.php',
                'Login',
                [
                    'error' => isset($_GET['error'])
                ]
            );
        }

        $email = $_POST['email'];
        $password = $_POST['password'];

		if (!$this->authService->login($email, $password)) {
		    return header('Location: index.php?controller=auth&action=login&error=true');
		}

        return header('Location: index.php?controller=user&action=list');
	}

	public function userLogout() {
        $this->authService->deleteSession();

        return header('Location: index.php?controller=auth&action=login');
	}
}