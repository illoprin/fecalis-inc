<?

require_once $_SERVER['DOCUMENT_ROOT'] . '/server/functions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/server/db.php';

$user_id = isset($_COOKIE['id']) ? $_COOKIE['id'] : false;
if ($user_id) {
    $pdo = Database::getInstance();

    $sql = 'DELETE FROM user WHERE id = ?';
    $query = query($sql, [$user_id]);
    $pdo = null;
    exit_account();
} else {
    echo 'Пользователь не авторизован';
}
