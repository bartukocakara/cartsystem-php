<?php 

class Category extends DB {

    private $conn;

    public function __construct() 
    {
        $this->conn = $this->connect();
    }

    public function CategoryList() 
    {
        $sql = "SELECT * FROM categories";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
}



?>