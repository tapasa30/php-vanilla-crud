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
        $templatePath = dirname(__DIR__) . '/Templates/' . $template;

        if (!file_exists($templatePath)) {
            return false;
        }

        $canAccessSite = $this->authService->canAccessSite();

        ob_start();
        require_once($templatePath);
        $templateContent = ob_get_contents();
        ob_end_clean();

        return require_once(dirname(__DIR__) . '/Templates/base/baseTemplate.php');
    }
}
