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
    <title>Document</title>
    <link rel="stylesheet" href="index1.css">
</head>
<body> 
    <div class="header">
            <div>
                <h1> Welcome <?php echo  ucwords ($_SESSION['username'])?>  </h1>
            </div>

            <div>
                <h1> <a class='link' href="../logout.php"> Logout </a></h1>
            </div>
                
    </div>
    <form action="" method="POST" >
        <input type="text" name ='company-name' placeholder="Company Name" >
        <input type="text" name ='address' placeholder="Address">
        <button type="submit" class='add'> Add </button> 
    </form>
    <?php 
    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
        $company_name = $_POST['company-name'];
        $address = $_POST['address'];
        $find_sql = "SELECT company_name,address FROM company where company_name =? and address = ?";
        $find_stmt  = mysqli_stmt_init($com_conn);
        mysqli_stmt_prepare($find_stmt,$find_sql);
        mysqli_stmt_bind_param($find_stmt,"ss",$company_name,$address);
        mysqli_stmt_execute($find_stmt);
        mysqli_stmt_store_result($find_stmt);

        if(!mysqli_stmt_num_rows($find_stmt)>0)
        {
            mysqli_stmt_close($find_stmt);
            mysqli_next_result($com_conn);

            $create_sql = "INSERT INTO `company`(`company_name`, `address`) VALUES (?,?)";
            $create_stmt = mysqli_stmt_init($com_conn);
            if(!mysqli_stmt_prepare($create_stmt,$create_sql))
            {
                echo "Could Not Add in DataBase ";
            }
            else
            {
                mysqli_stmt_bind_param($create_stmt,'ss',$company_name,$address);
                mysqli_stmt_execute($create_stmt);

                mysqli_stmt_close($create_stmt);
                mysqli_next_result($com_conn);
            }
            header("LOCATION:index.php");
        }
        else
        {
            mysqli_stmt_close($find_stmt);
            mysqli_next_result($com_conn);
            echo $company_name. " already in the list";
            
        }
        
        
    }
    ?>
    <?php include 'read.php'; ?>
    <script src="index.js"></script>
</body>
</html>