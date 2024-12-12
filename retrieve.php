<?php
// Database connection
$host = 'localhost';
$username = 'root';
$password = ''; // Add your database password here
$dbname = 'db_employee'; // Database name

try {
    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database " . $e->getMessage());
}

// Fetch student data
if (isset($_GET['id'])) {
    // Single record fetch based on 'id'
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM employees WHERE id = :id LIMIT 1");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        echo json_encode(['success' => true, 'data' => $result]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No data found for the given ID']);
    }
} else {
    // Fetch all student records
    $stmt = $pdo->query("SELECT * FROM employees");
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($students) {
        echo json_encode($students);
    } else {
        echo json_encode(['message' => 'No students found']);
    }
}
?>
