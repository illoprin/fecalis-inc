<?php

header('Content-Type: application/json');

include_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/server/db.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/server/functions.php';


$pdo = Database::getInstance();

$responce = array(
    'status' => 0,
    'message' => 'Запрос выполнен успешно',
);

$data = check_empty($_POST['data']);

if (!$data) {
    $responce['message'] = 'Передан пустой массив';
    $responce['status'] = 1;
}else {
    // Add payment id
    $sql = 'INSERT INTO payment(card_number, card_date, card_cvv, user_id) VALUES (?, ?, ?, ?)';
    get_query_statement($sql, 
        [$data['card_number'], $data['card_date'], $data['card_cvv'], $data['user_id']]
    );
    // Get added payment id
    $payment_id = query('SELECT id FROM payment WHERE user_id = ?', [$data['user_id']])[0]['id'];
    // Update payment_id on regitered user entry
    $sql = 'UPDATE user SET payment_id = ? WHERE id = ?';
    get_query_statement($sql, [$payment_id, $data['user_id']]);
}

echo json_encode($responce);

?>