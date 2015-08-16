<?php
  $TitleSite = "WebYummy - Change Password";
        include 'header.php';
        include 'Menu.php';
     is_not_logged_in();
        ?>

        <div id="Main">
            <br/><br/>
             <?php
     

     
  
    if(isset($_SESSION["Warnpass"])) echo '<div class="message warning"> '.$_SESSION["Warnpass"].' </div>';
    
    if(isset($_SESSION["Others"])) echo '<div class="message warning"> '.$_SESSION["Others"].' </div>';
    
     unset($_SESSION["Others"]);
    unset($_SESSION["Warnpass"]);
 ?>
  
             <h2 id="lgo">Change Password!</h2>
              <div class="message info"> The fields with * is required <br/>
    The <i>Password</i> must have Characters from [a-z, A-Z, 0-9, _ (underscore),!,@] and must be  higher than 8 characters<br/>
    </div>
     
             <form id="ChangePass" class="CreateForms" action="Inc/Change.php" method="POST" name="ChangePass" onsubmit="return valid_change()">
            <table class="TableForms">
                        <tr>
                            <td>Old PassWord:</td><td class="required"><input type="password" placeholder="Old Password" id="PassWord" name="PassWord"  value="" size="25" maxlength="45"  /> <span id="Passerr" class="error"></span></td>
                        </tr> 
                        <tr>
                            <td>New Password:</td><td class="required"><input type="password" placeholder="New Password" id="NewPassword" name="NewPassword"  value="" size="25" maxlength="45"  /> <span class="error" id="NewPasserr"></span></td>
                        </tr>
                        <tr>
                            <td>Re-type Password:</td><td class="required"><input type="password" placeholder="Re-type Password" id="RetypPassword" name="RetypPassword"  value="" size="25" maxlength="45"  /> <span class="error" id="RetypPasserr"></span></td>
                        </tr>
                        <tr><td class="buttons"></td><td class="buttons"><input id="submit" name="submit" type="submit" value="Change Password" /></td></tr>
                        <tr><td class="buttons"></td><td class="buttons"><input id="reset" name="reset" type="Reset" value="Reset" /></td></tr>
                    </table> 
        </form>
                  <br/><br/>
               </div>

<?php
        include 'Inc/footer.php';
?>