<?php


header('Content-Type: application/json');

include_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/server/functions.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/server/db.php';


$response = array(
	'status' => 0,
	'message' => 'Запрос выполнен успешно',
);


$form_data = array();

foreach ($_POST as $key => $value) {
	$form_data[$key] = $value;
}
$image = $_FILES['img_src'];

$upload_file = upload_file($image);

if ($upload_file['status'] == 1) {
	$response['form_data'] = $form_data;
	$response['form_data']['file'] = $image['name'];
	
	$pdo = Database::getInstance();
	$sql = 'INSERT INTO
		product (category_id, title, description, img_src, vendor, price)
	VALUES (?, ?, ?, ?, ?, ?)';
	$insert_result = query($sql, [$form_data['category_id'], $form_data['title'], $form_data['description'], $upload_file['target'], $form_data['vendor'], $form_data['price']]);
}


echo json_encode($response);