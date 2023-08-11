<?php 
  require_once  "config.php";
  $username = $email = $password = $confirm_password = "";
  $username_err = $email_err = $password_err = $confirm_password_err = "";
  if($_SERVER['REQUEST_METHOD'] == "POST"){
    //check if username is empty
    if(empty(trim($_POST["username"]))){
      $username_err = "Username cannot be blank";
    }
    else{
      if  (! preg_match('/^[A-Za-z]+\s[A-Za-z]+(\s[A-Za-z]+)?$/', trim($_POST["username"]))){
       $username_err = "Invalid name format";
     }
      $sql = "SELECT id FROM users WHERE username = ?";
      $stmt = mysqli_prepare($conn, $sql);
      if($stmt){
        mysqli_stmt_bind_param($stmt, "s",  $param_username);
        //set the value of param username
        $param_username = trim($_POST['username']);
        //try to execute the statement
        if(mysqli_stmt_execute($stmt)){
          mysqli_stmt_store_result($stmt);
          if(mysqli_stmt_num_rows($stmt) == 1){
            $username_err = "This username is already taken.";
          }
          else{
            $username = trim($_POST['username']);
          }
        }
        else{
          echo "something went wrong";
        }
      }

  mysqli_stmt_close($stmt);
    }
    //check for email
    $emailcheck = trim($_POST['email']);
    $sql1 = "SELECT * FROM users WHERE email = '$emailcheck' ";
  $result = $conn->query($sql1);
    if(empty(trim($_POST['email']))){
      $email_err = "Email cannot be blank.";
    }
   elseif($result->num_rows > 0) {
    $email_err = "Email already exists";
  }
   elseif(!filter_var( trim($_POST['email']), FILTER_VALIDATE_EMAIL)) {
        $email_err = "Invalid email format";
    }
    else{
      $email = trim($_POST['email']);
    }
    //check for the password
    if(empty(trim($_POST['password']))){
      $password_err = "Password cannot be blank.";
    }
    elseif(strlen(trim($_POST['password'])) < 5){
      $password_err = "Password cannot be less than 5 characters.";
    }
    else{
      $password = trim($_POST['password']);
    }
    //check for confirm password field
    if(trim($_POST['confirm_password']) != trim($_POST['confirm_password'])){
      $password_err = "Password should match.";
    }
    // if there were no errors
    if(empty($username_err) &&  empty($email_errr) && empty($password_err) && empty($confirm_password_err)){
      $sql = "INSERT INTO users (username, email,  password) VALUES (?, ?, ?)";
      $stmt = mysqli_prepare($conn, $sql);
      if($stmt){
        mysqli_stmt_bind_param($stmt, "sss", $param_username,  $param_email, $param_password);
        // set these parameters
        $param_username = $username;
        $param_email = $email;
        $param_password = password_hash($password, PASSWORD_DEFAULT);
        //try to execute the query
        if(mysqli_stmt_execute($stmt)){
          header("Location: login.php");
        }
        else{
          echo " Something went wrong...cannot redirect!";
        }
      }
      mysqli_stmt_close($stmt);
    }
    mysqli_close($conn);
  }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>signup
    </title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1 class="header">Sign Up</h1>
        <p class="sub">Please fill in this form to add an account.</p>
        <p style="color : red;">
          <?php
           echo $username_err. "<br>". $email_err. "<br>" . $password_err;
           ?>
        </p>
        <form action="register.php" method="POST">
        <label for="name"><b>Name:</b></label>
        <input type="text" placeholder="Enter name" name="username" id = "username"  required>
        <br>
        <label for="email"><b>Email:</b></label>
        <input type="text" placeholder="Enter Email" name="email" required>
        <br>
        <label for="psw"><b>Password:</b></label>
        <input type="password" placeholder="Enter Password" name="password" id = "password" required>
        <br>
        <label for="psw-repeat"><b>Confirm Password:</b></label>
        <input type="password" placeholder="Re-enter Password" name="confirm_password"  id ="confirm_password" required>
        <br>
        <label>
          <input type="checkbox"  name="remember" style="margin-bottom:15px" onclick="togglePasswordVisibility()"> Show Password
        </label>
        <div class="clearfix">
          <button type="submit" class="signupbtn">Sign Up</button>
            <button type="reset" class="cancelbtn">Cancel</button>
         
          
        </div>
      </form>
    </div>
    <script>
function togglePasswordVisibility() {
    var passwordInput = document.getElementById("password");
    var confirmpasswordInput = document.getElementById("confirm_password");
    if (passwordInput.type === "password" ) {
        passwordInput.type = "text";
        confirmpasswordInput.type = "text";
    } else {
        passwordInput.type = "password";
        confirmpasswordInput.type = "password";
    }
}
</script>
</body>
</html>