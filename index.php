<?php

include_once 'config.php';
require_once $root . '/server/functions.php';
require_once $root . '/server/db.php';

// Изменяем статусы заказов, удаляем старые
$pdo = Database::getInstance();

// Удаляем старые отменённые заказы старше 30 дней
$purchase_delete = 'DELETE FROM purchase WHERE delivery_status = 2 AND delivery_date < ?';
// По достижению текущей даты, заказ со статусом "в пути" считается доставленным
// $purchase_update = 'UPDATE purchase SET delivery_status = 0 WHERE delivery_date < CURRENT_DATE AND delivery_status = 1';

$past = date('Y-m-d', time() - 3600*24*30);
get_query_statement($purchase_delete, [$past]);
// get_query_statement($purchase_update);

$pdo = null;

if (isset($_COOKIE['login']))
    header('Location: /app/account?mode=user_data');
else
    header('Location: /static/?view=landing')

?>