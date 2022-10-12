<?php
class Advertisement
{
    // Connection
    private $connection;
    // Columns
    public $id_advertisement;
    public $advertisement_name;
    public $advertisement_company;
    public $advertisement_location;
    public $advertisement_type;
    public $advertisement_description;
    public $advertisement_salary;
    // Database connection
    public function __construct($config)
    {
        $this->connection = $config;
    }
    // Read all advertisements OK
    public function getAdvertisements()
    {
        $advertisements = $this->connection->prepare("SELECT * FROM advertisements");
        if ($advertisements->execute()) {
            $result = $advertisements->fetchAll();
            return array("response" => true, "result" => $result);
        } else {
            return array("response" => false);
        }
    }
    // Read one advertisement OK
    public function getSingleAdvertisement()
    {
        $advertisement = $this->connection->prepare("SELECT * FROM advertisements WHERE id_advertisement = ?");
        $advertisement->bindParam("1", $this->id_advertisement);
        if ($advertisement->execute()) {
            $result = $advertisement->fetchAll();
            return array("response" => true, "result" => $result);
        } else {
            return array("response" => false);
        }
    }
    // Create an advertisement - Fini
    public function create() {
        if (isset($_COOKIE["token"])) {
            $tokenParts = explode(".", $_COOKIE["token"]);
            $payload = base64_decode($tokenParts[1]);
            $signature = hash_hmac("sha256", $tokenParts[0] . "." . $tokenParts[1], "90zgLEniSbKFrV6OJjVa825KcTI1JC7m", true);
            $base64UrlSignature = str_replace(["+", "/", "="], ["-", "_", ""], base64_encode($signature));
            if ($base64UrlSignature == $tokenParts[2]) {
                if (intval(((array) json_decode($payload))["admin"])) {
                    $advertisement = $this->connection->prepare("INSERT INTO advertisements (advertisement_name, advertisement_company, advertisement_location, advertisement_type, advertisement_description, advertisement_salary) VALUES (?, ?, ?, ?, ?, ?)");
                    $advertisement->bindParam(1, htmlspecialchars(strip_tags($this->advertisement_name)));
                    $advertisement->bindParam(2, htmlspecialchars(strip_tags($this->advertisement_company)));
                    $advertisement->bindParam(3, htmlspecialchars(strip_tags($this->advertisement_location)));
                    $advertisement->bindParam(4, htmlspecialchars(strip_tags($this->advertisement_type)));
                    $advertisement->bindParam(5, htmlspecialchars(strip_tags($this->advertisement_description)));
                    $advertisement->bindParam(6, htmlspecialchars(strip_tags($this->advertisement_salary)));
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
    // Update an advertisement - Fini - when ressource is not found ?
    public function update() {
        if (isset($_COOKIE["token"])) {
            $tokenParts = explode(".", $_COOKIE["token"]);
            $payload = base64_decode($tokenParts[1]);
            $signature = hash_hmac("sha256", $tokenParts[0] . "." . $tokenParts[1], "90zgLEniSbKFrV6OJjVa825KcTI1JC7m", true);
            $base64UrlSignature = str_replace(["+", "/", "="], ["-", "_", ""], base64_encode($signature));
            if ($base64UrlSignature == $tokenParts[2]) {
                if (intval(((array) json_decode($payload))["admin"])) {
                    $advertisement = $this->connection->prepare("UPDATE advertisements SET advertisement_name = ?, advertisement_company = ?, advertisement_location = ?, advertisement_type = ?, advertisement_description = ?, advertisement_salary = ? WHERE id_advertisement = ?");
                    $advertisement->bindParam(1, htmlspecialchars(strip_tags($this->advertisement_name)));
                    $advertisement->bindParam(2, htmlspecialchars(strip_tags($this->advertisement_company)));
                    $advertisement->bindParam(3, htmlspecialchars(strip_tags($this->advertisement_location)));
                    $advertisement->bindParam(4, htmlspecialchars(strip_tags($this->advertisement_type)));
                    $advertisement->bindParam(5, htmlspecialchars(strip_tags($this->advertisement_description)));
                    $advertisement->bindParam(6, htmlspecialchars(strip_tags($this->advertisement_salary)));
                    $advertisement->bindParam(7, htmlspecialchars(strip_tags($this->id_advertisement)));
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
    // Delete an advertisement - Fini - when ressource is not found ?
    public function delete() {
        if (isset($_COOKIE["token"])) {
            $tokenParts = explode(".", $_COOKIE["token"]);
            $payload = base64_decode($tokenParts[1]);
            $signature = hash_hmac("sha256", $tokenParts[0] . "." . $tokenParts[1], "90zgLEniSbKFrV6OJjVa825KcTI1JC7m", true);
            $base64UrlSignature = str_replace(["+", "/", "="], ["-", "_", ""], base64_encode($signature));
            if ($base64UrlSignature == $tokenParts[2]) {
                if (intval(((array) json_decode($payload))["admin"])) {
                    $advertisement = $this->connection->prepare("DELETE FROM advertisements WHERE id_advertisement = ?");
                    $advertisement->bindParam(1, htmlspecialchars(strip_tags($this->id_advertisement)));
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








    //Search an advertisement
    public function searchAdvertisement()
    {
        $advertisement_name_search = "%" . $this->advertisement_name . "%";
        $advertisement = $this->connection->prepare("SELECT FROM advertisements WHERE advertisement_name LIKE ?");
        $advertisement->bindParam(1, htmlspecialchars(strip_tags($advertisement_name_search)));
        if ($advertisement->execute()) {
            return true;
        }
        return false;
    }
}
