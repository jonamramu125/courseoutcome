<?php
// Check if CO array, Bloom's Taxonomy array, and assessment type are received
if(isset($_POST['coArray']) && isset($_POST['bloomArray']) && isset($_POST['assessmentType'])&& isset($_POST['Marks']) &&isset($_POST['course'])&&isset($_POST['batch'])) {
    // Retrieve the arrays from the POST data and decode them from JSON
    $coArray = json_decode($_POST['coArray'], true);
    $bloomArray = json_decode($_POST['bloomArray'], true);
    $Marks=json_decode($_POST['Marks'],true);
    $assessmentType = json_decode($_POST['assessmentType'],true);
    $quNumber = json_decode($_POST['QuNo'],true);
    $subjectCode=$_POST['subjectCode'];
    $course=$_POST['course'];
    $batch=$_POST['batch'];
    // $mardup=$_POST['mardup'];

    // Connect to the MySQL database
    $servername = "localhost"; // Change this to your MySQL server hostname
    $username = "root"; // Change this to your MySQL username
    $password = ""; // Change this to your MySQL password
    $dbname = "cop"; // Change this to your MySQL database name

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $getSql = "SELECT COUNT(subject_code) from cob where subject_code='$subjectCode' AND assessment_type='$assessmentType' AND batch='$batch'";

    $result = $conn->query($getSql);
    $row = $result->fetch_assoc();
    $count = $row['COUNT(subject_code)'];
    if ($count != 0) {
        $response = array('status' => 'fault',
                          'message' => 'Duplicate records not allowed');
        echo json_encode($response);
        // echo "<script>alert('no dup allow');</script>";
    } else {
    $coString = implode(",", $coArray);
    $bloomString = implode(",", $bloomArray);
    $quMarkString = implode(",", $quNumber);

    // Escape strings to prevent SQL injection
    $coString = $conn->real_escape_string($coString);
    $bloomString = $conn->real_escape_string($bloomString);
    $quMarkString = $conn->real_escape_string($quMarkString);
    // Explode CO and Bloom's Taxonomy strings to get individual values
    $coValues = explode(",", $coString);
    $bloomValues = explode(",", $bloomString);
    $qnValues = explode(",", $quMarkString);

    // Insert CO, Bloom's Taxonomy values, and assessment type into database
    $maxIterations = max(count($coValues), count($bloomValues));
    for ($i = 0; $i < $maxIterations; $i++) {
        $coValue = isset($coValues[$i]) ? $coValues[$i] : '';
        $bloomValue = isset($bloomValues[$i]) ? $bloomValues[$i] : '';
        $qnValue = isset($qnValues[$i]) ? $qnValues[$i] : '';
        $mark=isset($Marks[$i])? $Marks[$i]:'';
        $sql = "INSERT INTO cob (co_data, bloom_data, assessment_type,marks,subject_code,question_no,batch,course) VALUES ('$coValue', '$bloomValue', '$assessmentType','$mark','$subjectCode','$qnValue','$batch','$course')";
        if ($conn->query($sql) != TRUE) {
            $response = array('status' => 'fault',
                              'message' => 'Error inserting data into database');
            // echo "Error inserting data: " . $sql . "<br>" . $conn->error;
        }
        else{
            $response = array('status' => 'success', 
                              'message' => 'Co detail inserted successfully');
        // echo "<script>alert('Co detail inserted successfully');</script>";
        }
    }
    // Close database connection
    $conn->close();
    echo json_encode($response);
}  
}
else {
    // Display error message
    $response = array('status' => 'error',
                      'message' => 'CO array, Bloom\'s Taxonomy array, or assessment type not received');
    echo json_encode($response);
}
?>