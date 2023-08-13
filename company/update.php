<?php
    session_start();
    require_once '../dbcompany.php';
    if(empty($_SESSION['username']))
{
    header('location:login.php');
}

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Company</title>
    <link rel="stylesheet" href="update.css">
</head>
<body>
    <?php 
    $get_companyname = $_GET['username'];
    $get_address = $_GET['address'];
    
    if($_SERVER['REQUEST_METHOD']=='POST')
    {
        
        $update_companyname = $_POST['company-name'];
        $update_address =$_POST['address'];
        $update_sql = 'UPDATE company SET company_name = ?, address = ? where company_name =? AND address =?';
        $update_stmt = mysqli_stmt_init($com_conn);
        mysqli_stmt_prepare($update_stmt,$update_sql);
        mysqli_stmt_bind_param($update_stmt,'ssss',$update_companyname,$update_address,$get_companyname,$get_address);
        mysqli_stmt_execute($update_stmt); 
        mysqli_stmt_close($update_stmt);
        mysqli_next_result($com_conn);
         

        header('location:index.php');

    }
    
    ?>
    <h1> Update</h1>
    <form action="" method="post">
    <input type="text" name ="company-name" placeholder="Company Name" value="<?=$get_companyname?>">
    <input type="text" name ="address" placeholder="Address" value="<?=$get_address?>">
    <button type="submit">Update</button>
    </form>
</body>
</html>