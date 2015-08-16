<?php
 session_start();
 // Change Password
if(isset($_SESSION["username"]))
{
if(isset($_POST['PassWord']) && isset($_POST['NewPassword']) && isset($_POST['RetypPassword']))
{
    $match = true;
    $password = $_POST['PassWord'];
    $newpassword = $_POST['NewPassword'];
    $retypedpass = $_POST['RetypPassword'];
    if(!preg_match("/^[a-zA-Z0-9_!@]+$/",$password)) // Ελέγχει αν υπάρχουν οι παρακάτω χαρακτήρες A-Z a-z 0-9 _ ! @
    {
        try{
              include '../Dtopfun/dbparm.php';
            $pass = new PDO("mysql:host=$dbhost;dbname=$dbname",$dbuser,$dbpassword);
            $sql = 'SELECT Password from Users where User_Name = :username';
            $statement = $pass->prepare($sql);
            $statement->execute(array(':username'=>$_SESSION["username"]));
            $record = $statement->fetch();
            if($record["Password"] != crypt($password,$record["Password"]))
            {
            $match = false;
            $_SESSION["Warnpass"] = "Your current password does not match please put your password!";
            }
            $pass = null;
            $statement->closeCursor();
            $record = null;
    }catch(PDOException $e)
    {
         $_SESSION["ERROR"] = "Something came up with our Database. We apologize come back later!";
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
    }
    // Ελέγχει αν υπάρχουν οι παρακάτω χαρακτήρες A-Z a-z 0-9 _ ! @
 if(!preg_match("/^[a-zA-Z0-9_!@]+$/",$newpassword) || ( strlen($newpassword)<8 && (strlen($retypedpass) < 8 && $newpassword != $retypedpass)))
    {
         $_SESSION["Warnpass"] .= '<br/>'."The new Password does not match the re-typed password OR is incorect. \r\nPlease follow the Rules!";
        $match = false;
    
    }
    if($match== true)
    {
        try{
              include '../Dtopfun/dbparm.php';
            $passins = new PDO("mysql:host=$dbhost;dbname=$dbname",$dbuser,$dbpassword);
            $sql = 'Update Users Set Password = :pass where User_Name =  :username';
            $statement = $passins->prepare($sql);
            $statement->execute(array(':pass'=>$newpassword,':username'=>$_SESSION["username"]));
            
            $passins = null;
            $statement->closeCursor();
             $host  = $_SERVER['HTTP_HOST'];
             $public_directory = dirname($_SERVER['PHP_SELF']);
    //place each directory into array
    $directory_array = explode('/', $public_directory);
    //get highest or top level in array of directory strings
    $public_base ="/$directory_array[1]"; 
$uri   = rtrim($public_base, '/\\');
$extra = "index.php?msg=Your Password has Changed with Success!";
          header("Location: http://$host$uri/$extra");
      exit; 
    }catch(PDOException $e)
    {
         $_SESSION["ERROR"] = "Something came up with our Database. We apologize come back later!";
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
              $_SESSION["Others"] = "Please Try again AND follow the Rules!";
      $host  = $_SERVER['HTTP_HOST'];
             $public_directory = dirname($_SERVER['PHP_SELF']);
    //place each directory into array
    $directory_array = explode('/', $public_directory);
    //get highest or top level in array of directory strings
    $public_base ="/$directory_array[1]"; 
$uri   = rtrim($public_base, '/\\');
 $extra = "ChangePassword.php";
header("Location: http://$host$uri/$extra");
exit; 
    }
    
}else{
   
            $_SESSION["Others"] = "Please fill up all the required fields!";
      $host  = $_SERVER['HTTP_HOST'];
             $public_directory = dirname($_SERVER['PHP_SELF']);
    //place each directory into array
    $directory_array = explode('/', $public_directory);
    //get highest or top level in array of directory strings
    $public_base ="/$directory_array[1]"; 
$uri   = rtrim($public_base, '/\\');
 $extra = "ChangePassword.php";
header("Location: http://$host$uri/$extra");
exit;
}
}else{
    session_destroy();
    session_start();
      $_SESSION["ERROR"] = "You are not logged in";
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
