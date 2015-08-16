<?php
$TitleSite = "WebYummy - Search Page";
include 'header.php';
include 'Menu.php';
// Ελέγχει αν το page είναι αριθμός και αποτελείται το πολύ από 5 ψηφία
if(isset($_GET["page"]) && preg_match("/^[0-9]{1,5}$/",$_GET["page"]))
{
 $page = "".$_GET["page"]."" ;
}else{
    $page = "1" ;
    
}
// Ελέγχει αν το trans είναι αριθμός και αποτελείται το πολύ από δυο ψηφία
if(isset($_GET["trans"]) && preg_match("/^[0-9]{1,2}$/",$_GET["trans"]))
{
    $trans = "".$_GET["trans"]."";
}else{
    $trans = 5 ;
    
}


?>

<script>
    var key = 0;
   
    $(document).ready(function(){
         $("#extent").html("Extented Search+");
  $("#Stringexport").click(function(){
    $(this).select();
  });
  $("#extent").click(function(){
      if(key == 0)
          {
              $("#extent").html("Extented Search-");
              key = 1;
          }else{
              $("#extent").html("Extented Search+");
              key = 0;
          }
    $(".need").slideToggle(0);
  });
});
    </script>
<div id="Main">
    <br />
    <br /><br />
    <br />
    
    <h2 id="lgo">Search!</h2>
    
     <div id="trans"><a href="search.php?trans=5" target="_self">5</a>|<a href="search.php?trans=10" target="_self">10</a>|<a href="search.php?trans=20" target="_self">20</a>|<a href="search.php?trans=30" target="_self">30</a></div>
    <form id="SearchForm" name="SearchForm" method="post" action="" onchange="getSearchResults(<?php echo '1,'.$trans.',null';?>)">
        <table class="TableForms">
           
            <tr>
           <td><input type="text" style="text-align: center;" id="Searchtext" name="Searchtext" placeholder="Type what ever you want to find" size="65" maxlength="45" value="<?php if(isset($search)) echo $search;  $search = null;?>"  /><input type="button" id="buttonsearch" name="buttonsearch" value="Search" onclick="getSearchResults(<?php echo $page.','.$trans.',null';?>)" onkeypress="getSearchResults(<?php echo $page.','.$trans.',null';?>)"  /></td>
                
            </tr>
            <tr>
                <th style="color:white;" id="extent">Extented Search</th>
            </tr>
            <tr class="need">
                <td style="color:white; text-align: center;">Search By:<br/> <label>(Phone:<input type="radio" id="Searchtype0" name="Searchtype" value="0" <?php if(isset($_SESSION["searchtype"]) && $_SESSION["searchtype"] == "0") echo "checked"; ?>  />)</label> <label>(Business Title:<input type="radio" id="Searchtype1" name="Searchtype" value="1"  <?php if((isset($_SESSION["searchtype"]) && $_SESSION["searchtype"] == "1") || !isset($_SESSION["searchtype"])) {?> checked <?php } ?>/>)</label> <label>(Address:<input type="radio" id="Searchtype2" name="Searchtype" value="2"  <?php if(isset($_SESSION["searchtype"]) && $_SESSION["searchtype"] == "2") echo "checked"; ?> />)</label> 
                    <label>(Description:<input type="radio" id="Searchtype3" name="Searchtype" value="3"  <?php if(isset($_SESSION["searchtype"]) && $_SESSION["searchtype"] == "3") echo "checked"; ?> />)</label> </td>
            </tr><tr class="need">   <td><select style="margin:0 auto;" id="TypeBusiness" name="TypeBusiness">
                        
                         <?php
                                if(!isset($_SESSION["ERROR"]))
                                {
                          
                                 if(isset($_SESSION["BUSTYPE"]))
                                {
                                    selectmanager("Bus_Type",$_SESSION["BUSTYPE"]);
                                
                                    unset($_SESSION["BUSTYPE"]);
                               
                                }else{
                                selectmanager("Bus_Type",-1);
                                }
                                }else
                                {
                                     unset($_SESSION["ERROR"]);
                                     
                                     echo'<option value="-1" selected="selected" style="text-align:center;" >----------------Type of Buisness----------------</option>';
                                }
                                ?>   
                    </select></td>
            </tr>
      
        </table>
   
    </form> 
     <div id="loadingstate" style="width:17em; margin:0 auto;"></div>
     <div id="results"></div>
</div>
 <?php  
    
    
    
    if($page != "1" )
{ ?>
   <script>getSearchResults(<?php echo $page.','.$trans.',null';?>);</script> 
<?php }
?>
<?php 
// Ελέγχει αν ο τύπος της επιχειρήσεις είναι ορθός
if(isset($_GET["BusinessType"]) && preg_match("/^[0-9]+$/",$_GET["BusinessType"]))
{
     echo '<script>getSearchResults(1,5,null,"'.$_GET["BusinessType"].'");</script>';
}
// Ελέγχει αν ο χρήστης προσπάθησε να γράψει κάποιου τύπου κώδικα.
if(isset($_POST["searchbox"]) && !preg_match("/^[<+($|#|%|script|Script)+>]+(.)+[<+($|#|%|\/script|\/Script)+>]+$/", $_POST["searchbox"]))
{
    $search= $_POST["searchbox"];
  echo '<script>getSearchResults(1,5,"'."$search".'");</script>';
    
}else if(isset($_SESSION["SearchLike"]))
{
    $search = $_SESSION["SearchLike"];
    unset($_SESSION["SearchLike"]);
}else{
    $search = null;
}
unset($_SESSION["searchtype"]);


include 'Inc/footer.php';
?>