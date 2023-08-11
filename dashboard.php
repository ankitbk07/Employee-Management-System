<?php
session_start();
require_once 'dbcompany.php';
if(empty($_SESSION['username']))
{
    header('location:login.php');
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Welcome To Dash board</h1>
    <button><a href="company/index.php">CRUD Operation for Company</a></button>
    <button><a href="employee/index.php">CRUD Operation for Employee</a></button>

</body>
</html>