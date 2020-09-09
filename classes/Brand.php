<?php 

class Brand extends DB {

    private $conn;

    public function __construct()
    {
        $this->conn = $this->connect();
    }

    public function BrandList()
    {
        $sql = "SELECT * FROM brands";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
}

?>