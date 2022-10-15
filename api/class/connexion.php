<?php
class Connexion {
    // Connection
    private $connection;
    // Columns
    public $id_user;
    public $user_civility;
    public $user_firstname;
    public $user_name;
    public $user_birthdate;
    public $user_phone;
    public $user_email;
    public $user_password;
    // Database connection
    public function __construct($config) {
        $this->connection = $config;
    }
    // LogIn
    public function logIn() {
        $user = $this->connection->prepare("SELECT * FROM users WHERE user_email = ?");
        $user->bindParam("1", $this->user_email);
        if ($user->execute()) {
            $result = $user->fetch();
            if (empty($result)) {
                return array("response" => false);
            } else {
                if (password_verify($this->user_password, $result["user_password"])) {
                    $header = json_encode(["tokenType" => "JWT", "algorithm" => "HS256"]);
                    $payload = json_encode(["id_user" => $result["id_user"], "user_firstname" => $result["user_firstname"], "user_name" => $result["user_name"], "user_birthdate" => $result["user_birthdate"], "user_phone" => $result["user_phone"], "user_email" => $result["user_email"], "admin" => $result["admin"]]);
                    $base64UrlHeader = str_replace(["+", "/", "="], ["-", "_", ""], base64_encode($header));
                    $base64UrlPayload = str_replace(["+", "/", "="], ["-", "_", ""], base64_encode($payload));
                    $signature = hash_hmac("sha256", $base64UrlHeader . "." . $base64UrlPayload, "90zgLEniSbKFrV6OJjVa825KcTI1JC7m", true);
                    $base64UrlSignature = str_replace(["+", "/", "="], ["-", "_", ""], base64_encode($signature));
                    $JWT = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
                    return array("response" => true, "result" => $JWT, "admin" => $result["admin"]);
                } else {
                    return array("response" => true);
                }
            }
        } else {
            return array("response" => false);
        }
    }
    // Check Log
    public function checkLog() {
        if (isset($_COOKIE["token"])) {
            $tokenParts = explode(".", $_COOKIE["token"]);
            $payload = json_decode(base64_decode($tokenParts[1]));
            $signature = hash_hmac("sha256", $tokenParts[0] . "." . $tokenParts[1], "90zgLEniSbKFrV6OJjVa825KcTI1JC7m", true);
            $base64UrlSignature = str_replace(["+", "/", "="], ["-", "_", ""], base64_encode($signature));
            if ($base64UrlSignature == $tokenParts[2]) {
                if (get_object_vars($payload)["admin"]) {
                    return array("response" => true, "admin" => true);
                } else {
                    return array("response" => true, "admin" => false, "result" => array("user_firstname" => get_object_vars($payload)["user_firstname"], "user_name" => get_object_vars($payload)["user_name"], "user_phone" => get_object_vars($payload)["user_phone"]));
                }
            } else {
                return array("response" => false);
            }
        } else {
            return array("response" => false);
        }
    }
}
?>