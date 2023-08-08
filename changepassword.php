<?php
require 'config.php';
if(!empty($_SESSION["id"])){
    $localid = $_SESSION["id"];
    $localresult = mysqli_query($localconn, "SELECT * FROM users WHERE id = $localid");
    $localrow = mysqli_fetch_assoc($localresult);
    $password = $localrow['password'];
  }
  else{
    header("Location: login.php");
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POML - Change Password</title>
    <link rel="stylesheet" href="cp.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <ul>
      <li><a href="settings.php">Return</a></li>
    </ul>
    <form action="" method="post" class="pass" id="fr">
      <div class="cp">
        <input type="password" name="cps" id="cps" class="pi" placeholder="Enter the current password." required value="" maxlength="16">
        <i class="fa-regular fa-eye-slash fa-2xl" style="color: #f24c3d;" id="eye""></i>
      </div>
        <input type="password" name="nps" id="nps" class="pi" placeholder="Enter the new password." required value="" pattern=".{8,}" maxlength="16">
        <input type="password" name="vps" id="vps" class="pi" placeholder="Validate the new password." required value="" pattern=".{8,}" maxlength="16">
        <button name="btn">Change Password</button>

    </form>
    <script src="cp.js"></script>
</body>
</html>

<?php
if(isset($_POST["btn"])){
  if($password == $_POST["cps"] and $_POST["nps"] == $_POST["vps"] and $_POST["cps"] != $_POST["nps"] ){
    $query = mysqli_prepare($localconn, 'UPDATE `users` SET `password` = ? WHERE `users`.`id` = ?');
    $newPassword = $_POST["nps"];
    $userId = $_SESSION["id"];
    mysqli_stmt_bind_param($query, 'si', $newPassword, $userId);
    mysqli_stmt_execute($query);
    echo "<script> alert('The password changed succesfully.')</script>";
    header("Location: index.php");
  }
  elseif($_POST["cps"] != $_POST["vps"]){
    echo "<script> alert('Passwords are not matching.')</script>";
  }
  
  elseif($password != $_POST["cps"]){
    echo "<script> alert('Current password you have entered is incorrect.')</script>";
  }
  elseif($_POST["cps"] == $_POST["nps"]){
    echo "<script> alert('Passports entered are the same.')</script>";
  }
}
?>