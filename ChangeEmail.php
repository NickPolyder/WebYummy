<?php
  $TitleSite = "WebYummy - Change Email";
        include 'header.php';
        include 'Menu.php';
     is_not_logged_in();
        ?>

        <div id="Main">
            <br/><br/>
             <?php
     

     
  
    if(isset($_SESSION["WarnMail"])) echo '<div class="message warning"> '.$_SESSION["WarnMail"].' </div>';
    
    if(isset($_SESSION["Others"])) echo '<div class="message warning"> '.$_SESSION["Others"].' </div>';
    
     unset($_SESSION["Others"]);
    unset($_SESSION["WarnMail"]);
 ?>
  
             <h2 id="lgo">Change E-mail!</h2>
              <div class="message info"> The fields with * is required <br/>
 
    </div>
     
             <form id="changemail" class="CreateForms" action="Inc/Changeemail.php" method="POST" name="changemail" onsubmit="return looks_like_email(document.getElementById('Newemail').value,document.getElementById('Newemail'))">
            <table class="TableForms">
                <tr>
                    <td>Current E-mail:</td><td><input type="text" id="Email" name="Email"  value="<?php echo "".getmail()."";?>" size="50" readonly/></td>
                </tr>
                        <tr>
                            <td>New E-mail:</td><td class="required"><input type="text" placeholder="New Email" id="Newemail" name="NewEmail"  value="" size="50" maxlength="45"  /> <span class="error" id="Mailerr"></span></td>
                        </tr>
                        <tr><td class="buttons"></td><td class="buttons"><input id="submit" name="submit" type="submit" value="Change email" /></td></tr>
                        <tr><td class="buttons"></td><td class="buttons"><input id="reset" name="reset" type="Reset" value="Reset" /></td></tr>
                    </table> 
        </form>
                  <br/><br/>
               </div>

<?php
        include 'Inc/footer.php';
?>
