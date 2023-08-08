<?php
require 'config.php';
if(!empty($_SESSION["id"])){
  header("Location: index.php");
}
if(isset($_POST["submit"])){
  $usernameemail = $_POST["usernameemail"];
  $password = $_POST["password"];
  $result = mysqli_query($localconn, "SELECT * FROM users WHERE username = '$usernameemail' OR email = '$usernameemail'");
  $row = mysqli_fetch_assoc($result);
  if(mysqli_num_rows($result) > 0){
    if($password == $row['password']){
      $_SESSION["login"] = true;
      $_SESSION["id"] = $row["id"];
      $_SESSION["admin"] = $row["admin"];
      $_SESSION["user"] = $row["username"];
      header("Location: index.php");
    }
    else{
      echo
      "<script> alert('Informations Entered Is Incorrect'); </script>";
    }
  }
  else{
    echo
    "<script> alert('No Matching Account Found'); </script>";
  }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>POML - Login</title>
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  </head>
  <body>
    <div class="logo">
    <h2>Login</h2>
    <form class="" action="" method="post" autocomplete="off">
      <input type="text" name="usernameemail" id = "usernameemail" required value="" placeholder="Username or Email" maxlength="16">
      <div id="cp">
      <input type="password" name="password" id = "password" required value="" placeholder="Password" maxlength="16"> 
      <i class="fa-regular fa-eye-slash fa-xl" style="color: #f24c3d;" id="eye""></i>
      </div>
      <button type="submit" name="submit">Login</button>
    </form>
    <p>If you don't have an account just register.</p>
    <a href="register.php">Registration</a>
    </div>
    <script src="login.js"></script>
  </body>
</html>