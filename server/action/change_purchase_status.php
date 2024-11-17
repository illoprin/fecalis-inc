<?

header('Content-Type: application/json');

include_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/server/functions.php';

$responce = array(
    'status' => 0,
    'message' => 'Запрос выполнен успешно',
);

$data = check_empty($_POST['data']);

if ($data) {

    require_once $root . '/server/db.php';
    $pdo = Database::getInstance();

    $sql = 'UPDATE purchase SET delivery_status = ?, delivery_date = CURRENT_TIMESTAMP WHERE id = ?';
    $query = query($sql, [$data['status'], $data['id']]);
    $pdo = null;
}else {
    $responce['status'] = 1;
    $responce['message'] = 'Передан пустой массив';
}

echo json_encode($responce);