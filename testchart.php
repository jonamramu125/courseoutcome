<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytics</title>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="stylesheet" href="style.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&display=swap"
    rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
    @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap");

    * {
        font-family: "Poppins", sans-serif;
        font-weight: 400;
        font-style: normal;

    }

    .container {
        /* width: 80%; */
        margin: 0 auto;
        padding: 80px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: rgb(166, 150, 245);
    }

    .mark {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .row {
        flex: 0 0 32 %;
        /* Two columns per row */
        margin-bottom: 10px;
    }

    label {
        display: block;
        margin-bottom: 5px;
    }

    select {
        width: calc(100% - 20px);
        /* Adjust select width */
        padding: 5px;
        margin-top: 5px;
        margin-bottom: 10px;
    }

    button {
        padding: 10px 20px;
        background-color: #007bff;
        color: #fff;
        border: none;
        cursor: pointer;
    }

    button:hover {
        background-color: #0056b3;
    }

    .tab {
        overflow: hidden;
        border: none;
        background-color: inherit;
        margin-bottom: 20px;
        flex: 0 0 100%;
    }

    .tab button {
        background-color: blue;
        color: white;
        display: flex;
        flex-wrap: wrap;
        flex: 1;
        justify-content: space-between;
        float: left;
        border: none;
        outline: none;
        cursor: pointer;
        padding: 14px 16px;
        transition: 0.3s;
    }

    .tab button:first-of-type {
        margin-right: 5px;
    }

    .tab button:hover {
        background-color: #45a049;
    }

    .tab button.active {
        background-color: green;
    }

    .tab .main-tab.active {
        background-color: #4CAF50;
        /* Green */
        color: white;
    }

    body {
        background-color: rgb(235, 233, 233);
    }

    /* Styles for the tab content */
    .tabcontent {
        display: none;
    }

    .tabcontent.active {
        display: block;
    }


    .dropdown-table {
        border-collapse: collapse;
        width: 100%;
    }

    .dropdown-table td,
    .dropdown-table th {
        border: 1px solid #ddd;
        padding: 8px;
    }

    .dropdown-table tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    .dropdown-table tr:hover {
        background-color: #ddd;
    }

    .dropdown-table th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #4caf50;
        color: white;
    }

    .dropdown-table {
        width: 100%;
        border-collapse: collapse;
    }

    .dropdown-table th,
    .dropdown-table td {
        padding: 8px;
        border: 1px solid #ddd;
        text-align: left;
    }

    .dropdown-table select {
        width: 100%;
        padding: 6px 12px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        background-color: #fff;
        font-size: 14px;
    }

    /* Optional: Style the hover effect of the dropdown options */
    .dropdown-table select option:hover {
        background-color: #f2f2f2;
    }

    #co,
    #marks_table {
        display: none;
    }
</style>

<body>
    <div class="sidebar">
        <div class="logo"></div>
        <ul class="menu">
            <li>
                <a href="dash.php">
                    <i class="fa fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li id="coDetailsNavItem" class="active">
                <a href="1stpage.php">
                    <i class="fa fa-file"></i>
                    <span>Marks</span>
                </a>
            </li>
            <li>
                <a href="co_report.php">
                    <i class="fa fa-key"></i>
                    <span>Co-Detail</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fa fa-key"></i>
                    <span>Change Password</span>
                </a>
            </li>
            <li>
                <a href="testchart.php">
                    <i class="fa fa-chart-bar"></i>
                    <span>Analytics</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fa fa-user"></i>
                    <span>Profile</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fas fa-cog"></i>
                    <span>Settings</span>
                </a>
            </li>
            <li class="logout" id="logout">
                <a href="login.php">
                    <i class="fas fa-sign-out-alt"></i>
                    <span> Logout</span>
                </a>
            </li>
        </ul>
    </div>

    <div class="container">

        <div class="mark">

            <?php
            function fetchData($columnName, $tableName)
            {
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "cop";
                $conn = new mysqli($servername, $username, $password, $dbname);
                if ($conn->connect_error) {
                    die("Connection Failed:" . $conn->connect_error);
                }

                $sql = "SELECT DISTINCT $columnName FROM $tableName";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $value = $row[$columnName];
                        echo "<option value=\"$value\">$value</option>";
                    }
                } else {
                    echo "<option value=\"\">No $columnName found</option>";
                }

                $conn->close();
            }

            ?>

            <div class="row">
                <label for="batch">Batch</label>
                <select name="batch" id="batch" onchange="handleDropdownChange()">
                    <option> </option>
                    <?php fetchData('batch', 'student_info'); ?>
                </select>
            </div>

            <div class="row">
                <label for="course">Course</label>
                <select name="course" id="course" onchange="handleDropdownChange()">
                    <option> </option>
                    <?php fetchData('course', 'student_info'); ?>
                </select>
            </div>
            <div class="row">
                <label for="semester">Semester</label>
                <select name="semester" id="semester" onchange="handleDropdownChange()">
                    <option></option>
                    <?php fetchData('semester', 'marks'); ?>
                </select>
            </div>

            <div class="row">
                <label for="subject-code">Subject Code</label>
                <select name="subject-code" id="subject-code">
                    <option></option>
                </select>
                <script>
                    var isDropdownFilled = false; // Variable to track if all dropdowns are filled

                    function handleDropdownChange() {
                        var selectedBatch = document.getElementById("batch").value;
                        var selectedCourse = document.getElementById("course").value;
                        var selectedSemester = document.getElementById("semester").value;

                        // Check if all dropdowns are filled
                        if (selectedBatch && selectedCourse && selectedSemester) {
                            isDropdownFilled = true;
                            enableTabButtons(); // Enable tab buttons
                        } else {
                            isDropdownFilled = false;
                            disableTabButtons(); // Disable tab buttons
                        }

                        var xhttp = new XMLHttpRequest();
                        xhttp.onreadystatechange = function () {
                            if (this.readyState == 4 && this.status == 200) {
                                var response = JSON.parse(this.responseText);
                                console.log(response.subjectCodes)
                                document.getElementById("subject-code").innerHTML = response.subjectCodes;
                                //document.getElementById("subject-title").innerHTML = response.subjectTitles;
                            }
                        };
                        xhttp.open("GET", "subject_title.php?batch=" + selectedBatch + "&course=" + selectedCourse + "&semester=" + selectedSemester, true);
                        xhttp.send();
                    }
                    function enableTabButtons() {
                        var tabButtons = document.querySelectorAll(".tab button");
                        tabButtons.forEach(function (button) {
                            button.disabled = false;
                        });
                    }

                    function disableTabButtons() {
                        var tabButtons = document.querySelectorAll(".tab button");
                        tabButtons.forEach(function (button) {
                            button.disabled = true;
                        });
                    }

                    // Event listener for tab buttons
                    document.querySelectorAll(".tab button").forEach(function (button) {
                        button.addEventListener("click", function () {
                            if (!isDropdownFilled) {
                                alert("Please fill all dropdown boxes before proceeding.");
                            }
                        });
                    });
                    function saveValue() {
                        var batch = document.getElementById('batch').value;
                        var course = document.getElementById('course').value;
                        var assess_type = document.getElementById('assessment').value;
                        var semester = document.getElementById('semester').value;
                        var subject_code = document.getElementById('subject-code').value;
                        var cmp = document.getElementById('compare').value;
                        if (batch == cmp) {
                            alert("Please select different batch");
                        }
                        var formDa = new FormData();
                        formDa.append("batch", batch);
                        formDa.append("cmp", cmp);
                        formDa.append("course", course);
                        formDa.append("subject_code", subject_code);
                        formDa.append("assess_type", assess_type);
                        formDa.append("semester", semester);
                        fetch("testsql.php", {
                            method: 'POST',
                            body: formDa
                        }).then(response => {
                            return response.text()
                        }).then(data => {
                        console.log('Received data:', data);
                        const jsonData = JSON.parse(data);
                        const current = jsonData.current;
                        const cmp = jsonData.cmp;
                        console.log('Current:', current);
                        console.log('CMP:', cmp);
                       })
                    .catch(error=>{
                        console.error("Error:",error);
                    })
                    }
                
                </script>
            </div>
            <div class="row">
                <label for="assessment">Assessment</label>
                <select name="assessment" id="assessment">
                    <option value="ass1">Internal1</option>
                    <option value="ass2">Internal2</option>
                    <option value="sem">Semester</option>
                </select>
            </div>
            <div class="row">
                <label for="compare">Compare</label>
                <select name="compare" id="compare">
                    <option></option>
                    <?php fetchData('batch', 'student_info'); ?>
                </select>
            </div>
        </div>
        <button type="submit" onclick="saveValue()">Submit</button>
        <div>
        <div id="chart-container">
            <canvas id="coAttainmentChart"></canvas>
        </div>
        <div id="chart-container">
            <canvas id="line_chart"></canvas>
        </div>
        </div>
        </div>
        <script>
    var ctx = document.getElementById('coAttainmentChart').getContext('2d');
    // var lctx=document.getElementById('line_chart').getContext('2d');
    const coLabels = ['co1', 'co2', 'co3', 'co4', 'co5'];
    const data = {
        labels: [],
        datasets: [{
            label: '2018-2022',
            data: [],
            backgroundColor:'yellow'
        }, {
            label: '2019-2023',
            data: [],
            backgroundColor: 'blue'
        }]
    };
    const config = {
        type: 'bar',
        data: data,
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    };
    const config1={
    type: 'line',
        data: data,
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    };
    
  
        // const config_line = {
        //     type: 'line', // Change the type to 'line'
        //     data: {
        //         datasets: [{
        //             label: 'Vertical Line',
        //             data: line,
        //             borderColor: 'red',
        //             backgroundColor: 'red',
        //             borderWidth: 2,
        //         }]
        //     },
        //     options: {
        //         scales: {
        //             x: {
        //                 type: 'linear',
        //                 position: 'bottom'
        //             },
        //             y: {
        //                 beginAtZero: true
        //             }
        //         }
        //     }
        // };

    // Initial chart setup
    const coAttainmentChart = new Chart(ctx, config);

    // Function to update chart with new data
    function updateChart(current, cmp, yValue) {
        // Update chart data
        // coAttainmentChart.data.labels = coLabels;
        coAttainmentChart.data.datasets[0].data = current;
        coAttainmentChart.data.datasets[1].data = cmp;
        const lineDatasetIndex = coAttainmentChart.data.datasets.findIndex(dataset => dataset.label === 'Line Data');
        if (lineDatasetIndex !== -1) {  
        // Remove the line dataset if it exists
        coAttainmentChart.data.datasets.splice(lineDatasetIndex, 1);
        }
        const y = yValue;
        const LineData = Array(6).fill(y);

        const lineDataset = {
            label: 'Line Data',
            type: 'line',
            data: LineData,
            borderColor: 'red',
            backgroundColor: 'red',
            borderWidth: 2
        };
        coAttainmentChart.data.datasets.push(lineDataset);
        // Update chart
        coAttainmentChart.update();
    }
    

    function saveValue() {
        const yValue = prompt("Enter the target value:");
        if (yValue == null || isNaN(parseFloat(yValue))) {
            alert("Please enter a valid input.");
        } 
        else{
        

        var batch = document.getElementById('batch').value;
        var course = document.getElementById('course').value;
        var assess_type = document.getElementById('assessment').value;
        var semester = document.getElementById('semester').value;
        var subject_code = document.getElementById('subject-code').value;
        var cmp = document.getElementById('compare').value;

        if (batch == cmp) {
            alert("Please select a different batch for comparison.");
            return;
        }

        var formData = new FormData();
        formData.append("batch", batch);
        formData.append("cmp", cmp);
        formData.append("course", course);
        formData.append("subject_code", subject_code);
        formData.append("assess_type", assess_type);
        formData.append("semester", semester);

        fetch("testsql.php", {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            console.log('Received data:', data);
            const jsonData = JSON.parse(data);
            const current = jsonData.current;
            const cmp = jsonData.cmp;
            console.log('Current:', current);
            console.log('CMP:', cmp);

            updateChart(current, cmp, yValue);
        })
    
        .catch(error => {
            console.error("Error:", error);
        });
    }
}
</script>

</body>

</html>