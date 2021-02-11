<?php

namespace Controller;

use Service\AuthenticationService;
use Service\TemplateService;
use Service\UserService;

class UserController
{

    private $userService;
    private $authService;
    private $templateService;

    public function __construct()
    {
        $this->userService = new UserService();
        $this->authService = new AuthenticationService();
        $this->templateService = new TemplateService();
    }

    public function list()
    {
        $users = $this->userService->getAllUsers();

        return $this->templateService->renderTemplate(
            'user/list.php',
            'Users list',
            [
                'users' => $users,
                'error' => $_GET['error'] ?? null
            ]
        );
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            return $this->templateService->renderTemplate(
                'user/show.php',
                'Add user',
                [
                    'formMode' => 'create'
                ]
            );
        }

        $userData = [
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'password' => $_POST['password'],
        ];

        return $this->userService->createUser($userData)
            ? header('Location: index.php?controller=user&action=list')
            : header("Refresh:0")
        ;
    }

    public function show()
    {
        $userId = $_GET['userId'];

        if (!$userId) {
            return false;
        }

        if ($userId === $_SESSION['user']->getId()) {
            return header('Location: index.php?controller=user&action=list&error=sameUser');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $userObject = $this->userService->getUserObjectById($userId);

            return $this->templateService->renderTemplate(
                'user/show.php',
                '',
                [
                    'user' => $userObject,
                    'formMode' => 'edit',
                ]
            );
        }

        $userUpdated = $this->userService->updateUser($userId, [
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'password' => $this->userService->encryptPassword($_POST['password']),
        ]);

        return $userUpdated ? header('Location: index.php?controller=user&action=list') : header("Refresh:0");
    }

    public function delete()
    {
        $usersIds = $_POST['users'] ? json_decode($_POST['users']) : null;

        if (empty($usersIds)) {
            return false;
        }

        foreach ($usersIds as $userId) {
            $this->userService->deleteUser($userId);
        }

        return true;
    }
}