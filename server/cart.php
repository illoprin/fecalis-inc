<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/server/functions.php';

if (!isset($_SESSION))
    session_start();

function get_cart_info(){
    $cart_session = !empty($_SESSION['cart']) ? $_SESSION['cart'] : false;
    $cart = array();

    if ($cart_session) {
        $total_cost = 0;
        foreach ($cart_session as $key => $value) {
            $qty = intval($value);
            if ($qty > 0) {
                $id = intval($key);
                $sql = 'SELECT title, price, vendor, img_src FROM product WHERE id = ?';
                $query = query($sql, [$id])[0];
                $query['cost'] = intval($query['price']) * $value;
                $query['qty'] = $qty;
                $query['id'] = $id;
                $total_cost += $query['cost'];
                array_push($cart, $query);
            }
        }
        $cart['total_cost'] = $total_cost;
    }
    
    return $cart;
}

function set_to_cart($id, $value) {
    $id = intval($id);
    $qty = intval($value);

    if ($value == 0){
        unset($_SESSION['cart'][$id]);
    }else
        $_SESSION['cart'][$id] = $qty;
}

function clear_cart() {
    if (isset($_SESSION))
        $_SESSION['cart'] = array();
}


