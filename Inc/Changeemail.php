<?php
 session_start();
 //Change Email
if(isset($_SESSION["username"]))
{
if(isset($_POST["NewEmail"]))
{
    $match = true;
   $email = $_POST["NewEmail"];
   //Ελέγχει εάν έχει την μορφή ενός e-mail
     if (!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/",$email))
  {
      $_SESSION["WarnMail"] = "The E-mail you typed is incorrect!";
    $match = false;
  }

    if($match== true)
    {
        try{
              include '../Dtopfun/dbparm.php';
            $passins = new PDO("mysql:host=$dbhost;dbname=$dbname",$dbuser,$dbpassword);
            $sql = 'Update Users Set Mail = :mail where User_Name =  :username';
            $statement = $passins->prepare($sql);
            $statement->execute(array(':mail'=>$email,':username'=>$_SESSION["username"]));
            
            $passins = null;
            $statement->closeCursor();
             $host  = $_SERVER['HTTP_HOST'];
             $public_directory = dirname($_SERVER['PHP_SELF']);
    //place each directory into array
    $directory_array = explode('/', $public_directory);
    //get highest or top level in array of directory strings
    $public_base ="/$directory_array[1]"; 
$uri   = rtrim($public_base, '/\\');
$extra = "index.php?msg=Your E-mail has Changed with Success!";
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
 $extra = "ChangeEmail.php";
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
 $extra = "ChangeEmail.php";
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
