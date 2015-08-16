<?php
session_start();
// Delete Business
if(isset($_SESSION["username"]) && isset($_POST["BUSID"]))
{
    $user = $_SESSION["username"];
    $BusID = $_POST["BUSID"];
 
    if(!preg_match("/^[0-9]+$/", $BusID)) // Ελέγχει αν  είναι αριθμός
    {
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
    }
    try{
       include '../Dtopfun/dbparm.php';
            $Delete = new PDO("mysql:host=$dbhost;dbname=$dbname",$dbuser,$dbpassword);  
            $sql = 'DELETE FROM Business 
                WHERE Business_ID = :IDB 
                and User_ID = (SELECT Users.User_ID from Users where Users.User_Name = :user)';
            $statement = $Delete->prepare($sql);
         $statement->execute(array(':IDB'=>$BusID,':user'=>$user));
         $success= $statement->rowCount();
         if($success > 0 )
         {
             $statement->closeCursor();
             $Delete= null;
             $success = null;
             
                $host  = $_SERVER['HTTP_HOST'];
             $public_directory = dirname($_SERVER['PHP_SELF']);
    //place each directory into array
    $directory_array = explode('/', $public_directory);
    //get highest or top level in array of directory strings
    $public_base ="/$directory_array[1]"; 
$uri   = rtrim($public_base, '/\\');
 $extra = "Catalog.php?msg=The Business with ID: ".$BusID." Deleted with Success";
header("Location: http://$host$uri/$extra"); 
exit;
         }else{
            $statement->closeCursor();
             $Delete= null;
             $success = null;
             
                $host  = $_SERVER['HTTP_HOST'];
             $public_directory = dirname($_SERVER['PHP_SELF']);
    //place each directory into array
    $directory_array = explode('/', $public_directory);
    //get highest or top level in array of directory strings
    $public_base ="/$directory_array[1]"; 
$uri   = rtrim($public_base, '/\\');
 $extra = "Catalog.php?msg=The Business with ID: ".$BusID." Cant be Deleted please try again later OR Contact with the Administrator!";
header("Location: http://$host$uri/$extra"); 
exit;
         }
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
?>
