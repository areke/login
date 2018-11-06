<?php
    require('includes/config.php');
    require('includes/functions.php');
    
    
    $content = "<div class='alert alert-success' style = 'margin-top:100px; text-align:center;'>Successfully logged in as ".$_SESSION['username'].".</div>";
    echoPage('', $content, 3);
    
    ?>
