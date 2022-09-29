<?php
class User {
    // Connection
    private $connection;
    // Columns
    public $id_user;
    public $user_name;
    public $user_firstname;
    public $user_password;
    public $user_email;
    public $user_phone;
    public $user_birthdate;
    public $user_civility;
    // Database connection
    public function __construct($config){
        $this->connection = $config;
    }
    // Register User
    public function registerUser(){
        session_start();
        $user = $this->connection->prepare("SELECT * FROM users WHERE user_email = ?");
        $user->bindParam("1", $this->user_email);
        $user->execute();
        $result = $user->fetchAll();
        if (empty($result)) {
            $newUser = $this->connection->prepare("INSERT INTO users (id_user, user_name, user_password, user_email, user_phone, user_birthdate, user_civility, user_firstname) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?)");
            $newUser->bindParam(1, htmlspecialchars(strip_tags($this->user_name)));
            $newUser->bindParam(2, htmlspecialchars(strip_tags(password_hash($this->user_password, PASSWORD_BCRYPT))));
            $newUser->bindParam(3, htmlspecialchars(strip_tags($this->user_email)));
            $newUser->bindParam(4, htmlspecialchars(strip_tags($this->user_phone)));
            $newUser->bindParam(5, htmlspecialchars(strip_tags($this->user_birthdate)));
            $newUser->bindParam(6, htmlspecialchars(strip_tags($this->user_civility)));
            $newUser->bindParam(7, htmlspecialchars(strip_tags($this->user_firstname)));
            $newUser->execute();
            echo var_dump($newUser);    
            return "User created.";
        } else {
            return "Email already used.";
        }
    }
    // LogIn User
    public function logInUser() {
        session_start();
        $user = $this->connection->prepare("SELECT * FROM users WHERE user_email = ?");
        $user->bindParam("1", $this->user_email);
        $user->execute();
        $result = $user->fetch();
        if (empty($result)) {
            return false;
        } else {
            if (password_verify($this->user_password, $result["user_password"])) {
                $_SESSION["id_user"] = $result["id_user"];
                $_SESSION["user_name"] = $result["user_name"];
                $_SESSION["logIn"] = true;
                return true;
            } else {
                return false;
            }
        }
    }
}
?>