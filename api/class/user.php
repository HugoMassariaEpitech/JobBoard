<?php
class Advertisement {
    // Connection
    private $connection;
    // Columns
    public $id_user;
    public $user_name;
    public $admin;
    // Database connection
    public function __construct($config){
        $this->connection = $config;
    }
    // Read all advertisements
    public function logInUser(){
        session_start();
        if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
            // Check if the user is already logged in, if yes then redirect him to welcome page
        } else {

        }
    }
}
?>