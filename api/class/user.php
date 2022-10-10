<?php
include_once "../class/session.php";
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
    // Register User OK
    public function registerUser() {
        $user = $this->connection->prepare("SELECT * FROM users WHERE user_email = ?");
        $user->bindParam("1", $this->user_email);
        if ($user->execute()) {
            $checkResult = $user->fetch();
            if (empty($checkResult)) {
                $newUser = $this->connection->prepare("INSERT INTO users (id_user, user_civility, user_firstname, user_name, user_birthdate, user_phone, user_email, user_password) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?)");
                $newUser->bindParam(1, htmlspecialchars(strip_tags($this->user_civility)));
                $newUser->bindParam(2, htmlspecialchars(strip_tags($this->user_firstname)));
                $newUser->bindParam(3, htmlspecialchars(strip_tags($this->user_name)));
                $newUser->bindParam(4, htmlspecialchars(strip_tags($this->user_birthdate)));
                $newUser->bindParam(5, htmlspecialchars(strip_tags($this->user_phone)));
                $newUser->bindParam(6, htmlspecialchars(strip_tags($this->user_email)));
                $newUser->bindParam(7, htmlspecialchars(strip_tags(password_hash($this->user_password, PASSWORD_BCRYPT))));
                if ($newUser->execute()) {
                    return array("response" => true, "registered" => true);
                } else {
                    return array("response" => false); 
                }
            } else {
                return array("response" => true, "registered" => false);
            }
        } else {
            return array("response" => false);
        }
    }
    // LogIn User OK
    public function logInUser() {
        $user = $this->connection->prepare("SELECT * FROM users WHERE user_email = ?");
        $user->bindParam("1", $this->user_email);
        if ($user->execute()) {
            $result = $user->fetch();
            if (empty($result)) {
                return array("response" => false);
            } else {
                if (password_verify($this->user_password, $result["user_password"])) {
                    $header = json_encode(["tokenType" => "JWT", "algorithm" => "HS256"]);
                    $payload = json_encode(["id_user" => $result["id_user"], "user_name" => $result["user_name"], "admin" => $result["admin"], "user_email" => $result["user_email"], "user_phone" => $result["user_phone"], "user_birthdate" => $result["user_birthdate"], "user_civility" => $result["user_civility"], "user_firstname" => $result["user_firstname"]]);
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
    // Check Log OK
    public function checkLogUser() {
        if (isset($_COOKIE["token"])) {
            $tokenParts = explode(".", $_COOKIE["token"]);
            $payload = base64_decode($tokenParts[1]);
            $signature = hash_hmac("sha256", $tokenParts[0] . "." . $tokenParts[1], "90zgLEniSbKFrV6OJjVa825KcTI1JC7m", true);
            $base64UrlSignature = str_replace(["+", "/", "="], ["-", "_", ""], base64_encode($signature));
            if ($base64UrlSignature == $tokenParts[2]) {
                return array("response" => true);
            } else {
                return array("response" => false);
            }
        } else {
            return array("response" => false);
        }
    }
}
?>