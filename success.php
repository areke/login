<?php
    require('includes/functions.php');
    
    
    $content = "<div class='alert alert-success' style = 'margin-top:100px; text-align:center;'>Successfully Logged In As ".$_SESSION['username']."</div>";
    echoPage('', $content, 3);
    
    ?>
