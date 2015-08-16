<?php
  $TitleSite = "WebYummy - Catalog";
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
            <?php
            if(!isset($_SESSION["ERROR"]))
{
      if(useron())
      {
    ?>
            <div id="UserPanel">
                <ul>
                   <?php if(!alreadyowner())
                    {?>
                    <li><a href="AddBusiness.php" target="_self">Add</a></li>
                    <?php if(!isAdmin())
                    {  ?>
                     <li style="background-color:gray;  padding:0.5em 2em;"><abbr title="You are not owner of One Business Record">Edit</abbr></li>
                    <li style="background-color:gray;  padding:0.5em 2em;"><abbr title="You are not owner of One Business Record">Delete</abbr></li>
                    <?php }else{
                        if(testdata() == true)
                        {
                        ?>
   
                   <li><a href="Edit.php" target="_self">Edit</a></li>
                 <li><a href="Delete.php" target="_self">Delete</a></li>
                        
                        <?php  }else{
                            
                            ?>
                   <li style="background-color:gray;  padding:0.5em 2em;"><abbr title="You are not owner of One Business Record">Edit</abbr></li>
                    <li style="background-color:gray;  padding:0.5em 2em;"><abbr title="You are not owner of One Business Record">Delete</abbr></li>
                                
                                <?php
                    }
                    
                        } }else{
                        
                 echo '<li style="background-color:gray;  padding:0.5em 2em;"><abbr title="You already own One Business Record">Add</abbr></li> ';
                 ?>
                    <li><a href="Edit.php" target="_self">Edit</a></li>
                    <li><a href="Delete.php" target="_self">Delete</a></li>
                <?php }
        ?>
                    
            </ul></div> 
            <?php 
      
      }
}
?>
             <br/>
             <br/>
             <div id="BusCat">
              
                 <span id="transback"><a href="Catalog.php?trans=5" target="_self">5</a>|<a href="Catalog.php?trans=10" target="_self">10</a>|<a href="Catalog.php?trans=20" target="_self">20</a>|<a href="Catalog.php?trans=30" target="_self">30</a></span>
                 <br />
                 <table class="CatalogFormtable">
                     <?php   
                     try{
                         if(isset($_GET["trans"]))
                         {
                             // Ελέγχει αν το trans είναι αριθμός και αποτελείται το πολύ από δυο ψηφία
                             if(preg_match("/^[0-9]{1,2}$/",$_GET["trans"])){
                             $recperpage = $_GET["trans"];
                             $doit = "&trans=".$recperpage."";
                             } else
                             {
                             $recperpage = 5;
                             $doit = "&trans=5";
                         }
                         }else{
                             $doit = "&trans=5";
                             $recperpage = 5;
                         }
                         if(isset($_GET["page"]))
                         {
                             // Ελέγχει αν το page είναι αριθμός και αποτελείται το πολύ από 5 ψηφία
                        if(preg_match("/^[0-9]{1,5}$/",$_GET["page"]))
                             $page = $_GET["page"];
                             else
                             $page = 1;
                         }else{
                             $page = 1;
                            
                         }
                         
                         $startpage = (number_format($page)-1) * number_format($recperpage);
                        
                        include 'Dtopfun/dbparm.php';
             $sel = new PDO("mysql:host=$dbhost;dbname=$dbname",$dbuser,$dbpassword);
             $sqlpaging = 'SELECT count(Business_ID) as Counter from Business';
             $pagingstate = $sel->prepare($sqlpaging);
             $pagingstate->execute();
             $pagesrec = $pagingstate->fetch();
             $pages = ceil($pagesrec["Counter"]/$recperpage);
             $pagesrec = null;
             echo '<br /><div style="text-align:center; padding:0 1em;">';
             if($page!=1)
                 {
                  echo '  <a href="catalog.php?page=1'.$doit.'">First</a>  ';   
                 }
             if($page>1)
                 {
                  echo '  <a href="catalog.php?page='.($page-1).''.$doit.'">Previous</a>  ';   
                 }
             for($i=1; $i<$pages+1; $i++)
             {
                 if($page !=$i)
              echo '  <a href="catalog.php?page='.$i.''.$doit.'">'.$i.'</a>  ';
                 else
                     echo ' '.$i.' ';
              
             }
             if($page<$pages)
                 {
                  echo '  <a href="catalog.php?page='.($page+1).''.$doit.'">Next</a>  ';   
                 }
                  if($page!=$pages)
                 {
                  echo '  <a href="catalog.php?page='.$pages.''.$doit.'">Last</a>  ';   
                 }
             echo '</div>';
             $pagingstate->closeCursor();
                   $sql = "SELECT Business_ID, (SELECT User_Name from Users where Users.User_ID = b.User_ID) as UserName
,Business_Title,Address,Phone,Date_of_Creation,Description
,(SELECT Name_of_Type FROM Bus_Type where TypeoB_ID = b.Business_Type) as BusinessType
FROM Business b ORDER BY Date_of_Creation DESC LIMIT $startpage , $recperpage";
                           $statement = $sel->prepare($sql);
               
                         $statement->execute();
                 while ($record = $statement->fetch())
                 {
                     ?>
   <tr class="catowners"><td>Posted By: <?php echo $record["UserName"];?>/Created: <?php echo $record["Date_of_Creation"];?></td>
                     </tr><tr class="catdetails">
                     <td> Business:  <?php echo $record["Business_Title"];?> <br/> 
                             Address:  <?php echo $record["Address"];?> <br/>
                             Phone: <?php echo $record["Phone"];?> <br/>
                             Business Type: <?php echo $record["BusinessType"];?> <br/>
                           <a href="ViewBusiness.php?busID=<?php echo $record["Business_ID"];?>">See more Details</a> 
                     </td>
                     </tr>
                
                     <?php 
                 }
                  
                 $record = null;
                 $statement->closeCursor();
                 $sel = null;
                 }catch(PDOException $e){
                          $_SESSION["ERROR"] = "Something came up with our Database. We apologize come back later!";
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
                     
                 </table>
           <?php
           
              echo '<br /><div style="text-align:center; padding:0 1em;">';
             if($page!=1)
                 {
                  echo '  <a href="catalog.php?page=1'.$doit.'">First</a>  ';   
                 }
             if($page>1)
                 {
                  echo '  <a href="catalog.php?page='.($page-1).''.$doit.'">Previous</a>  ';   
                 }
             for($i=1; $i<$pages+1; $i++)
             {
                 if($page !=$i)
              echo '  <a href="catalog.php?page='.$i.''.$doit.'">'.$i.'</a>  ';
                 else
                     echo ' '.$i.' ';
              
             }
             if($page<$pages)
                 {
                  echo '  <a href="catalog.php?page='.($page+1).''.$doit.'">Next</a>  ';   
                 }
                  if($page!=$pages)
                 {
                  echo '  <a href="catalog.php?page='.$pages.''.$doit.'">Last</a>  ';   
                 }
             echo '</div>';
           ?>
             </div>
 
 </div>

<?php
        include 'Inc/footer.php';
?>