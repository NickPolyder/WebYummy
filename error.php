<?php

$TitleSite = "WebYummy - ERROR PAGE!!!";
        include 'header.php';
        include 'Menu.php';
     
        ?>
<div id="Main">
    <br/>
     <?php
 
    if(isset($_SESSION["ERROR"]))
    {
            ?>
    <div class="message warning"><?php echo $_SESSION["ERROR"]; ?></div>
    <?php
        unset($_SESSION["ERROR"]);
    }
    ?>
    
</div>
<?php
 include 'Inc/footer.php'
?>