<?php
  $TitleSite = "WebYummy - Map";
        include 'header.php';
        include 'Menu.php';
        $page= "";
     // Ελέγχει εάν είναι κάποιο php αρχείο
        if(isset($_SESSION["Page"]) && preg_match("/(.)+[^\"'\\<>()0-9]+.php/", $_SESSION["Page"]))
{
  $pub_Base = explode("/",$_SESSION["Page"]);
  
 $host  = $_SERVER['HTTP_HOST'];
$uri   = trim(dirname($_SERVER['PHP_SELF']), '/\\');
$page = $extra = $pub_Base[2];

}else{
 $_SESSION["ERROR"] = "Something Wrong With the Page please try Again later!";
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
// Ελέγχει αν το ID είναι αριθμός
if(isset($_GET["ID"]) && preg_match("/^[0-9]+$/", $_GET["ID"]))
{
    $page .= "?ID=".$_GET["ID"].'';
}
unset($_SESSION["Page"]);
     is_not_logged_in();
        ?>
<div id="Main">
       <br /> <a href="<?php echo $page;?>" title="go back" class="goback">Go Back!</a>
   <br />  <h2 id="lgo"> Map for geolocation insert </h2>
 <script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
 <script>
 var marker;
function initialize() {
  var mapOptions = {
    zoom: 5,
    center: new google.maps.LatLng(39.57182223734374,22.183595895767212),
    mapTypeId: google.maps.MapTypeId.ROADMAP
  };
  var map = new google.maps.Map(document.getElementById('map-canvas'),
      mapOptions);

  google.maps.event.addListener(map, 'click', function(e) {
  var x = ""+e.latLng+ "";
  var y = x.split(",");
  var lat = y[0].split("(");
  var Lng = y[1].split(")");
  document.getElementById('GeoX').value= lat[1]; 
  document.getElementById('GeoY').value =Lng[0];
  
if(marker)
    {
        marker.setPosition(e.latLng);
    }else{
  marker = new google.maps.Marker({
  position:e.latLng,
  title: 'Your Business Location'
  });
marker.setMap(map);
    }
    
 
  });

	
}


google.maps.event.addDomListener(window, 'load', initialize);

    </script>
  
 
    <div style="width:100%; margin:0 auto;"><div id="map-canvas"></div></div>
    <form class="restrictform" id="AddMap" name="AddMap" method="POST" action="<?php echo $page; ?>">
          
    <table class="TableForms">
      
    <tr>
        <td>Longitude:</td> <td><input type="text" id="GeoX" name="GeoX" size="25" readonly /></td>
              </tr> <tr>
           <td>Latitude:</td> <td><input type="text" id="GeoY" name="GeoY" size="25" readonly /></td>
        
        </tr>
        <tr>
         <td class="buttons"></td>  <td class="buttons">
          <input name="submit" type="submit" id="submit" value="Submit"  /></td>
         
        </tr>
        <tr> <td class="buttons"></td> <td class="buttons"><input name="reset" type="reset" id="reset" value="Reset"  /></td></tr>
    </table>
    </form>

</div>