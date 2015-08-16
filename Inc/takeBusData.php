<?php
session_start();
//Retrieve Business Data
if(isset($_SESSION["username"]) && isset($_POST["Title"]))
{
    if(preg_match("/Edit/",$_POST["Title"])) // Ψάχνει το edit
    {
        $filename="Edit.php?ID=";
    }else if(preg_match("/Delete/",$_POST["Title"]))  // Ψάχνει το Delete
        
    {
      $filename="Delete.php?ID=";  
    }else{
        $filename = "index.php?msg=Something Happend maybe you tried something naughty&ID=";
    }
    try{
         include '../Dtopfun/dbparm.php';
            $data = new PDO("mysql:host=$dbhost;dbname=$dbname",$dbuser,$dbpassword);
        $sql = 'SELECT Business_ID,Business_Title,Address,Phone,Date_of_Creation,Description 
            ,(SELECT Name_of_Type FROM Bus_Type where TypeoB_ID = b.Business_Type) as BusinessType FROM Business b 
WHERE b.User_ID = (SELECT Users.User_ID from Users where Users.User_Name = :username)';
        $statement = $data->prepare($sql);
        $statement->execute(array(':username'=>$_SESSION["username"]));
     echo '<table class="CatalogFormtable">';
        while($record = $statement->fetch())
        {
           echo '<tr class="catowners"><td>Posted By: YOU /Created: '.$record["Date_of_Creation"].'</td></tr>';
           echo '<tr class="catdetails"><td> Business: '.$record["Business_Title"].'  Address: '.$record["Address"].'<br />';
           echo 'Phone: '.$record["Phone"].'  Business Type: '.$record["BusinessType"].'<br />';
           echo '<a style="text-align:center; font-size:1.2em; text-decoration:none;" href="'.$filename.''.$record["Business_ID"].'" >----->'.$_POST["Title"].'<-----</a></td></tr>';
        }
       echo '</table>';
        $statement->closeCursor();   
        $record= null;
           $data= null;
           
}catch(PDOException $e)
{
echo '<div class="message warning">Something Wrong with our database sorry</div>';
}
}else{
    echo 'Hey Something Happening xD';
}
?>
