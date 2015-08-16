
<?php
if(isset($_GET["BUSID"]) && preg_match("/^[0-9]+$/", $_GET["BUSID"]))
{
try{
      include '../Dtopfun/dbparm.php';
   
      $Business = new PDO("mysql:host=$dbhost;dbname=$dbname",$dbuser,$dbpassword);
    $sqlprof = 'SELECT * FROM Pics
 where Pic_ID In(SELECT Pics_Pic_ID from Business_has_Pics where IsProfilePic = true  and Business_Business_ID = :BiD)';
       $picprof = $Business->prepare($sqlprof);
       $picprof->execute(array(':BiD'=>$_GET["BUSID"]));
       $profilepic = $picprof->fetch();
       if($picprof->rowCount() > 0)
        echo '<img id="profpic" src="Images/Uploaded_Images/'.$profilepic["PicPath"].'" alt="'.$profilepic["Description"].'" title="'.$profilepic["Description"].'" width="40%" height="auto"/>';
 else
     echo '<i>Dont Have Profile Picture</i>';
        $Business = null;
     
                        $picprof->closeCursor();
}catch(PDOException $e)
{
   echo 'Database Error'; 
}
}else
{
    echo 'Dont try Naughty things!';
}

?>
