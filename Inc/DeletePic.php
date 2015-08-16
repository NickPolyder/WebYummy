<?php
//Delete Picture
if(isset($_POST["PicID"]) && preg_match("/^[0-9]+$/", $_POST["PicID"])) // Ελέγχει αν είναι αριθμός
{
    $PicID = $_POST["PicID"];
    try{
         include '../Dtopfun/dbparm.php';
             $delpic = new PDO("mysql:host=$dbhost;dbname=$dbname",$dbuser,$dbpassword);
             $takefile = 'SELECT * FROM Pics Where Pic_ID = :ID';
             $takethefile = $delpic->prepare($takefile);
             $takethefile->execute(array(':ID'=>$PicID));
             $filename =  $takethefile->fetch();
             $takethefile->closeCursor();
             $sqlbus = 'DELETE FROM Business_has_Pics WHERE Pics_Pic_ID = :ID';
             $delfbus = $delpic->prepare($sqlbus);
             $delfbus->execute(array(':ID'=>$PicID));
          $flag2 = $delfbus->rowCount();
                     
             $sql = 'DELETE FROM Pics WHERE Pic_ID = :ID';
             $delete = $delpic->prepare($sql);
            $delete->execute(array(':ID'=>$PicID));
       $flag = $delete->rowCount();
       
             $delete->closeCursor();
             
        
          if($flag > 0 && $flag2 > 0)
          {
              $filePath='../Images/Uploaded_Images/';
              if(!file_exists($filePath.$filename["PicPath"]))
              {
                  echo 'File Does Not Exist!';
              }else{
                  
                  $fileDelResult=unlink($filePath.$filename["PicPath"]);
                 
                  if(!$fileDelResult)
                  {
                      echo 'File Dont want to Delete from this Server. Talk some Sense to It!';
                  }else{
                      echo 'File Deleted thanks for your time! ';
                  }
              }
          }else{
              echo 'Database dont want to delete your file Sorryyyyy!';
          }
             $delfbus->closeCursor();
             $delpic = null;
}catch(PDOException $e)
{
echo '<div class="message warning">Something Wrong with our database sorry</div>';
}
}else{
    echo 'We Cant delete this file';
}
?>
