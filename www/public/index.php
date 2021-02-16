<?php

$loader = require __DIR__ . '/../vendor/autoload.php';

session_start();

use Controller\AuthenticationController;
use Controller\UserController;
use Service\AuthenticationService;

if ($_GET['controller'] == 'auth') {
    $authController = new AuthenticationController();

    if ($_GET['action'] == 'login') {
        $authController->userLogin();
    }

    if ($_GET['action'] == 'logout') {
        $authController->userLogout();
    }
}

if ($_GET['controller'] == 'user') {
    $authService = new AuthenticationService();

    if (!$authService->canAccessSite()) {
        header('HTTP/1.0 403 Permission denied');

        return;
    }

    $userController = new UserController();

    if ($_GET['action'] == 'list') {
        $userController->list();
    }

    if ($_GET['action'] == 'create') {
        $userController->create();
    }

    if ($_GET['action'] == 'show') {
        $userController->show();
    }

    if ($_GET['action'] == 'delete') {
        $userController->delete();
    }
}

if (empty($_GET['controller']) || empty($_GET['action'])) {
    header('HTTP/1.0 404 Not Found');
}

