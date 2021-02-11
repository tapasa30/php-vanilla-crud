<?php

namespace Service;

class TemplateService
{
    private $authService;

    public function __construct()
    {
        $this->authService = new AuthenticationService();
    }

    public function renderTemplate($template, $pateTitle, $data = []) {
        $templatePath = '../Templates/' . $template;

        if (!file_exists($templatePath)) {
            return false;
        }

        $canAccessSite = $this->authService->canAccessSite();

        ob_start();
        include ($templatePath);
        $templateContent = ob_get_contents();
        ob_end_clean();

        return include('../Templates/base/baseTemplate.php');
    }
}
