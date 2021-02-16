<?php

namespace Service;

use Model\User;

class UserService {

	private $databaseService;
	private $pagerService;

	public function __construct() {
		$this->databaseService = new DatabaseService();
		$this->pagerService = new PagerService();
	}

	public function getUsersWithPagination(int $itemsPerPage, int $currentPage, string $baseUrl): array {
        $users = [];
        $allUsersQuery = sprintf('SELECT id, email, name FROM user ORDER BY id LIMIT %s, %s', (($currentPage - 1) * $itemsPerPage), $itemsPerPage);
        $usersData = $this->databaseService->query($allUsersQuery);

        if (!empty($usersData)) {
            $users = array_map(function($userData) {
                return $this->getUserObject($userData);
            }, $usersData);
        }

        $totalUsersCount = $this->getTotalUsers();

        return [
            'users' => $users,
            'pager' => $this->pagerService->buildPagination($itemsPerPage, $currentPage, ceil($totalUsersCount / $itemsPerPage), $baseUrl)
        ];
    }

    public function createUser($userData): ?bool {
        $encryptedPassword = $this->encryptPassword($userData['password']);
        $createUserQuery = sprintf(
            'INSERT INTO user (name, email, password) VALUES (\'%s\', \'%s\', \'%s\')',
            $userData['name'], $userData['email'], $encryptedPassword);

        return $this->databaseService->query($createUserQuery);
    }

    public function updateUser(int $userId, array $newData): ?bool {
        $updateUserQuery = sprintf(
            'UPDATE user set name=\'%s\', email=\'%s\', password=\'%s\' WHERE id = \'%s\'',
            $newData['name'], $newData['email'], $newData['password'], $userId
        );

        return $this->databaseService->query($updateUserQuery);
    }

    public function deleteUser($id): bool {
        $removeUserQuery = "DELETE FROM user WHERE id = $id";

        return $this->databaseService->query($removeUserQuery);
    }

    public function getTotalUsers() {
        $allUsersQuery = sprintf('SELECT COUNT(*) as totalUsers FROM user');
        $usersData = $this->databaseService->query($allUsersQuery);

        return $usersData ? $usersData[0]['totalUsers'] : 0;
    }

	public function getUserIdByLoginData(string $email, string $originalPassword): ?int {
		$encryptedPassword = $this->encryptPassword($originalPassword);
		$userExistsQuery = sprintf('SELECT id FROM user WHERE email = \'%s\' AND password = \'%s\'', $email, $encryptedPassword);

		return $this->databaseService->query($userExistsQuery)[0]['id'] ?? null;
	}

	public function getUserObjectById($id): ?User {
        $userQuery = "SELECT * FROM user WHERE id = $id";

        $userData = $this->databaseService->query($userQuery)[0] ?? null;
        if (empty($userData)) {
            return null;
        }

        return $this->getUserObject($userData);
	}

	private function getUserObject($userData): ?User {
        $user = new User();

        $user->setId($userData['id']);
        $user->setName($userData['name']);
        $user->setEmail($userData['email']);

        return $user;
    }

	public function encryptPassword($originalPassword): string {
		return md5($originalPassword);
	}
}
