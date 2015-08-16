<?php
$TitleSite = "WebYummy - View Business";
include 'header.php';
include 'Menu.php';

if(!isset($_GET["busID"]))
{
    $host  = $_SERVER['HTTP_HOST'];
             $public_directory = dirname($_SERVER['PHP_SELF']);
    //place each directory into array
    $directory_array = explode('/', $public_directory);
    //get highest or top level in array of directory strings
    $public_base ="/$directory_array[1]"; 
$uri   = rtrim($public_base, '/\\');
 $extra = "Catalog.php?msg=Please Select a Business to view";
header("Location: http://$host$uri/$extra");
exit;
}else{
    // Ελέγχει αν το busID είναι αριθμός
    if(!preg_match("/^[0-9]+$/", $_GET["busID"]))
    {
      session_destroy();
        session_start();
      $_SESSION["ERROR"] = "Good Try ;)";
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
    }else{
        $busID = $_GET["busID"];
    }
}

?>

<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
<script>
    
    var i = 0;
    
    $(document).ready(function(){
          $("#PhotoFlip").addClass("unpressedtd");
        $("#Photos").css("display","none");
 $("#infoflip").click(function(){
    $("#Info").slideDown("slow");
    $("#Info").css("display","block");
  $("#infoflip").removeClass("unpressedtd");
   $("#PhotoFlip").addClass("unpressedtd");
   $("#Photos").css("display","none");
   $("#Map").css("display","");
  
  });
  $("#PhotoFlip").click(function(){
      
    $("#Photos").slideDown("slow");
    
  $("#PhotoFlip").removeClass("unpressedtd");
  $("#infoflip").addClass("unpressedtd");
  $("#Pics").css("display","block");
  $("#Info").css("display","none");
  $("#Map").css("display","none");
   
  });
   $("img").click(function(){
      if(i==1)
          {
              i=0;
              
    $(this).css({"width":"40%","height":"auto"});
          }else{
             
              
             $(this).css({"width":"100%","height":"auto"});
             i=1;
          }
              
  });
 

});


function initialize() {
    var marker;
var x= document.getElementById("GeoX").value;
var y= document.getElementById('GeoY').value;
var myCenter = new google.maps.LatLng(x,y);
var Name = 'Location of' + document.getElementById('Business_Title').innerHTML;
  
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
    <br />
    <a href="Catalog.php" title="go back" class="goback">Go Back!</a>
        <br />
    <br />
     <?php
            if(isset($_GET["msg"]))
            {
                $message = $_GET["msg"];
                 // Ελέγχει αν ο χρήστης προσπάθησε να γράψει κάποιου τύπου κώδικα.
                if(!preg_match("/^[<+($|#|%|script|Script)+>]+(.)+[<+($|#|%|\/script|\/Script)+>]+$/", $message))
                {
                
             ?>
             <div class="message info"><?php echo $message; ?></div>
        <?php   }else{
         echo '<div class="message warning"><h1>Busted!</h1></div>';
        }
            }
           
            ?>
     <h2 id="lgo">View Business!</h2>
    <div id="ViewBusiness">
          <?php 
              
                try{
                    include 'Dtopfun/dbparm.php';
                    $Business = new PDO("mysql:host=$dbhost;dbname=$dbname",$dbuser,$dbpassword);
                    $sql = 'SELECT Business_Title,Address,Phone,Date_of_Creation,GeoLocation_x,GeoLocation_y,
                        Date_of_Update,Description 
                        ,(SELECT Name_of_Type FROM Bus_Type where TypeoB_ID = b.Business_Type) as BusinessType,
                        (SELECT Users.User_Name from Users where Users.User_ID = b.User_ID) as UserName
                        FROM Business b 
                        WHERE Business_ID = :bid';
                    $parsebus = $Business->prepare($sql);
                    $parsebus->execute(array(':bid'=>$busID));
                    $record= $parsebus->fetch();
                    $x = trim($record["GeoLocation_x"]," "); 
                     $y = trim($record["GeoLocation_y"]," ");
                       $sql = 'SELECT * FROM Pics
 where Pic_ID In(SELECT Pics_Pic_ID from Business_has_Pics where Business_Business_ID = :BiD)';
         $picprep = $Business->prepare($sql);
         $picprep->execute(array(':BiD'=>$busID));
       
               ?>
        <table class="ViewTable">
            <thead>
            <tr>
                <td id="infoflip">Info:</td><td id="PhotoFlip">Photos:</td>
                <?php
                 if((isset($_SESSION["username"]) && $record["UserName"] == $_SESSION["username"]))
          {?><td><div id="BusinessPanel">
                  <ul><li><a href="Edit.php?ID=<?php echo $busID; ?>" target="_self">Edit</a></li>
                    <li><a href="Delete.php?ID=<?php echo $busID; ?>" target="_self">Delete</a></li><br/>
                  <li><a href="UploadImage.php?BiD=<?php echo $busID; ?>" target="_self">Upload Image</a></li></ul></div></td> 
          
          <?php } ?>
            </tr>
           
            </thead>
            <tbody>
            <tr>
              
                <td id="Info" >
                    <br />
                    <br />
                    <span class="labels" style="alignment-adjust: middle;">Profile Picture:</span><span id="Profile_Pic" class="records"><img id="profpic" style="margin:0 auto;" src="Images/loading.gif" alt="loading" title="loading" /><br /></span><br/>
                <span class="labels">Business Name:</span> <span id="Business_Title" class="records"><?php echo $record["Business_Title"];?></span><br />
                
                <span class="labels">Address:</span> <span class="records"><?php echo $record["Address"];?></span><br />
                <span class="labels">Phone:</span> <span class="records"><?php echo $record["Phone"];?></span><br />
                <span class="labels"> BusinessType:</span> <span class="records"><?php echo $record["BusinessType"];?></span><br />
              <?php if($record["Description"] != null) {?>  <span class="labels">Description:</span> <span class="records"><?php echo $record["Description"];?></span><br /><?php } ?>
<input type="hidden" id="GeoX" name="GeoX" value="<?php echo $x;?>" />
<input type="hidden" id="GeoY" name="GeoY" value="<?php echo $y;?>" />
                </td>
           
 <td id="Map" colspan="2" style="margin:0 auto;">
                     <div id="map-canvas" ></div>
                   
                   
                </td>
                <td id="Photos" style="width:20em; height:20em;" colspan="3"><br />
                    <h5 id="ProfChanged" style="color:white; text-align: center;"></h5>
               <table>
                <?php
                $i = -1;
                while($img = $picprep->fetch())
                {
                    if($i == -1 || $i == 4)
                    {
                        echo '<tr>';
                    }
                   echo '<td>';
                   
            echo '<img src="Images/Uploaded_Images/'.$img["PicPath"].'" alt="'.$img["Description"].'" title="'.$img["Description"].'" width="40%" height="auto"/><br />';
          if(isset($_SESSION["username"]) && $record["UserName"] == $_SESSION["username"] )
          {
            ?>
           Make Profile Pic: <input style="margin: 0 auto;" type="radio" name="ProfPic"  value="<?php echo $img["Pic_ID"]; ?>" onchange="ChangeProfPic(this,<?php echo $busID;?>)" /><br />
          
           <input type="hidden" id="PicID" name="PicID" value="<?php echo $img["Pic_ID"]; ?>" />
           <input style="margin: 0 auto;" type="button" name="ProfPic"  value="Delete Picture" onclick="DeletePic()" />
          <?php }  
          echo '</td>';
             if($i== 3)
             {
               echo '</tr>'; 
              
               $i= 0;
               
             }
             $i++;
                }
                
                ?></table></td>
                
            </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td style="text-align: center; clear:both;" colspan="2">
                          <br />
                    <br />
                       <span class="labels">Creator:</span> <span class="records"><?php echo $record["UserName"];?></span><br /> 
                         <span class="labels">Date of Creation:</span> <span class="records"><?php echo $record["Date_of_Creation"];?></span> <br />
                             <?php if($record["Date_of_Update"] != null) {?> <span class="labels">Last Update:</span><span class="records"> <?php echo $record["Date_of_Update"];?></span><br />
                    </td>
                    <td></td>
                </tr>
            </tfoot>
                        <?php  }   
                        $img = null;
                      
                        $picprep->closeCursor();
                        $record= null;
                        $parsebus->closeCursor();
                        $Business = null;
                        
                        }catch(PDOException $e)
                  {
                                $_SESSION["ERROR"] = "Something came up with our Database. We apologize come back later";
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
                
?>
        </table>
        
    </div>
     <script>
         
         getimage(<?php echo $busID;?>);
        
     
   
    
     </script>
         
    <br />
<br />
<br />
<br />
<br />
<br />
</div>
<?php

include 'Inc/footer.php';
?>
