<?php

header('Content-Type: application/json');

include_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/server/db.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/server/functions.php';



$responce = array(
    'status' => 0,
    'message' => 'Пользователь авторизован, данные отправлены',
);

// for jQuery
$request = check_empty($_POST['data']);

// THIS CODE IS A MUST FOR FETCH!!!
// $request = json_decode(file_get_contents('php://input'), true);

if (!$request) {
    $responce['status'] = 1;
    $responce['message'] = 'Передан пустой массив';
}else{
    switch ($request['request_type']) {
        case 'get_user_data':
            $pdo = Database::getInstance();
            $user_data = get_user_data();
            $responce = add_to_json($responce, $user_data);
        break;
        case 'get_cookie':
            if (isset($_COOKIE['id']) && !empty($_COOKIE['login'])) {
                $responce = add_to_json($responce, $_COOKIE);
            }else {
                $responce['status'] = 2; 
                $responce['message'] = 'Пользователь не авторизован';
            }
        break;
    }
}

echo json_encode($responce);


function get_user_data() {
    $user_id = $_COOKIE['id'];
    $sql = 'SELECT firstname, secondname, login, email, phone, delivery_address, avatar_src FROM user WHERE id = ?';
    $user_data = query($sql, [$user_id])[0];

    $sql = 'SELECT card_number, card_date, card_cvv FROM payment WHERE user_id = ?';
    $payment_data = query($sql, [$user_id])[0];
    
    return $user_data + $payment_data;
    
}

?>