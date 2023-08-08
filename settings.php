<?php
require "config.php";

if(!empty($_SESSION["id"])){
    $localid = $_SESSION["id"];
    $localresult = mysqli_query($localconn, "SELECT * FROM users WHERE id = $localid");
    $localrow = mysqli_fetch_assoc($localresult);
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
    <title>POML - Settings</title>
    <link rel="stylesheet" href="settings.css">
</head>
<body>
    <ul>
      <li><a href="logout.php">Logout</a></li>
      <li><a href="index.php">Home</a></li>
      <?php
      if($localrow["admin"] == 1){
      echo '<li><a href="admin.php">Admin</a></li>';
      }
      ?>
    </ul>
    <div class="info">
      <p class="name">Name : <?php echo $localrow["name"]; ?></p>
      <p class="username">Username : <?php echo $localrow["username"]; ?></p>
      <p class="email">Email : <?php echo $localrow["email"]; ?></p>
      <p class="date">Registeration Date : <?php echo $localrow["date"]; ?></p>
      <a class="btn" href="changepassword.php">Change Password</a>
    </div>
</body>
</html>

