<?php

require_once("../database/DB.php");
require_once("../errors/DatabaseQueryError.php");
require_once("../errors/HashingPasswordError.php");
require_once("../errors/InvalidPasswordError.php");
require_once("../errors/PasswordMismatchError.php");

class User {
  private $name, $email, $expertise, $password;

  public function __construct(string $name, string $email, string $expertise, string $password, string $conf_password) {
      $this->password = $this->processPassword($password, $conf_password);
      $this->name = $name;
      $this->email = $email;
      $this->expertise = $expertise;
  }
  
public function store() {
    $connection = (new DB())->getConnection();
    $sql = "INSERT INTO teachers (name, email, expertise, password) VALUES (?, ?, ?, ?)";

	$stmt = $connection->prepare($sql);
	$result  = $stmt->execute([$this->name, $this->email, $this->expertise, $this->password]);
			
	if(!$result) {
		throw new DatabaseQueryError();
	}
}

    public function getById($id) {
        $connection = (new DB())->getConnection();
        $sql = "SELECT FROM teachers (name, email, expertise) WHERE id = ?";

        $stmt = $conn->prepare($sql);
    	$result  = $stmt->execute($id);
    			
    	if(!$result) {
    		throw new DatabaseQueryError();
    	}
    }


  private function verifyPasswordPattern(string $password) {
 	$regex = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$/";
	
	if(!preg_match($regex, $password)) {
        throw new InvalidPasswordError();
	}
 }

 private function hashPassword(string $password) : string {
 	$hashedPassword = password_hash($password, PASSWORD_ARGON2I);
 	$isCorrect = password_verify($password, $hashedPassword);

 	if(!$isCorrect) {
 		throw new HashingPasswordError();
 	}

 	return $hashedPassword;
 }

 private function processPassword(string $password, string $confpassword) : string {
 	if($password !== $confpassword) {
 		throw new PasswordMismatchError();
 	}

 	$this->verifyPasswordPattern($password);

 	return $this->hashPassword($password);
 }

}