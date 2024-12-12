<?php
// Database connection parameters
$host = 'localhost';
$username = 'root';
$password = ''; // Add your database password here
$dbname = 'db_employee'; // Make sure the database name is correct

try {
    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'] ?? '';

        if (!empty($id)) {
            $stmt = $pdo->prepare("DELETE FROM employees WHERE id = :id");
            $stmt->execute([':id' => $id]);

            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "message" => "Missing Id"]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Invalid request method"]);
    }

} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
?>