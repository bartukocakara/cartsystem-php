<?php
      require_once 'classes/db.php';
      require_once 'classes/User.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>

<?php
  $user = new User();

  if(isset($_POST['register']) AND ($_POST['user_password'] === $_POST['psw-repeat'])) {

      $sonuc = $user->create('users', $_POST, [
        "form_name" => "register",
        "repeat" => "psw-repeat",
        "pass" => "user_password"
      ]);
      
      
      if($sonuc['status']) {

        echo "Başarılı";
        // header('location:register.php');
        // echo "<pre>";
        // print_r($_SESSION['userLoggedIn']);
        // echo "</pre>";
        // echo "Başarılı";
        // exit;
        
      }
      else {
        echo "Başarısız";
      }
    }
?>
<form action="" style="border:1px solid #ccc" method="post">

  <div class="container">
    <h1>Sign Up</h1>
    <p>Please fill in this form to create an account.</p>
    <hr>

    <label for="firstname"><b>First Name</b></label>
    <input type="text" placeholder="First Name" name="first_name" required>

    <label for="lastname"><b>Last Name</b></label>
    <input type="text" placeholder="Last Name" name="last_name" required>
    
    <label for="email"><b>Email</b></label>
    <input type="text" placeholder="Enter Email" name="email" required>

    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="user_password" required>

    <label for="psw-repeat"><b>Repeat Password</b></label>
    <input type="password" placeholder="Repeat Password" name="psw-repeat" required>

    <label for="mobile"><b>Mobile</b></label>
    <input type="text" placeholder="Mobile" name="mobile" required>

    <label for="address1"><b>Address Line 1</b></label>
    <input type="text" placeholder="Address Line 1" name="address1" required>

    <label for="address2"><b>Address Line 2</b></label>
    <input type="text" placeholder="Address Line 2" name="address2" required>

    <div class="clearfix">
      <button type="button" class="cancelbtn">Cancel</button>
      <button type="submit" class="signupbtn" name="register">Sign Up</button>
    </div>
  </div>
</form>
</body>
</html>