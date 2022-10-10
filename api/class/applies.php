<?php
class Applies {
    // Connection
    private $connection;
    // Columns
    public $id_apply;
    public $user_email;
    public $user_phone;
    public $user_civility;
    public $user_name;
    public $user_firstname;
    public $id_advertisement;

    // Database connection
    public function __construct($config){
        $this->connection = $config;
    }
    // Read all applies OK
    public function getApplies() {
        $applies = $this->connection->prepare("SELECT * FROM applies");
        if ($applies->execute()) {
            $result = $applies -> fetchAll();
            return array("response" => true, "result" => $result);
        } else {
            return array("response" => false);
        }
    }
    // Read one applies OK
    public function getSingleApply(){
        $apply = $this->connection->prepare("SELECT * FROM applies WHERE id_apply = ?");
        $apply->bindParam("1", $this->id_advertisement);
        if ($apply->execute()) {
            $result = $apply -> fetchAll();
            return array("response" => true, "result" => $result);
        } else {
            return array("response" => false);
        }
    }
    // Create an apply OK
    public function createApply() {

                $apply = $this->connection->prepare("INSERT INTO applies (user_email, id_advertisement, user_phone, user_firstname, user_name) VALUES (?, ?, ?, ?, ?)");
                $apply->bindParam(1, htmlspecialchars(strip_tags($this->user_email)));
                $apply->bindParam(2, htmlspecialchars(strip_tags($this->id_advertisement)));
                $apply->bindParam(3, htmlspecialchars(strip_tags($this->user_phone)));
                $apply->bindParam(4, htmlspecialchars(strip_tags($this->user_firstname)));
                $apply->bindParam(5, htmlspecialchars(strip_tags($this->user_name)));
                if ($apply->execute()) {
                    return array("response" => true);
                } else {
                    return array("response" => false, "message" => "check params");
                }

    }

    // Delete an apply OK - when ressource is not found ?
    public function deleteApply(){
        $headers = apache_request_headers();
        $tokenParts = explode(".", str_replace("Bearer ", "", $headers["Authorization"]));
	    $payload = base64_decode($tokenParts[1]);
        $signature = hash_hmac("sha256", $tokenParts[0] . "." . $tokenParts[1], "90zgLEniSbKFrV6OJjVa825KcTI1JC7m", true);
        $base64UrlSignature = str_replace(["+", "/", "="], ["-", "_", ""], base64_encode($signature));
        if ($base64UrlSignature == $tokenParts[2]) {
            if (intval(((array) json_decode($payload))["admin"])) {
                $apply = $this->connection->prepare("DELETE FROM advertisements WHERE id_apply= ?");
                $apply->bindParam(1, htmlspecialchars(strip_tags($this->id_apply)));
                if ($apply->execute()) {
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

}
?>