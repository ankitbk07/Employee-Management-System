<?php
    define('DB_SERVER','localhost');
    define('DB_USERNAME','root');
    define('DB_PASSWORD','');
    define('DB_NAME','company');

    $com_conn  = mysqli_connect(DB_SERVER, DB_USERNAME,DB_PASSWORD,DB_NAME);
    if($com_conn == False)
    {
        echo "Connection Failed";
    }

?>