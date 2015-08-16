<?php
//Creates Xml file
// Ελέγχει αν είναι αριθμός
if ((isset($_GET["ID"]) && preg_match("/^[0-9]+$/",$_GET["ID"])) || (isset($_GET["type"]) && preg_match("/^[0-9]+$/",$_GET["type"]) && $_GET["type"] != "-1"))
{
try{
    
    include '../Dtopfun/dbparm.php';

   $pdoObject = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpassword);
   if(isset($_GET["ID"]))
   {
   $sql= 'SELECT Business_ID,Business_Title,Address,Phone,Business_Type,
       (SELECT Name_of_Type FROM Bus_Type where TypeoB_ID = b.Business_Type) as BusinessType,
       Date_of_Creation,GeoLocation_x,GeoLocation_y,Description FROM Business b 
                        WHERE Business_ID = :bid';
   }else if(isset($_GET["type"]))
   {
     $sql= 'SELECT Business_ID,Business_Title,Address,Phone,Business_Type,
       (SELECT Name_of_Type FROM Bus_Type where TypeoB_ID = b.Business_Type) as BusinessType,
       Date_of_Creation,GeoLocation_x,GeoLocation_y,Description FROM Business b 
                        WHERE Business_Type = :bid';   
   }
   $statement = $pdoObject->prepare($sql);
    if(isset($_GET["ID"]))
   {
     $statement->execute(array(':bid'=>$_GET['ID']));
   }else if(isset($_GET["type"]))
   {
   $statement->execute(array(':bid'=>$_GET["type"]));
   }
   header("content-type: text/xml");
    //εδώ αρχίζει η παραγωγή του XML - το "\r\n" είναι αλλαγή γραμμής
    echo '<?xml version="1.0" encoding="UTF-8"?'.'>'."\r\n";
    echo '<!DOCTYPE movies SYSTEM "Business.dtd">'."\r\n";
    echo '<Businesses>'."\r\n";   //το root element του XML

    //φτιάξτε εδώ το while loop του PDO που θα γράψει τα XML elements
    while ( $record = $statement->fetch() ) {

   echo '<Business id="'.$record["Business_ID"].'">'."\r\n";
   echo '<BusinessName>'.$record["Business_Title"].'</BusinessName>'."\r\n";
     echo '<Address>'.$record["Address"].'</Address>'."\r\n";
       echo '<Phone>'.$record["Phone"].'</Phone>'."\r\n";
         echo '<DateOfCreation>'.$record["Date_of_Creation"].'</DateOfCreation>'."\r\n";
           echo '<Description>'.$record["Description"].'</Description>'."\r\n";
   echo '<BusinessType id="'.$record["Business_Type"].'">'.$record["BusinessType"].'</BusinessType>'."\r\n";
   echo '<GeoX>'.$record["GeoLocation_x"].'</GeoX>'."\r\n";
   echo '<GeoY>'.$record["GeoLocation_y"].'</GeoY>'."\r\n";
   echo '</Business>'."\r\n";   
    }
    echo '</Businesses>'."\r\n";   //κλείσιμο το root element
        
    // αποσύνδεση από database
    $statement->closeCursor();
    $pdoObject = null;  
}catch(PDOException $e)
{
    echo 'Database Error';
}
}else if(isset($_GET["type"]) &&  $_GET["type"] == "-1")
{
    try{
    include '../Dtopfun/dbparm.php';
 header("content-type: text/xml");
   $pdoObject = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpassword);
 
   $sql= 'SELECT Business_ID,Business_Title,Address,Phone,Business_Type,
       (SELECT Name_of_Type FROM Bus_Type where TypeoB_ID = b.Business_Type) as BusinessType,
       Date_of_Creation,GeoLocation_x,GeoLocation_y,Description FROM Business b'; 
    $statement = $pdoObject->prepare($sql);
    $statement->execute();
    header("content-type: text/xml");
    //εδώ αρχίζει η παραγωγή του XML - το "\r\n" είναι αλλαγή γραμμής
    echo '<?xml version="1.0" encoding="UTF-8"?'.'>'."\r\n";
    echo '<!DOCTYPE movies SYSTEM "Business.dtd">'."\r\n";
    echo '<Businesses>'."\r\n";   //το root element του XML

    //φτιάξτε εδώ το while loop του PDO που θα γράψει τα XML elements
    while ( $record = $statement->fetch() ) {

   echo '<Business id="'.$record["Business_ID"].'">'."\r\n";
   echo '<BusinessName>'.$record["Business_Title"].'</BusinessName>'."\r\n";
     echo '<Address>'.$record["Address"].'</Address>'."\r\n";
       echo '<Phone>'.$record["Phone"].'</Phone>'."\r\n";
         echo '<DateOfCreation>'.$record["Date_of_Creation"].'</DateOfCreation>'."\r\n";
           echo '<Description>'.$record["Description"].'</Description>'."\r\n";
   echo '<BusinessType id="'.$record["Business_Type"].'">'.$record["BusinessType"].'</BusinessType>'."\r\n";
   echo '<GeoX>'.$record["GeoLocation_x"].'</GeoX>'."\r\n";
   echo '<GeoY>'.$record["GeoLocation_y"].'</GeoY>'."\r\n";
   echo '</Business>'."\r\n";   
    }
    echo '</Businesses>'."\r\n";   //κλείσιμο το root element
        
    // αποσύνδεση από database
    $statement->closeCursor();
    $pdoObject = null;  
    }catch(PDOException $e)
{
    echo 'Database Error';
}
    
    }else{
    echo 'Insert Error';
}
?>
