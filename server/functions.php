<?php


function has_empty_fields($data) {
    foreach ($data as $key => $value) {
        if (!isset($value) || empty($value))
            return true;
    }
    return false;
}

function add_to_json($a = [], $b = []) {
    foreach ($b as $key => $value)
        $a[$key] = $value;
    
    return $a;
}

function check_auth() {
    return (isset($_COOKIE['id']) && !empty($_COOKIE['login']));
}

function check_empty($data) {
    return (!empty($data) && isset($data)) ? $data : false;
}




function check_same_user_existence($data) {

    $stmt = get_query_statement(
        'SELECT id FROM user WHERE login = ? AND email = ?',
        [$data['login'], $data['email']]
    );

    if ($stmt->rowCount() == 0)
        return false;

    return true;
}

function add_cookie(array $array, $time, string $location) {
    foreach ($array as $key => $value) {
        setcookie($key, strval($value), $time, $location);
    }
}

function enter_account($login_query_result) {
    $message = '';
    $data = $login_query_result->fetchAll()[0];

    // Load payment info data
    $payment_raw = get_query_statement('SELECT card_number, card_date, card_cvv FROM payment WHERE user_id = ?', [$data['id']]);
    if ($payment_raw->rowCount() == 1) {
        $data = add_to_json($data, $payment_raw->fetchAll()[0]);
        $message = 'Успешный вход в аккаунт!';
    }else {
        $message = 'Авторизация успешна! Добавьте данные платёжной системы';
    }

    add_cookie($data, COOKIE_LIFETIME, '/');
    return $message;
}

function exit_account() {
    $cookie_data = array();
    foreach ($_COOKIE as $key => $value){
        $cookie_data[$key] = $value;
        unset($_COOKIE[$key]);
    }
        
    add_cookie($cookie_data, time()-1000, '/');
}


function upload_file($file, $avaliable_formats = ['jpg', 'png', 'jpeg', 'gif']) {
    $filename = $file['name'];
    $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/user_data/";
    $target_filename = uniqid();
    $file_type = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    $target_file = $target_dir . $target_filename . '.' . $file_type;
    $localpath = "/user_data/" . $target_filename . '.' . $file_type;
    
    $status = 1;
    $upload_message = '';

    // проверка, является ли файл изображением
    $check = getimagesize($file['tmp_name']);
    if (!$check) {
        $status = 0;
        $upload_message = 'Файл не является изображением';
    }

    // Проверка на существование идентичного файла
    if (file_exists($target_file)) {
        $upload_message = 'Изображение с таким именем уже существует';
        $status = 0;
    }

    // Проверка на размер в байтах
    if ($file["size"] > 500000) {
        $upload_message = 'Извините, файл слишком большой ❌';
        $status = 0;
    }

    // Проверка на соответствие форматам
    if (!in_array($file_type, $avaliable_formats)) {
        $upload_message = 'Неверный формат загруженного файла ❌';
        $status = 0;
    }

    // Пробуем загрузить файл
    if ($status != 0) {
        try {
            move_uploaded_file($file["tmp_name"], $target_file);
        }catch (Exception $e) {
            $upload_message = "Файл не удалось загрузить на сервер, код ошибки: {$e->getMessage()}";
        }
    }

    $responce = [
        'message' => $upload_message, 
        'status' => $status,
        'target' => $localpath,
    ];

    return $responce;
}

?>