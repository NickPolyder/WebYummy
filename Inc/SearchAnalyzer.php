<?php
session_start();
if(isset($_POST["Searchlike"]) || (isset($_POST["BusinessType"]) && $_POST["BusinessType"] != "-1" ) || isset($_GET["BusinessType"]))
{
    $match = true;
    // Ελέγχει αν  είναι αριθμός
    if(isset($_POST["SearchType"]) && preg_match("/^[0-9]$/", $_POST["SearchType"]))
    {
      $_SESSION["searchtype"] =  $searchtype = "".$_POST["SearchType"]."";
    }else{
        $searchtype = "1";
        
    }
   
    if(isset($_POST["Searchlike"]) && strlen($_POST["Searchlike"]) > 0)
    {
   $_SESSION["SearchLike"] = $searchtext = $_POST["Searchlike"];
    }else{
      $searchtext = null;  
    }
     // Ελέγχει αν  είναι αριθμός
    if(isset($_POST["BusinessType"]) && ($_POST["BusinessType"] != "-1" && preg_match("/^[0-9]+$/",$_POST["BusinessType"])))
    {
   $_SESSION["BUSTYPE"] = $bustype = "".$_POST["BusinessType"]."";
    }else if(isset($_GET["BusinessType"]) && preg_match("/^[0-9]+$/",$_GET["BusinessType"])) 
    {
       $_SESSION["BUSTYPE"] = $bustype = $_GET["BusinessType"];
}else{
     $_SESSION["BUSTYPE"] = $bustype = "-1";
    }
     // Ελέγχει αν ο χρήστης προσπάθησε να γράψει κάποιου τύπου κώδικα.
    if(preg_match("/^[<+($|#|%|script|Script)+>]+(.)+[<+($|#|%|\/script|\/Script)+>]+$/", $searchtext))
    {
        $match = false;
         
    }     
            if($match == true)
            {
                
 try{
     ?>
<table class="CatalogFormtable">
    <?php
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
                           include '../Dtopfun/dbparm.php';
             $sel = new PDO("mysql:host=$dbhost;dbname=$dbname",$dbuser,$dbpassword);
              $sqlpaging = 'SELECT count(Business_ID) as Counter from Business';
              $truth = true;
             if($searchtype == "1")
             {
                 /*Ψάχνει να βρει μη εγκεκριμένος χαρακτήρες όπως < > @ ! $ % ^ & *  */
                 if(preg_match("/^[A-Za-z0-9_ \-  \. (+(.)+)+]+$/",$searchtext))
             {
                     $truth =false;
                 $sqlpaging .= ' WHERE Business_Title LIKE '."\"%$searchtext%\"";
             }
          
             }else if($searchtype == "0")
             {
                  /* Ψάχνει να βρει έναν αποδεκτό αριθμό μεταξύ 10 - 14 ψηφίων
 Όπου επιτρέπονται μόνο αριθμοί και το + */
                  if(preg_match("/^[\+0-9]{10,14}$/", $searchtext))
             {
                      $truth =false;
             $sqlpaging .= ' WHERE Phone LIKE '."\"%$searchtext%\"";
             }else{
                 echo '<div class="message warning"> Try A Number</div>';
             exit();
                 
             }
             }else if($searchtype == "2")
             {
                  /*Ψάχνει να βρει μη εγκεκριμένος χαρακτήρες όπως < > @ ! $ % ^ & *  */
                 if(preg_match("/^[A-Za-z0-9_ \-  \. (+(.)+)+]+$/",$searchtext))
             {
                 $truth =false;
             $sqlpaging .= ' WHERE Address LIKE '."\"%$searchtext%\""; 
             }
             }else if($searchtype == "3")
             {
                  /*Ψάχνει να βρει μη εγκεκριμένος χαρακτήρες όπως < > @ ! $ % ^ & *  */
                  if(preg_match("/^[A-Za-z0-9_ \-  \. (+(.)+)+]+$/",$searchtext))
             {
                      $truth =false;
                 $sqlpaging .=' WHERE Description LIKE '."\"%$searchtext%\"";
             }
             }
             if($truth ==false)
             {
             if($bustype != "-1")
             {
                 $sqlpaging .= ' AND Business_Type = '."$bustype";
                        
             }
             }else{
                 if($bustype != "-1")
             {
                  $sqlpaging .= ' WHERE Business_Type = '."$bustype";
             }
             }
         
             $pagingstate = $sel->prepare($sqlpaging);
             if(isset($searchtext) && $bustype != "-1")
             {
                 $pagingstate->execute();
            
             }else  if(isset($searchtext))
             {
             $pagingstate->execute();
             }else if($bustype != "-1")
             {
                $pagingstate->execute(); 
             }
             $pagesrec = $pagingstate->fetch();
             echo '<h4 style="text-align:center;">'.$pagesrec["Counter"].' Search Results!</h4><br/>';
             echo '<h6 style="text-align:center;" class="XMLi"><a  href="Inc/xmlcreator.php?type='."$bustype".'" target="_blank">Business Type to XML</a></h6>';
             $pages = ceil($pagesrec["Counter"]/$recperpage);
             $pagesrec = null;
             
             echo '<br /><div style="text-align:center; padding:0 1em; color:white;">';
             if($page!=1)
                 {
                  echo '  <a href="search.php?page=1'.$doit.'">First</a>  ';   
                 }
             if($page>1)
                 {
                  echo '  <a href="search.php?page='.($page-1).''.$doit.'">Previous</a>  ';   
                 }
             for($i=1; $i<$pages+1; $i++)
             {
                 if($page !=$i)
              echo '  <a href="search.php?page='.$i.''.$doit.'">'.$i.'</a>  ';
                 else
                     echo ' '.$i.' ';
              
             }
             if($page<$pages)
                 {
                  echo '  <a href="search.php?page='.($page+1).''.$doit.'">Next</a>  ';   
                 }
                  if($page!=$pages)
                 {
                  echo '  <a href="search.php?page='.$pages.''.$doit.'">Last</a>  ';   
                 }
             echo '</div>';
             $pagingstate->closeCursor();
             $sql = "SELECT Business_ID, (SELECT User_Name from Users where Users.User_ID = b.User_ID) as UserName
,Business_Title,Address,Phone,Date_of_Creation,Description
,(SELECT Name_of_Type FROM Bus_Type where TypeoB_ID = b.Business_Type) as BusinessType
FROM Business b";
             $lie = true;
              if($searchtype == "1")
             {
                   /*Ψάχνει να βρει μη εγκεκριμένος χαρακτήρες όπως < > @ ! $ % ^ & *  */
                 if(preg_match("/^[A-Za-z0-9_ \-  \. (+(.)+)+]+$/",$searchtext))
             {
                     $lie =false;
                  $sql = $sql.' WHERE Business_Title LIKE '."\"%$searchtext%\"";
              
             }
          
             }else if($searchtype == "0")
             {
                 /* Ψάχνει να βρει έναν αποδεκτό αριθμό μεταξύ 10 - 14 ψηφίων
 Όπου επιτρέπονται μόνο αριθμοί και το + */
                  if(preg_match("/^[\+0-9]{10,14}$/", $searchtext))
             {
                        $lie =false;
              $sql = $sql.' WHERE Phone LIKE '."\"%$searchtext%\"";
             }
             }else if($searchtype == "2")
             {
                 /*Ψάχνει να βρει μη εγκεκριμένος χαρακτήρες όπως < > @ ! $ % ^ & *  */
                 if(preg_match("/^[A-Za-z0-9_ \-  \. (+(.)+)+]+$/",$searchtext))
             {
                   $lie =false;
              $sql = $sql.' WHERE Address LIKE '."\"%$searchtext%\""; 
             
             }
             }else if($searchtype == "3")
             {
                 /*Ψάχνει να βρει μη εγκεκριμένος χαρακτήρες όπως < > @ ! $ % ^ & *  */
                  if(preg_match("/^[A-Za-z0-9_ \-  \. (+(.)+)+]+$/",$searchtext))
             {
                        $lie =false;
                  $sql = $sql.' WHERE Description LIKE '."\"%$searchtext%\"";
             }
             
             }
             if($lie==false)
             {
             if($bustype != "-1")
             {
                  $sql .= ' AND Business_Type = '.$bustype.' '." LIMIT $startpage , $recperpage" ;
                        
             }
             }else{
                 if($bustype != "-1")
             {
                 $sql .= " WHERE Business_Type = $bustype LIMIT $startpage , $recperpage";
             }else{
                $sql .= " LIMIT $startpage , $recperpage"; 
             }
             }
             $statement = $sel->prepare($sql);
             if(isset($searchtext) && $bustype != "-1")
             {
               
                 $statement->execute();
             
             }else if(isset($searchtext))
             {
              
                
             $statement->execute();
             }else if($bustype != "-1")
             {
                
                $statement->execute(); 
             }
            
                       
                 while ($record = $statement->fetch())
                 {
                     ?>
  
                     <tr>
                      <td class="catowners">
                          <span style="float:left;" class="XMLi"><a  href="Inc/xmlcreator.php?ID=<?php echo $record["Business_ID"];?>" target="_blank">ToXML</a></span>Posted By: <?php echo $record["UserName"];?>/Created: <?php echo $record["Date_of_Creation"];?></td>  
                         
                     <td class="catdetails"> Business:  <?php echo $record["Business_Title"];?> <br/> 
                             Address:  <?php echo $record["Address"];?> <br/>
                             Phone: <?php echo $record["Phone"];?> <br/>
                             Business Type: <?php echo $record["BusinessType"];?> <br/>
                           <?php  echo'<a href="ViewBusiness.php?busID='.$record["Business_ID"].'">See more Details</a>'; ?>
                     </td>
                     </tr>
                
                     <?php 
                 }
                 echo '</table>';
                  
                 $record = null;
                 $statement->closeCursor();
                 $sel = null;
             
             
 
 
                 }catch(PDOException $e)
 {
     echo '<div class="message warning">We Had some problem with our Database. We apologize...<br /> Try Again later</div>';
 }
}else{
    
    echo '<div class="message warning">Please check the input you send us maybe you tried something naughty</div>';
}
}else{
    echo '<div class="message info">We dont have the necessary  things to show you the results sorry :(</div>';
}
?>
<br />
<br />
<br />
<br />

