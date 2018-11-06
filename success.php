<?php
    require('includes/functions.php');
    require('includes/config.php');
    $content = "<div class='alert alert-success' style = 'margin-top:100px; text-align:center;'>Successfully logged in as " . $_SESSION["username"] . ". You can log out <a href = './logout.php'>here.</a></div>";
    echoPage('', $content, 3);
    
    ?>
