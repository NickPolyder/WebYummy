<?php
session_start();
//Reset Password Method
if(isset($_POST["UserName"]))
{
    $match = true;
   $user = $_POST["UserName"];
   // Ακολουθεί regular expression που περιγράφει τους μη επιτρεπτούς χαρακτήρες.
  // Συγκεκριμένα, μη επιτρεπτοί είναι όλα εκτός από 0-9, A-Z, a-z, _ (κάτω παύλα)
    if(!preg_match("/^[a-zA-Z_-]+$/", $user) || strlen($user) <3 )
    {
        $match = false;
    }

    if($match== true)
    {
        try{
            $password = substr(sha1(uniqid('',true)),1,10); // δημιουργία ψευδό - τυχαίου κωδικού
            $pass = crypt($password);
              include '../Dtopfun/dbparm.php';
            $passupd = new PDO("mysql:host=$dbhost;dbname=$dbname",$dbuser,$dbpassword);
            $sql = 'Update Users Set Password = :pass where User_Name =  :username';
            $statement = $passupd->prepare($sql);
            $statement->execute(array(':pass'=>$pass,':username'=>$user));
            $rows = $statement->rowCount();
            if($rows > 0)
            {
           
            $statement->closeCursor();
            $selemail = 'SELECT Mail from Users where User_Name =  :username ';
            $state= $passupd->prepare($selemail);
            $state->execute(array(':username'=>$user));
            $rec=$state->fetch();
             $host  = $_SERVER['HTTP_HOST'];
             $public_directory = dirname($_SERVER['PHP_SELF']);
    //place each directory into array
    $directory_array = explode('/', $public_directory);
    //get highest or top level in array of directory strings
    $public_base ="/$directory_array[1]"; 
$uri   = rtrim($public_base, '/\\');
$extra = "index.php?msg=The new password have been sent in your e-mail please check it!";
$to = $rec["Mail"];
             $subject = "Your New Reseted Password";
               $message = 'your New password is: '.$password.' '.PHP_EOL.'Go to this page to Login: http://'.$host.''.$uri.'/login.php';
                mail($to,$subject,$message);
                $state->closeCursor();
                $rec = null;
                $passupd = null;
          header("Location: http://$host$uri/$extra");
      exit; 
            }else{
                $passupd = null;
            $statement->closeCursor();
                       $_SESSION["UserError"] = "The Username does not exist in our Database!";
      $host  = $_SERVER['HTTP_HOST'];
             $public_directory = dirname($_SERVER['PHP_SELF']);
    //place each directory into array
    $directory_array = explode('/', $public_directory);
    //get highest or top level in array of directory strings
    $public_base ="/$directory_array[1]"; 
$uri   = rtrim($public_base, '/\\');
 $extra = "ResetPassword.php";
header("Location: http://$host$uri/$extra");
exit; 
            }
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
 $extra = "ResetPassword.php";
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
 $extra = "ResetPassword.php";
header("Location: http://$host$uri/$extra");
exit;
}
?>
