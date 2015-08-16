
<div id="Menu"> <ul>
                  <li><a  href="index.php" target="_self" >Home</a></li>
                  <li><a href="WebService.php" target="_self">WebService</a></li>
                  <li><a href="Catalog.php" target="_self" >Catalog</a></li>
                  <li><a href="Contact.php" target="_self" >Contact</a></li>
                  
                  </ul>
    <form id="searchbox" name="searchbox" method="post" action="search.php"><input type="text" id="search1" name="searchbox" placeholder="Search..."  size="40" maxlength="45"/><input type="submit" id="submit" name="submit" value="Search" /></form>


  <?php

if(!isset($_SESSION["ERROR"]))
{
      if(!useron())
      {
    ?>
            <ul ><li ><a href="login.php" target="_self">Log In</a></li>
                  <li ><a href="register.php" target="_self">Register</a></li></ul>
      <?php }else{
    ?>
    <ul style="float:right;"><li ><a href="" title="<?php if(isset($_SESSION["username"])) echo $_SESSION["username"]; 
    else echo '';?>"> <?php if(isset($_SESSION["username"]))if(strlen($_SESSION["username"]) > 7) echo substr($_SESSION["username"], 0,7)."..."; else echo $_SESSION["username"];
    else echo '';?></a><ul >
        <li><a href="ChangePassword.php">Change PassWord</a></li>
        <li><a href="ChangeEmail.php">Change E-mail&nbsp;&nbsp;</a></li>
    </ul></li>
                  <li ><a href="Inc/Logout.php" target="_self">Log Out</a></li></ul>
<?php 
      }
      }
?>
    
        </div>
