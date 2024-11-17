<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/server/functions.php';

    exit_account();

    header('Location: /app/auth?mode=login');

?>