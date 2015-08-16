<?php
$TitleSite = "WebYummy - Web Service";
include 'header.php';
include 'Menu.php';

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
    
    <h2 id="lgo">Web Service!</h2>
    
    
    <form id="SearchForm" name="SearchForm" method="get" action="" onchange="getWebService()">
        <table class="TableForms">
           
            <tr>
           <td><input type="text" style="text-align: center;" id="Searchtext" name="Searchtext" placeholder="Type what ever you want to find" size="55" maxlength="45" value=""  /><input type="button" id="buttonsearch" name="buttonsearch" value="Create Web Service string" onclick="getWebService()" onkeypress="getWebService()"/></td>
                
            </tr>
            <tr>
                <th id="extent" style="color:white;">Extented Search</th>
            </tr>
            <tr class="need">
                <td style="color:white; text-align: center;">Search By:<br/> <label>(Phone:<input type="radio" id="Searchtype0" name="Searchtype" value="0"  />)</label> <label>(Business Title:<input type="radio" id="Searchtype1" name="Searchtype" value="1"  />)</label> <label>(Address:<input type="radio" id="Searchtype2" name="Searchtype" value="2"   />)</label> 
                    <label>(Description:<input type="radio" id="Searchtype3" name="Searchtype" value="3"   />)</label> </td>
            </tr><tr class="need">   <td><select style="margin:0 auto;" id="TypeBusiness" name="TypeBusiness">
                        
                         <?php
                                if(!isset($_SESSION["ERROR"]))
                                {
                               
                                selectmanager("Bus_Type",-1);
                                
                                }else
                                {
                                     unset($_SESSION["ERROR"]);
                                     
                                     echo'<option value="-1" selected="selected" style="text-align:center;" >----------------Type of Buisness----------------</option>';
                                }
                                ?>   
                    </select><select style="margin:0 auto;" id="Typeofexport" name="Typeofexport">
                        <option value="-1" selected="selected">------------------- Type of export--------------------</option>
                        <option value="0" >XML</option>
                        <option value="1">HTML</option>
                    </select></td>
            </tr>
            
          <tr></tr>
             
        <tr>
   <td> <h5>String for Other page</h5><br />
      <textarea  id="Stringexport" name="Stringexport" rows="5" cols="42" readonly></textarea></td>
        </tr>
        <tr><td id="loadingstate"></td></tr>
      </table>
   
    </form> <br />
     <div id="results"></div>
<br /><br /><br /><br /><br /><br /><br />
</div>

<?php 

include 'Inc/footer.php';
?>