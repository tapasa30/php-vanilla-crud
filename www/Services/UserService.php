<?php

namespace Service;

use Model\User;

class UserService {

	private $databaseService;

	public function __construct() {
		$this->databaseService = new DatabaseService();
	}

	public function getAllUsers(): array {
        $users = [];
        $allUsersQuery = 'SELECT id, email, name FROM user';
        $usersData = $this->databaseService->query($allUsersQuery);

        if (!empty($usersData)) {
            $users = array_map(function($userData) {
                return $this->getUserObject($userData);
            }, $usersData);
        }

        return $users;
    }

    public function createUser($userData) {
        $encryptedPassword = $this->encryptPassword($userData['password']);
        $createUserQuery = sprintf(
            'INSERT INTO user (name, email, password) VALUES (\'%s\', \'%s\', \'%s\')',
            $userData['name'], $userData['email'], $encryptedPassword);

        return $this->databaseService->query($createUserQuery);
    }

    public function updateUser(int $userId, array $newData): bool {
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
