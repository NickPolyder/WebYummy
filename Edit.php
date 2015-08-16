<?php
  $TitleSite = "WebYummy - Edit Business";
        include 'header.php';
        include 'Menu.php';
         $_SESSION["Page"]= $_SERVER['PHP_SELF'];
     is_not_logged_in();
        ?>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
<script type="text/javascript" >


function initialize() {
    var marker;
var x= document.getElementById("GeoX").value;
var y= document.getElementById('GeoY').value;
var myCenter = new google.maps.LatLng(x,y);
var Name = 'Location ' + document.getElementById('BusName').value;
  
        var mapOptions = {
    zoom: 6,
    center: myCenter,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  };
  var map = new google.maps.Map(document.getElementById('map-canvas'),
      mapOptions);

  marker = new google.maps.Marker({
  position:myCenter,
  title: Name
  });
marker.setMap(map);
    
    google.maps.event.addListener(marker, 'click', function() {
    map.setZoom(12);
    map.setCenter(marker.getPosition());
  });

}


google.maps.event.addDomListener(window, 'load', initialize);

   
</script>
<div id="Main">
    <br />
        <a href="Catalog.php" title="go back" class="goback">Go Back!</a>
        <br />
        <h2 id="lgo">Edit-Form</h2>
         <?php
           if(isset($_SESSION["Trust"])) echo '<div class="message warning"> '.$_SESSION["Trust"].' </div>';
      if(isset($_SESSION["Others"])) echo '<div class="message warning"> '.$_SESSION["Others"].' </div>';
      if(isset($_SESSION["ERRBUS"])) echo '<div class="message warning"> '.$_SESSION["ERRBUS"].' </div>';
      
      unset($_SESSION["Trust"]);
      unset($_SESSION["ERRBUS"]);
      unset($_SESSION["Others"]);
      ?>
    <table class="EditDeltable">
        <tr>
    <td style="float:left;"><h3 style="text-align: center;"><strong>Business Records of you</strong></h3></td><td><div id="List" style="float:left;"> 
        </div></td></tr>
    </table>
    <br />
          
    <div class="editdeldiv">
      
        <?php
        
        if(isset($_GET["ID"]) && isset($_SESSION["username"]))
        {
              // Ελέγχει αν το ID είναι αριθμός
            if(preg_match("/^[0-9]+$/", $_GET["ID"]))
            {
                
            try{
                include 'Dtopfun/dbparm.php';
                $delpip = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpassword);
                $sql = 'SELECT Business_ID,Business_Title,Address,Phone,Date_of_Creation,Description,GeoLocation_x,GeoLocation_y
                    ,Date_of_Update,(SELECT Name_of_Type FROM Bus_Type where TypeoB_ID = b.Business_Type) as BusinessType,b.Business_Type
                    FROM Business b WHERE b.User_ID = (SELECT Users.User_ID from Users where Users.User_Name = :user) 
                    AND b.Business_ID = :id ';
                $state = $delpip->prepare($sql);
                $state->execute(array(':user'=>$_SESSION["username"],':id'=>$_GET["ID"]));
                $record = $state->fetch();
             
                // Ελέγχει αν είναι συντεταγμένες
                if(isset($_POST["GeoX"]) && preg_match("/^[0-9 \. \-]+$/",$_POST["GeoX"]))
                {
                $x = $_POST["GeoX"];
                }else{
                   $x = $record["GeoLocation_x"]; 
                }
                if(isset($_POST["GeoY"]) && preg_match("/^[0-9 \. \-]+$/",$_POST["GeoY"]))
                {
                $y = $_POST["GeoY"];
                }else{
                    $y = $record["GeoLocation_y"];
                }
              
        ?>
        <form class="restrictform"  id="Delete" action="Inc/Editnew.php" method="POST" onsubmit="return addbusvalid()">
            <table class="TableForms">
                <tr><td><input type="hidden" id="BUSID" name="BUSID" value="<?php echo $record["Business_ID"];?>" /></td></tr>
                <tr><td>Creation Date:</td><td><input type="text" id="CreationDate" name="CreationDate" size="25" value="<?php echo $record["Date_of_Creation"];?>" readonly/></td></tr>
                <?php if($record["Date_of_Update"] != null)
                {?>
                 <tr><td>Last Update Date:</td><td><input type="text" id="LastUpdate" name="LastUpdate" size="25" value="<?php echo $record["Date_of_Update"];?>" readonly/></td></tr>
                <?php } ?>
                <tr><td>Business Name:</td><td><input type="text" id="BusName" name="BusName" size="25" value="<?php echo $record["Business_Title"];?>" onkeyup="Bus_Name()" /><span id="buserr" class="error"></span></td>
                    <td id="upload"><a href="UploadImage.php?BiD=<?php echo $record["Business_ID"]; ?>" target="_self" onclick="Passelms()">Upload Image</a></td>
                </tr>
            <tr><td>Address:</td><td><input type="text" id="Address" name="Address" size="25" value="<?php echo $record["Address"];?>" onkeyup="Address()" /><span id="addrerr" class="error"></span></td></tr>
            <tr><td>Phone:</td><td><input type="text" id="Phone" name="Phone" size="25"  value="<?php echo $record["Phone"];?>" onkeyup="Phone()" /><span id="phoneerr" class="error"></span></td></tr>
            
            <tr><td>Business Type:</td><td><select id="BusinessID" name="BusinessID" onchange="BusID()">
                    <?php 
                    if(!isset($_SESSION["ERROR"]))
                    {
                        if(isset($_SESSION["BusinessID"]))
                        {
                         selectmanager("Bus_Type",$_SESSION["BusinessID"]);
                        }else{
                           selectmanager("Bus_Type",$record["Business_Type"]);
                        }
                        
                    }else{
                        
                        unset($_SESSION["ERROR"]);
                        echo'<option value="-1" selected="selected" style="text-align:center;" >-----------Type of Buisness-----------</option>';
                    }
                    
                    ?>
                </select><span id="BuissIDerr" class="error"></span></td></tr>
             <tr><td> <input type="hidden" id="GeoX" name="GeoX" value="<?php echo $x;?>" /></td>
              </tr> <tr>
           <td> <input type="hidden" id="GeoY" name="GeoY" value="<?php echo $y;?>" /></td></tr>
            <tr><td>Description:</td><td><textarea id="Description" name="Description" cols="20" rows="10" onkeyup="Des()" ><?php echo $record["Description"];?></textarea></td></tr>
            <tr><td>Map:</td><td><div id="map-canvas" style="width:15em; height:15em; margin:0;"></div>
                <br /><a href="MapMarker.php?ID=<?php echo $_GET["ID"];?>" target="_self" onclick="Passelms()">Click Here to Edit the location of your Business</a><span id="MapError" class="error"></span></td></tr>
            <tr>
                         <td class="buttons"></td><td class="buttons"><input name="submit" type="submit" id="submit" value="Submit"  /></td>
                    </tr>
                    <tr>
                       <td class="buttons"></td> <td class="buttons"><input name="reset" type="reset" id="reset" value="Reset"  /></td>
                    </tr>
            </table>
        </form>
        <?php 
        $record=null;
        $state->closeCursor();
        $delpip=null;
            }catch(PDOException $e){
            
            $_SESSION["ERROR"] = "Something came up with our Database. We apologize come back later!";
      $host  = $_SERVER['HTTP_HOST'];
             $public_directory = dirname($_SERVER['PHP_SELF']);
    //place each directory into array
    $directory_array = explode('/', $public_directory);
    //get highest or top level in array of directory strings
    $public_base ="/$directory_array[1]"; 
$uri   = rtrim($public_base, '/\\');
 $extra = "error.php";
header("Location: http://$host$uri/$extra");
exit; 
        }
        
        }else{
            session_destroy();
            session_start();
             $_SESSION["ERROR"] = "He He Dont Try This Again!";
      $host  = $_SERVER['HTTP_HOST'];
             $public_directory = dirname($_SERVER['PHP_SELF']);
    //place each directory into array
    $directory_array = explode('/', $public_directory);
    //get highest or top level in array of directory strings
    $public_base ="/$directory_array[1]"; 
$uri   = rtrim($public_base, '/\\');
 $extra = "error.php";
header("Location: http://$host$uri/$extra");
exit; 
        }
        }?>
        <br />
    </div> 
    <script type="text/javascript">getbusData("Edit");</script>
</div>
 
<?php
        include 'Inc/footer.php';
?>
