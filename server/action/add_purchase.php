<?

header('Content-Type: application/json');

include_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/server/functions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/server/cart.php';

$responce = array(
    'status' => 0,
    'message' => 'Запрос выполнен успешно',
);

if (isset($_POST['data']))
    $user_data = check_empty($_POST['data']);

if (!isset($_SESSION))
    session_start();

if (count($_SESSION['cart']) <= 0) {
    $responce['message'] = 'Корзина пуста';
    $responce['status'] = 1;
}else {
    require_once $_SERVER['DOCUMENT_ROOT'] . '/server/db.php';
    $pdo = Database::getInstance();

    $cart = get_cart_info();
    $total_cost = intval($cart['total_cost']);
    unset($cart['total_cost']);
    if (count($cart) > 0) {
        // Create entries value
        $entries_arr = array();
        foreach ($cart as $info) {
            array_push($entries_arr, [
                'title' => $info['title'],
                'qty' => $info['qty'],
                'cost' => $info['cost']
            ]);
        }

        $entries = json_encode($entries_arr);

        $user_id = $_COOKIE['id'];

        // Calculate delivery date
        $delivery_date = date('Y-m-d', time() + 60*60*24*rand(3,5));

        // Make entry
        $sql = 'INSERT INTO purchase(client_id, entries, delivery_date, total_cost, delivery_status) VALUES (?, ?, ?, ?, ?)';
        $query = query($sql, [$user_id, $entries, $delivery_date, $total_cost, 1]);

        // Clear cart
        clear_cart();

        // Update user payment and delivery address
        if (isset($user_data['delivery_address']))
        {
            $sql = 'UPDATE user SET delivery_address = ? WHERE id = ?';
            $update = get_query_statement($sql, [$user_data['delivery_address'], $user_id]);
            setcookie('delivery_address', $user_data['delivery_address'], COOKIE_LIFETIME, '/');
        }
    }else {
        $responce['message'] = 'Корзина пуста';
        $responce['status'] = 1;
    }
}

echo json_encode($responce);