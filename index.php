<?php
session_start();
require_once 'dbcompany.php'
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="index.css">
</head>
<body> 
    <div class="header">
            <div>
                <h1> welcome <?php echo  $_SESSION['username']?>  </h1>
            </div>

            <div>
                <h1> <a class='link' href="logout.php"> Logout </a></h1>
            </div>
                
    </div>
    <form action="" method="POST" >
        <input type="text" name ='company-name' placeholder="Company Name" >
        <input type="text" name ='address' placeholder="Address">
        <button type="submit"> Add </button> 
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

        //To create stmt
        $create_sql = "INSERT INTO `company`(`company_name`, `address`) VALUES (?,?)";
        $create_stmt = mysqli_stmt_init($com_conn);

        if(!mysqli_stmt_affected_rows($find_stmt)>0)
        {
            mysqli_stmt_close($find_stmt);
            if(!mysqli_stmt_prepare($create_stmt,$create_sql))
            {
                echo "Could Not Add in DataBase ";
            }
            else
            {
                mysqli_stmt_bind_param($create_stmt,'ss',$company_name,$address);
                mysqli_stmt_execute($create_stmt);
    
                mysqli_stmt_close($create_stmt);
            }
            header("LOCATION:index.php");
        }
        else
        {
            echo $company_name. " already in the list";
            
        }
        
    }


    ?>
    <?php
    $fetch_sql = "Select * FROM company;";
    $fetch_stmt = mysqli_stmt_init($com_conn);
    mysqli_stmt_prepare($fetch_stmt,$fetch_sql);
    mysqli_stmt_execute($fetch_stmt);
    mysqli_stmt_bind_result($fetch_stmt,$id,$companyName,$address1);
    // $resultCheck =mysqli_stmt_affected_rows($fetch_stmt);
    // echo $resultCheck;
    // if($resultCheck>0): ?>
    <table>
        <tr>
            <th>SN</th>
            <th>Company Name</th>
            <th>Address</th>
        </tr>
        <?php
            while(mysqli_stmt_fetch($fetch_stmt)):
        ?>
        <tr>
            <td><?php echo $id ;?> </td>
            <td><?php echo $companyName ;?> </td>
            <td><?php echo $address1 ;?> </td>
        </tr>
        <?php
        endwhile;
        ?>
        <?php mysqli_stmt_close($fetch_stmt); ?>

    </table>

    





</body>
</html>