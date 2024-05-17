<?php
if(isset($_POST['subject_code']) && isset($_POST['assess_type']) && isset($_POST['batch'])&& isset($_POST['course'])&&isset($_POST['semester'])&&isset($_POST['mark'])) {
    // Retrieve the arrays from the POST data and decode them from JSON
    $markArray = json_decode($_POST['mark'], true);
    $batch=$_POST['batch'];
    $assessmentType = $_POST['assess_type'];
    $subjectCode=$_POST['subject_code'];
    $course=$_POST['course'];
    $semester=$_POST['semester'];
    // print_r($markArray);


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
    $getSql = "SELECT COUNT(subject_code) from cob where subject_code='$subjectCode' AND assessment_type='$assessmentType'";
    $result = $conn->query($getSql);
    $row = $result->fetch_assoc();
    $count = $row['COUNT(subject_code)'];
    $coData = 'co1';

// Loop until co_data equals 'co5'
    while ($coData != 'co6') {
    // Prepare the SQL query
    $sql = "SELECT SUM(marks) as total_marks FROM cob WHERE subject_code=? AND assessment_type=? AND co_data=?";
    $statement = $conn->prepare($sql);
    $statement->bind_param('sss', $subjectCode, $assessmentType, $coData);

    // Execute the query
    if ($statement->execute()) {
        // Get the result
        $result = $statement->get_result();
        
        if ($result) {
            // Fetch the row
            $row = $result->fetch_assoc();
            
            // Store the result in the array
            $co_tot_mark[$coData] = $row['total_marks'];
        } else {
            $response = array(
                'status' => 'fault',
                'message' => 'Error Fetching Result' . $conn->error
            );            
            echo json_encode($response);
        }
    } else {
        $response = array(
            'status' => 'fault',
            'message' => 'Error Fetching Query' . $conn->error
        );            
        echo json_encode($response);
    }
    // Increment co_data
    $coData = 'co' . ((int)substr($coData, 2) + 1);
    }
    if($count == 0){
        $response = array(
            'status' => 'fault',
            'message' => 'No co-detail found'
        );            
        echo json_encode($response);
    }
    else{
    
    // Initialize arrays to store question numbers for different CO types
    $co_arrays = array(
    'co1' => array(),
    'co2' => array(),
    'co3' => array(),
    'co4' => array(),
    'co5' => array()
    );;
  
  // Add more arrays if you have more CO types
  
  // Query the database to retrieve question numbers based on subject code and assessment type
    $sql = "SELECT question_no, co_data FROM cob WHERE subject_code = '$subjectCode' AND assessment_type = '$assessmentType'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // Loop through each row of the result set
        while ($row = $result->fetch_assoc()) {
          switch ($row['co_data']) {
            case 'co1':
            case 'co2':
            case 'co3':
            case 'co4':
            case 'co5':
                $co_arrays[$row['co_data']][] = $row['question_no'];
                break;
              
              default:
                  
                  break;
          }
      }
        } else {
            $response = array(
                'status' => 'fault',
                'message' => 'No details found'
            );            
            echo json_encode($response);
        }
        // echo 'co array';
        // print_r($co_arrays);

        //co_array contains the question no of each co
        if($assessmentType!= 'sem'){
        foreach($markArray as $key => $val) {
            $marks = $val['Marks'][0];
            $name = $val['Name'];
            $roll = $val['Roll No'];
            $sql="insert into internal_marks values ('$roll','$name','$subjectCode','$assessmentType','$batch',$semester,'$course',$marks[0],$marks[1],$marks[2],$marks[3],$marks[4],$marks[5],$marks[6],$marks[7],$marks[8],$marks[9],$marks[10],$marks[11])";
            $result = $conn->query($sql);
            if ($result === true) {
                $response = array(
                    'status' => 'success',
                    'message' => 'Internal marks updated successfully'
                );            
                echo json_encode($response);
            } else {
                $response = array(
                    'status' => 'success',
                    'message' => 'Internal marks not updated'
                );            
                echo json_encode($response);
            }
            $int_quNos = array("Q1" => 0,
            "Q2" => 0,
            "Q3" => 0,
            "Q4" => 0,
            "Q5" => 0,
            "Q6" => 0,
            "Q7" => 0,
            "Q8a" => 0,
            "Q8b" => 0,
            "Q9a" => 0,
            "Q9b" => 0,
            "Q10" => 0);
            $count = 0;
            foreach($int_quNos as $key => $value){
                $int_quNos[$key] = $marks[$count];
                $count++;
            }
            $co_mark = array(
                'co1' => 0,
                'co2' => 0,
                'co3' => 0,
                'co4' => 0,
                'co5' => 0
            );
            
            foreach($co_arrays as $key => $value)
            {
                foreach($int_quNos as $key2 => $value2)
                {
                    if(in_array($key2, $value))
                    {
                        $co_mark[$key] += $value2;
                    }
                }

            }
            $co_convert_array[$roll] = array();
            // echo "\n";
            // echo $roll;
            // echo "\n";
            foreach($co_mark as $key => $val){
                $va = $co_mark[$key];
                $co_ma = $co_tot_mark[$key];
                if($co_ma>0){
                $co_con_mark = convert_to_scale_3($va,$co_ma);
                $co_convert_array[$roll][$key] = $co_con_mark;
                }else{
                $co_convert_array[$roll][$key]=0;
                }
            }
            $sql1 = "INSERT INTO co_cal (rollno, name,course,batch,subject_code, assess_type, semester, co1_marks, co2_marks, co3_marks, co4_marks, co5_marks, co1_cal, co2_cal, co3_cal, co4_cal, co5_cal) VALUES ('$roll', '$name', '$course','$batch','$subjectCode', '$assessmentType', '$semester', '{$co_mark['co1']}', '{$co_mark['co2']}', '{$co_mark['co3']}', '{$co_mark['co4']}', '{$co_mark['co5']}', '{$co_convert_array[$roll]['co1']}', '{$co_convert_array[$roll]['co2']}', '{$co_convert_array[$roll]['co3']}', '{$co_convert_array[$roll]['co4']}', '{$co_convert_array[$roll]['co5']}')";
        if (mysqli_query($conn, $sql1)) {
            $response = array(
                'status' => 'success',
                'message' => 'co marks updated successfully for'. $assessmentType
            );            
            echo json_encode($response);
        } else {
            $response = array(
                'status' => 'fault',
                'message' => mysqli_error($conn)
            );            
            echo json_encode($response);
            }
        }
          print_r($co_convert_array);
        }
        else{
            foreach($markArray as $key => $val) {
                $marks = $val['Marks'][0];
                $name = $val['Name'];
                $roll = $val['Roll No'];
                $sql="insert into semester values ('$roll','$name','$subjectCode','$assessmentType','$batch','$semester','$course',$marks[0],$marks[1],$marks[2],$marks[3],$marks[4],$marks[5],$marks[6],$marks[7],$marks[8],$marks[9],$marks[10],$marks[11],$marks[12],$marks[13],$marks[14],$marks[15],$marks[16],$marks[17],$marks[18],$marks[19],$marks[20])";
                
                if (mysqli_query($conn, $sql)) {
                    $response = array(
                        'status' => 'success',
                        'message' => 'semester marks updated successfully'
                    );            
                    echo json_encode($response);
                } else {
                    $response = array(
                        'status' => 'fault',
                        'message' => mysqli_error($conn)
                    );            
                    echo json_encode($response);
        
                }
                $sem_quNOs = array(
                    "Q1" => 0,
                    "Q2" => 0,
                    "Q3" => 0,
                    "Q4" => 0,
                    "Q5" => 0,
                    "Q6" => 0,
                    "Q7" => 0,
                    "Q8" => 0,
                    "Q9" => 0,
                    "Q10" => 0,
                    "Q11a" => 0,
                    "Q11b" => 0,
                    "Q12a" => 0,
                    "Q12b" => 0,
                    "Q13a" => 0,
                    "Q13b" => 0,
                    "Q14a" => 0,
                    "Q14b" => 0,
                    "Q15a" => 0,
                    "Q15b" => 0,
                    "Q16" => 0
                );
                
                $count = 0;
                foreach($sem_quNOs as $key => $value){
                    $sem_quNOs[$key] = $marks[$count];
                    $count++;
                }
                $co_mark = array(
                    'co1' => 0,
                    'co2' => 0,
                    'co3' => 0,
                    'co4' => 0,
                    'co5' => 0
                );

                foreach($co_arrays as $key => $value)
                {
                    foreach($sem_quNOs as $key2 => $value2)
                    {
                        if(in_array($key2, $value))
                        {
                            $co_mark[$key] += $value2;
                        }
                    }
    
                }
                $co_convert_array[$roll] = array();
            foreach($co_mark as $key => $val){
                $va = $co_mark[$key];
                $co_ma = $co_tot_mark[$key];
                if($co_ma>0){
                $co_con_mark = convert_to_scale_3($va,$co_ma);
                $co_convert_array[$roll][$key] = $co_con_mark;
                // echo "\n";
                }else{
                $co_convert_array[$roll][$key]=0;
                }
            }
                //$co_mark contains sum of each respective co marks
                $sql1 = "INSERT INTO co_cal (rollno, name,course,batch,subject_code, assess_type, semester, co1_marks, co2_marks, co3_marks, co4_marks, co5_marks, co1_cal, co2_cal, co3_cal, co4_cal, co5_cal) VALUES ('$roll', '$name', '$course','$batch','$subjectCode', '$assessmentType', '$semester', '{$co_mark['co1']}', '{$co_mark['co2']}', '{$co_mark['co3']}', '{$co_mark['co4']}', '{$co_mark['co5']}', '{$co_convert_array[$roll]['co1']}', '{$co_convert_array[$roll]['co2']}', '{$co_convert_array[$roll]['co3']}', '{$co_convert_array[$roll]['co4']}', '{$co_convert_array[$roll]['co5']}')";
                if (mysqli_query($conn, $sql1)) {
                    $response = array(
                        'status' => 'success',
                        'message' => 'co marks updated successfully for'. $name
                    );            
                    echo json_encode($response);
                }else{
                    $response = array(
                        'status' => 'fault',
                        'message' => mysqli_error($conn)
                    );            
                    echo json_encode($response);
                 
                    // echo "Error: " . $sql1 . "<br>" . mysqli_error($conn);
                }
            
              }
            }

        }

        
        // print_r($co_convert_array);
    // }
}
function convert_to_scale_3($obtained_marks, $total_marks) {
    $conv_mark = ($obtained_marks / $total_marks) * 3;
    $rounded_mark = round($conv_mark * 2) / 2; // Round to nearest 0.5
    return $rounded_mark;
}
        /*{"Name":"Gobinath GS","Roll No":"2022178032","Marks":[["0","0","0","0","0","0","0","0","0","0","0","0"]]},
        {"Name":"Manojkumar K","Roll No":"2022178042","Marks":[["0","0","0","0","0","0","0","0","0","0","0","0"]]}]*/

    
    // function convert_to_scale_3($obtained_marks, $total_marks) {
    //     $co_convert = array();
    //     echo "ob marks:";
    //     print_r($obtained_marks);
    //     foreach ($obtained_marks as $co => $marks) {
    //         $co_convert[$co] = round(($marks / $total_marks[$co]) * 3, 2);
    //     }
    //     return $co_convert;
    
?>