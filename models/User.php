<?php

class User {
    private $name, $email, $expertise, $password;

    public function __construct(string $name, string $email, string $expertise, string $password, string $conf_password) {
        $this->password = $this->processPassword($password, $conf_password);
        $this->name = $name;
        $this->email = $email;
        $this->expertise = $expertise;
    }

    public function store() {
        $sql = "INSERT INTO teachers (name, email, expertise, password) VALUES (?, ?, ?, ?)";
        $values = array($this->name, $this->email, $this->expertise, $this->password);

        (new DB())->store($sql, $values);
    }

    public static function getById($id) {
        $sql = "SELECT FROM teachers (name, email, expertise) WHERE id = ?";
        $values = array($id);

        return (new DB())->select($sql, $values);
    }

    public static function getByEmail($email) : array {
        $sql = "SELECT * FROM teachers WHERE email = ?";
        $values = array($email);

        return (new DB())->select($sql, $values);
    }

    public static function verifyCredentials(string $email, string $password): array {
        $user = User::getByEmail($email);

        $isCorrect = password_verify($password, $user["password"]);

        if (!$isCorrect) {
            throw new InvalidCredentialsError();
        }

        return $user;
    }

    private function verifyPasswordPattern(string $password) {
        $regex = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$/";

        if (!preg_match($regex, $password)) {
            throw new InvalidPasswordError();
        }
    }

    private function hashPassword(string $password): string {
        $hashedPassword = password_hash($password, PASSWORD_ARGON2I);
        $isCorrect = password_verify($password, $hashedPassword);

        if (!$isCorrect) {
            throw new HashingPasswordError();
        }

        return $hashedPassword;
    }

    private function processPassword(string $password, string $confpassword): string {
        if ($password !== $confpassword) {
            throw new PasswordMismatchError();
        }

        $this->verifyPasswordPattern($password);

        return $this->hashPassword($password);
    }

}
