<?php

$TitleSite = "WebYummy - Log In";
        include 'header.php';
        include 'Menu.php';
     is_logged_in();
        ?>

<div id="Main">
    
   
    <h2 id="lgo"> Log-In Form</h2>
    
    <?php 
 
    if(isset($_SESSION["PassError"]))
    {
        echo '<div class="message warning"> '.$_SESSION["PassError"].' </div>';
    }
    if(isset($_SESSION["UserError"]))
    {
         echo '<div class="message warning"> '.$_SESSION["UserError"].' </div>';
       
    }
    if(isset($_SESSION["ActiveError"]))
    {
         
             $public_directory = dirname($_SERVER['PHP_SELF']);
    //place each directory into array
    $directory_array = explode('/', $public_directory);
    //get highest or top level in array of directory strings
    $public_base ="/$directory_array[1]"; 
$uri   = rtrim($public_base, '/\\');
 $extra = "Inc/ResendActivationCode.php";
         echo '<div class="message warning"> '.$_SESSION["ActiveError"].'';
       echo '<br />If you have lost your Activation Code please click <a href="'.$uri.'/'.$extra.'" target="_blank">here</a> to resend your Activation Code! </div>';
    }
    unset($_SESSION["ActiveError"]);
    unset($_SESSION["UserError"]);
    unset($_SESSION["PassError"]);
    ?>
        <form id="LogIn" class="CreateForms" action="Inc/LogOn.php" method="POST" name="LogIn" onsubmit="return valid_login()">
            <table class="TableForms">
                        <tr>
                            <td>Username:</td><td><input type="text" placeholder="Username" id="UserName" name="UserName"  value="" size="25" maxlength="45"  /> <span id="Nameerr" class="error"></span></td>
                        </tr> 
                        <tr>
                            <td>Password:</td><td><input type="password" placeholder="Password" id="PassWord" name="PassWord"  value="" size="25" maxlength="45"  /> <span class="error" id="Passerr"></span></td>
                        </tr>
                        <tr>
                            <td><a href="ResetPassword.php" target="_self">Forgot Password?</a></td>
                        </tr>
                        <tr><td class="buttons"></td><td class="buttons"><input id="submit" name="submit" type="submit" value="Submit" /></td></tr>
                        <tr><td class="buttons"></td><td class="buttons"><input id="reset" name="reset" type="Reset" value="Reset" /></td></tr>
                    </table> 
        </form>
   </div>

<?php
        include 'Inc/footer.php';
?>