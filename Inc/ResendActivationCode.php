<?php
session_start();

if(isset($_SESSION["ResEmail"]))
{
    $username = $_SESSION["ResEmail"];
    
    try{
        include '../Dtopfun/dbparm.php';
       $resend = new PDO("mysql:host=$dbhost;dbname=$dbname",$dbuser,$dbpassword);
       $sql = "SELECT Activation_Code, Mail From Users WHERE User_Name = :username AND Active_User = 0";
       $statement = $resend->prepare($sql);
       $statement->execute(array(':username'=>$username));
       $record = $statement->fetch();
         $host  = $_SERVER['HTTP_HOST'];
             $public_directory = dirname($_SERVER['PHP_SELF']);
    //place each directory into array
    $directory_array = explode('/', $public_directory);
    //get highest or top level in array of directory strings
    $public_base ="/$directory_array[1]"; 
$uri   = rtrim($public_base, '/\\');
$to = $record["Mail"];
             $subject = "Your Activation Code";
               $message = 'your Activation Code is '.$record["Activation_Code"].' '.PHP_EOL.'Go to this page to Activate your account: http://'.$host.''.$uri.'/ActivationPage.php?username='.$username.'';
                mail($to,$subject,$message);
  $extra = "index.php?msg=Your Activation Code has been sent to your e-mail Please check your e-mail!";
$statement->closeCursor();
$resend = null;
  header("Location: http://$host$uri/$extra");
exit;
    }  catch (PDOException $e)
    {
        $_SESSION["ERROR"] = "Something came up with our Database. We apologize come back later";
                $host  = $_SERVER['HTTP_HOST'];
             $public_directory = dirname($_SERVER['PHP_SELF']);
    //place each directory into array
    $directory_array = explode('/', $public_directory);
    //get highest or top level in array of directory strings
    $public_base ="/$directory_array[1]"; 
$uri   = rtrim($public_base, '/\\');
 $extra = "error.php";
header("Location: http://$host$uri/$extra");
exit; 
    }
}else{
    
    session_destroy();  
  session_start();
  $_SESSION["ERROR"] = "Why are you here ?!?";
 $host  = $_SERVER['HTTP_HOST'];
             $public_directory = dirname($_SERVER['PHP_SELF']);
    //place each directory into array
    $directory_array = explode('/', $public_directory);
    //get highest or top level in array of directory strings
    $public_base ="/$directory_array[1]"; 
$uri   = rtrim($public_base, '/\\');
 $extra = "error.php";
header("Location: http://$host$uri/$extra");
exit;
}

?>
