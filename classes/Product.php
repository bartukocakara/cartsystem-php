<?php 

class Product extends DB {

    private $conn;

    public function __construct()
    {
        $this->conn = $this->connect();
    }

    public function ProductList()
    {
        $limit = 9;
        
        if(isset($_GET['page'])) {
            
            $page = $_GET['page'];

        } else {

            $page = 1;
        }

        $start_from = ($page - 1) * $limit;

        $sql = "SELECT * FROM products ORDER BY product_id ASC LIMIT $start_from, $limit";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public function pageList($limit = 9)
    {
        $sql = "SELECT COUNT(product_id) FROM products";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([]);
        
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $total_records = $result[0]['COUNT(product_id)'];

        $total_pages = ceil($total_records / $limit);

        $pageLink = "<ul class='pagination'>";

        for($i = 1; $i <= $total_pages; $i++)
        {
        
            $pageLink .= "<li class='page-item'><a class='page-link' href='?page=".$i."'>$i</a></li>";
            
        }
        echo $pageLink .'</ul>';
    
    }

    public function getBrandProducts($brandId)
    {
        $sql = "SELECT *
                FROM brands
                LEFT JOIN products
                ON brands.brand_id = products.product_brand
                WHERE products.product_brand=?";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$brandId]);

        $brandProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $brandProducts;
    }

    public function getCategoryProducts($catId)
    {
        $sql = "SELECT *
                FROM categories
                LEFT JOIN products
                ON categories.cat_id = products.product_cat
                WHERE products.product_cat=?
                ORDER BY RAND() LIMIT 0,9";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$catId]);

        $categoryProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $categoryProducts;
    }

    public function searchProduct($keyword)
    {
        $sql = "SELECT *
                FROM products 
                WHERE product_keywords 
                LIKE '%$keyword%'";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$keyword]);

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $result;
    }

}

?>