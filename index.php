<?php

require_once 'classes/db.php';
require_once 'classes/Category.php';
require_once 'classes/Brand.php';
require_once 'classes/Product.php';
require_once 'classes/User.php';

$dbCat = new Category();
$allCategories = $dbCat->CategoryList();
// $allCategories = json_decode(json_encode($allCategories), true);

$dbBrand = new Brand();
$allBrands = $dbBrand->BrandList();
// $allBrands = json_decode(json_encode($allBrands), true);

$dbProduct = new Product();
$allProducts = $dbProduct->ProductList();

$user = new User();

// $dil = strip_tags($_GET['dil']);

// if($dil == "tr" || $dil == "en") {

//     session_id("dil");
//     $_SESSION["dil"] = $dil;
//     header("Location:index.php");

// } else {

//     header("Location:index.php");
// }

// if(!$_SESSION['dil']) {
//      include "dil/";
// } else {
//     include "dil/".$_SESSION['dil'].".php";
// }

if(isset($_GET['brand_id'])) 
{

    $brandProducts = $dbProduct->getBrandProducts($_GET['brand_id']);
    // echo "<pre>";
    // print_r($brandProducts);
    // echo "</pre>";
}

if(isset($_GET['cat_id'])) 
{

    $categoryProducts = $dbProduct->getCategoryProducts($_GET['cat_id']);
    // echo "<pre>";
    // print_r($categoryProducts);
    // echo "</pre>";
}

if(isset($_GET['all_categories']) OR isset($_GET['all_brands']))
{
    $allProducts = $dbProduct->ProductList();

    // echo "<pre>";
    // print_r($allProducts);
    // echo "</pre>";
}

if(isset($_GET['search']))
{
    $searchProducts = $dbProduct->searchProduct($_GET['product_keywords']);
    // echo "<pre>";
    // print_r($searchProducts);
    // echo "</pre>";
}
if(isset($_POST['login']))
{
    $userLogin = $user->loginUser(htmlspecialchars($_POST['email']), htmlspecialchars($_POST['password']));
    
    if($userLogin != false) {
    // echo "başarılı";

        if(!empty($_SESSION)) {
            echo "<pre>";
            print_r($_SESSION["userLoggedIn"]);
            echo "</pre>";
        } else {
            echo "session is empty";
        }
    
    }
    else {
        echo "fail";
    }
}

// if(isset($_POST['addToCart'])) {

    // echo "<pre>";
    // print_r($dbProduct->pageList());
    // echo "</pre>";
    // exit;

//     $result = $user->addToCart($_SESSION['userLoggedIn'], $_POST['product_id']);

//     if($result == true) {

//         echo "success";
//     }
// }

$userLoggedIn = $_SESSION['userLoggedIn'];

if($_SESSION['userLoggedIn'] != null) {

    if(isset($_POST['addToCart'])) {

        // echo "<pre>";
        // print_r($_POST);
        // echo "</pre>";
        // exit;
    
        $result = $user->addToCart($_POST, [
            'form_name' => 'addToCart'
        ]);
    
        if($result = ['status']) {
            echo "Başarılı";
        }
        else {
            echo "Başarısız";
        }
    }
}else {
    
    $_SESSION['userLoggedIn'] == null;
}

if(isset($_POST['decrease']))
{
    // echo "<pre>";
    // print_r($_POST);
    // echo "</pre>";
    // exit;
    $user->decreaseQty($_POST['product_id'], $userLoggedIn['user_id']); 
}

if(isset($_POST['increase']))
{
    // echo "<pre>";
    // print_r($_POST);
    // echo "</pre>";
    // exit;
    $user->increaseQty($_POST['product_id'], $userLoggedIn['user_id']); 
}

if(isset($_POST['delete']))
{
    // echo "<pre>";
    // print_r($_POST);
    // echo "</pre>";
    // exit;
    $user->deleteFromCart($_POST['product_id'], $userLoggedIn['user_id']); 
}




$cartList = $user->getCartList($userLoggedIn['user_id']);
// echo "<pre>";
// print_r($cartList);
// echo "</pre>";
// exit;
$countCartList = count($cartList);
$totalPrice = $user->getTotalPriceCart($userLoggedIn['user_id']);
echo session_id();

?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>MyStore</title>
</head>
<body>
    <div class="navbar navbar-inverse navbar-fixed-top">
        <div class="container-fluid">
        <nav class="nav">
            <a class="nav-link active" href="index.php">Ticaret</a>
            <a class="nav-link" href="#"><span class="fa fa-home"></span> Ev</a>
            <a class="nav-link" href="#"><span class="fa fa-window"></span>Ürün</a>
            <form class="d-flex" action="" method="GET">
                <input type="text" name="product_keywords" id="search">
                <button class="btn btn-primary ml-2" name="search" id="search_btn">Ara</button>
            </form>
        </nav>

        <nav class="nav navbar-right">
            <div style="align-items:center; justify-content:space-between">
            <a href="tr.php"><img class="m-2" src="images/tr.png" alt="" width="40px" height="20px"></a>
            <a href="en.php"><img class="m-2" src="images/en.png" alt="" width="40px" height="20px"></a>
            </div>
            <?php

            if(!empty($_SESSION['userLoggedIn'])) { ?>
                <h5 style="margin-right:10px"> Merhaba <?=$_SESSION['userLoggedIn']['first_name']?></h5>
            <?php } ?>
            <li class="mr-2">
            <div class="dropdown">
                <button class="btn btn-danger dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                   <span style="margin-right:10px; font-weight;:font-weight:bold; padding:0px 5px; text-align:center; border:1px solid white; border-radius:40%"><?php echo $countCartList?></span><span class="fa fa-shopping-cart"></span> Sepet
                </button>
                <div class="dropdown-menu" style="width:750px; left:-600px !important" aria-labelledby="dropdownMenuButton">
                <table class="table">
                    <div class="total">
                        <h5>Total: <?=$totalPrice[0]['SUM(total_amount)']?></h5>
                    </div>
                    <thead>
                        <tr>
                        <th scope="col">Ürün id</th>
                        <th scope="col">Ürün fotğraf</th>
                        <th scope="col">Ürün isim</th>
                        <th scope="col">Ürün fiyat</th>
                        <th>düşür</th>
                        <th>Miktar</th>
                        <th>arttır</th>
                        <th>Ürünü sil</th>
                        </tr>
                    </thead>
                    <tbody>
                    <tr>
                    <?php 
                        if(count($cartList) > 0) {
                            foreach($cartList as $cartItem) {

                        ?>
                        <th scope="row"><?=$cartItem['id']?></td>
                        <td><img width="50" src="images/<?=$cartItem['product_image']?>" alt=""></td>
                        <td><?=$cartItem['product_title']?></td>
                        <td><?=$cartItem['price']?></td>
                        <td>
                        <form method="post">
                            <input type="hidden" value="<?=$cartItem['product_id']?>" name="product_id"/>
                            <input type="hidden" value="<?=$userLoggedIn['user_id']?>" name="user_id"/>
                            <button class="btn btn-danger pr-2 pl-2" type="submit" name="decrease" style="font-size:15px; font-weight:bold">-</button>
                        </form>
                        </td>
                        <td style="align-items:center; justify-content:center"><?=$cartItem['qty']?></td>
                        <td>
                        <form method="post">
                            <input type="hidden" value="<?=$cartItem['product_id']?>" name="product_id"/>
                            <input type="hidden" value="<?=$userLoggedIn['user_id']?>" name="user_id"/>
                            <button class="btn btn-success pr-2 pl-2" type="submit" name="increase" style="font-size:15px; font-weight:bold">+</button>
                        </form>
                        </td>
                        <td>
                        <form method="post">
                            <input type="hidden" value="<?=$cartItem['product_id']?>" name="product_id"/>
                            <input type="hidden" value="<?=$userLoggedIn['user_id']?>" name="user_id"/>
                            <button class="btn btn-danger pr-2 pl-2" type="submit" name="delete" style="font-size:15px; font-weight:bold"><i class="fa fa-trash"></i></button>
                        </form>
                        </td>
                        </tr>
                    <?php } } else { ?>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    <?php } ?>
                    </tr>
                    </tbody>
                    
                </table>
                </div>
                </div>
            </li>
            <li>
            <div class="dropdown">
                <?php 
                
                if(!empty($_SESSION['userLoggedIn'])) { ?>
                <a href="logout.php" class="nav-link" type="button">
                   Sign Out
                </a>
                
                <?php } else { ?>
                
                <a class="nav-link dropdown-toggle bg-primary" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <span class="fa fa-user"></span>  Giriş Yapınız
                </a>
                
                <div class="dropdown-menu form-group" aria-labelledby="dropdownMenuButton">
                
                    <form action="" method="post">
                        <label for="">Email:</label>
                        <input class="form-control" type="text" name="email">
                        <label for="">Şifre</label>
                        <input class="form-control" type="password" name="password">
                        <input class="btn btn-primary d-block"type="submit" name="login" value="Giriş Yap">
                        <a href="">Şifremi unuttum</a>
                    </form>
                </div>
                <?php } ?>
            </div>
            </li>
            <?php 

            if(empty($_SESSION['userLoggedIn'])){ ?>

                <li><a class="nav-link" href="register.php">Üye ol</a></li>

                <?php } ?>
        </nav>
        </div>
    </div>
    <p><br/></p>
    <p><br/></p>
    <p><br/></p>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-1">
                <div class="nav nav-pills nav-stacked">
                    <li class="active bg-primary mb-2 p-1" style="border-radius: 4px"><a href="index.php?all_categories"><h5 style="color:white">Kategoriler</h5></a></li>
                    
                    <?php

                    foreach($allCategories as $category) { ?>
                    <li class="p-1"><a href="index.php?cat_id=<?=$category['cat_id']?>"><?=$category['cat_title']?></a></li>
                    
                    <?php } ?>

                </div>
                <div class="nav nav-pills nav-stacked">
                    <li class="active bg-primary mb-2 p-1" style="border-radius: 4px"><a href="index.php?all_brands"><h5 style="color:white">Brands</h5></a></li>
                    
                    <?php
                    foreach($allBrands as $brand ) { ?>
                    <li class="p-1"><a href="index.php?brand_id=<?=$brand['brand_id']?>"><?=$brand['brand_title']?></a></li>
                    
                    <?php } ?>

                </div>
            </div>
            <div class="col-md-8">
                <div class="panel panel-info" style="border:1px solid grey">
                    <div class="panel-heading"><h4>Products</h4></div>
                    <div class="row">
                    <?php
                    if(isset($_GET['search'])) {

                        foreach($searchProducts as $s) { ?>

                        <div class="card col-md-4">
                        <form action="" method="POST">
                                        <div class="card-body">
                                            <h5 class="card-title" name="<?=$s['product_title']?>"><?=$s['product_title']?></h5>
                                            <img src="images/<?=$s['product_image']?>" class="img-fluid img-thumbnail" alt="..." name="<?=$s['product_image']?>">
                                        </div>
                                        <div class="card-footer">
                                        
                                            <button class="btn btn-danger" name="addToCart"><span class="fa fa-shopping-cart"></span> Add to cart</button>
                                        
                                            <label for=""><?=$s['product_price']?> ₺</label>
                                            <input type="hidden" value="<?=$s['product_id'] ?>" name="product_id">
                                            <input type="hidden" value="<?=$userLoggedIn['user_id']?>" name="user_id">
                                            <input type="hidden" value="<?=$s['product_title']?>" name="product_title">
                                            <input type="hidden" value="<?=$s['product_image']?>" name="product_image">
                                            <input type="hidden" value="<?=$s['product_price']?>" name="price">
                                        </div>
                                    </form>
                        </div>
                            
                    <?php } }
                    else if(isset($_GET['cat_id'])) { 
                             $categoryProducts = $dbProduct->getCategoryProducts($_GET['cat_id']);

                             foreach($categoryProducts as $c){ ?>
                            
                                <div class="card col-md-4">
                                    <form action="" method="POST">
                                        <div class="card-body">
                                            <h5 class="card-title" name="<?=$c['product_title']?>"><?=$c['product_title']?></h5>
                                            <img src="images/<?=$c['product_image']?>" class="img-fluid img-thumbnail" alt="..." name="<?=$c['product_image']?>">
                                        </div>
                                        <div class="card-footer">
                                        
                                            <button class="btn btn-danger" name="addToCart"><span class="fa fa-shopping-cart"></span> Add to cart</button>
                                        
                                            <label for=""><?=$c['product_price']?> ₺</label>
                                            <input type="hidden" value="<?=$c['product_id'] ?>" name="product_id">
                                            <input type="hidden" value="<?=$userLoggedIn['user_id']?>" name="user_id">
                                            <input type="hidden" value="<?=$c['product_title']?>" name="product_title">
                                            <input type="hidden" value="<?=$c['product_image']?>" name="product_image">
                                            <input type="hidden" value="<?=$c['product_price']?>" name="price">
                                        </div>
                                    </form>
                                </div>
                           

                    <?php } } 

                    else if(isset($_GET['brand_id'])) { 
                        $brandProducts = $dbProduct->getBrandProducts($_GET['brand_id']);

                        foreach($brandProducts as $b){ ?>
                            <div class="card col-md-4">
                                <form action="" method="POST">
                                    <div class="card-body">
                                        <h5 class="card-title" name="<?=$b['product_title']?>"><?=$b['product_title']?></h5>
                                        <img src="images/<?=$b['product_image']?>" class="img-fluid img-thumbnail" alt="..." name="<?=$b['product_image']?>">
                                    </div>
                                    <div class="card-footer">
                                    
                                        <button class="btn btn-danger" name="addToCart"><span class="fa fa-shopping-cart"></span> Add to cart</button>
                                    
                                        <label for=""><?=$b['product_price']?> ₺</label>
                                        <input type="hidden" value="<?=$b['product_id'] ?>" name="product_id">
                                        <input type="hidden" value="<?=$userLoggedIn['user_id']?>" name="user_id">
                                        <input type="hidden" value="<?=$b['product_title']?>" name="product_title">
                                        <input type="hidden" value="<?=$b['product_image']?>" name="product_image">
                                        <input type="hidden" value="<?=$b['product_price']?>" name="price">
                                    </div>
                                </form>
                            </div>

                    <?php } } 
                    else if(isset($_GET['cat_id']) OR !isset($_GET['brand_id']) OR !isset($_GET['search'])){ 
                          foreach($allProducts as $product) { ?>
                            <div class="card col-md-4">
                                <form action="" method="POST">
                                    <div class="card-body">
                                        <h5 class="card-title" name="<?=$product['product_title']?>"><?=$product['product_title']?></h5>
                                        <img src="images/<?=$product['product_image']?>" class="img-fluid img-thumbnail" alt="..." name="<?=$product['product_image']?>">
                                    </div>
                                    <div class="card-footer">
                                    
                                        <button class="btn btn-danger" name="addToCart"><span class="fa fa-shopping-cart"></span> Add to cart</button>
                                    
                                        <label for=""><?=$product['product_price']?> ₺</label>
                                        <input type="hidden" value="<?=$product['product_id'] ?>" name="product_id">
                                        <input type="hidden" value="<?=$userLoggedIn['user_id']?>" name="user_id">
                                        <input type="hidden" value="<?=$product['product_title']?>" name="product_title">
                                        <input type="hidden" value="<?=$product['product_image']?>" name="product_image">
                                        <input type="hidden" value="<?=$product['product_price']?>" name="price">
                                    </div>
                                </form>
                            </div>

                        <?php } } ?>
                    
                    </div>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>
    <div class="footer">
        <div class="container" style="justify-content:center;">
            <?php echo $dbProduct->pageList()?>
        </div>
    </div>
</body>
<script
  src="https://code.jquery.com/jquery-3.5.1.js"
  integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
  crossorigin="anonymous">
</script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
<script src="js/main.js"></script>
</html>