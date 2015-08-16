<?php
session_start();
$expire=time()+60*60*24*30;
// Ελέγχει αν το $_POST["Style"] είναι αριθμός
if(isset($_POST["Style"]) && preg_match("/^[0-9]+$/", $_POST["Style"]))
{
setcookie("Style",$_POST["Style"], $expire);
if(isset($_SESSION["username"]))
{
    
    try{
        include 'Dtopfun/dbparm.php';
     
        $theme = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpassword);
        if($_POST["Style"] == "2")
        {
        $sql = "UPDATE Users SET Theme = 2 Where User_Name = :username";
        }else{
            $sql = "UPDATE Users SET Theme = 1 Where User_Name = :username";
        }
        $statement = $theme->prepare($sql);
     $statement->execute(array(':username'=>$_SESSION["username"]));
   
   $statement->closeCursor();
   $theme = null;
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
// Ελέγχει εάν είναι κάποιο php αρχείο
if(isset($_POST["page"]) && preg_match("/(.)+[^\"'\\\/<>()0-9]+.php/", $_POST["page"]))
{
  $pub_Base = explode("/",$_POST["page"]);
  
 $host  = $_SERVER['HTTP_HOST'];
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$extra = $pub_Base[2];
header("Location: http://$host$uri/$extra");
exit;
}else{
 $host  = $_SERVER['HTTP_HOST'];
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$extra = '';
header("Location: http://$host$uri/$extra");
exit;
}
?>
