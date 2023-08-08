<?php
require   "config.php";


if(!empty($_SESSION["id"])){
  $localid = $_SESSION["id"];
  $localresult = mysqli_query($localconn, "SELECT * FROM users WHERE id = $localid");
  $localrow = mysqli_fetch_assoc($localresult);
}
else{
  header("Location: login.php");
}

include "postconfig.php";

if(isset($_POST['post'])){

    $localusername = $localrow['username'];
    $localmessage = $_POST['message'];
    $localdate = date("y-m-d") . " " . date("h:i:sa");
    if(isset($_POST['cb'])){
      $localanon = true;
    }
    else{
      $localanon = false;
    }


    if(strlen($localmessage) >= 10 and $localrow["muted"] != 1){
      $localsql = $localconn->prepare("INSERT INTO posts (username, message, anon, date)
      VALUES ('$localusername', '$localmessage', '$localanon', '$localdate')");
      if ($localsql->execute()) {
        echo "<script> alert('The post sent succesfully.')</script>";
      } else {
        echo "Error: " . $localsql . "<br>" . $localconn->error;
      }
    }
    elseif($localrow["muted"] == 1){
      echo "<script> alert('Your account is suspended.')</script>";
    }
    else{
      echo "<script> alert('The Message Have To Be At Least 10 Characters')</script>";
    }
}


?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>POML - Main Page</title>
    <link rel="stylesheet" href="main.css">
  </head>
  <body>
    <ul>
      <li><a href="logout.php">Logout</a></li>
      <li><a href="settings.php">Settings</a></li>
      <?php
      if($localrow["admin"] == 1){
      echo '<li><a href="admin.php">Admin</a></li>';
      }
      ?>
    </ul>

    <div class="wrapper">
    <h1>Welcome <?php echo $localrow['name']?></h1><br>
      <form action="" method="post" class="form" onsubmit="return">
      <div class="check">
        <label for="name">Anonymous?</label>
        <input type="checkbox" class="name" name="cb">
        </div>
        <textarea name="message" cols="30" rows="10" class="message" placeholder="Enter your message..."></textarea>
        <button type="submit" class="btn" name="post">Post</button>
      </form>
    </div>

    <div class="cnt">
      <?php

          $sql = "SELECT * FROM posts";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
              while($row = $result->fetch_assoc()) {

      ?>

      <h3><?php if($row['anon'] == true){
        echo "Hidden";
      }
      else{
        echo $row['username'];
      }
      ?></h3>
      <p><?php echo $row['message'];?></p>
      
      <?php } } ?>

    </div>
    <script>
    if ( window.history.replaceState ) {
      window.history.replaceState( null, null, window.location.href );
      }
    </script>
  </body>
</html>