<?php
  $TitleSite = "WebYummy - Delete Business";
        include 'header.php';
        include 'Menu.php';
     is_not_logged_in();
        ?>

<div id="Main">
    <br />
        <a href="Catalog.php" title="go back" class="goback">Go Back!</a>
        <h2 id="lgo">Delete-Form</h2>
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
                echo '<div class="message info ">This Page use pop up element for validation if you have problems check your pop up restricts in your browser</div>';
            try{
                include 'Dtopfun/dbparm.php';
                $delpip = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpassword);
                $sql = 'SELECT Business_ID,Business_Title,Address,Phone,Date_of_Creation,Description
                    ,(SELECT Name_of_Type FROM Bus_Type where TypeoB_ID = b.Business_Type) as BusinessType
                    FROM Business b WHERE b.User_ID = (SELECT Users.User_ID from Users where Users.User_Name = :user) 
                    AND b.Business_ID = :id ';
                $state = $delpip->prepare($sql);
                $state->execute(array(':user'=>$_SESSION["username"],':id'=>$_GET["ID"]));
                $record = $state->fetch();
        ?>
        <form class="restrictform"  id="Delete" action="Inc/Del.php" method="POST" onsubmit="return confirm('Are you sure you Want to Delete the Record with Name: '+document.getElementById('BusName').value)">
            <table class="TableForms">
                <tr><td><input type="hidden" id="BUSID" name="BUSID" value="<?php echo $record["Business_ID"];?>" /></td></tr>
                <tr><td>Creation Date:</td><td><input type="text" id="CreationDate" name="CreationDate" size="25" value="<?php echo $record["Date_of_Creation"];?>" readonly/></td></tr>
                <tr><td>Business Name:</td><td><input type="text" id="BusName" name="BusName" size="25" value="<?php echo $record["Business_Title"];?>" readonly/></td></tr>
            <tr><td>Address:</td><td><input type="text" id="Address" name="Address" size="25" value="<?php echo $record["Address"];?>"  readonly/></td></tr>
            <tr><td>Phone:</td><td><input type="text" id="Phone" name="Phone" size="25" value="<?php echo $record["Phone"];?>"  readonly/></td></tr>
            <tr><td>Business Type:</td><td><input type="text" id="BusTID" name="BusTID" size="25" value="<?php echo $record["BusinessType"];?>"  readonly/></td></tr>
            <tr><td>Description:</td><td><textarea id="BusTID" name="BusTID" cols="20" rows="10"   readonly><?php echo $record["Description"];?></textarea></td></tr>
            <tr>
                        <td></td><td id="buttons"><input name="submit" type="submit" id="submit" value="Submit"  /></td>
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
   <script type="text/javascript" >
getbusData("Delete");
</script>
</div>
 
<?php
        include 'Inc/footer.php';
?>
