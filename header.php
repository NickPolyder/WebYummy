<?php

require_once("Dtopfun/datafunctions.php");

if(!isset($_SESSION["ERROR"]))
{
fadinsert();
}

?>
<!DOCTYPE html>
<html>
    <head>
        <title> <?php echo $TitleSite;?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <?php 
        // Ελέγχει αν το $_COOKIE["Style"] είναι αριθμός
        if(isset($_COOKIE["Style"]) && preg_match("/^[0-9]+$/", $_COOKIE["Style"]))
        {
            if($_COOKIE["Style"] == "1")
            {
                  
      echo ' <link rel="stylesheet" href="css/Style1.css" type="text/css"> ';
            } else if ($_COOKIE["Style"] == "2") {
               echo '<link rel="stylesheet" href="css/Style2.css" type="text/css">';  
            }else{
                  echo ' <link rel="stylesheet" href="css/Style1.css" type="text/css"> ';
            }
        }else if(ThemeINT() == "2"){
            echo '<link rel="stylesheet" href="css/Style2.css" type="text/css">'; 
            
            }else{
             echo '<link rel="stylesheet" href="css/Style1.css" type="text/css">';
        }
     ?>
        <script type="text/javascript" src="scripts/jquery.js"></script>
<script type="text/javascript" src="scripts/Functions.js">

</script> 

    </head>
    <body>
        <div id="Header">
            <h1>WebYummy</h1>
            <form style="float:right;" id="Style1" name="Style1" method="POST" action="theme.php" >
                <select id="Style" name="Style">
                    <option value="1">WebYummy(Default) Theme</option>
                    
                    <option value="2" <?php if(isset($_COOKIE["Style"]) && preg_match("/^[0-9]+$/", $_COOKIE["Style"]) && $_COOKIE["Style"] == "2" || ThemeINT() == "2") echo 'selected="selected"'; ?>>Black &amp; White Theme </option>
                </select>
                <input id="page" name="page" type="Hidden" value="<?php echo $_SERVER['PHP_SELF'] ; ?>" />
                <input id="Submit" name="Submit" type="Submit" value="Change Theme" />
            </form>
        </div>
