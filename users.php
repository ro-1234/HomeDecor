<?php

class Users {
    private $conn;
    private $table = "users";

    public function __construct($db){
        $this->conn = $db;
    }

    // =========================
    // REGISTER USER
    // =========================
    public function register($name, $username, $email, $password){

        // check if username or email exists
        $check = "SELECT id FROM {$this->table} 
                  WHERE username = :username OR email = :email 
                  LIMIT 1";

        $stmt = $this->conn->prepare($check);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        if($stmt->fetch()){
            return "User already exists";
        }

        // insert user
        $query = "INSERT INTO {$this->table}
                  (name, username, email, password, role)
                  VALUES
                  (:name, :username, :email, :password, :role)";

        $stmt = $this->conn->prepare($query);

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $role = "user";

        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":password", $hashedPassword);
        $stmt->bindParam(":role", $role);

        if($stmt->execute()){
            return "success";
        }

        return "error";
    }

    // =========================
    // LOGIN USER
    // =========================
    public function login($username, $password){

        $query = "SELECT * FROM {$this->table} 
                  WHERE username = :username OR email = :username 
                  LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":username", $username);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if($user && password_verify($password, $user['password'])){

            // session (start outside file ideally)
            if(session_status() === PHP_SESSION_NONE){
                session_start();
            }

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            return "success";
        }

        return "error";
    }

}