<?php

$loader = require __DIR__ . '/../vendor/autoload.php';

session_start();

use Controller\AuthenticationController;
use Controller\UserController;
use Service\AuthenticationService;

if (empty($_GET['controller']) || empty($_GET['action'])) { // or method
    header("HTTP/1.0 404 Not Found");

    return;
}

if ($_GET['controller'] == 'auth') {
    $authController = new AuthenticationController();

    if ($_GET['action'] == 'login') {
        return $authController->userLogin();
    }

    if ($_GET['action'] == 'logout') {
        return $authController->userLogout();
    }
}

if ($_GET['controller'] == 'user') {
    $authService = new AuthenticationService();

    if (!$authService->canAccessSite()) {
        header("HTTP/1.0 403 Permission denied");

        return;
    }

    $userController = new UserController();

    if ($_GET['action'] == 'list') {
        return $userController->list();
    }

    if ($_GET['action'] == 'create') {
        return $userController->create();
    }

    if ($_GET['action'] == 'show') {
        return $userController->show();
    }

    if ($_GET['action'] == 'delete') {
        return $userController->delete();
    }
}

header("HTTP/1.0 404 Not Found");
