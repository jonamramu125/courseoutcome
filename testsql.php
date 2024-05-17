<?php
if(isset($_POST['batch']) && isset($_POST['course']) && isset($_POST['subject_code']) && isset($_POST['semester']) && isset($_POST['assess_type']) && isset($_POST['cmp'])) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "cop";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $cmp = $_POST['cmp'];
    $batch = $_POST['batch'];
    $course = $_POST['course'];
    $semester = $_POST['semester'];
    $subject_code = $_POST['subject_code'];
    $assess_type = $_POST['assess_type'];

    $data = array();

    $sql_batch = "SELECT co1_cal, co2_cal, co3_cal, co4_cal, co5_cal FROM co_cal WHERE subject_code = ? AND assess_type = ? AND batch = ? AND course = ? AND semester = ?";
    $stmt_batch = $conn->prepare($sql_batch);
    $stmt_batch->bind_param("sssss", $subject_code, $assess_type, $batch, $course, $semester);
    $stmt_batch->execute();
    $result_batch = $stmt_batch->get_result();
    $avg_batch = co_average($result_batch);
    
    $data['current'] = $avg_batch;


    $stmt_cmp = $conn->prepare($sql_batch);
    $stmt_cmp->bind_param("sssss", $subject_code, $assess_type, $cmp, $course, $semester);
    $stmt_cmp->execute();
    $result_cmp = $stmt_cmp->get_result();
    $avg_cmp = co_average($result_cmp);
    $data['cmp']=$avg_cmp;
    $jsonData = json_encode($data);
    echo $jsonData;

} else {
    echo "Testing.php reporting: data not received";
}

function co_average($result) {
    $sum = array();
    if ($result->num_rows > 0) {
        $rowCount = $result->num_rows;
        while ($row = $result->fetch_assoc()) {
            foreach ($row as $key => $value) {
                $sum[$key] = 0;
                if (!isset($sum[$key])) {
                    $sum[$key] = 0;
                }
                $sum[$key] += $value;
            }
        }

        $averages = array();
        
        foreach ($sum as $key => $sums) {
            if($rowCount != 0) {         
                $averages[$key] = $sums / $rowCount;
            } else {
                $averages[$key] = 0;
            }
        }
        $newAverage = [];
        foreach ($averages as $key => $value) {
            $coNumber = substr($key, 2,1);
            $newKey = 'co' . $coNumber;
            $newAverage[$newKey] = $value;
        }
        return $newAverage;
    } else {
        return array();
    }
}
?>
