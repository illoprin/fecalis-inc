<?php
    $root = $_SERVER['DOCUMENT_ROOT'];
    define('DB_USER', 'local_server_user');
    define('DB_PASS', 'database_user1337&&');
    define('DB_NAME', 'fecalis');
    define('DB_PORT', '3306');
    define('PASS_SALT', '&%^$*55523');

    define('DATE_FORMAT', 'd F Y');
    define('DATETIME_FORMAT', 'F j, Y, H:i');

    define('COOKIE_LIFETIME', time() + 3600*24*30);
?>