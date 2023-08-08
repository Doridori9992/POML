<?php
require "config.php";

if ($_SESSION["admin"] == 0) {
  header("Location: index.php");
} elseif (empty($_SESSION["id"])) {
  header("Location: login.php");
}
include "postconfig.php";

if(isset($_POST['dlt']) && isset($_POST['idea'])){
  if(intval($_POST['idea']) != 0){
    $find = mysqli_prepare($conn, "SELECT * FROM `posts` WHERE `id` = ?");
    mysqli_stmt_bind_param($find, "i", $_POST['idea']);
    mysqli_stmt_execute($find);
    $result = mysqli_stmt_get_result($find);
    $postDetails = mysqli_fetch_assoc($result);
    if (mysqli_num_rows($result) > 0) {
      $adminValue = $_SESSION["user"];
      $localdate = date("y-m-d") . " " . date("h:i:sa");
      $id = mysqli_real_escape_string($conn, $postDetails['id']);
      $username = mysqli_real_escape_string($conn, $postDetails['username']);
      $message = mysqli_real_escape_string($conn, $postDetails['message']);
      $anon = mysqli_real_escape_string($conn, $postDetails['anon']);
      $date = mysqli_real_escape_string($conn, $postDetails['date']);
      $sql = mysqli_prepare($conn, "INSERT INTO `oldposts` (id, username, message, anon, postdate, deleteddate, adminwhodeleted) VALUES ('$id', '$username', '$message', '$anon', '$date', '$localdate', '$adminValue')");
      mysqli_stmt_execute($sql);
      $delete = mysqli_prepare($conn, "DELETE FROM `posts` WHERE `id` = {$_POST['idea']}");
      mysqli_stmt_execute($delete);
      echo "<script> alert('The post is deleted.')</script>";
    }
    else{
      echo "<script> alert('No matching post.')</script>";
    }
  }
  else{
    echo "<script> alert('Enter a post id.')</script>";
  }

}
if(isset($_POST['udl'])){
  $suspend = mysqli_prepare($localconn, "UPDATE `users` SET `muted` = '1' WHERE `users`.`id` = ?;");
  mysqli_stmt_bind_param($suspend, "i", $_POST["uid"]);
  mysqli_stmt_execute($suspend);
}
if(isset($_POST['us'])){
  $suspend = mysqli_prepare($localconn, "UPDATE `users` SET `muted` = '0' WHERE `users`.`id` = ?;");
  mysqli_stmt_bind_param($suspend, "i", $_POST["uid"]);
  mysqli_stmt_execute($suspend);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>POML - Admin Page</title>
  <link rel="stylesheet" href="admin.css">
</head>

<body>
  <ul>
    <li><a href="logout.php">Logout</a></li>
    <li><a href="settings.php">Settings</a></li>
    <li><a href="index.php">Home</a></li>
  </ul>
  <div class="man">
  <div class="cnt">
  <h2>POST MANAGEMENT</h2><br>
    <div class="tbat">
      <form method="post" action="" onsubmit="return">
        <input type="number" class="tb" placeholder="Type post id." name="idea" id="idea">
        <input type="submit" class="btn" value="Delete" name="dlt" id="btn">
      </form>
      </div>
    <?php

    $sql = "SELECT * FROM posts";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {

    ?>

        <h3><?php
            echo $row['username']; ?></h3>
        <span><?php echo $row['message']; ?> - <?php echo $row['id'] ?></span>

    <?php }
    } ?>
      </div>
  <div class="um">
    <h2>USER MANAGEMENT</h2><br>
    <div class="usermanagement">
      <form method="post" action="">
      <input type="number" class="uid" placeholder="Type user id." name="uid" id="uid">
        <input type="submit" class="udl" value="Suspend" name="udl" id="udl">
        <input type="submit" class="us" value="Unsuspend" name="us" id="us">
      </form>
    </div>
    <?php

    $sqlu = "SELECT * FROM `users` WHERE `admin` != 1";
    $resultu = $localconn->query($sqlu);
    if ($resultu->num_rows > 0) {
    while ($rowu = $resultu->fetch_assoc()) {

  ?>

    <h3><?php
        echo $rowu["username"]; ?></h3>
    <span><?php echo $rowu["date"]; ?> - <?php
    if($rowu["muted"] == 1){
      echo "Suspended - ";
    }
    ?><?php echo $rowu["id"] ?></span>

<?php }
} ?></div></div>

  <script>
    if (window.history.replaceState) {
      window.history.replaceState(null, null, window.location.href);
    }
  </script>
</body>

</html>