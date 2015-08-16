<?php
session_start();
// Adds new business
if(isset($_POST["BusName"]) && isset($_POST["Address"]) && isset($_POST["Phone"]) && isset($_POST["BusinessID"]) && isset($_POST["GeoX"]) && isset($_POST["GeoY"]))
{
    $match = true;
  $BusinessName =   $_POST["BusName"];
  $BusinessAddress = $_POST["Address"];
  $BusinessPhone = $_POST["Phone"];
  $BusinessTypeID = $_POST["BusinessID"];
  $BusinessGx = trim($_POST["GeoX"]," ");
  $BusinessGy = trim($_POST["GeoY"]," ");
  
  if(!isset($_SESSION["username"]))
  {
     $match = false;
     $_SESSION["ERROR"] = "You are not logged in. Please Log In and try Again!";
      $host  = $_SERVER['HTTP_HOST'];
             $public_directory = dirname($_SERVER['PHP_SELF']);
    //place each directory into array
    $directory_array = explode('/', $public_directory);
    //get highest or top level in array of directory strings
    $public_base ="/$directory_array[1]"; 
$uri   = rtrim($public_base, '/\\');
 $extra = "error.php";
header("Location: http://$host$uri/$extra");
  }
  if(isset($_POST["Description"]))
  {
      $BusinessDesc = $_POST["Description"];
  }else{
      $BusinessDesc = null;
  }
  if($BusinessDesc == "Your Description here")
      $BusinessDesc = null;
  /*Ψάχνει να βρει μη εγκεκριμένος χαρακτήρες όπως < > @ ! $ % ^ & *  */
  
 if(!preg_match("/^[A-Za-z0-9_ \-  \. (+(.)+)+]+$/",$BusinessName) || strlen($BusinessName) < 5)
 {
     $match= false;
     $_SESSION["ERRBUS"] = 'Business Name Wrong! Please Follow the rules! <br/>';
 }
 if(!preg_match("/^[A-Za-z0-9_ \-  \. (+(.)+)+]+$/",$BusinessAddress) || strlen($BusinessAddress) < 5)
 {
      $match= false;
     $_SESSION["ERRBUS"] .= 'Business Address Wrong! Please Follow the rules! <br/>';
 }
 /* Ψάχνει να βρει έναν αποδεκτό αριθμό μεταξύ 10 - 14 ψηφίων
 Όπου επιτρέπονται μόνο αριθμοί και το + */
 if(!preg_match("/^[\+0-9]{10,14}$/",$BusinessPhone) || strlen($BusinessPhone)<= 0)
 {
     $match= false;
     $_SESSION["ERRBUS"] .= 'Business Phone Wrong! Please Follow the rules! <br/>';
 }
 if($BusinessTypeID == -1)
 {
    $match= false;
     $_SESSION["ERRBUS"] .= 'Please choose Business Type <br/>';  
 }
 /* Ψάχνει να βρει έναν αποδεκτό αριθμό  που να μοιάζει με συντεταγμένες */
 if(!preg_match("/^[0-9 \. \-]+$/", $BusinessGx) && !preg_match("/^[0-9 \. \-]+$/",$BusinessGy)  )
 {
  $match= false;
     $_SESSION["ERRBUS"] .= 'Please Put the location of your Business! <br/>';     
 }
 try{
     include '../Dtopfun/dbparm.php';
             $addtry = new PDO("mysql:host=$dbhost;dbname=$dbname",$dbuser,$dbpassword);
             $sql='SELECT * from Business'; 
             $state = $addtry->prepare($sql);
             $state->execute();
             while($record = $state->fetch())
             {
                 if($record["Business_Title"] == $BusinessName)
                 {
                     $_SESSION["ERRBUS"] .= 'This Business Name is already exists try a new one <br/>';
                     $match= false;
                 }
                 if($record["Phone"] == $BusinessPhone)
                 {
                     $_SESSION["ERRBUS"] .= 'This Business Phone is already exist <br />';
                     $match= false;
                 }
             }
             $state->closeCursor();
             $addtry = null;
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
    if($match == true)
    {
        try{
             include '../Dtopfun/dbparm.php';
             $add = new PDO("mysql:host=$dbhost;dbname=$dbname",$dbuser,$dbpassword);
             $sqluser='SELECT User_ID from Users where User_Name = :username';
           $user = $add->prepare($sqluser);
           $user->execute(array(':username'=>$_SESSION["username"]));
           $userID = $user->fetch();
             $sqlmatch = 'SELECT Permissions_Perm_ID from Users_has_permissions where Users_User_ID = :uID';
             $try = $add->prepare($sqlmatch);
           $try->execute(array(':uID'=>$userID[0]));  
         
           $record = $try->fetch();
          
           if($record[0] == 5)
           {
               $sqlchange = 'UPDATE Users_has_Permissions SET Permissions_Perm_ID = 4 Where Users_User_ID = :uID';
               $changethis = $add->prepare($sqlchange);
               $changethis->execute(array(':uID'=>$userID[0]));
               $changethis->closeCursor();
               
           }
           if($record[0] == 4)
           {
               $userID = null;
               $try->closeCursor();
               $user->closeCursor();
               $add = null;
                
               $_SESSION["ERRBUS"] = 'You already own a Business <br/>You cant have another record Business!';
               $host  = $_SERVER['HTTP_HOST'];
             $public_directory = dirname($_SERVER['PHP_SELF']);
    //place each directory into array
    $directory_array = explode('/', $public_directory);
    //get highest or top level in array of directory strings
    $public_base ="/$directory_array[1]"; 
$uri   = rtrim($public_base, '/\\');
 $extra = "AddBusiness.php";
header("Location: http://$host$uri/$extra");
exit;  
           }
         
           $sqlinsert = 'INSERT INTO Business (`User_ID`, `Business_Title`, `Address`, `Phone`, `GeoLocation_x`, `GeoLocation_y`, `Description`, `Business_Type`) VALUES (:UserID, :bustitle, :busaddr, :busphone, :busgeoX, :busgeoY, :busDesc, :bustypeID)';
           $insbus = $add->prepare($sqlinsert);
           $insbus->execute(array(':UserID'=>$userID[0],':bustitle'=>$BusinessName,':busaddr'=>$BusinessAddress,':busphone'=>$BusinessPhone,':busgeoX'=>$BusinessGx,':busgeoY'=>$BusinessGy,':busDesc'=>$BusinessDesc,':bustypeID'=>$BusinessTypeID));
         
           $user->closeCursor();
           $insbus->closeCursor();
           $try->closeCursor();
            $add = null;
            $record = null;
            $userID = null;
                  $host  = $_SERVER['HTTP_HOST'];
             $public_directory = dirname($_SERVER['PHP_SELF']);
    //place each directory into array
    $directory_array = explode('/', $public_directory);
    //get highest or top level in array of directory strings
    $public_base ="/$directory_array[1]"; 
$uri   = rtrim($public_base, '/\\');
 $extra = "Catalog.php?msg=The Business with Business name: $BusinessName Added to the records";
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
              $host  = $_SERVER['HTTP_HOST'];
             $public_directory = dirname($_SERVER['PHP_SELF']);
    //place each directory into array
    $directory_array = explode('/', $public_directory);
    //get highest or top level in array of directory strings
    $public_base ="/$directory_array[1]"; 
$uri   = rtrim($public_base, '/\\');
 $extra = "AddBusiness.php";
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
 $extra = "AddBusiness.php";
header("Location: http://$host$uri/$extra");
exit;
}
?>
