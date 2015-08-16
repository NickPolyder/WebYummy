<?php
session_start();
  
function selectmanager($tablename,$selectedindex) // Παίρνει έναν πινάκα και τον τοποθετεί σε select tags
{
    include 'Dtopfun/dbparm.php';
    if($tablename == "Country") // Ελέγxει ποιος πινάκας είναι και ανάλογα τοποθετεί τα πεδία
    {
        $orderbystat = "CountryName";
        $name = "Country";
    }else if($tablename == "Bus_Type") 
    {
        $orderbystat = "Name_of_Type";
        $name = "Type of Buisness";
    }else
    {
    $orderbystat = "";
    $name = "Επιλεξτε";
    }
    if($selectedindex == -1) // Πρώτη εγγραφή της select
        $attrib = 'selected="selected"';
    else $attrib = "";
    
 echo '<option value="-1" '.$attrib.' style="text-align:center;" >----------------'.$name.'----------------</option> ';
 
    try{
       
        $datab = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpassword);
        if($orderbystat != "") // Ελέγχει αν υπάρχει  πεδίο για order by
        {
        $sql = "SELECT * FROM $tablename ORDER BY $orderbystat ASC";
        }else{
           $sql = "SELECT * FROM $tablename"; 
        }
       $statement = $datab->prepare($sql);
       $statement->execute();
       
       
       while($newent = $statement->fetch())
       {
           if($selectedindex == $newent[0]) // Ελέγχει αν είναι pre selected
           {
                  $attrib = 'selected="selected"';
           }
    else $attrib = "";
    
    echo'<option value="'.$newent[0].'" '.$attrib.' >'.$newent[1].'</option> ';
    
       }
       $statement->closeCursor();
    $datab = NULL;
    }catch(PDOException $e)
    {
        $_SESSION["ERROR"] = "Something came up with our Database. We apologize come back later";
       $host  = $_SERVER['HTTP_HOST'];
$uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
 $extra = "error.php";
header("Location: http://$host$uri/$extra");
exit;

    }
}

function fadinsert() //Δημιουργεί έναν Administrator
{
    include 'Dtopfun/dbparm.php';
    try{
       
    $database = new PDO("mysql:host=$dbhost;dbname=$dbname;", $dbuser, $dbpassword);
    $sql = "SELECT User_ID FROM Users";
    $statement = $database->prepare($sql);
    $statement->execute();
   $record = $statement->rowcount();

    if($record == 0)
    {
        $password="Adm1n1str@t0r";
     // Κρυπτογράφηση των password και ενημέρωση της database
        $EncryptedPassword = crypt($password);
        $sqlins='INSERT INTO Users (`User_Name`, `Password`,  `Active_User`, `Sex`, `Mail`, `Age`, `CountryID`) VALUES ("Administrator", :password, True, 0, "Admin@localhost.com", 20, 70)';
        $newins = $database->prepare($sqlins);
         $newins->execute(array(':password'=>$EncryptedPassword));
         $sqlperms = 'INSERT INTO Users_has_Permissions(`Users_User_ID`,`Permissions_Perm_ID`) VALUES(1,1)';
         $newins = $database->prepare($sqlperms);
         $newins->execute();
         $newins->closeCursor();
    }
      unset($record);
       $statement->closeCursor();
               $database = NULL;
       
    }catch(PDOException $e){
        
           $_SESSION["ERROR"] = "Something came up with our Database. We apologize come back later";
       $host  = $_SERVER['HTTP_HOST'];
$uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
 $extra = "error.php";
header("Location: http://$host$uri/$extra");
exit;

    }
}
function useron() // Ελέγχει αν υπάρχει χρήστης 
{
  try{
  
    if(isset($_SESSION["username"]))
    {
    include 'Dtopfun/dbparm.php';
    $tryuser = new PDO("mysql:host=$dbhost;dbname=$dbname;",$dbuser,$dbpassword);
    $sql= 'SELECT Active_User from Users where User_Name = :username';
    $statement = $tryuser->prepare($sql);
   
   $isuser = $statement->execute(array(':username'=>$_SESSION["username"]));
    
  $record= $statement->rowCount();
  if($record >= 1)
      $isuser = true;
  else
      $isuser = false;
  
  unset($record);
  $statement->closeCursor();
  $tryuser = NULL;
  return $isuser;
  
  }  
}catch(PDOException $e)
{
   
     $_SESSION["ERROR"] = "Something came up with our Database. We apologize come back later!";
$host  = $_SERVER['HTTP_HOST'];
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$extra = 'error.php?';
header("Location: http://$host$uri/$extra");
exit;

}
}
function is_not_logged_in() // Ελέγχει αν ο χρήστης δεν είναι logged in
{
  $isuser = useron();
   
if($isuser == false)
{
    $_SESSION["ERROR"] = "You dont have user permissions!";
$host  = $_SERVER['HTTP_HOST'];
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$extra = 'error.php';
header("Location: http://$host$uri/$extra");
exit;
}
   

}
function is_logged_in() // Ελέγχει αν ο χρήστης είναι logged in
{
  $isuser = useron();
   
if($isuser == true)
{
    $_SESSION["ERROR"] = "You are already Logged In";
$host  = $_SERVER['HTTP_HOST'];
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$extra = 'error.php';
header("Location: http://$host$uri/$extra");
exit;
}
}
function alreadyowner() // Ελέγχει αν ο χρήστης είναι Owner κάποιας επιχειρήσεις
{
    $isowner = true;
    if(isset($_SESSION["username"]))
    {
    try{
        include 'Dtopfun/dbparm.php';
    $ifowner = new PDO("mysql:host=$dbhost;dbname=$dbname;",$dbuser,$dbpassword);
        $sql= 'SELECT Permissions_Perm_ID as PermID
 From Users_has_Permissions 
where Users_User_ID = (SELECT User_ID From Users where User_Name = :username)';
        $statement = $ifowner->prepare($sql);
        $statement->execute(array(':username'=>$_SESSION["username"]));
        $record = $statement->fetch();
        if($record["PermID"] != 4)
        {
            $isowner= false;
        }
      
    $record = null;
    $statement->closeCursor();
    $ifowner = null;
    return $isowner;
}catch(PDOException $e)
{
  $_SESSION["ERROR"] = "Something came up with our Database. We apologize come back later";
       $host  = $_SERVER['HTTP_HOST'];
$uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
 $extra = "error.php";
header("Location: http://$host$uri/$extra");
exit;   
}
    }else{
        $_SESSION["ERROR"] = "You are not Logged In Or You are not User";
       $host  = $_SERVER['HTTP_HOST'];
$uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
 $extra = "error.php";
header("Location: http://$host$uri/$extra");
exit;   
    }
    }
   
    function isAdmin() // Ελέγχει αν ο χρήστης είναι Admin 
    {
        $isadmin = false;
    if(isset($_SESSION["username"]))
    {
    try{
        include 'Dtopfun/dbparm.php';
    $ifowner = new PDO("mysql:host=$dbhost;dbname=$dbname",$dbuser,$dbpassword);
        $sql= 'SELECT Permissions_Perm_ID as PermID
 From Users_has_Permissions 
where Users_User_ID = (SELECT User_ID From Users where User_Name = :username)';
        $statement = $ifowner->prepare($sql);
        $statement->execute(array(':username'=>$_SESSION["username"]));
        $record = $statement->fetch();
      
        if($record["PermID"] == 2)
        {
           $isadmin = true;
        }else if($record["PermID"] == 1)
        {
           $isadmin = true; 
        }
      
    $record = null;
    $statement->closeCursor();
    $ifowner = null;
    return $isadmin;
}catch(PDOException $e)
{
  $_SESSION["ERROR"] = "Something came up with our Database. We apologize come back later";
       $host  = $_SERVER['HTTP_HOST'];
$uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
 $extra = "error.php";
header("Location: http://$host$uri/$extra");
exit;   
}
    
    }else{
      return $isadmin;  
    }
    }
    
    function testdata() // Ελέγχει αν υπάρχει επιχειρήσει που να έχει δημιουργήσει ο χρήστης
    {
         $hasBusiness = false;
    if(isset($_SESSION["username"]))
    {
    try{
        include 'Dtopfun/dbparm.php';
    $ifhasbus = new PDO("mysql:host=$dbhost;dbname=$dbname",$dbuser,$dbpassword);
        $sql= 'SELECT Business_ID,Business_Title,Address,Phone,Date_of_Creation,Description 
            ,(SELECT Name_of_Type FROM Bus_Type where TypeoB_ID = b.Business_Type) as BusinessType FROM Business b 
WHERE b.User_ID = (SELECT Users.User_ID from Users where Users.User_Name = :username)';
        $statement = $ifhasbus->prepare($sql);
        $statement->execute(array(':username'=>$_SESSION["username"]));
        $record = $statement->rowCount();
      if($record > 0)
      {
         $hasBusiness = true; 
      }
       
    $record = null;
    $statement->closeCursor();
    $ifhasbus = null;
    return $hasBusiness;
}catch(PDOException $e)
{
  $_SESSION["ERROR"] = "Something came up with our Database. We apologize come back later";
       $host  = $_SERVER['HTTP_HOST'];
$uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
 $extra = "error.php";
header("Location: http://$host$uri/$extra");
exit;   
}
    
    }else{
      return $hasBusiness;     
    }
    }

 function ThemeINT() // Τσεκάρει αν έχει καταχωρημένο ο Χρηστης κάποιο θέμα
 {
     $theme = "1";
     if(isset($_SESSION["username"]))
     {
          try{
        include 'Dtopfun/dbparm.php';
        $taketheme = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpassword);
        $sql = 'SELECT Theme FROM Users Where User_Name = :username';
        $statement = $taketheme->prepare($sql);
    $statement->execute(array(':username'=> $_SESSION["username"]));
    $record= $statement->fetch();
    if($statement->rowCount() > 0)
    {
        $theme = "".$record["Theme"]."";
    }
    $statement->closeCursor();
    $taketheme = null;
    $record = null;
    return $theme;
 
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
     }
 }
 function getlastimg() // Παίρνει τις 3 τελευταίες εικόνες κάθε μια από διαφορετική επιχειρήση 
 {
     try{
          include 'Dtopfun/dbparm.php';
        $takeImg = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpassword);
        $sql = "Select PicPath,Description,Business_Business_ID as BusID
from Pics b inner join Business_has_Pics d on b.Pic_ID = d.Pics_Pic_ID where
d.IsProfilePic = true
order by b.Pic_ID DESC LIMIT 3";
        $statement = $takeImg->prepare($sql);
        $statement->execute();
        /*
         * Δημιουργία div element και τοποθέτηση φωτογραφιών
         */
        echo'<div style=" width:80%; margin:0 auto; padding:0; overflow:auto;"><h5 class="center" style="color:black;">Last Business Image</h5><br/>';
        while($record = $statement->fetch())
        {
            echo '<a href="ViewBusiness.php?busID='.$record["BusID"].'" target="_self"><img src="Images/Uploaded_Images/'.$record["PicPath"].'" title="'.$record["Description"].'" alt="'.$record["Description"].'" width="25%" height="auto" /></a> ';
        }
        echo '</div>';
        $statement->closeCursor();
        $takeImg = null;
         
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
 }
 
 function getmail() // επιστρέφει το mail του χρήστη που είναι online
 {
     if(isset($_SESSION["username"]))
     {
        try{
          include 'Dtopfun/dbparm.php';
        $getmail = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpassword);
        $sql = 'SELECT Mail from Users WHERE User_Name= :user';
        $statement = $getmail->prepare($sql);
        $statement->execute(array(':user'=>$_SESSION["username"]));
       $record = $statement->fetch();
        $statement->closeCursor();
        $getmail = null;
        return $record["Mail"];
         
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
            $_SESSION["ERROR"] = "YOU are NOT a USER ";
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
