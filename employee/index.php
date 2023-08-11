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
    <link rel="stylesheet" href="index.css">
</head>
<body> 
    <div class="header">
            <div>
                <h1> welcome <?php echo  $_SESSION['username']?>  </h1>
            </div>

            <div>
                <h1> <a class='link' href="../logout.php"> Logout </a></h1>
            </div>
                
    </div>
    <form action="" method="POST" >
        <input type="text" name ='employee-name' placeholder="Employee Name" >
        <input type="text" name ='salary' placeholder="Salary">
        <input type="text" name ='dob' placeholder="YYYY-MM-DD">
        <input type="text" name = 'company-id'placeholder = 'company-name'>
        <button type="submit"> Add </button> 
    </form>
    <?php 
    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
        $employee_name = mysqli_real_escape_string( $com_conn,$_POST['employee-name']);
        $salary = $_POST['salary'];
        $dob = $_POST['dob'];
        $company_id = $_POST['company-id'];
        //Checks if redudant data is present in the database
        $find_sql = "SELECT emp_name,salary FROM employee where emp_name =? and salary = ?";
        $find_stmt  = mysqli_stmt_init($com_conn);
        mysqli_stmt_prepare($find_stmt,$find_sql);
        mysqli_stmt_bind_param($find_stmt,"si",$employee_name,$salary);
        mysqli_stmt_execute($find_stmt);
        mysqli_stmt_store_result($find_stmt);

        if(!mysqli_stmt_num_rows($find_stmt)>0)
        {
            mysqli_stmt_close($find_stmt);
            mysqli_next_result($com_conn);

            $create_sql = "INSERT INTO `employee`(`emp_name`, `salary`,`dob`,`company_id`) VALUES (?,?,?,?)";
            $create_stmt = mysqli_stmt_init($com_conn);
            if(!mysqli_stmt_prepare($create_stmt,$create_sql))
            {
                echo "Could Not Add in DataBase ";
            }
            else
            {
                mysqli_stmt_bind_param($create_stmt,'sisi',$employee_name,$salary,$dob,$company_id);
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