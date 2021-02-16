<?php

namespace Service;

use Model\User;

class AuthenticationService {

    public function login($email, $originalPassword): bool {
        $userService = new UserService();

        $userId = $userService->getUserIdByLoginData($email, $originalPassword);
		if (!$userId) {
			return false;
		}

        $this->setSession($userService->getUserObjectById($userId));

		return true;
	}

	public function setSession(User $user): void {
        $_SESSION['user'] = $user;
	}

    public function deleteSession(): void {
        unset($_SESSION['user']);
    }

    public function canAccessSite(): bool {
        return !empty($_SESSION['user']) && $_SESSION['user'] instanceof User;
    }
}
