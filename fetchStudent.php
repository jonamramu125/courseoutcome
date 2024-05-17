<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cop";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get selected values from AJAX request
$course = $_GET['course'];
$batch = $_GET['batch'];

// You can use the selected values to query your database and fetch data
// Example query
$sql = "SELECT * FROM student_info WHERE batch='$batch' AND course='$course' ORDER BY rollno ASC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// Convert the data array to JSON format
$jsonData = json_encode($data);

// Set the content type header to JSON
header('Content-Type: application/json');

// Output the JSON data
echo $jsonData;

$conn->close();
?>
