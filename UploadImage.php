<?php
$TitleSite = "WebYummy - Upload Image";
include 'header.php';
include 'Menu.php';
is_not_logged_in();
if(!alreadyowner() && !isAdmin())
{
     $_SESSION["ERROR"] = "You are not Own any Business Record";
$host  = $_SERVER['HTTP_HOST'];
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$extra = 'error.php';
header("Location: http://$host$uri/$extra");
exit;
}
if(isset($_GET["BiD"]))
{
    // Ελέγχει αν το BiD είναι αριθμός
    if(preg_match("/^[0-9]+$/", $_GET["BiD"]))
  $BiD =  $_GET["BiD"];
else{
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
}else{
    $host  = $_SERVER['HTTP_HOST'];
             $public_directory = dirname($_SERVER['PHP_SELF']);
    //place each directory into array
    $directory_array = explode('/', $public_directory);
    //get highest or top level in array of directory strings
    $public_base ="/$directory_array[1]"; 
$uri   = rtrim($public_base, '/\\');
 $extra = "Catalog.php?msg=Please Select a Business and Try Again!";
header("Location: http://$host$uri/$extra");
exit;
}

?>
<div id="Main">
     <br />
    <br />
    <?php 
    // Ελέγχει εάν είναι κάποιο php αρχείο
if(isset($_SESSION["Page"]) && preg_match("/(.)+[^\"'<>()0-9\/]+.php/", $_SESSION["Page"]))
{
  $pub_Base = explode("/",$_SESSION["Page"]);
  
 $host  = $_SERVER['HTTP_HOST'];
$uri   = trim(dirname($_SERVER['PHP_SELF']), '/\\');
$page = $extra = $pub_Base[2];

   
   echo '<a href="'.$page.'" title="go back" class="goback">Go Back!</a>';
}else{
   echo '<a href="Catalog.php" title="go back" class="goback">Go Back!</a>';  
}  
              ?>
      <br />
    <br /> <br />
    <br />
    
  <?php
  
  if(isset($_GET["warn"]))
            {
                $message = $_GET["warn"];
                 // Ελέγχει αν ο χρήστης προσπάθησε να γράψει κάποιου τύπου κώδικα.
                if(!preg_match("/^[<+($|#|%|script|Script)+>]+(.)+[<+($|#|%|\/script|\/Script)+>]+$/", $message))
                {
              preg_replace("/(<br>)+/","\n", $message); // Αλλάζει το <br> σε χαρακτήρα αλλαγής γραμμής
              
             ?>
             <div class="message warning"><?php echo $message; ?></div>
        <?php   }else{
         echo '<div class="message warning"><h1>Busted!</h1></div>';
        }
            }
        
  if(isset($_GET["msg"]))
            {
                $message = $_GET["msg"];
                 // Ελέγχει αν ο χρήστης προσπάθησε να γράψει κάποιου τύπου κώδικα.
                if(!preg_match("/^[<+($|#|%|script|Script)+>]+(.)+[<+($|#|%|\/script|\/Script)+>]+$/", $message))
                {
                
             ?>
             <div class="message info"><?php echo $message; ?></div>
        <?php   }else{ 
         echo '<div class="message info"><h1>Busted!</h1></div>';
        }
            } ?>
     <h2 id="lgo">Upload Image!</h2>
    
     
     <form class="CreateForms"  name="Upload" method="post" action="Inc/upload.php" enctype="multipart/form-data">
         <table class="TableForms">
             <tr><td><input type="hidden" id="ID" name="ID" value="<?php echo $BiD;?>" /></td></tr>
             <tr>
                 
           <td>Image:</td><td><input type="file"  id="imgFilename" name="imgFilename" /></td></tr>
           <tr> <td>Image Description:</td><td>
               <textarea id="ImageDescription" placeholder="Write a description for your image" name="ImageDescription" rows="5" cols="25" style="color:black;"></textarea>
           </td>
             </tr>
            <tr><td class="buttons"></td><td class="buttons"><input id="Upload" name="Upload" type="submit" value="Upload" /></td></tr>
                        <tr><td class="buttons"></td><td class="buttons"><input id="reset" name="reset" type="Reset" value="Reset" /></td></tr>
         </table>
    </form>
    
    
    
    
    <br />
<br />
<br />
</div>

<?php

include 'Inc/footer.php';
?>
