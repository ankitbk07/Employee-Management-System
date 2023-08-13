<?php
    $fetch_sql = "SELECT employee.emp_id, employee.emp_name,employee.salary,employee.dob, company.company_name
    FROM employee
    INNER JOIN company ON employee.company_id = company.company_id";
    $fetch_stmt = mysqli_stmt_init($com_conn);
    mysqli_stmt_prepare($fetch_stmt,$fetch_sql);
    mysqli_stmt_execute($fetch_stmt);
    mysqli_stmt_store_result($fetch_stmt);
    if(mysqli_stmt_num_rows($fetch_stmt)):
    mysqli_stmt_bind_result($fetch_stmt,$emp_id,$emp_name,$salary,$dob,$company_name);
    // $resultCheck =mysqli_stmt_affected_rows($fetch_stmt);
    // echo $resultCheck;
    // if($resultCheck>0): ?>
    <table>
        <tr>
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
            <td><?php echo $emp_name ;?> </td>
            <td><?php echo $salary ;?> </td>
            <td><?php echo $dob ;?> </td> 
            <td><?php echo $company_name ;?> </td>
            <td><button id ="btn-update"><a class ='a-link' href="update.php?id=<?=$emp_id?>" >Update</a></button>
            <button id ="btn-delete"><a class="a-link" href="delete.php?id=<?=$emp_id?>">Delete</a></button>
        </tr>
        <?php
        endwhile;
        mysqli_stmt_close($fetch_stmt);
        mysqli_next_result($com_conn);
        ?>
    </table>
    <?php endif ?>

    