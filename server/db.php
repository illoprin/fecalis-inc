
<?php

$root = $_SERVER['DOCUMENT_ROOT'];
include_once $root . '/config.php';

// mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
// $db = new mysqli('localhost:'. DB_PORT, DB_USER, DB_PASS, DB_NAME);

// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }


function get_query_statement($sql, $params = []) {
    global $pdo;
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt;
}

function query($sql, $params = []) {
    return get_query_statement($sql, $params)->fetchAll();
}


class Database {
    private static $instance = null;
    private $pdo;

    private function __construct() {

        $name = DB_NAME;
        $port = DB_PORT;
        $user = DB_USER;
        $pass = DB_PASS;

        $opt = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ];

        $this->pdo = new PDO("mysql:host=localhost;dbname={$name};port={$port}", $user, $pass, $opt);

    }

    public static function getInstance() {
        if (is_null(self::$instance)) {
            self::$instance = new Database();
        }
        return self::$instance->pdo;
    }
}


