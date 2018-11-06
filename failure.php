<?php
    require('includes/functions.php');
    
    
    $content = "<div class='alert alert-error' style = 'margin-top:100px; text-align:center;'>Something went wrong. Please <a href = './index.php'>try again.</a> or <a href = './reset.php'>reset your password</a></div>";
    
    echoPage('', $content, 3);
    
    ?>
