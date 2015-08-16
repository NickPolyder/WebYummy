<?php
session_start();
//Edit Business
if(isset($_POST["BUSID"]) && isset($_POST["BusName"]) && isset($_POST["Address"])&& isset($_POST["Phone"]) && isset($_POST["BusinessID"]) && isset($_POST["GeoX"]) && isset($_POST["GeoY"]))
{
     $match = true;
    
     $BusID = ''.$_POST["BUSID"].'';
  $BusinessName =   $_POST["BusName"];
  $BusinessAddress = $_POST["Address"];
  $BusinessPhone = $_POST["Phone"];
  $BusinessTypeID = $_POST["BusinessID"];
  $BusinessGx = trim($_POST["GeoX"]," ");
  $BusinessGy = trim($_POST["GeoY"]," ");
  if(isset($_POST["LastUpdate"]))
  {
       $lastupdate = $_POST["LastUpdate"];
  }else{
      $lastupdate= "";
  }
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
  if(!preg_match("/^[0-9]+$/",$BusID)) // Ελέγχει αν είναι αριθμός
          $match = false;
  
    /*Ψάχνει να βρει μη εγκεκριμένος χαρακτήρες όπως < > @ ! $ % ^ & *  */
 if(!preg_match("/^[A-Za-z0-9_ \-  \. (+(.)+)+]+$/",$BusinessName) || strlen($BusinessName) < 5)
 {
     $match= false;
     $_SESSION["ERRBUS"] = 'Business Name Wrong! Please Follow the rules! <br/>';
 }
   /*Ψάχνει να βρει μη εγκεκριμένος χαρακτήρες όπως < > @ ! $ % ^ & *  */
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
    if($match == true)
    {
        try{
             include '../Dtopfun/dbparm.php';
             $edit = new PDO("mysql:host=$dbhost;dbname=$dbname",$dbuser,$dbpassword);
             $sqluser='SELECT User_ID from Users where User_Name = :username';
           $user = $edit->prepare($sqluser);
           $user->execute(array(':username'=>$_SESSION["username"]));
           $userID = $user->fetch();
       
           $updatesql = 'UPDATE Business SET Business_Title = ? 
               , Address = ? , Phone = ? , Business_Type = ? , GeoLocation_x = ? , GeoLocation_y = ? ,
               Description = ? , Date_of_Update = ? WHERE Business_ID= ? AND User_ID = ?';
           $day = ''.date("Y-m-d H:i:s").'';
  $update = $edit->prepare($updatesql);
  $update->bindParam(1,$BusinessName);
  $update->bindParam(2,$BusinessAddress);
  $update->bindParam(3,$BusinessPhone);
  $update->bindParam(4,$BusinessTypeID);
  $update->bindParam(5,$BusinessGx);
  $update->bindParam(6,$BusinessGy);
  $update->bindParam(7,$BusinessDesc);
  $update->bindParam(8,$day);
  $update->bindParam(9,$BusID);
  $update->bindParam(10,$userID[0]);
  $update->execute();
        $update->closeCursor();
       
           $userID = null;
           $user->closeCursor();
           $edit =null;
           $_SESSION["Trust"] = "The Business with ID: $BusID edited succesfully!";
           $host  = $_SERVER['HTTP_HOST'];
             $public_directory = dirname($_SERVER['PHP_SELF']);
    //place each directory into array
    $directory_array = explode('/', $public_directory);
    //get highest or top level in array of directory strings
    $public_base ="/$directory_array[1]"; 
$uri   = rtrim($public_base, '/\\');
 $extra = "Edit.php";
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
 $extra = "Edit.php";
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
 $extra = "Edit.php";
header("Location: http://$host$uri/$extra");
exit;
}
?>
