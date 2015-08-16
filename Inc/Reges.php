<?php
session_start();
//Register Check
if(isset($_POST['security_code']) && isset($_POST["UserName"]) && isset($_POST["PassWord"]) && isset($_POST["RePassword"]) && isset($_POST["Email"]) && isset($_POST["Age"]) && isset($_POST["Country"]) && isset($_POST["sex"]))
{
    if($_SESSION['security_code'] == $_POST['security_code'] && !empty($_SESSION['security_code'] ))
    {
       unset($_SESSION['security_code']); 
    
    $match = true;
    $username = $_POST["UserName"];
    $password = $_POST["PassWord"];
    $repassword = $_POST["RePassword"];
    $email = $_POST["Email"];
    $age = $_POST["Age"];
    $country = $_POST["Country"];
    $sex = $_POST["sex"];
  
//Ελέγχει εάν έχει την μορφή ενός e-mail
  if (!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/",$email))
  {
      $_SESSION["Warnemail"] = "The E-mail you typed is incorrect!";
    $match = false;
  }
  // Ακολουθεί regular expression που περιγράφει τους μη επιτρεπτούς χαρακτήρες.
  // Συγκεκριμένα, μη επιτρεπτοί είναι όλα εκτός από 0-9, A-Z, a-z, _ (κάτω παύλα)
    if(!preg_match("/^[A-Za-z0-9_]+$/",$username) || strlen($username) < 3)
    {
         $_SESSION["Warnuser"] = "The Username is Incorrect!\r\nPlease follow the Rules!";
        $match = false;
    }
    
     // Ελέγχει αν υπάρχουν οι παρακάτω χαρακτήρες A-Z a-z 0-9 _ ! @
     if(!preg_match("/^[a-zA-Z0-9_!@]+$/",$password) || ( strlen($password)<8 && (strlen($RePassword) < 8 && $password != $RePassword)))
    {
         $_SESSION["Warnpass"] = "The Password is Incorrect. \r\nPlease follow the Rules!";
        $match = false;
    
    }
  try{
       include '../Dtopfun/dbparm.php';
            $check = new PDO("mysql:host=$dbhost;dbname=$dbname",$dbuser,$dbpassword);
            $sql = "Select User_Name,Mail from Users";
            $statement = $check->prepare($sql);
            $statement->execute();
            while($record = $statement->fetch())
            {
                
                $result = true;
                if($username == $record["User_Name"])
                {
                    $result = false;
                  $match= false;
                   $_SESSION["Warnuser"] = "The Username you typed is already registered!";
                }
              if($email == $record["Mail"])
              {
                
                   $_SESSION["Warnemail"] = "The E-mail you typed is already registered!";
                  
                  $result = false;
                  $match= false;
              }
              $record = null;
              $check= null;
               $statement->closeCursor();
              if($result == false)
              {
           
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
            }
   
  }  catch(PDOException $e)
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
  
    
    
   
    
    if($country == -1)
    {
        $match = false;
        $_SESSION["Others"] = "Please Put a valid Country!";
    }
    
    if($age == -1)
    {
        $match = false;
        if(!empty($_SESSION["Others"]))
        {
            $_SESSION["Others"] = ''.$_SESSION["Others"]."\r\nPlease Put your Age";
        }else{
           $_SESSION["Others"] = "Please Put your Age"; 
        }
    }
   
    if($sex == null)
    {
        $match = false;
        if(!empty($_SESSION["Others"]))
        {
            $_SESSION["Others"] = ''.$_SESSION["Others"]."\r\nPlease choose your Genre!";
        }else{
           $_SESSION["Others"] = "Please choose your Genre!"; 
        }
    }
    
    
    
    if($match==true)
    {
        try
        {
            include '../Dtopfun/dbparm.php';
            $Reg = new PDO("mysql:host=$dbhost;dbname=$dbname",$dbuser,$dbpassword);
            $sqlq='INSERT INTO Users (`User_Name`, `Password`, `Active_User`,`Activation_Code`, `Sex`, `Mail`, `Age`, `CountryID`) VALUES (:UserName, :password, false, :activationCode , :gender, :email, :Age, :country)';
           
            $ActivationCode = rand(1000000000000,9999999999999);
            var_dump($ActivationCode);
            $EncryptedPassword = crypt($password);
            $newinsert = $Reg->prepare($sqlq);
            $newinsert->execute(array(':UserName'=>$username, ':password'=>$EncryptedPassword,':activationCode'=>$ActivationCode, ':gender'=>$sex, ':email'=>$email, ':Age'=>$age, ':country'=>$country));
            $sqluserperms = 'INSERT INTO Users_has_Permissions(`Users_User_ID`,`Permissions_Perm_ID`) VALUES(:UserID,5)';
            $id = $Reg->lastInsertId();
            $newprepare = $Reg->prepare($sqluserperms);
            $newprepare->execute(array(':UserID'=>$id));
           
            $newinsert->closeCursor();
            $newprepare->closeCursor();
            
            $Reg=NULL;
            
            $host  = $_SERVER['HTTP_HOST'];
             $public_directory = dirname($_SERVER['PHP_SELF']);
    //place each directory into array
    $directory_array = explode('/', $public_directory);
    //get highest or top level in array of directory strings
    $public_base ="/$directory_array[1]"; 
$uri   = rtrim($public_base, '/\\');
$extra = "index.php?msg=Thanks for the Registration! An activation code will be sent to your E-mail Directly!";
$to = $email;
             $subject = "Your Activation Code";
               $message = 'your Activation Code is '.$ActivationCode.' '.PHP_EOL.'Go to this page to Activate your account: http://'.$host.''.$uri.'/ActivationPage.php?username='.$username.'';
                mail($to,$subject,$message);
header("Location: http://$host$uri/$extra");
      exit;      
            
        }
        catch(PDOException $e){
           
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
   
            $_SESSION["Others"] = "Please fill up all the required fields!";
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

?>
