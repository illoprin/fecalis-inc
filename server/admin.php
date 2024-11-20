<?php


header('Content-Type: application/json');

include_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/server/functions.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/server/db.php';
$pdo = Database::getInstance();

$response = array(
	'status' => 0,
	'message' => 'Запрос выполнен успешно',
);


$request = check_empty($_POST['data']);

if (!$request) {
	$response['status'] = 1;
    $response['message'] = 'Передан пустой массив.';
}else {
	switch ($request['request_type']) {
		case 'set_status':
			$id = intval($request['id']);
			$value = intval($request['value']);

			$sql = 'UPDATE purchase SET delivery_status = ? WHERE id = ?';
			$status_query = query($sql, [$value, $id]);
		break;
		case 'remove_product':
			$id = intval($request['id']);
			
			$sql = 'DELETE FROM product WHERE id = ?';
			$delete_query = query($sql, [$id]);
		break;
		case 'update_product':

		break;
	}
}

$pdo = null;

echo(json_encode($response));
?>