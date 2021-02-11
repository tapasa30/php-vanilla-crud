<?php

namespace Model;

class User {
	private $id;

	private $name;

	private $password;

	private $email;

	public function getId() {
	    return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

	public function getEmail() {
	    return $this->email;
    }

	public function setEmail($email) {
	    $this->email = $email;
    }

	public function getName() {
	    return $this->name;
    }

	public function setName($name) {
	    $this->name = $name;
    }

	public function getPassword() {
	    return $this->password;
    }

	public function setPassword($password) {
	    $this->password = $password;
    }
}
