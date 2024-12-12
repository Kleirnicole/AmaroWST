<?php
// Database connection parameters
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'db_employee';

try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if required POST data is set
    if (isset($_POST['employeeId']) && isset($_POST['firstName']) && isset($_POST['lastName']) && isset($_POST['contactNumber'])) {
        // Assign POST data to variables
        $employeeId = $_POST['employeeId'];
        $firstName = $_POST['firstName'];
        $middleName = $_POST['middleName'] ?? ''; // Optional field
        $lastName = $_POST['lastName'];
        $contactNumber = $_POST['contactNumber'];

        // Prepare SQL statement with placeholders
        $sql = "INSERT INTO employees (employeeId, firstName, middleName, lastName, contactNumber)
                VALUES (:employeeId, :firstName, :middleName, :lastName, :contactNumber)";

        // Prepare the statement
        $stmt = $pdo->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':employeeId', $employeeId, PDO::PARAM_STR);
        $stmt->bindParam(':firstName', $firstName, PDO::PARAM_STR);
        $stmt->bindParam(':middleName', $middleName, PDO::PARAM_STR);
        $stmt->bindParam(':lastName', $lastName, PDO::PARAM_STR);
        $stmt->bindParam(':contactNumber', $contactNumber, PDO::PARAM_STR);

        // Execute the query
        if ($stmt->execute()) {
            echo "Data inserted successfully!";
        } else {
            echo "Please fill in all required fields.";
        }
    } else {
        echo "Please fill in all required fields.";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Close the connection
$pdo = null;
?>