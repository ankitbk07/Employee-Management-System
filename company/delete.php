<?php
session_start();
require_once '../dbcompany.php';
if(empty($_SESSION['username']))
{
    header('location:login.php');
}
?>


<?php
    if(isset($_GET['id']))
    {
        $id = $_GET['id'];
        $delete_sql = "DELETE From company where company_id = ?";
        $del_stmt = mysqli_stmt_init($com_conn);
        mysqli_stmt_prepare($del_stmt,$delete_sql);
        mysqli_stmt_bind_param($del_stmt,'i',$id);
        mysqli_stmt_execute($del_stmt); 
        mysqli_stmt_close($del_stmt);
        mysqli_next_result($com_conn);

        header('Location:index.php');

    }
    

?>