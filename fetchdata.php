<?php
// fetch_data.php

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cop";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM co_attainment";
$result = $conn->query($sql);

// Check if there are any rows
if ($result->num_rows > 0) {
    // Initialize an empty array to store data
    $data = array();

    // Fetch each row and add it to the data array
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    // Encode the data array as JSON and output it
    echo json_encode($data);
} else {
    echo "No data found";
}

// Close the database connection
$conn->close();
?>