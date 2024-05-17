<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add details</title>
   
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head> <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&display=swap"
        rel="stylesheet">
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
            flex: 0 0 48%;
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
        .user-logo{
            background-color: rgb(166, 150, 245);
            width: 50px;
            height: 50px;
            font-size: 30px;
            border-radius: 50%;
            padding: 4px;
            padding-left:12px;
        }
        .user-name{
            padding-top: 12px;
        }
        .user{
            padding:10px;
            display:flex;
            justify-content: baseline;
            gap:8px;
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

                    function openTab(evt, tabName) {
                        if (!isDropdownFilled) {
                            alert("Please fill all dropdown boxes before proceeding.");
                            return; // If not all dropdowns are filled, return without executing further code
                        }

                        document.getElementById('wrapper').innerHTML = "";
                        var i, tabcontent, tablinks;
                        tabcontent = document.getElementsByClassName("tabcontent");

                        const co = document.getElementById("co-detail")
                        const mark = document.getElementById("marks")

                        for (i = 0; i < tabcontent.length; i++) {
                            tabcontent[i].style.display = "none";
                        }
                        tablinks = document.getElementsByClassName("tablinks");
                        for (i = 0; i < tablinks.length; i++) {
                            tablinks[i].className = tablinks[i].className.replace(" active", "");
                        }
                        document.getElementById(tabName).style.display = "block";
                        evt.currentTarget.className += " active";

                        // Hide the content of the "Questions" tab when switching to other tabs
                        if (tabName === 'Table1') {
                            document.getElementById('Table2').style.display = 'none';
                        } else if (tabName === 'Table2') {
                            document.getElementByClassName("qn-table").item(0).style.display = "none"
                            document.getElementById('Table1').style.display = 'none';
                        }
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
                </script>
            </div>
            <!-- End of dropdowns -->

            <!-- Tabs -->
            <div class="tab">
                <button class="tablinks" id="co-detail" onclick="openTab(event, 'co')">Co Detail</button>
                <button class="tablinks" id="marks" onclick="openTab(event, 'marks_table')">Marks</button>
            </div>
        </div>

        <!-- Co Detail -->
        <div id="co" class="tabcontent">
            <label for="assessment">Assessment:</label>
            <select id="assessment">
                <option></option>
                <option value="ass1">Assessment 1</option>
                <option value="ass2">Assessment 2</option>
                <option value="sem">Semester</option>
            </select>
            <div id="dropdowns"></div>
            <button id="savebtn">Submit</button>
        </div>

        <!-- Marks -->
        <div id="marks_table" class="tabcontent">
            <table>
                <div class="row">
                    <label for="Assessment2">Assessment</label>
                    <select name="Assessment2" id="Assessment2">
                        <option>Select Assessment Type</option>
                        <option value="ass1">Internal Assessment 1</option>
                        <option value="ass2">Internal Assessment 2</option>
                        <option value="sem">End semester</option>
                        <!-- Add more options as needed -->
                    </select>
                </div>
            </table>
        </div>

        <!-- End of moved content -->
        <div id="wrapper">
            
        </div>
    </div>
    <div class="user">
        <div class="user-logo"><i class="fa-solid fa-user"></i></div>
        <div class="user-name">Raj</div>
    </div>
    <script src="1stpage.js"></script>
</body>

</html>