<?php

class DB {

    private $conn;

    protected function connect() {

        $host = "localhost";
        $username = "root";
        $dbname = "cartsystem2";
        $password = "";

        $dsn = "mysql:host=" .$host. ';dbname='. $dbname;

        try
        {
            $this->conn = new PDO($dsn, $username, $password);
            //whenever we get data from database it automatically converts it to the object
            //instead of normal array
            //sürekli PDO::FETCH_ASSOC yazmak yerine setAttribute ile hallet
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->conn;
        }
        catch(Exception $e)
        {
            echo "Connection failed." . $e->getMessage();
        }

    }
}
?>