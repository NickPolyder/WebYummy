<?php
session_start();
// Ελέγχει αν είναι αριθμός
 if(isset($_GET["Typeofexport"]) && preg_match("/^[0-9]$/", $_GET["Typeofexport"]) && $_GET["Typeofexport"]== "0")
 {
 header("content-type: text/xml");
 }
 $host  = $_SERVER['HTTP_HOST'];
             $public_directory = dirname($_SERVER['PHP_SELF']);
    //place each directory into array
    $directory_array = explode('/', $public_directory);
    //get highest or top level in array of directory strings
    $public_base ="/$directory_array[1]"; 
$uri   = rtrim($public_base, '/\\');
$TitleSite = "WebYummy - Web Service Department";
//Ελέγχει εάν είναι αριθμός και συγκεκριμένα 0 ή 1
if(isset($_GET["output"]) && preg_match("/^[0-1]$/", $_GET["output"]) && $_GET["output"] == "1") 
{ ?>
  <!DOCTYPE html>
<html>
    <head>
        <title> <?php echo $TitleSite;?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <?php 
        if(isset($_COOKIE["Style"]))
        {
            if($_COOKIE["Style"] == "1")
            {
                  
      echo ' <link rel="stylesheet" href="http://'.$host.$uri.'/css/Style1.css" type="text/css" /> ';
            } else if ($_COOKIE["Style"] == "2") {
               echo '<link rel="stylesheet" href="http://'.$host.$uri.'/css/Style2.css" type="text/css" />';  
            }
        }else{
             echo '<link rel="stylesheet" href="http://'.$host.$uri.'/css/Style1.css" type="text/css" />';
        }
     ?> 
        </head>
    <body>
        <div id="Main">
<?php }
if(isset($_GET["Searchlike"]) || (isset($_GET["BusinessType"]) && $_GET["BusinessType"] != "-1" ))
{
    $match = true;
    // Ελέγχει αν είναι αριθμός
    if(isset($_GET["Typeofexport"]) && preg_match("/^[0-9]$/", $_GET["Typeofexport"]) && $_GET["Typeofexport"]!= "-1")
    {
        $typeofexport = $_GET["Typeofexport"];
    }else{
        $typeofexport = "1";
    }
    // Ελέγχει αν είναι αριθμός
    if(isset($_GET["SearchType"]) && preg_match("/^[0-9]$/", $_GET["SearchType"]))
    {
     $searchtype = "".$_GET["SearchType"]."";
    }else{
        $searchtype = "1";
        
    }
   
    if(isset($_GET["Searchlike"]) && strlen($_GET["Searchlike"]) > 0)
    {
    $searchtext = $_GET["Searchlike"];
    }else{
      $searchtext = null;  
    }
    // Ελέγχει αν είναι αριθμός
    if($_GET["BusinessType"] != "-1" && preg_match("/^[0-9]+$/",$_GET["BusinessType"]))
    {
   $bustype = "".$_GET["BusinessType"]."";
    }else{
        $bustype = "-1";
    }
     // Ελέγχει αν ο χρήστης προσπάθησε να γράψει κάποιου τύπου κώδικα.
    if(preg_match("/^[<+($|#|%|script|Script)+>]+(.)+[<+($|#|%|\/script|\/Script)+>]+$/", $searchtext))
    {
        $match = false;
    }     
            if($match == true)
            {
      
 try{
if($typeofexport == "1")
{
     
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
             echo '<h6 style="text-align:center;" class="XMLi"><a  href="http://'.$host.$uri.'/Inc/xmlcreator.php?type='."$bustype".'" target="_blank">Business Type to XML</a></h6>';
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
                          <span style="float:left;" class="XMLi">
                              <?php echo '<a  href="http://'.$host.$uri.'/Inc/xmlcreator.php?ID='.$record["Business_ID"].'" target="_blank">ToXML</a></span>'; ?>Posted By: <?php echo $record["UserName"];?>/Created: <?php echo $record["Date_of_Creation"];?></td>  
                         
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
             
             
 
}else{
              include '../Dtopfun/dbparm.php';
             $sel = new PDO("mysql:host=$dbhost;dbname=$dbname",$dbuser,$dbpassword);
              $sql = "SELECT Business_ID,Business_Title,Address,Phone,Date_of_Creation,
                  Description,GeoLocation_x,GeoLocation_y,Business_Type
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
                  $sql .= ' AND Business_Type = '.$bustype.'';
                        
             }
             }else{
                 if($bustype != "-1")
             {
                 $sql .= " WHERE Business_Type = $bustype";
             }
             }
             $statement = $sel->prepare($sql);
             $statement->execute();
    
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
         $record = null;
                 $statement->closeCursor();
                 $sel = null;
             
}
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
//Ελέγχει εάν είναι αριθμός και συγκεκριμένα 0 ή 1
if(isset($_GET["output"]) && preg_match("/^[0-1]$/", $_GET["output"]) && $_GET["output"] == "1")
{ ?>
        </div>
    </body>
</html>
        
                     
                     
<?php } ?>
