<?php 
class Database {
    public $connection;
    public function getConnection(){
        $this->connection = null;
        try {
            $this->connection = new PDO('mysql:host=localhost;dbname=job_board;charset=utf8', 'root', 'Rootepitech');
        } catch (PDOException $exception) {
            echo "Database not connected : ", $exception->getMessage();
        }
        return $this->connection;
    }
}
?>