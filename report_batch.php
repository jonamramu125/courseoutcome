<style>table, th, td {
  border: 1px solid black;
}
</style>
<?php
if(isset($_POST['batch']) && isset($_POST['course']) && isset($_POST['assessment'])) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "cop";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection Failed:" . $conn->connect_error);
    }

    $html = '';
    $sl_no = 0;
    $batch = $_POST['batch'];
    $course = $_POST['course'];
    $assessment = $_POST['assessment'];

    // $sql = "SELECT distinct subject_code,course,semester,co1_marks,co2_marks,co3_marks,co4_marks,co5_marks,co1_cal,co2_cal,co3_cal,co4_cal,co5_cal FROM `co_cal` WHERE batch='$batch' AND course='$course' AND assess_type='$assessment'";
    $sql="SELECT subject_code, course, semester, 
    ROUND(AVG(co1_cal)*2)/2 AS co1_avg,
    ROUND(AVG(co2_cal)*2)/2 AS co2_avg,
    ROUND(AVG(co3_cal)*2)/2 AS co3_avg,
    ROUND(AVG(co4_cal)*2)/2 AS co4_avg,
    ROUND(AVG(co5_cal)*2)/2 AS co5_avg
    FROM `co_cal` 
    WHERE batch='$batch' 
    AND course='$course' 
    AND assess_type='$assessment'
    GROUP BY subject_code, course, semester";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $html .= "<table style='border: 1px solid black;'>";
        $html .= "<thead>";
        $html .= "<tr>";
        $html .= "<th colspan='4'>$batch. $assessment. Examination</th>";
        $html .= "<th colspan='5'>Co marks</th>";
        $html .= "<th colspan='8'>Attainment Indicated as Y</th>"; // Merged the header cells
        $html .= "</tr>";
        $html .= "<tr>";
        $html .= "<th>SL No</th>";
        $html .= "<th>Course Code</th>";
        $html .= "<th>Course</th>";
        $html .= "<th>SEM</th>";
        $html .= "<th>Co1</th>";
        $html .= "<th>Co2</th>";
        $html .= "<th>C03</th>";
        $html .= "<th>C04</th>";
        $html .= "<th>C05</th>";
        $html .= "<th>CO1</th>";
        $html .= "<th>CO2</th>";
        $html .= "<th>C03</th>";
        $html .= "<th>C04</th>";
        $html .= "<th>C05</th>";
        $html .= "</tr>";
        $html .= "</thead>";

        // Start building the HTML table rows
        // Initialize row number
        while ($row = $result->fetch_assoc()) {
            ++$sl_no; // Increment row number for each row
            $html .= '<tr>';
            $html .= '<td>' . $sl_no . '</td>'; // Output the auto-incremented SL No

            // Output the other columns
            $html .= '<td>' . $row['subject_code'] . '</td>';
            $html .= '<td>' . $row['course'] . '</td>';
            $html .= '<td>' . $row['semester'] . '</td>';

            // Output the CO columns and check if any value is greater than 2
            for ($i = 1; $i <= 5; $i++) {
                $co_value = $row['co' . $i.'_avg'];
                $html .= '<td>' . $co_value . '</td>';

                // Check if the CO value is greater than 2
                $co_attainment[$i] = ($co_value >= 2) ? 'Y' : 'N';
            }

            // Output the CO attainment values from the array
            foreach ($co_attainment as $attainment) {
                $bg_color = ($attainment == 'Y') ? 'lightgreen' : 'salmon';
                // Output HTML with inline CSS styling for background color
                $html .= '<td style="background-color: ' . $bg_color . ';">' . $attainment . '</td>';            }

            $html .= '</tr>';
        }

        $html .= '</table>';
        
        // Output the HTML table
        echo $html;
    } else {
        echo "No data available";
    }
} else {
    echo "Data not received correctly";
}
?>
