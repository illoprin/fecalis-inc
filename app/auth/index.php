<?php
    
    $mode = isset($_GET['mode']) ? $_GET['mode'] : 'reg';

    if ($mode == 'reg')
        include 'reg.html';
    else if ($mode == 'login')
        include 'login.html';


?>