<?php
// Retrieve selected values from AJAX request
$batch = $_GET['batch'];
$course = $_GET['course'];
$semester = $_GET['semester'];

// Perform database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cop";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Construct SQL query with conditions based on selected values
$sql = "SELECT DISTINCT subject_code, subject_name FROM marks WHERE course='$course' AND semester='$semester'";
$result = $conn->query($sql);

// Generate JSON response with subject codes and titles
$response = array();
if ($result->num_rows > 0) {
    $subjectCodes = "";
    $subjectTitles = "";
    while ($row = $result->fetch_assoc()) {
        $subjectCode = $row["subject_code"];
        $subjectName = $row["subject_name"];
        $subjectCodes .= "<option value=\"$subjectCode\">$subjectCode-$subjectName</option>";
        // $subjectTitles .= "<option value=\"$subjectName\">$subjectName</option>";
    }
    $response['subjectCodes'] = $subjectCodes;

    
    // $response['subjectTitles'] = $subjectTitles;
} 

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response);

// Close database connection
$conn->close();
?>