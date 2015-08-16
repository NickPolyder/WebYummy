<?php
session_start();
if(isset($_POST['security_code']) && isset($_POST["UserName"]) && isset($_POST["ActivationCode"]))
{
    if($_SESSION['security_code'] == $_POST['security_code'] && !empty($_SESSION['security_code'] ))
    {
       unset($_SESSION['security_code']); 
    
    $username = $_POST["UserName"];
   $ActiveCode = $_POST["ActivationCode"];
    $match= true;
    
    // Ακολουθεί regular expression που περιγράφει τους μη επιτρεπτούς χαρακτήρες.
  // Συγκεκριμένα, μη επιτρεπτοί είναι όλα εκτός από 0-9, A-Z, a-z, _ (κάτω παύλα)
    if(preg_match("/^[a-zA-Z_-]+$/", $username) && strlen($username) <3 )
    {
        $match = false;
    }
    
    if($ActiveCode == "")
        {
        $match = false;
        }
       
        if($match == true)
        {
    try{
        include '../Dtopfun/dbparm.php';
      $Active = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpassword); 
      $sql = 'SELECT Activation_Code from Users where User_Name = :username';
      $statement = $Active->prepare($sql);
    $result = $statement->execute(array(':username'=>$username));
    if($result == false || $statement->rowCount() == 0)
    {
         $statement->closeCursor();
        $Active = NULL;
        $result=null;
      $_SESSION["WarnMessage"] = "Your Username is Wrong please. Try Again!";
                $host  = $_SERVER['HTTP_HOST'];
             $public_directory = dirname($_SERVER['PHP_SELF']);
    //place each directory into array
    $directory_array = explode('/', $public_directory);
    //get highest or top level in array of directory strings
    $public_base ="/$directory_array[1]"; 
$uri   = rtrim($public_base, '/\\');
 $extra = "ActivationPage.php";
header("Location: http://$host$uri/$extra");
exit;     
    }
     while($record = $statement->fetch())
     {
    
     if($record[0] == $ActiveCode)
     {
        $sqlupd= 'UPDATE Users SET Active_User = 1 where User_Name = :username';
        $updatestat = $Active->prepare($sqlupd);
        $updatestat->execute(array(':username'=>$username));
        $updatestat->closeCursor();
         $statement->closeCursor();
        $Active = NULL;
        $record=null;
              $host  = $_SERVER['HTTP_HOST'];
             $public_directory = dirname($_SERVER['PHP_SELF']);
    //place each directory into array
    $directory_array = explode('/', $public_directory);
    //get highest or top level in array of directory strings
    $public_base ="/$directory_array[1]"; 
    $uri = rtrim($public_base, '/\\');
 $extra = "index.php?msg=Your Account is Activated please Log In";
header("Location: http://$host$uri/$extra");
exit;
     }else{
          $statement->closeCursor();
        $Active = NULL;
        $record=null;
      $_SESSION["WarnMessage"] = "Your Activation Code is Wrong please. Try Again!";
                $host  = $_SERVER['HTTP_HOST'];
             $public_directory = dirname($_SERVER['PHP_SELF']);
    //place each directory into array
    $directory_array = explode('/', $public_directory);
    //get highest or top level in array of directory strings
    $public_base ="/$directory_array[1]"; 
$uri   = rtrim($public_base, '/\\');
 $extra = "ActivationPage.php";
header("Location: http://$host$uri/$extra");
exit;   
         
     }
     }
      
        $statement->closeCursor();
        $Active = NULL;
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
 $extra = "ActivationPage.php";
header("Location: http://$host$uri/$extra");
exit;
    }
        }else{
            
          $_SESSION["Warnrecaptcha"] = "The ReCaptCha is Wrong please try again!!!";
   $host  = $_SERVER['HTTP_HOST'];
             $public_directory = dirname($_SERVER['PHP_SELF']);
    //place each directory into array
    $directory_array = explode('/', $public_directory);
    //get highest or top level in array of directory strings
    $public_base ="/$directory_array[1]"; 
$uri   = rtrim($public_base, '/\\');
 $extra = "register.php";
header("Location: http://$host$uri/$extra");
exit;         
            
        }
       
    }else{
            $_SESSION["ERROR"] = "Something is wrong with your input";
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

?>
