<?php
  $TitleSite = "WebYummy - Add Buisness";
        include 'header.php';
        include 'Menu.php';
        $_SESSION["Page"]= $_SERVER['PHP_SELF'] ;
     is_not_logged_in();
        ?>

<div id="Main">
 <br /> <br />
        <a href="Catalog.php" title="go back" class="goback">Go Back!</a>
        <br />
     <br /> <br />
      <h2 id="lgo"> Add Business record </h2>
      
      <div class="message info"> The fields with * is required <br/>
    The <i>Business Name</i> must have Characters from [a-z, A-Z, 0-9, _ (underscore) , - , . (dot), ( )] and must be  higher than 5 characters<br/>
     The <i>Business Address</i> must have Characters from [a-z, A-Z, 0-9, _ (underscore) , - , . (dot), ( )] and must be  higher than 5 characters<br/>
    The <i>Phone</i> must have Characters from [+ , 0-9] and must be between 10 - 14 characters<br/>
    </div>
      <?php
      if(isset($_SESSION["Others"])) echo '<div class="message warning"> '.$_SESSION["Others"].' </div>';
      if(isset($_SESSION["ERRBUS"])) echo '<div class="message warning"> '.$_SESSION["ERRBUS"].' </div>';
      
      unset($_SESSION["ERRBUS"]);
      unset($_SESSION["Others"]);
      ?>
      
    <form class="CreateForms" id="AddBusiness" name="AddBusiness" method="POST" action="Inc/Addnew.php"  onsubmit="return addbusvalid()" >
    <table class="TableForms">
        <tr>
            <td>Business Name:</td><td class="required"><input type="text" placeholder="Business Name" id="BusName" name="BusName" size="25" maxlength="45" onkeyup="Bus_Name()" value="<?php if(isset($_SESSION["BusName"])) echo $_SESSION["BusName"];  ?>"  /><span id="buserr" class="error"></span></td>
        </tr>
             <tr>
            <td>Address:</td><td class="required"><input type="text" placeholder="Business Address" id="Address" name="Address" size="25" maxlength="45" onkeyup="Address_lol()" value="<?php if(isset($_SESSION["Address"])) echo $_SESSION["Address"];  ?>"  /><span id="addrerr" class="error"></span></td>
        </tr> 
           <tr>
            <td>Phone:</td><td class="required"><input type="text" placeholder="Business Phone" id="Phone" name="Phone" size="25" maxlength="14" onkeyup="Phonein()" value="<?php if(isset($_SESSION["Phone"])) echo $_SESSION["Phone"];  ?>"   /><span id="phoneerr" class="error"></span></td>
        </tr>
        <tr>
             <td>Business Type:</td><td class="required">
                <select id="BusinessID" name="BusinessID" onchange="BusID()">
                    <?php 
                    if(!isset($_SESSION["ERROR"]))
                    {
                        if(isset($_SESSION["BusinessID"]))
                        {
                         selectmanager("Bus_Type",$_SESSION["BusinessID"]);
                        }else{
                           selectmanager("Bus_Type",-1);
                        }
                        
                    }else{
                        
                        unset($_SESSION["ERROR"]);
                        echo'<option value="-1" selected="selected" style="text-align:center;" >-----------Type of Buisness-----------</option>';
                    }
                    
                    ?>
                </select>
           <span id="BuissIDerr" class="error"></span> </td>
        </tr>
        
        <tr>
        
            <td>Description:</td><td><textarea id="Description" name="Description" cols="30" rows="10" onfocus="focusDesc()" onkeyup="Des()"><?php if(isset($_SESSION["Description"])) echo $_SESSION["Description"];?></textarea></td>
        </tr>
             <tr><td> <input type="hidden" id="GeoX" name="GeoX" value="<?php if(isset($_POST["GeoX"]) && preg_match("/^[0-9 \. \-]+$/",$_POST["GeoX"])) echo $_POST["GeoX"];?>" /></td><?php //Ελέγχει αν είναι συντεταγμένες ?>
              </tr> <tr>
           <td> <input type="hidden" id="GeoY" name="GeoY" value="<?php if(isset($_POST["GeoY"]) && preg_match("/^[0-9 \. \-]+$/",$_POST["GeoY"])) echo $_POST["GeoY"];?>" /></td></tr>
        <tr>
            <td>Choose The location
                <br />Of your Business<br />
            
            </td><td class="required" ><a href="MapMarker.php" target="_self" onclick="Passelms()">Click Here to see the Map</a>
                <span id="MapError" class="error"></span></td>
        </tr>
       
        <tr><td class="buttons"></td> <td class="buttons"><input name="submit" type="submit" id="submit" value="Submit" onclick="resetlocal()" /></td>
        </tr> <tr>
            <td class="buttons"></td><td class="buttons"><input name="reset" type="reset" id="reset" value="Reset" onclick="resetlocal()" /></td> </tr> 
        </table>
        
        
    </form>
   
      <?php if(!isset($_SESSION["Description"]))
      { ?>
   <script type="text/javascript">loadDesc();
  window.onload = passelmslocal();
</script> 
      <?php }?>
</div>

<?php
 
    unset($_SESSION["BusName"]);
    unset($_SESSION["Address"]);
    unset($_SESSION["Phone"]);
    unset($_SESSION["BusinessID"]);
    unset($_SESSION["Description"]);
    

        include 'Inc/footer.php';
?>