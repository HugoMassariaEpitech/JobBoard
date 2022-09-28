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
    // Database connection
    public function __construct($config){
        $this->conn = $config;
    }
    // Read all advertisements
    public function getAdvertisements(){
        $advertisements = $this->conn->prepare("SELECT * FROM advertisements");
        $advertisements->execute();
        $result = $advertisements -> fetchAll();
        return json_encode($result);
    }
    // Read one advertisement
    public function getSingleAdvertisement(){
        $advertisement = $this->conn->prepare("SELECT * FROM advertisements WHERE id_advertisement = ?");
        $advertisement->bindParam("1", $this->id_advertisement);
        $advertisement->execute();
        $result = $advertisement -> fetchAll();
        return json_encode($result);
    }
    // Create an advertisement
    public function createAdvertisement(){
        $advertisement = $this->conn->prepare("INSERT INTO advertisements (id_advertisement, advertisement_name, advertisement_company, advertisement_location, advertisement_type, advertisement_description) VALUES (NULL, ?, ?, ?, ?, ?)");
        $advertisement->bindParam(1, htmlspecialchars(strip_tags($this->advertisement_name)));
        $advertisement->bindParam(2, htmlspecialchars(strip_tags($this->advertisement_company)));
        $advertisement->bindParam(3, htmlspecialchars(strip_tags($this->advertisement_location)));
        $advertisement->bindParam(4, htmlspecialchars(strip_tags($this->advertisement_type)));
        $advertisement->bindParam(5, htmlspecialchars(strip_tags($this->advertisement_description)));
        if($advertisement->execute()){
            return true;
        }
        return false;
    }
    // Update an advertisement
    public function updateAdvertisement(){
        $advertisement = $this->conn->prepare("UPDATE advertisements SET advertisement_name = ?, advertisement_company = ?, advertisement_location = ?, advertisement_type = ?, advertisement_description = ? WHERE id_advertisement = ?");
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
        $advertisement = $this->conn->prepare("DELETE FROM advertisements WHERE id_advertisement = ?");
        $advertisement->bindParam(1, htmlspecialchars(strip_tags($this->id_advertisement)));
        if($advertisement->execute()){
            return true;
        }
        return false;
    }
}
?>