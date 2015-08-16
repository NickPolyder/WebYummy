<?php
  $TitleSite = "WebYummy";
        include 'header.php';
        include 'Menu.php';
     
        ?>

        <div id="Main">
            <br/><br/>
            <?php
            if(isset($_GET["msg"]))
            {
                $message = $_GET["msg"];
                 // Ελέγχει αν ο χρήστης προσπάθησε να γράψει κάποιου τύπου κώδικα.
                if(!preg_match("/^[<+($|#|%|script|Script)+>]+(.)+[<+($|#|%|\/script|\/Script)+>]+$/", $message))
                {
                
             ?>
             <div class="message info"><?php echo $message; ?></div>
        <?php   }else{
         echo '<div class="message warning"><h1>Busted!</h1></div>';
        }
            }
           
            ?>
             <div id="leftsidebar">
                 <table>
                     <tr><th colspan="2">Categories</th></tr>
         <?php
         try{
             include 'Dtopfun/dbparm.php';
             $menu = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser,$dbpassword);
             $sql = "SELECT TypeoB_ID,Name_of_Type,
(SELECT count(Business_ID) from Business where Business_Type = b.TypeoB_ID) as NumberOfBus
 FROM Bus_Type b ";
             $state= $menu->prepare($sql);
             $state->execute();
             while($record = $state->fetch())
             {
                 echo '<tr><td colspan="2"><a href="search.php?BusinessType='.$record["TypeoB_ID"].'" >'.$record["Name_of_Type"].'  ('.$record["NumberOfBus"].')</td></tr>';
             }
             $state->closeCursor();
             $menu = null;
             
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
         ?>
                     <tr >
                         <th style="border-top:thin solid darkred;">Technologies,<br /> We used for this site.</th>
                     </tr>
                     <tr><td><a href="http://www.php.net" target="_blank">PHP</a></td></tr>
                     <tr><td><a href="http://www.w3schools.com/html/" target="_blank">HTML</a></td></tr>
                     <tr><td><a href="http://www.w3schools.com/css/" target="_blank">CSS</a></td></tr>
                     <tr><td><a href="http://www.w3schools.com/js/" target="_blank">JavaScript</a></td></tr>
                     <tr><td><a href="http://jquery.com/" target="_blank">JQuery</a></td></tr>
                     <tr><td><a href="http://www.w3schools.com/ajax/" target="_blank">Ajax</a></td></tr>
                 </table>
             </div>
             <div id="centerview">
                 <br/>
       <p class="center">The <strong>WebYummy</strong> is a Project based in Web Design &amp; Develop in real situation. <br/>
                 It could be a real web site up and running!</p>
         <br/>
         <?php if(!isset($_SESSION["ERROR"]))
{ getlastimg(); }?>
         <br/>
             </div>
          
         <?php for($i=0; $i<20; $i++) {?>
          <br/>
          <br/>
         <?php } ?>
        </div>

<?php
        include 'Inc/footer.php';
?>