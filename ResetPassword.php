<?php

$TitleSite = "WebYummy - Reset Password";
        include 'header.php';
        include 'Menu.php';
     is_logged_in();
        ?>

<div id="Main">
    <br/>
    <br/>
    
     <h2 id="lgo"> Reset Password</h2>
     <?php
       if(isset($_SESSION["Others"])) echo '<div class="message warning"> '.$_SESSION["Others"].' </div>';
     if(isset($_SESSION["UserError"])) echo '<div class="message warning"> '.$_SESSION["UserError"].' </div>';
     unset($_SESSION["Others"]);
          unset($_SESSION["UserError"]);
     ?>
     <div class="message info"> The fields with * is required <br/>
         
      <i style="font-weight: bold;"> Put your Username and we will send you a new password in your email</i><br/>
  
    </div>
     <form id="ResetPass" class="CreateForms" action="Inc/reset.php" method="POST" name="ResetPass" onsubmit="return username('→ Wrong Username please put a valid username')">
            <table class="TableForms">
                        <tr>
                            <td>Username:</td><td class="required"><input type="text" placeholder="Username" id="UserName" name="UserName"  value="" size="25" maxlength="45"  /> <span id="Nameerr" class="error"></span></td>
                        </tr> 
                        <tr>
                            <td><br/></td>
                        </tr>
                        <tr><td class="buttons"></td><td class="buttons"><input id="submit" name="submit" type="submit" value="Submit" /></td></tr>
                        <tr><td class="buttons"></td><td class="buttons"><input id="reset" name="reset" type="Reset" value="Reset" /></td></tr>
                    </table> 
        </form>
    
    
</div>


<?php
        include 'Inc/footer.php';
?>