<?php
    $fetch_sql = "Select * FROM company";
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
        mysqli_stmt_close($fetch_stmt);
        mysqli_next_result($com_conn);
        ?>
    </table>