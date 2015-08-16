<?php

if(isset($_POST["PiciD"]) && isset($_POST["BiD"]))
{
    
   $BiD = $_POST["BiD"];
    $PicD = $_POST["PiciD"];
    if(preg_match("/^[0-9]+$/", $BiD) && preg_match("/^[0-9]+$/", $PicD)) // Ελέγχει εάν είναι αριθμός 
    {
   try{
        include '../Dtopfun/dbparm.php';
      $ProfPic = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpassword);
         $sql = 'UPDATE Business_has_Pics SET IsProfilePic = true WHERE Pics_Pic_ID = :PicID AND Business_Business_ID = :bid';
         $PicProf = $ProfPic->prepare($sql);
        $PicProf->execute(array(':PicID'=>$PicD,':bid'=>$BiD));
        $PicProf->closeCursor();
       $upd = 'UPDATE Business_has_Pics SET IsProfilePic = false WHERE Pics_Pic_ID <> :PicID AND Business_Business_ID = :bid';
       $upda = $ProfPic->prepare($upd);
       $upda->execute(array(':PicID'=>$PicD,':bid'=>$BiD));
       $upda->closeCursor();
       $ProfPic = null;
       echo 'Profile Picture Changed!';
       
}catch(PDOException $e)
{
    echo '<div class="message warning">Something Wrong with our database sorry</div>';
}
    
}else{
    echo '<div class="message warning">Dont Try Naughty things</div>';
}
}else{
      echo '<div class="message warning">Something Came up. Please try again!</div>';

}
?>
