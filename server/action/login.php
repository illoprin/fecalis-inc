<?php

header('Content-Type: application/json');

include_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/server/functions.php';


$responce = array(
    'status' => 0,
    'message' => 'Запрос выполнен успешно',
);

$login_data = check_empty($_POST['data']);

// Password encrypt
$password_hash = md5(PASS_SALT . $login_data['password']);

require_once $_SERVER['DOCUMENT_ROOT'] . '/server/db.php';
$pdo = Database::getInstance();

// SQL Query
$sql = 'SELECT * FROM user WHERE login = ? AND password = ?';
$query = get_query_statement($sql, [$login_data['login'], $password_hash]);

if ($query->rowCount() == 0) {
    $responce['status'] = 1;
    $responce['message'] = 'Таких пользователей не существует или данные введены не верно';
}else if ($query->rowCount() == 1) {
    // Пользователь существует -> Войти в аккаунт
    $responce['message'] = enter_account($query);
}else {
    $responce['message'] = 'пользователей с такими данными несколько, как это блять получилось?!';
}

echo json_encode($responce);

?>