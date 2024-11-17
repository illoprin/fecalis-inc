<?php

$view = $_GET['view'];

if ($view == 'landing')
    include 'landing.html';
else if ($view == 'about')
    include 'about.php';

?>