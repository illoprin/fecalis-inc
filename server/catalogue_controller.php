<?php

header('Content-Type: application/json');

include_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/server/functions.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/server/cart.php';

session_start();

$responce = array(
    'status' => 0,
    'message' => 'Запрос выполнен успешно.',
);

$request = check_empty($_POST['data']);

if (!$request) {
    $responce['status'] = 1;
    $responce['message'] = 'Передан пустой массив.';
}else{
    switch ($request['request_type']) {

        case 'get_product_snippet':
            require_once $_SERVER['DOCUMENT_ROOT'] . '/server/db.php';
            $pdo = Database::getInstance();
            
            if (isset($request['id'])) {
                $id = $request['id'];
                $sql = 'SELECT id, title, price, vendor, img_src, category_id FROM product WHERE id = ?';
                $query = query($sql, [$id]);
            }else {
                $sql =  'SELECT id, title, price, vendor, img_src, category_id FROM product';
                $query = query($sql);
            }

            $responce =  $responce + $query;
        break;

        case 'get_cart':
            $cart_session = !empty($_SESSION['cart']) ? $_SESSION['cart'] : false;

            if ($cart_session) {
                include $_SERVER['DOCUMENT_ROOT'] . '/server/db.php';
                $pdo = Database::getInstance();
                $cart = get_cart_info();
                unset($cart['total_cost']);
                $responce = $responce + $cart;
            }else {
                $responce['message'] = 'Запрос выполнен успешно. Корзина пуста.';
            }
        break;

        case 'add_to_cart':
            set_to_cart($request['id'], $request['qty']);
            $responce = $responce + $_SESSION['cart'];
        break;

        case 'get_cart_snippet':
            $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : false;
            if ($cart){
                $responce = $responce + $cart;
                $responce['total_qty'] = count($cart);
            }
            else{
                $responce['message'] = 'Запрос выполнен успешно. Корзина пуста.';
                $responce['total_qty'] = 0;
            }
        break;

        case 'clear_cart':
            clear_cart();
        break;
    }
}


echo json_encode($responce);

?>