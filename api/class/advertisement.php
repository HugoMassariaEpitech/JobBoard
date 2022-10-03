<?php
class Advertisement {
    // Connection
    private $connection;
    // Columns
    public $id_advertisement;
    public $advertisement_name;
    public $advertisement_company;
    public $advertisement_location;
    public $advertisement_type;
    public $advertisement_description;
    public $advertisement_details;
    // Database connection
    public function __construct($config){
        $this->connection = $config;
    }
    // Read all advertisements OK
    public function getAdvertisements() {
        $advertisements = $this->connection->prepare("SELECT * FROM advertisements");
        if ($advertisements->execute()) {
            $result = $advertisements -> fetchAll();
            return array("response" => true, "result" => $result);
        } else {
            return array("response" => false);
        }
    }
    // Read one advertisement OK
    public function getSingleAdvertisement(){
        $advertisement = $this->connection->prepare("SELECT * FROM advertisements WHERE id_advertisement = ?");
        $advertisement->bindParam("1", $this->id_advertisement);
        if ($advertisement->execute()) {
            $result = $advertisement -> fetchAll();
            return array("response" => true, "result" => $result);
        } else {
            return array("response" => false);
        }
    }
    // Create an advertisement
    public function createAdvertisement() {
        if (isset($_SESSION["role"]) && $_SESSION["role"] == "admin") {
            $advertisement = $this->connection->prepare("INSERT INTO advertisements (id_advertisement, advertisement_name, advertisement_company, advertisement_location, advertisement_type, advertisement_description, advertisement_details) VALUES (NULL, ?, ?, ?, ?, ?, ?)");
            $advertisement->bindParam(1, htmlspecialchars(strip_tags($this->advertisement_name)));
            $advertisement->bindParam(2, htmlspecialchars(strip_tags($this->advertisement_company)));
            $advertisement->bindParam(3, htmlspecialchars(strip_tags($this->advertisement_location)));
            $advertisement->bindParam(4, htmlspecialchars(strip_tags($this->advertisement_type)));
            $advertisement->bindParam(5, htmlspecialchars(strip_tags($this->advertisement_description)));
            $advertisement->bindParam(6, htmlspecialchars(strip_tags($this->advertisement_details)));
            if($advertisement->execute()){
                return array("response" => true);
            } else {
                return array("response" => false, "access" => true);
            }
        } else {
            return array("response" => false, "access" => false);
        }
    }
    // Update an advertisement
    public function updateAdvertisement(){
        $advertisement = $this->connection->prepare("UPDATE advertisements SET advertisement_name = ?, advertisement_company = ?, advertisement_location = ?, advertisement_type = ?, advertisement_description = ? WHERE id_advertisement = ?");
        $advertisement->bindParam(1, htmlspecialchars(strip_tags($this->advertisement_name)));
        $advertisement->bindParam(2, htmlspecialchars(strip_tags($this->advertisement_company)));
        $advertisement->bindParam(3, htmlspecialchars(strip_tags($this->advertisement_location)));
        $advertisement->bindParam(4, htmlspecialchars(strip_tags($this->advertisement_type)));
        $advertisement->bindParam(5, htmlspecialchars(strip_tags($this->advertisement_description)));
        $advertisement->bindParam(6, htmlspecialchars(strip_tags($this->id_advertisement)));
        if($advertisement->execute()){
            return true;
        }
        return false;
    }
    // Delete an advertisement
    public function deleteAdvertisement(){
        $advertisement = $this->connection->prepare("DELETE FROM advertisements WHERE id_advertisement = ?");
        $advertisement->bindParam(1, htmlspecialchars(strip_tags($this->id_advertisement)));
        if($advertisement->execute()){
            return true;
        }
        return false;
    }
    //Search an advertisement
    public function searchAdvertisement(){
        $advertisement_name_search = "%".$this->advertisement_name."%";
        $advertisement = $this->connection->prepare("SELECT FROM advertisements WHERE advertisement_name LIKE ?");
        $advertisement->bindParam(1,htmlspecialchars(strip_tags($advertisement_name_search)));
        if($advertisement->execute()){
            return true;
        }
        return false;
    }
}
?>