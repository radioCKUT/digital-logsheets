<?php
    include('../smarty/libs/Smarty.class.php');
    $smarty = new Smarty;
    
    $artists = $_POST["artist"];
    foreach ($artists as $artist) {
         echo $artist . "<br>";
    }
        
    // display it
    $smarty->display('dff2.tpl');
?>