<?php
$servername = 'localhost';
$username = 'root';
$server_pass = '';
$db = 'pms';
$database_connect = mysqli_connect($servername, $username, $server_pass, $db);
if (!$database_connect) {
    echo "database failed to connect" . mysqli_connect_error();
} else {
    //echo"database connected successfully";
};
?>