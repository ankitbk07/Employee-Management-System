<?php
//This script will handle login
session_start();
//check if the user is already login
if(isset($_SESSION['username'])){
    header("LOCATION:index.php");
    exit;
}
require_once "config.php";
$username = $password ="";
$username_err = $password_err = "";
//if request method is post
if($_SERVER['REQUEST_METHOD'] == "POST"){
    if(empty(trim($_POST['username'])) || empty(trim($_POST['password']))){
        $username_err = "Please enter username ";
        $password_err = "Please enter your password";
    }
    else{
        $username =trim( $_POST['username']);
        $password = trim($_POST['password']);
    }
    if(empty($username_err) && empty($password_err)){
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $param_username);
        $param_username = $username;
        //try to execute the statement
        if(mysqli_stmt_execute($stmt)){
            mysqli_stmt_store_result($stmt);
         if(mysqli_stmt_num_rows($stmt) == 1){
            mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
            if(mysqli_stmt_fetch($stmt)){
                if(password_verify($password, $hashed_password)){
                    //this means the password is correct
                    session_start();
                    $_SESSION["username"] = $username;
                    $_SESSION["id"] = $id;
                    $_SESSION["loggedin"] = true;
                    //redirect user to welcome page
                    header("location:dashboard.php");
                }
                else{
                    $password_err = "Incorrect password";
                }
            }
         }
        }
    }
}
       
?>  

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="form">
    <h1 class="header-form" >Log In</h1>    
    <form action="" method="POST">
            <input class="input-form" type="text" name ='username' placeholder='Usernmae'> 
            <input class="input-form" type="password" name="password" placeholder="Password" />
            <button type= 'submit' class='btn-form'>Log In</button>
        </form> 
    </div>
</body>
</html>