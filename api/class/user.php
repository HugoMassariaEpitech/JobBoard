<?php
class User {
    // Connection
    private $connection;
    // Columns
    public $id_user;
    public $user_name;
    public $user_password;
    public $user_email;
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
        $result = $user -> fetchAll();
        if (empty($result)) {
            $newUser = $this->connection->prepare("INSERT INTO users (id_user, user_name, user_password, user_email) VALUES (NULL, ?, ?, ?)");
            $newUser->bindParam(1, htmlspecialchars(strip_tags($this->user_name)));
            $newUser->bindParam(2, htmlspecialchars(strip_tags($this->user_password)));
            $newUser->bindParam(3, htmlspecialchars(strip_tags($this->user_email)));
            if($newUser->execute()){
                return true;
            }
            return false;
        } else {
            return "Email already used.";
        }
    }
    // LogIn User
    public function logInUser(){
        if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
            // Check if the user is already logged in, if yes then redirect him to welcome page
        } else {
            $user = $this->connection->prepare("SELECT id_user, user_name, admin FROM users WHERE user_name = ?");
            $user->bindParam("1", $this->user_name);
            $user->execute();
            $result = $user -> fetchAll();
            return json_encode($result);
        }
    }
}
?>