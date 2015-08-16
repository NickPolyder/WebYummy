<?php
session_start();
//Upload Image
if((isset($_FILES["imgFilename"]) || $_FILES["imgFilename"]["name"] != '' )&& isset($_POST["ID"]))
{
    $match=true;
    if(!preg_match("/^[0-9]+$/", $_POST["ID"])) // Ελέγχει αν το ID είναι αριθμός
    {
        $match = false;
         session_destroy();
        session_start();
      $_SESSION["ERROR"] = "Good Try ;)";
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
    }else{
        $BiD = $_POST["ID"];
    }
   $type = $_FILES["imgFilename"]["type"];
   $size = $_FILES["imgFilename"]["size"];
   
   $max_size = 1024*1024;
   
  if($size > $max_size)
  {
      $warnmessage = "?warn=Please Follow the Rules!<br> The Size of the file is bigger than 1 mb!";
      $match= false;
  }
 if ($type == "image/jpg" || $type == "image/jpeg" )
  {
      $ext = ".jpg";
  }else if ($type == "image/gif")
  {
      $ext=".gif";
  }else if ($type == "image/png")
  {
      $ext = ".png";
  }else{
      $ext = null;
      $match=false;
     if(strlen($warnmessage) == 0)
     {
         $warnmessage= "?warn=Please follow the rules!<br> Choose the right type of image!";
     }else{
         $warnmessage .= "<br>Choose the right type of image!";
     }
  }
   
   
 if(isset($_POST["ImageDescription"]))
 {
    $ImageDescription =  $_POST["ImageDescription"];
 }else{
      $ImageDescription = null;
 }
 

 if($match == true)
 {
     $newfilename = "".uniqid("Image-",true).''.$ext;
     $copied = copy($_FILES['imgFilename']['tmp_name'], "../Images/Uploaded_Images/".$newfilename);
     if($copied)
     {
     try{
         include '../Dtopfun/dbparm.php';
         $upload = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpassword);
         $sql = 'INSERT INTO Pics (PicPath, Description) VALUES (:image, :description)';
         $picprep = $upload->prepare($sql);
         $picprep->execute(array(':image'=>$newfilename,':description'=>$ImageDescription));
         $row = $picprep->rowCount();
         $PicID = $upload->lastInsertId();
         if($row > 0)
         {
            $sql2 = 'INSERT INTO Business_has_Pics (Business_Business_ID, Pics_Pic_ID) VALUES (:BusID, :PicID)'; 
            $bustopic = $upload->prepare($sql2);
            $bustopic->execute(array(':BusID'=>$BiD,':PicID'=>$PicID));
            
         }
         $bustopic = null;
         $row = null;
         $picprep->closeCursor();
         $upload = null;
               $host  = $_SERVER['HTTP_HOST'];
             $public_directory = dirname($_SERVER['PHP_SELF']);
    //place each directory into array
    $directory_array = explode('/', $public_directory);
    //get highest or top level in array of directory strings
    $public_base ="/$directory_array[1]"; 
$uri   = rtrim($public_base, '/\\');
 $extra = "ViewBusiness.php?busID=".$BiD."&msg=The Image has been uploaded Succesfully";
header("Location: http://$host$uri/$extra");

exit;
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
         $warnmessage = "?warn=Something came up with the file so it didnt uploaded.<br>Please Try Again!&BiD=".$BiD;
        $host  = $_SERVER['HTTP_HOST'];
             $public_directory = dirname($_SERVER['PHP_SELF']);
    //place each directory into array
    $directory_array = explode('/', $public_directory);
    //get highest or top level in array of directory strings
    $public_base ="/$directory_array[1]"; 
$uri   = rtrim($public_base, '/\\');
 $extra = "UploadImage.php".$warnmessage;
header("Location: http://$host$uri/$extra"); 
         
     }
     
     
 }else{
     $host  = $_SERVER['HTTP_HOST'];
             $public_directory = dirname($_SERVER['PHP_SELF']);
    //place each directory into array
    $directory_array = explode('/', $public_directory);
    //get highest or top level in array of directory strings
    $public_base ="/$directory_array[1]"; 
$uri   = rtrim($public_base, '/\\');
 $extra = "UploadImage.php".$warnmessage.'&BiD='.$BiD;
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
 $extra = "UploadImage.php?msg=Please choose a file to upload!&BiD=".$BiD;
header("Location: http://$host$uri/$extra");

exit;
}
?>
