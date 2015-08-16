<?php
session_start();
session_destroy();
    $host  = $_SERVER['HTTP_HOST'];
             $public_directory = dirname($_SERVER['PHP_SELF']);
    //place each directory into array
    $directory_array = explode('/', $public_directory);
    //get highest or top level in array of directory strings
    $public_base ="/$directory_array[1]"; 
$uri   = rtrim($public_base, '/\\');
$extra = 'index.php?msg=We will miss you! GoodBye and See you Soon';
header("Location: http://$host$uri/$extra");
exit;
?>
