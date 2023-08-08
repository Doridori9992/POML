<?php
require "config.php";
if(!empty($_SESSION["id"])){
    header("Location: index.php");
}
if(isset($_POST["submit"])){

    $name = $_POST["name"];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmpassword = $_POST["confirmpassword"];
    $date = date('Y-m-d');
    $duplicate = mysqli_query($localconn, "SELECT * FROM users WHERE username = '$username' OR email = '$email'");
    if(mysqli_num_rows($duplicate) > 0){
        echo
        "<script> alert('Username or Email Is Already In Use')</script>";
    }
    else{
        if($password == $confirmpassword){
            $api_key = "1bd6da3666b343a6b67193d58cec91f9";

            $ch = curl_init();
            
            curl_setopt_array($ch, [
                CURLOPT_URL => "https://emailvalidation.abstractapi.com/v1?api_key=$api_key&email=$email",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true
            ]);
            
            $response = curl_exec($ch);
            
            curl_close($ch);
            
            $data = json_decode($response, true);

            if($data["is_disposable_email"]["value"] == true and $data["is_valid_format"]["value"] == true or $data["is_free_email"]["value"] == true and $data["is_valid_format"]["value"] == true){
                $query = mysqli_prepare($localconn, "INSERT INTO users (name, username, email, password, date, muted, admin) VALUES (?, ?, ?, ?, ?, 0, 0)");
                mysqli_stmt_bind_param($query, 'sssss', $name, $username, $email, $password, $date);
                mysqli_stmt_execute($query);
                header("Location: login.php");
                echo
                "<script> alert('You Have Registered Succesfully')</script>";
            }
            else{
                echo
                "<script>alert('The Email Is Wrong') </script>";
            }

        }
        else{
            echo
            "<script> alert('Passwords Does Not Match')</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <title>POML - Register</title>
    <link rel="stylesheet" href="register.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body>
    <div class="rego">
        <h2>Registration</h2>
        <form class="" action="" method="post" autocomplete="off">
        <input type="text" name="name" id = "name" required value="" maxlength="16" pattern="^[A-Za-z]+$" title="Only Alphabetical Letters Are Allowed." placeholder="Your Name"> 
        <input type="text" name="username"  title="Only letters and numbers are allowed" id = "username" required value="" pattern="^(?=.*[A-Za-z].*[A-Za-z])[A-Za-z0-9]+$" placeholder="Username" maxlength="16">
        <input type="email" name="email" id = "email" required value="" placeholder="Email"> 
        <div class="cp">
        <input type="password" name="password" id = "password" required value="" pattern=".{6,}" placeholder="Password" maxlength="16" title="At least 6 digits"> 
        <i class="fa-regular fa-eye-slash fa-xl" style="color: #f24c3d;" id="eye""></i>
        </div>
        <div class="cp">
        <input type="password" name="confirmpassword" id = "confirmpassword" required value="" placeholder="Confirm Password"> 
        <i class="fa-regular fa-eye-slash fa-xl" style="color: #f24c3d;" id="ceye""></i>
        </div>
        <button type="submit" name="submit">Register</button>
        </form>
        <h2 id="hehe"></h2>
        <p>If you already have an account login.</p>
        <a href="login.php">Login Page</a>
    </div>
    <script src="register.js"></script>
    <script>
    if ( window.history.replaceState ) {
      window.history.replaceState( null, null, window.location.href );
      }
    </script>
</body>
</html>