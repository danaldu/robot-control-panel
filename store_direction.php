<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "robot";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Debug output to check request method
echo "Request method: " . $_SERVER["REQUEST_METHOD"] . "\n";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['direction'])) {
        $direction = $_POST['direction'];

        // Debug output to check received direction
        echo "Received direction: " . $direction . "\n";

        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO directions (direction) VALUES (?)");
        if ($stmt === false) {
            die("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("s", $direction);

        // Execute the statement
        if ($stmt->execute()) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close statement and connection
        $stmt->close();
    } else {
        echo "No direction received";
    }
} else {
    echo "Invalid request method";
}

$conn->close();
?>
