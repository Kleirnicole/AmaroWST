<?php
// Database connection parameters
$host = 'localhost';
$username = 'root';
$password = ''; // Add your database password here
$dbname = 'db_employee'; // Make sure the database name is correct

try {
    // Create a new PDO instance
    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
} catch (PDOException $e) {
    die("Could not connect to the database " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $id = $_GET['id']; // Fix the incorrect usage of $_GET

    echo getDataById($id);
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    // Fix the incorrect usage of $_POST and remove reference assignment
    $id = $_POST['id'];
    $employeeId = $_POST['employeeId'];
    $firstName = $_POST['firstName'];
    $middleName = $_POST['middleName'];
    $lastName = $_POST['lastName'];
    $contactNumber = $_POST['contactNumber'];

    echo updateData($id, $employeeId, $firstName, $middleName, $lastName, $contactNumber);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request'
    ]);
}

function getDataById($id) {
    global $pdo;

    if (!is_numeric($id) || $id <= 0) {
        return json_encode([
            'success' => false,
            'message' => 'Invalid Id'
        ]);
    }
    $sql = "SELECT * FROM employees WHERE id = :id LIMIT 1";
    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    try {
        $stmt->execute();
    } catch (PDOException $e) {
        return json_encode([
            'success' => false,
            'message' => 'Database error: ' . $e->getMessage()
        ]);
    }

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result) {
        return json_encode([
            'success' => true,
            'data' => $result
        ]);
    } else {
        return json_encode([
            'success' => false,
            'message' => 'Data not found'
        ]);
    }
}

function updateData($id, $employeeId, $firstName, $middleName, $lastName, $contactNumber) {
    global $pdo;

    // Check if the record exists before updating
    $checkSql = "SELECT COUNT(*) FROM employees WHERE id = :id";
    $stmt = $pdo->prepare($checkSql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $count = $stmt->fetchColumn();

    if ($count == 0) {
        return json_encode([
            'success' => false,
            'message' => 'Record not found to update'
        ]);
    }

    // Fixed the missing semicolon and SQL query concatenation
    $sql = "UPDATE employees SET employeeId = :employeeId, firstName = :firstName, middleName = :middleName, lastName = :lastName, contactNumber = :contactNumber WHERE id = :id";
    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':employeeId', $employeeId, PDO::PARAM_STR);
    $stmt->bindParam(':firstName', $firstName, PDO::PARAM_STR);
    $stmt->bindParam(':middleName', $middleName, PDO::PARAM_STR);
    $stmt->bindParam(':lastName', $lastName, PDO::PARAM_STR);
    $stmt->bindParam(':contactNumber', $contactNumber, PDO::PARAM_STR);

    try {
        $stmt->execute();
        return json_encode(['success' => true, 'message' => 'Data updated successfully']);
    } catch (PDOException $e) {
        return json_encode([
            'success' => false,
            'message' => 'Database error: ' . $e->getMessage()
        ]);
    }
}
?>
