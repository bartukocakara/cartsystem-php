<?php

session_start();
class User extends DB {

    private $conn;

    public function __construct()
    {
        $this->conn = $this->connect();
    }

    public function addValue($argse) {

		$values=implode(',',array_map(function ($item){
			return $item.'=?';
		},array_keys($argse)));

		return $values;
	}

    public function create($table, $values, $options=[]) {


        try{
        
        if(isset($options['pass'])) {

            $values[$options['pass']] = md5($values[$options['pass']]);
        }

        unset($values[$options["form_name"]]);
        unset($values[$options["repeat"]]);

        // echo "<pre>";
        // print_r($this->addValue($values));
        // echo "</pre>";
        $sql = "INSERT INTO $table SET {$this->addValue($values)}";

        $stmt = $this->conn->prepare($sql);
        $result = $stmt->execute(array_values($values));
        
        return ["status" => true];

        } catch(Exception $e){
            
            return ["status" => false, "error" => $e->getMessage()];
        }

    }

    public function loginUser($email, $password) {

        $sql = "SELECT * FROM users WHERE email=? AND user_password=?";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$email, md5($password)]);

        if($stmt != null)
        {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            session_id("user");
            $_SESSION["userLoggedIn"] = [
                "user_id" => $row["user_id"],
                "first_name" => $row["first_name"],
                "last_name" => $row["last_name"],
                "email" => $email,
                "mobile" => $row["mobile"],
                "address1" => $row["address1"],
                "address2" => $row["address2"]
            ];

            
            return ['status' => true];
        }
        else {

            return ["status" => false];
        }
    }

    public function getcart($cartId) {

        $sql = "SELECT id, product_id, product_title, product_image, qty, price, total_amount
                FROM cart 
                LEFT JOIN users
                ON cart.user_id=users.user_id
                WHERE users.user_id=?";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$cartId]);

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;

    }

    public function addToCart($values, $options=[]) 
    {
        //Post edilen öğeler arasından form name'i çıkar
        unset($values[$options["form_name"]]);

        //önce ürünü select edicem
        $sql = "SELECT qty FROM cart WHERE product_id=? AND user_id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$values['product_id'], $values['user_id']]);

        $selectedProductQty = $stmt->fetch(PDO::FETCH_ASSOC);
        //Eğer ürün kullanıcının sepetinde mevcut değil ise ürünü sepete ekle.
        try {
            
            if($selectedProductQty == null) 
            {   
                $sql = "INSERT INTO cart (id, product_id, user_id, product_title, product_image, qty, price, total_amount)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?);";

                // echo "<pre>";
                // print_r($sql);
                // echo "</pre>";
                // exit;
                $stmt = $this->conn->prepare($sql);
                $result = $stmt->execute([NULL, $values['product_id'], $values['user_id'], $values['product_title'], $values['product_image'], 1, $values['price'], $values['price']]);

                echo "Sepete eklendi";
            }
            else if($selectedProductQty != null) 
            {   
                $sql = "UPDATE cart SET qty='".$selectedProductQty['qty']."'+1, total_amount = price * qty WHERE cart.user_id = ? AND cart.product_id = ?";

                $stmt = $this->conn->prepare($sql);
                $result = $stmt->execute([$values['user_id'], $values['product_id']]);

                if($result == true) {
                    
                    echo "Sepetteki miktar arttırıldı";
                }
            }
        } catch (Exception $e) {
            
            return ['status' => false, 'error'=> $e->getMessage()];
        }
        
    }


    //Session un sahip olduğu cart listesini çağır
    public function getCartList($userid)
    {
        $sql = "SELECT * FROM cart WHERE user_id=?";


        try {
            
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$userid]);
            $cartList = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $cartList;

        } catch (Exception $e) {
            
            return $e->getMessage();
        }
        
    }

    public function increaseQty($productid, $userid)
    {
        $sql = "SELECT qty FROM cart WHERE product_id=? AND user_id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$productid, $userid]);

        $selectedProductQty = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $sql = "UPDATE cart SET qty='".$selectedProductQty['qty']."'+1, total_amount = price * qty WHERE cart.product_id = ? AND cart.user_id = ?";

        $stmt = $this->conn->prepare($sql);
        $result = $stmt->execute([$productid, $userid]);

        if($result == true) {
                    
            echo "Sepetteki miktar arttırıldı";
        }
        else {
            echo "Başarısız";
        }
        
    }

    public function decreaseQty($productid, $userid)
    {
        $sql = "SELECT qty FROM cart WHERE product_id=? AND user_id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$productid, $userid]);

        $selectedProductQty = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $sql = "UPDATE cart SET qty='".$selectedProductQty['qty']."' - 1, total_amount = price * qty WHERE cart.product_id = ? AND cart.user_id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$productid, $userid]);
    }

    public function deleteFromCart($productid, $userid)
    {
        try {
            
            $sql = "DELETE FROM cart WHERE cart.product_id = ? AND cart.user_id = ?";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$productid, $userid]);

        } catch (Exception $e) {
            
            return $e->getMessage();
        }
    }

    public function getTotalPriceCart($userid)
    {
        try {
            
            $sql = "SELECT SUM(total_amount) FROM CART WHERE user_id=?";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$userid]);

            $totalPrice = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $totalPrice;  

        } catch (Exception $e) {
            
            return $e->getMessage();
        }
        
    }
    
}

?>