<?php

header('Content-Type: application/json');

$root = $_SERVER['DOCUMENT_ROOT'];

include_once $root . '/config.php';
require_once $root . '/server/db.php';
require_once $root . '/server/functions.php';



$responce = array(
    'status' => 0,
    'message' => 'Запрос выполнен успешно',
);

$data = [];
if (!isset($_FILES['upload']))
    $data = check_empty($_POST['data']);
else
    $data['request_type'] = 'update_avatar';

if (!$data) {
    $responce['status'] = 1;
    $responce['message'] = 'Передан пустой массив';
}else {

    switch ($data['request_type']) {
        case 'add_user':
            $pdo = Database::getInstance();

            if (!check_same_user_existence($data)){

                $password_hash = md5(PASS_SALT . $data['password']);
                require_once $_SERVER['DOCUMENT_ROOT'] . '/server/db.php';
                $sql = 'INSERT INTO user(firstname, secondname, phone, email, login, password) VALUES (?, ?, ?, ?, ?, ?)';
    
                $query_result = get_query_statement($sql,
                [$data['firstname'], $data['secondname'], $data['phone'], $data['email'], $data['login'], $password_hash]);
    
                $responce['user_id'] = query('SELECT id FROM user WHERE login = ?', [$data['login']])[0]['id'];
            }else {
                $responce = array(
                    'status' => 1,
                    'message' => 'Такой пользователь уже существует',
                    'user_id' => null,
                );
            }
            $pdo = null;
        break;
        case 'update_avatar':
            $file = $_FILES['upload'];
            $upload_responce = upload_file($file);
            $user_id = isset($_COOKIE['id']) ? $_COOKIE['id'] : false;
            if (($upload_responce['status']) && $user_id) {
                $pdo = Database::getInstance();
                $sql = 'UPDATE user SET avatar_src = ? WHERE id = ?';
                $query = query($sql, [$upload_responce['target'], $user_id]);
                $pdo = null;
                setcookie('avatar_src', $upload_responce['target'], COOKIE_LIFETIME, '/');
                $responce['avatar_src'] = $upload_responce['target'];
            }else {
                $responce['status'] = 1;
                $responce['message'] = "Файл не был загружен. Ошибка: {$upload_responce['message']}";
            }
        break;

    }

}
echo json_encode($responce);
?>