<?php
class Application {
    // Connection
    private $connection;
    // Columns
    public $id_application;
    public $id_advertisement;
    public $user_firstname;
    public $user_name;
    public $user_email;
    public $user_phone;
    // Database connection
    public function __construct($config) {
        $this->connection = $config;
    }
    // Create - Fini
    public function create() {
        $applications = $this->connection->prepare("SELECT * FROM applications WHERE id_advertisement = ? AND user_email = ?");
        $applications->bindParam(1, htmlspecialchars(strip_tags($this->id_advertisement)));
        $applications->bindParam(2, htmlspecialchars(strip_tags($this->user_email)));
        if ($applications->execute()) {
            $applicationsResult = $applications->fetch();
            if (empty($applicationsResult)) {
                $application = $this->connection->prepare("INSERT INTO applications (id_advertisement, user_firstname, user_name, user_email, user_phone) VALUES (?, ?, ?, ?, ?)");
                $application->bindParam(1, htmlspecialchars(strip_tags($this->id_advertisement)));
                $application->bindParam(2, htmlspecialchars(strip_tags($this->user_firstname)));
                $application->bindParam(3, htmlspecialchars(strip_tags($this->user_name)));
                $application->bindParam(4, htmlspecialchars(strip_tags($this->user_email)));
                $application->bindParam(5, htmlspecialchars(strip_tags($this->user_phone)));
                if ($application->execute()) {
                    return array("response" => true);
                } else {
                    return array("response" => false, "applied" => false);
                }
            } else {
                return array("response" => false, "applied" => true);
            }
        } else {
            return array("response" => false, "applied" => false);
        }
    }
    // Read - Fini
    public function read() {
        $application = $this->connection->prepare("SELECT * FROM applications WHERE id_advertisement = ?");
        $application->bindParam(1, htmlspecialchars(strip_tags($this->id_advertisement)));
        if ($application->execute()) {
            $result = $application->fetchAll();
            if (isset($_COOKIE["token"])) {
                $tokenParts = explode(".", $_COOKIE["token"]);
                $payload = json_decode(base64_decode($tokenParts[1]));
                $signature = hash_hmac("sha256", $tokenParts[0] . "." . $tokenParts[1], "90zgLEniSbKFrV6OJjVa825KcTI1JC7m", true);
                $base64UrlSignature = str_replace(["+", "/", "="], ["-", "_", ""], base64_encode($signature));
                if ($base64UrlSignature == $tokenParts[2]) {
                    if (get_object_vars($payload)["admin"]) {
                        return array("response" => true, "message" => $result);
                    } else {
                        foreach ($result as &$applicants) {
                            if ($applicants["user_email"] == get_object_vars($payload)["user_email"]) {
                                return array("response" => true, "applicant" => true, "message" => count($result));
                                break;
                            }
                        }
                        return array("response" => true, "applicant" => false, "message" => count($result));
                    }
                } else {
                    return array("response" => true, "applicant" => false, "message" => count($result));
                }
            } else {
                return array("response" => true, "applicant" => false, "message" => count($result));
            }
        } else {
            return array("response" => false);
        }
    }
    // Delete - Fini
    public function delete() {
        $application = $this->connection->prepare("DELETE FROM applications WHERE id_advertisement = ? AND user_email = ?");
        $application->bindParam(1, htmlspecialchars(strip_tags($this->id_advertisement)));
        $application->bindParam(2, htmlspecialchars(strip_tags($this->user_email)));
        if ($application->execute()) {
            return array("response" => true);
        } else {
            return array("response" => false, "access" => true);
        }
    }
}
?>