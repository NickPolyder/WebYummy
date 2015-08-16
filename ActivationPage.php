<?php
$TitleSite = "WebYummy - Activation";
                include 'header.php';
                include 'Menu.php';
                is_logged_in();          
?>
<div id="Main">
    <h2 id="lgo">Activation  Form</h2>
    <?php  
      if(isset($_SESSION["Warnrecaptcha"])) echo '<div class="message warning"> '.$_SESSION["Warnrecaptcha"].' </div>';
      
    if(isset($_SESSION["WarnMessage"]))
    {
        echo ' <div class="message warning">'.$_SESSION["WarnMessage"].'</div>';
        
    }
    unset($_SESSION["Warnrecaptcha"]);
    unset($_SESSION["WarnMessage"]);
    ?>
     <div class="message info"> The fields with * is required</div>
     
    <form class="CreateForms" id="Activation" name="Activation" action="Inc/ActivateAccount.php" method="post" onsubmit="return ActivationCo()">
        <table class="TableForms">
            <tr>
                <td>Username:</td><td class="required"><input type="text" placeholder="Username" id="UserName" name="UserName"  size="25" maxlength="45" <?php if(isset($_GET["username"])) echo 'value="'.$_GET["username"].'"'?> /><span id="Nameerr" class="error"></span></td>
                    </tr>
        <tr>
          <td>Activation Code:</td><td class="required"><input type="text" placeholder="Activation Code" id="ActivationCode" name="ActivationCode" size="25" maxlength="45" /><span id="Activeerr" class="error"></span></td>
        </tr>
      
         <tr><td></td><td><img src="Inc/CaptchaSecurityImages.php?width=100&height=40&characters=5" /></td><br /></tr>
		<tr><td>Security Code:</td><td class="required"><input id="security_code" placeholder="ReCaptcha Code" name="security_code" type="text" /><span class="error" id="Secerr"></span></td><br />
                    </tr>
        <tr>
            <td class="buttons"></td> <td class="buttons">
          <input name="submit" type="submit" id="submit" value="Submit"  /></td>
        </tr>
        <tr>
            <td class="buttons"></td> <td class="buttons"><input name="reset" type="reset" id="reset" value="Reset"  /></td>
        </tr>
        </table>
    </form>
</div>
<?php

  include 'Inc/footer.php';
?>