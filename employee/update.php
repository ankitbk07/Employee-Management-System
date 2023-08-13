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
    <title>Update</title>
    <link rel="stylesheet" href="update.css">
</head>
<body>
    <?php 
    $get_empid = $_GET['id'];
    $update_empname ='';
    $update_salary =0;
    $update_dob = '';
    if($_SERVER['REQUEST_METHOD']=='POST')
    {
        $update_empname =$_POST['emp-name'] ;
        $update_salary = $_POST['salary'];
        $update_dob = $_POST['dob'];

        if(empty($update_empname) || empty($update_salary) || empty($update_dob))
        {
            echo "<p>Please fill the form</p>";
        }
        else
        {
            $update_sql = 'UPDATE employee SET emp_name = ?, salary = ?,dob = ? where emp_id = ?';
            $update_stmt = mysqli_stmt_init($com_conn);
            mysqli_stmt_prepare($update_stmt,$update_sql);
            mysqli_stmt_bind_param($update_stmt,'sssi',$update_empname,$update_salary,$update_dob,$get_empid);
            mysqli_stmt_execute($update_stmt); 
            mysqli_stmt_close($update_stmt);
            mysqli_next_result($com_conn);
            header('location:index.php');
            
        }
         


    }
    
    ?>
    <h1> Update</h1>
    <form action="" method="post">
    <input type="text" name ="emp-name" placeholder="Employee Name">
    <input type="text" name ="salary" placeholder="Salary">
    <input type="text" name ="dob" placeholder="dob">

    <button type="submit">Update</button>
    </form>
</body>
</html>