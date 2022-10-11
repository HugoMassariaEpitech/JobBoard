<?php
include_once "../class/session.php";
class User {
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
    // Read all users OK
    public function getUsers() {
        $headers = apache_request_headers();
        $tokenParts = explode(".", str_replace("Bearer ", "", $headers["Authorization"]));
        $payload = base64_decode($tokenParts[1]);
        $signature = hash_hmac("sha256", $tokenParts[0] . "." . $tokenParts[1], "90zgLEniSbKFrV6OJjVa825KcTI1JC7m", true);
        $base64UrlSignature = str_replace(["+", "/", "="], ["-", "_", ""], base64_encode($signature));
        if ($base64UrlSignature == $tokenParts[2]) {
            if (intval(((array) json_decode($payload))["admin"])) {
                $users = $this->connection->prepare("SELECT * FROM users");
                if ($users->execute()) {
                    $result = $users->fetchAll();
                    return array("response" => true, "result" => $result);
                } else {
                    return array("response" => false);
                }
            } else {
                return array("response" => false, "access" => false);
            }
        } else {
            return array("response" => false, "access" => false);
        }
    }

    // Read one advertisement OK
    public function getSingleUser() {
        $headers = apache_request_headers();
        $tokenParts = explode(".", str_replace("Bearer ", "", $headers["Authorization"]));
        $payload = base64_decode($tokenParts[1]);
        $signature = hash_hmac("sha256", $tokenParts[0] . "." . $tokenParts[1], "90zgLEniSbKFrV6OJjVa825KcTI1JC7m", true);
        $base64UrlSignature = str_replace(["+", "/", "="], ["-", "_", ""], base64_encode($signature));
        if ($base64UrlSignature == $tokenParts[2]) {
            if (intval(((array) json_decode($payload))["admin"])) {
                $user = $this->connection->prepare("SELECT * FROM users WHERE id_advertisement = ?");
                $user->bindParam("1", $this->id_user);
                if ($user->execute()) {
                    $result = $user->fetchAll();
                    return array("response" => true, "result" => $result);
                } else {
                    return array("response" => false);
                }
            } else {
                return array("response" => false, "access" => false);
            }
        } else {
            return array("response" => false, "access" => false);
        }
    }

    // Update an advertisement OK - when ressource is not found ?
    public function updateUser() {
        $user = $this->connection->prepare("UPDATE users SET user_name = ?, user_firstname = ?, user_email = ?, user_phone = ?, user_civility = ?, user_birthdate = ? WHERE id_user = ?");
        $user->bindParam(1, htmlspecialchars(strip_tags($this->user_name)));
        $user->bindParam(2, htmlspecialchars(strip_tags($this->user_firstname)));
        $user->bindParam(3, htmlspecialchars(strip_tags($this->user_email)));
        $user->bindParam(4, htmlspecialchars(strip_tags($this->user_phone)));
        $user->bindParam(5, htmlspecialchars(strip_tags($this->user_civility)));
        $user->bindParam(6, htmlspecialchars(strip_tags($this->user_birthdate)));
        if ($user->execute()) {
            return array("response" => true);
        } else {
            return array("response" => false, "access" => true);
        }
    }
    // Delete an advertisement OK - when ressource is not found ?
<<<<<<< HEAD
    public function deleteAdvertisement() {
=======
    public function deleteUser()
    {
>>>>>>> 04df98c51fe575f5c1be91abd7602a5ee2c75ca1
        $headers = apache_request_headers();
        $tokenParts = explode(".", str_replace("Bearer ", "", $headers["Authorization"]));
        $payload = base64_decode($tokenParts[1]);
        $signature = hash_hmac("sha256", $tokenParts[0] . "." . $tokenParts[1], "90zgLEniSbKFrV6OJjVa825KcTI1JC7m", true);
        $base64UrlSignature = str_replace(["+", "/", "="], ["-", "_", ""], base64_encode($signature));
        if ($base64UrlSignature == $tokenParts[2]) {
            if (intval(((array) json_decode($payload))["admin"])) {
                $user = $this->connection->prepare("DELETE FROM users WHERE id_user = ?");
                $user->bindParam(1, htmlspecialchars(strip_tags($this->id_user)));
                if ($user->execute()) {
                    return array("response" => true);
                } else {
                    return array("response" => false, "access" => true);
                }
            } else {
                return array("response" => false, "access" => false);
            }
        } else {
            return array("response" => false, "access" => false);
        }
    }
    // Register User OK
    public function registerUser()
    {
        $user = $this->connection->prepare("SELECT * FROM users WHERE user_email = ?");
        $user->bindParam("1", $this->user_email);
        if ($user->execute()) {
            $UserResult = $user->fetch();
            if (empty($UserResult)) {
                $newUser = $this->connection->prepare("INSERT INTO users (id_user, user_civility, user_firstname, user_name, user_birthdate, user_phone, user_email, user_password) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?)");
                $newUser->bindParam(1, htmlspecialchars(strip_tags($this->user_civility)));
                $newUser->bindParam(2, htmlspecialchars(strip_tags($this->user_firstname)));
                $newUser->bindParam(3, htmlspecialchars(strip_tags($this->user_name)));
                $newUser->bindParam(4, htmlspecialchars(strip_tags($this->user_birthdate)));
                $newUser->bindParam(5, htmlspecialchars(strip_tags($this->user_phone)));
                $newUser->bindParam(6, htmlspecialchars(strip_tags($this->user_email)));
                $newUser->bindParam(7, htmlspecialchars(strip_tags(password_hash($this->user_password, PASSWORD_BCRYPT))));
                if ($newUser->execute()) {
                    $newUserData = $this->connection->prepare("SELECT * FROM users WHERE user_email = ?");
                    $newUserData->bindParam("1", $this->user_email);
                    if ($newUserData->execute()) {
                        $newUserDataResult = $newUserData->fetch();
                        $header = json_encode(["tokenType" => "JWT", "algorithm" => "HS256"]);
                        $payload = json_encode(["id_user" => $newUserDataResult["id_user"], "user_firstname" => $this->user_firstname, "user_name" => $this->user_name, "user_birthdate" => $this->user_birthdate, "user_phone" => $this->user_phone, "user_email" => $this->user_email, "admin" => "0"]);
                        $base64UrlHeader = str_replace(["+", "/", "="], ["-", "_", ""], base64_encode($header));
                        $base64UrlPayload = str_replace(["+", "/", "="], ["-", "_", ""], base64_encode($payload));
                        $signature = hash_hmac("sha256", $base64UrlHeader . "." . $base64UrlPayload, "90zgLEniSbKFrV6OJjVa825KcTI1JC7m", true);
                        $base64UrlSignature = str_replace(["+", "/", "="], ["-", "_", ""], base64_encode($signature));
                        $JWT = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
                        return array("response" => true, "registered" => true, "result" => $JWT);
                    } else {
                        return array("response" => false);
                    }
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
    public function logInUser()
    {
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
    // Check Log OK
    public function checkLogUser()
    {
        if (isset($_COOKIE["token"])) {
            $tokenParts = explode(".", $_COOKIE["token"]);
            $payload = json_decode(base64_decode($tokenParts[1]));
            $signature = hash_hmac("sha256", $tokenParts[0] . "." . $tokenParts[1], "90zgLEniSbKFrV6OJjVa825KcTI1JC7m", true);
            $base64UrlSignature = str_replace(["+", "/", "="], ["-", "_", ""], base64_encode($signature));
            if ($base64UrlSignature == $tokenParts[2]) {
                return array("response" => true, "result" => $payload);
            } else {
                return array("response" => false);
            }
        } else {
            return array("response" => false);
        }
    }
}
?>