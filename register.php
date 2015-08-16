<?php
        $TitleSite = "WebYummy - Register Page";
                include'header.php';
                include'Menu.php';
                
              
               
        ?>

<!--username password passwordconfirmation email recaptcha age countries sex -->
<div id="Main">
  
    <h2 id="lgo">Register-Form</h2>
     <?php
     
     if(isset($_SESSION["Warnuser"])) echo '<div class="message warning"> '.$_SESSION["Warnuser"].' </div>';
     
    if(isset($_SESSION["Warnemail"])) echo '<div class="message warning"> '.$_SESSION["Warnemail"].' </div>';
    
    if(isset($_SESSION["Warnrecaptcha"])) echo '<div class="message warning"> '.$_SESSION["Warnrecaptcha"].' </div>';
    
    if(isset($_SESSION["Warnpass"])) echo '<div class="message warning"> '.$_SESSION["Warnpass"].' </div>';
    
    if(isset($_SESSION["Others"])) echo '<div class="message warning"> '.$_SESSION["Others"].' </div>';
    
     unset($_SESSION["Others"]);
    unset($_SESSION["Warnpass"]);
   unset($_SESSION["Warnrecaptcha"]);
    unset( $_SESSION["Warnemail"]);
     unset( $_SESSION["Warnuser"]);?>
    <div class="message info"> The fields with * is required <br/>
    The <i>Username</i> must have Characters from [a-z, A-Z, 0-9, _ (underscore)] and must be  higher than 3 characters<br/>
    The <i>Password</i> must have Characters from [a-z, A-Z, 0-9, _ (underscore),!,@] and must be  higher than 8 characters<br/>
    </div>
     
    <form class="CreateForms" id="Register" name="Register" action="Inc/Reges.php" method="post" onsubmit="return validate_form()"> 
        <table class="TableForms">
            <tr>
                <td>Username:</td><td class="required"><input type="text" placeholder="Username" name="UserName" id="UserName"  size="25" maxlength="45" /> <span id="Nameerr" class="error"></span></td>
                    </tr>
                     <tr>
                <td>Password:</td><td class="required"><input type="password" placeholder="Password"  id="PassWord" name="PassWord"  size="25" maxlength="45" /> <span class="error" id="Passerr"></span></td>
                    </tr>
                    <tr>
                        <td>Re-Enter Password:</td><td class="required"><input type="password" placeholder="Re-Type Password"  id="RePassword"  name="RePassword" size="25" maxlength="45" /> <span class="error" id="Repasserr"></span></td>
                    </tr>
                    <tr>
                        <td>E-Mail:</td><td class="required"><input type="text" placeholder="E-mail" name="Email" id="Email"  size="25" maxlength="45" /> <span class="error" id="Mailerr"></span></td>
                    </tr>
                     <tr>
                <td>Age:</td>
                   <td class="required">
                       <select id="Age" name="Age" >
                                <?php
                                echo'<option value="-1" selected="selected" style="text-align:center;"  >Age</option>';
                             for($i=18; $i<=100; $i++)
                             {
                      echo'<option value="'.$i.'"  style="text-align:center;" >'.$i.'</option>';
                             }
                                ?>   
                                 
                            </select> <span class="error" id="Ageerr"></span>
                </td>
                      </tr>
                    <tr>
                        <td >Country:</td><td class="required" >
                            <select id="Country" name="Country" >
                                <?php
                                if(!isset($_SESSION["ERROR"]))
                                {
                                
                                selectmanager("Country",-1);
                             
                                }else
                                {
                                     unset($_SESSION["ERROR"]);
                                     
                                     echo'<option value="-1" selected="selected" style="text-align:center;" >----------------Country----------------</option>';
                                }
                                ?>   
                                 
                            </select> <span id="Countryerr" class="error"></span></td>
                    </tr>
                    <tr>
                <td >Gender:</td><td class="required"><label><input id="sex1" name="sex" value="0" type="Radio"  />Male</label>
                    <label><input id="sex2" name="sex" value="1" type="Radio"/>Female</label> <span class="error" id="Sexerr"></span></td> 
                    </tr>
                   
                        <tr><td></td><td><img src="Inc/CaptchaSecurityImages.php?width=100&height=40&characters=5" /></td><br /></tr>
		 <tr><td>Security Code:</td><td class="required"><input id="security_code" placeholder="ReCaptcha Code" name="security_code" type="text" /><span class="error" id="Secerr"></span></td><br />
                    </tr>
                    <tr>
                        <td class="buttons"></td><td class="buttons">
          <input name="submit" type="submit" id="submit" value="Submit"  /></td>
                    </tr>
                    <tr>
                        <td class="buttons"></td><td class="buttons"><input name="reset" type="reset" id="reset" value="Reset"  /></td>
                    </tr>
        </table>        
        
    </form>
        
</div>

<?php
        include 'Inc/footer.php';
        ?>