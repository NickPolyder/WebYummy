<?php
session_start();
//Log in Check
if(!isset($_SESSION["username"]) && isset($_POST["PassWord"]) && isset($_POST["UserName"]))
{
    $match = true;
  $username = $_POST["UserName"];
    $password= $_POST["PassWord"];
   // Ακολουθεί regular expression που περιγράφει τους μη επιτρεπτούς χαρακτήρες.
  // Συγκεκριμένα, μη επιτρεπτοί είναι όλα εκτός από 0-9, A-Z, a-z, _ (κάτω παύλα)
    if(!preg_match("/^[a-zA-Z0-9_-]+$/", $username) || strlen($username) < 3 )
    {
        $match = false;
    }
    // Ελέγχει αν υπάρχουν οι παρακάτω χαρακτήρες A-Z a-z 0-9 _ ! @
    if(!preg_match("/^[a-zA-Z0-9_!@]+$/",$password) || strlen($password) < 8) 
    {
        $match = false;
    }
    
    if($match == true)
    {
        try{
            include '../Dtopfun/dbparm.php';
            $LogON = new PDO("mysql:host=$dbhost;dbname=$dbname",$dbuser,$dbpassword);
            $sql = 'SELECT Password,Active_User from Users where User_Name = :username';
            $statement = $LogON->prepare($sql);
            $statement->execute(array(':username'=>$username));
            $test = $statement->rowCount();
             
            if($test <= 0)
            {
                $LogON = NULL;
                $statement->closeCursor();
                $_SESSION["UserError"] = "Your Username is Incorrect ";
                      $host  = $_SERVER['HTTP_HOST'];
             $public_directory = dirname($_SERVER['PHP_SELF']);
    //place each directory into array
    $directory_array = explode('/', $public_directory);
    //get highest or top level in array of directory strings
    $public_base ="/$directory_array[1]"; 
$uri   = rtrim($public_base, '/\\');
$extra = "login.php";
header("Location: http://$host$uri/$extra");

exit;

            }
            $record = $statement->fetch();
            
            if($record["Active_User"] == 0)
            {
                $LogON = NULL;
                $statement->closeCursor();
                $record = null;
               $_SESSION["ActiveError"] = "Your Account is not Active ".'<br />'."Please Activate your Account with the code in your e-mail!";
               $_SESSION["ResEmail"]= $username;    
               $host  = $_SERVER['HTTP_HOST'];
             $public_directory = dirname($_SERVER['PHP_SELF']);
    //place each directory into array
    $directory_array = explode('/', $public_directory);
    //get highest or top level in array of directory strings
    $public_base ="/$directory_array[1]"; 
$uri   = rtrim($public_base, '/\\');
$extra = "login.php";
header("Location: http://$host$uri/$extra");

exit; 
            }
              
            if($record["Password"] == crypt($password,$record["Password"]))
            {
                
                  $_SESSION["username"] = $username;
                  $extra = "index.php?msg=Welcome, Have a Nice Day $username !";
                  $record = null;
                  $statement->closeCursor();
            $LogON = NULL;
                $host  = $_SERVER['HTTP_HOST'];
             $public_directory = dirname($_SERVER['PHP_SELF']);
    //place each directory into array
    $directory_array = explode('/', $public_directory);
    //get highest or top level in array of directory strings
    $public_base ="/$directory_array[1]"; 
$uri   = rtrim($public_base, '/\\');

header("Location: http://$host$uri/$extra");
exit;
            }else{
                
                $_SESSION["PassError"] = "Your Password is Incorrect";
                     
$extra = "login.php";  
$record = null;
                  $statement->closeCursor();
            $LogON = NULL;
                $host  = $_SERVER['HTTP_HOST'];
             $public_directory = dirname($_SERVER['PHP_SELF']);
    //place each directory into array
    $directory_array = explode('/', $public_directory);
    //get highest or top level in array of directory strings
    $public_base ="/$directory_array[1]"; 
$uri   = rtrim($public_base, '/\\');

header("Location: http://$host$uri/$extra");
exit;
            }
    $record = null;
                  $statement->closeCursor();
            $LogON = NULL;
         
    }catch(PDOException $e)
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
                    $_SESSION["UserError"] = "Please Follow the Rules!!!";
                      $host  = $_SERVER['HTTP_HOST'];
             $public_directory = dirname($_SERVER['PHP_SELF']);
    //place each directory into array
    $directory_array = explode('/', $public_directory);
    //get highest or top level in array of directory strings
    $public_base ="/$directory_array[1]"; 
$uri   = rtrim($public_base, '/\\');
$extra = "login.php";
header("Location: http://$host$uri/$extra");
exit();  
    }
    
}else{
    
   
  session_destroy();  
  session_start();
  $_SESSION["ERROR"] = "DONT TRY THIS AGAIN!";
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
