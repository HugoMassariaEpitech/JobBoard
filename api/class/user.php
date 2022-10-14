<?php
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
    // Read - Fini -
    public function read() {
        if (isset($_COOKIE["token"])) {
            $tokenParts = explode(".", $_COOKIE["token"]);
            $payload = json_decode(base64_decode($tokenParts[1]));
            $signature = hash_hmac("sha256", $tokenParts[0] . "." . $tokenParts[1], "90zgLEniSbKFrV6OJjVa825KcTI1JC7m", true);
            $base64UrlSignature = str_replace(["+", "/", "="], ["-", "_", ""], base64_encode($signature));
            if ($base64UrlSignature == $tokenParts[2]) {
                if (get_object_vars($payload)["admin"]) {
                    $users = $this->connection->prepare("SELECT * FROM users WHERE admin=0");
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
        } else {
            return array("response" => false, "access" => false);
        }
    }
    // Delete - Fini -
    public function delete() {
        if (isset($_COOKIE["token"])) {
            $tokenParts = explode(".", $_COOKIE["token"]);
            $payload = json_decode(base64_decode($tokenParts[1]));
            $signature = hash_hmac("sha256", $tokenParts[0] . "." . $tokenParts[1], "90zgLEniSbKFrV6OJjVa825KcTI1JC7m", true);
            $base64UrlSignature = str_replace(["+", "/", "="], ["-", "_", ""], base64_encode($signature));
            if ($base64UrlSignature == $tokenParts[2]) {
                if (get_object_vars($payload)["admin"]) {
                    $advertisement = $this->connection->prepare("DELETE FROM users WHERE id_user = ?");
                    $advertisement->bindParam(1, htmlspecialchars(strip_tags($this->id_user)));
                    if ($advertisement->execute()) {
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
        } else {
            return array("response" => false, "access" => false);
        }
    }
    // Upgrade - Fini -
    public function upgrade() {
        if (isset($_COOKIE["token"])) {
            $tokenParts = explode(".", $_COOKIE["token"]);
            $payload = json_decode(base64_decode($tokenParts[1]));
            $signature = hash_hmac("sha256", $tokenParts[0] . "." . $tokenParts[1], "90zgLEniSbKFrV6OJjVa825KcTI1JC7m", true);
            $base64UrlSignature = str_replace(["+", "/", "="], ["-", "_", ""], base64_encode($signature));
            if ($base64UrlSignature == $tokenParts[2]) {
                if (get_object_vars($payload)["admin"]) {
                    $advertisement = $this->connection->prepare("UPDATE users SET admin=1 WHERE id_user = ?");
                    $advertisement->bindParam(1, htmlspecialchars(strip_tags($this->id_user)));
                    if ($advertisement->execute()) {
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
        } else {
            return array("response" => false, "access" => false);
        }
    }
    // Create - Fini -
    public function create() {
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
    // Update - Fini -
    public function update() {
        if (isset($_COOKIE["token"])) {
            $tokenParts = explode(".", $_COOKIE["token"]);
            $payload = json_decode(base64_decode($tokenParts[1]));
            $signature = hash_hmac("sha256", $tokenParts[0] . "." . $tokenParts[1], "90zgLEniSbKFrV6OJjVa825KcTI1JC7m", true);
            $base64UrlSignature = str_replace(["+", "/", "="], ["-", "_", ""], base64_encode($signature));
            if ($base64UrlSignature == $tokenParts[2]) {
                $user = $this->connection->prepare("UPDATE users SET user_firstname = ?, user_name = ?, user_phone = ? WHERE id_user = ?");
                $user->bindParam(1, htmlspecialchars(strip_tags($this->user_firstname)));
                $user->bindParam(2, htmlspecialchars(strip_tags($this->user_name)));
                $user->bindParam(3, htmlspecialchars(strip_tags($this->user_phone)));
                $user->bindParam(4, htmlspecialchars(strip_tags(get_object_vars($payload)["id_user"])));
                if ($user->execute()) {
                    $header = json_encode(["tokenType" => "JWT", "algorithm" => "HS256"]);
                    $payload = json_encode(["id_user" => get_object_vars($payload)["id_user"], "user_firstname" => htmlspecialchars(strip_tags($this->user_firstname)), "user_name" => htmlspecialchars(strip_tags($this->user_name)), "user_birthdate" => get_object_vars($payload)["user_birthdate"], "user_phone" => htmlspecialchars(strip_tags($this->user_phone)), "user_email" => get_object_vars($payload)["user_email"], "admin" => get_object_vars($payload)["admin"]]);
                    $base64UrlHeader = str_replace(["+", "/", "="], ["-", "_", ""], base64_encode($header));
                    $base64UrlPayload = str_replace(["+", "/", "="], ["-", "_", ""], base64_encode($payload));
                    $signature = hash_hmac("sha256", $base64UrlHeader . "." . $base64UrlPayload, "90zgLEniSbKFrV6OJjVa825KcTI1JC7m", true);
                    $base64UrlSignature = str_replace(["+", "/", "="], ["-", "_", ""], base64_encode($signature));
                    $JWT = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
                    return array("response" => true, "result" => $JWT);
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
}
?>