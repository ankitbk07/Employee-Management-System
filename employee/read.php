<?php
    $fetch_sql = "Select * FROM employee";
    $fetch_stmt = mysqli_stmt_init($com_conn);
    mysqli_stmt_prepare($fetch_stmt,$fetch_sql);
    mysqli_stmt_execute($fetch_stmt);
    mysqli_stmt_store_result($fetch_stmt);
    if(mysqli_stmt_num_rows($fetch_stmt)):
    mysqli_stmt_bind_result($fetch_stmt,$emp_id,$emp_name,$salary,$dob,$company_id);
    // $resultCheck =mysqli_stmt_affected_rows($fetch_stmt);
    // echo $resultCheck;
    // if($resultCheck>0): ?>
    <table>
        <tr>
            <th>SN</th>
            <th>Employee Name</th>
            <th>Salary</th>
            <th>Date of Birth</th>
            <th>Company ID</th>
            <th>Action</th>
        </tr>
        <?php
            while(mysqli_stmt_fetch($fetch_stmt)):
        ?>
        <tr>
            <td><?php echo $emp_id ;?> </td>
            <td><?php echo $emp_name ;?> </td>
            <td><?php echo $salary ;?> </td>
            <td><?php echo $dob ;?> </td> 
            <td><?php echo $company_id ;?> </td>
            <td><button><a href="update.php?username=<?=$emp_name?>&address=<?=$salary?>&dob=<?=$dob?>" id ="btn-update">Update</a></button>
            <button><a href="delete.php?id=<?=$emp_id?>" id ="btn-delete">Delete</a></button>
        </tr>
        <?php
        endwhile;
        mysqli_stmt_close($fetch_stmt);
        mysqli_next_result($com_conn);
        ?>
    </table>
    <?php endif ?>

    