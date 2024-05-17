const Semester = [
  "Q1",
  "Q2",
  "Q3",
  "Q4",
  "Q5",
  "Q6",
  "Q7",
  "Q8",
  "Q9",
  "Q10",
  "Q11a",
  "Q11b",
  "Q12a",
  "Q12b",
  "Q13a",
  "Q13b",
  "Q14a",
  "Q14b",
  "Q15a",
  "Q15b",
  "Q16",
];


const assessment_1 = [
  "Q1",
  "Q2",
  "Q3",
  "Q4",
  "Q5",
  "Q6",
  "Q7",
  "Q8a",
  "Q8b",
  "Q9a",
  "Q9b",
  "Q10",
];



const marks_int = [
  "2",
  "2",
  "2",
  "2",
  "2",
  "2",
  "2",
  "12",
  "12",
  "12",
  "12",
  "12",
];
const marks_sem = [
  "2",
  "2",
  "2",
  "2",
  "2",
  "2",
  "2",
  "2",
  "2",
  "2",
  "13",
  "13",
  "13",
  "13",
  "13",
  "13",
  "13",
  "13",
  "13",
  "13",
  "15",
];

var rowValues = {};

const batch = document.getElementById("batch");
const subject_code = document.getElementById("subject-code");
const course = document.getElementById("course");
const semester = document.getElementById("semester");
const assessment = document.getElementById("Assessment");
const numberInput = document.getElementById("No_of_ques");
const submit = document.getElementById("submitbut");
const save = document.getElementById("co_submit");
const asstab2 = document.getElementById("Assessment2");

const wrapper = document.getElementById("wrapper");
const saveco = document.getElementById("savebtn");

//Create co and bloom table
$(document).ready(function () {
  $("#assessment").change(function () {
    var assessmentType = $(this).val();
    var numDropdowns;
    if (assessmentType === "ass1") {
      drop(12, assessment_1);
      // numDropdowns = 12;
    } else if (assessmentType === "ass2") {
      drop(12, assessment_1);
      // numDropdowns = 12
    } else if (assessmentType === "sem") {
      drop(21, Semester);
      // numDropdowns = 21;
    }
    else {
    }
  });
});

function drop(x, z) {
  var dropdownHTML =
    '<table class="dropdown-table">' + // Start of table with class for styling
    "<thead>" + // Table header
    "<tr>" + // Table header row
    "<th>Question No</th>" + // Header for Course Name column
    "<th>CO Detail</th>" + // Header for CO Detail column
    "<th>Bloom's Taxonomy</th>" + // Header for Bloom's Taxonomy column
    "</tr>" + // End of table header row
    "</thead>" +
    "<tbody id='drop'>"; // Start of table body
  for (var i = 1; i <= x; i++) {
    var y = i % 10;
    var firstopt;

    if (y == 1 || y == 2) {
        firstopt = "co1";
    } else if (y == 3 || y == 4) {
        firstopt = "co2";
    } else if (y == 5 || y == 6) {
        firstopt = "co3";
    } else if (y == 7 || y == 8) {
        firstopt = "co4";
    } else if (y == 9 || y == 0) {
        firstopt = "co5";
    }
    dropdownHTML +=
      "<tr>" + // Start of table row
      "<td><i>" +
      z[i - 1] +
      "</i></td>" + // Course name cell
      '<td><select id="coDetail' +
      i +
      '">' + // CO Detail dropdown cell
      '<option value="' + firstopt + '">' + firstopt.toUpperCase() + ' </option>' +
      '<option value="co1">CO 1</option>' +
      '<option value="co2">CO 2</option>' +
      '<option value="co3">CO 3</option>' +
      '<option value="co4">CO 4</option>' +
      '<option value="co5">CO 5</option>' +
      "</select></td>" +
      '<td><select id="blooms' +
      i +
      '">' + // Bloom's Taxonomy dropdown cell
      '<option value="L1">L1-Remember</option>' +
      '<option value="L2">L2-Understand</option>' +
      '<option value="L3">L3-Apply</option>' +
      '<option value="L4">L4-Analyze</option>' +
      '<option value="L5">L5-Evaluate</option>' +
      '<option value="L6">L6-Create</option>' +
      "</select></td>" +
      "</tr>"; // End of table row
  }
  dropdownHTML +=
    "</tbody>" + // End of table body
    "</table>"; // End of table
  $("#dropdowns").html(dropdownHTML);
}
//   if (x == 21) {
//     var coElements=document.querySelectorAll("[id^='coDetail']");
//     var co11a,co11b,co12a,co12b,co13a,co13b,co14a,co14b,co15a,co15b;
//     coElements.forEach(function(coElement){
//       if(coElement.id==="coDetail11"){
//         co11a=coElement;
//       }else if(coElement.id === 'coDetail12'){
//         co11b=coElement;
//       }
//       else if(coElement.id === 'coDetail13'){
//         co12a=coElement;
//       }
//       else if(coElement.id === 'coDetail14'){
//         co12b=coElement;
//       }
//       else if(coElement.id === 'coDetail15'){
//         co13a=coElement;
//       }
//       else if(coElement.id === 'coDetail16'){
//         co13b=coElement;
//       }
//       else if(coElement.id === 'coDetail17'){
//         co14a=coElement;
//       }
//       else if(coElement.id === 'coDetail18'){
//         co14b=coElement;
//       }
//       else if(coElement.id === 'coDetail19'){
//         co15a=coElement;
//       }
//       else if(coElement.id === 'coDetail20'){
//         co15b=coElement;
//       }
// co11b.addEventListener("change", () => {
//       handleCoChange(co11a, co11b);
//   });
//   co12b.addEventListener("change", () => {
//     handleCoChange(co12a, co12b);
// });
// co13b.addEventListener("change", () => {
//   handleCoChange(co13a, co13b);
// });
// co14b.addEventListener("change", () => {
//   handleCoChange(co14a, co14b);
// });
// co15b.addEventListener("change", () => {
//   handleCoChange(co15a, co15b);
// });
//     })
//   }
//   if(x == 12) {
//     // Initialize CO elements dynamically
// var coElements = document.querySelectorAll("[id^='coDetail']");

// var co8a, co8b, co9a, co9b;

// coElements.forEach(function(coElement) {
//     if (coElement.id === "coDetail8") {
//         co8a = coElement;
//     } else if (coElement.id === "coDetail9") {
//         co8b = coElement;
//     } else if (coElement.id === "coDetail10") {
//         co9a = coElement;
//     } else if (coElement.id === "coDetail11") {
//         co9b = coElement;
//     }
//     co11b.addEventListener("change", () => {
//       handleCoChange(co11a, co11b);
//   });
//   co12b.addEventListener("change", () => {
//     handleCoChange(co12a, co12b);
// });
// co13b.addEventListener("change", () => {
//   handleCoChange(co13a, co13b);
// });
// co14b.addEventListener("change", () => {
//   handleCoChange(co14a, co14b);
// });
// co15b.addEventListener("change", () => {
//   handleCoChange(co15a, co15b);
// });
// });

// // Add event listeners
// co8b.addEventListener("change", () => {
//     handleCoChange(co8a, co8b);
// });

// co9b.addEventListener("change", () => {
//     handleCoChange(co9a, co9b);
// });


// function handleCoChange(coA, coB) {
//     if (coA.value !== coB.value) {
//         if (!confirm("Either-or type question should have same CO. Click OK to continue with  the same CO \nCancel to change.")) {
//           coB.value = coA.value;  
//         }
        
//     }
// }
//     // var co8a = document.getElementById("coDetail8")
//     // var co8b = document.getElementById("coDetail9")
//     // var co9a = document.getElementById("coDetail10")
//     // var co9b = document.getElementById("coDetail11")
//     // co8a.addEventListener("change",()=>{
//     //   // if(co8a.value != co8b.value){
//     //       // if(confirm("This is eaither or type question click ok for apply the same co")){
//     //         co8b.value = co8a.value
//     //       // }
//     //   // }
//     // })
//     // co8b.addEventListener("change",()=>{
//     //   if(co8a.value != co8b.value){
//     //       if(confirm("This is eaither or type question click ok for apply the same co")){
//     //         // co8a.value = co8b.value
//     //         co8b.value = co8a.value
//     //       }
//     //   }
//     // })
//     // co9a.addEventListener("change",()=>{
//     //   // if(co9a.value != co9b.value){
//     //   //     if(confirm("This is eaither or type question click ok for apply the same co")){
//     //         co9b.value = co9a.value
//     //   //     }
//     //   // }
//     // })
//     // co9b.addEventListener("change",()=>{
//     //   if(co9a.value != co9b.value){
//     //       if(confirm("This is eaither or type question click ok for apply the same co")){
//     //         // co9a.value = co9b.value
//     //         co9b.value = co9a.value
//     //       }
//     //   }
//     // })
//     // var tags = document.getElementsByTagName("select");

//     // for (let i = 0; i < tags.length; i++) {
//     //   if (tags[i].id == "coDetail8"){
//     //     alert("The co for question q8b should be same as the q8a if needed can be changed");
//     //   }
//     //   if (tags[i].id == "coDetail10"){
//     //     alert("The co for question q98b should be same as the q8a if needed can be changed");
//     //   }
//     // }
//   }
// }

saveco.addEventListener("click", () => {
  var coArray = [];
  var bloomArray = [];

  //azar
  $("#drop tr").each(function () {
    var coDetailValue = $(this).find("select[id^='coDetail']").val();
    var bloomValue = $(this).find("select[id^='blooms']").val();

    coArray.push(coDetailValue);
    bloomArray.push(bloomValue);
    // let text =
    //   "CO type should be same \n Press OK to change \n Cancel to continue";
    // var check = true;
    // if (coArray[7] != coArray[8] && check == true) {
    //   if (confirm(text) == true) {
    //     let q = document.getElementById("coDetail8");
    //     q.value = coArray[7];
    //     check = false;
    //   } else {
    //     check = false;
    //   }
    // }
    // if (coArray[9] != coArray[10]) {
    //   if (confirm(text) == true) {
    //     let q = document.getElementById("coDetail10");
    //     q.value = coArray[9];
    //   }
    // }
  });
  //   const options = document.querySelectorAll('#subject-code option');

  // options.forEach(option => {
  //     const subjectCode = option.value;
  //     const subjectName = option.textContent;
  // });
  // console.log(subjectName);
  var assessmentType = document.getElementById("assessment").value;
  var batch = document.getElementById("batch").value;
  var course = document.getElementById("course").value;
  if (assessmentType == "sem") {
    var marks = marks_sem;
    var quNo = Semester;
  } else {
    var marks = marks_int;
    var quNo = assessment_1;
  }
  const details = {
    coArray: coArray,
    bloomArray: bloomArray,
    assessmentType: assessmentType,
  };
  var formData = new FormData();
  formData.append("batch", JSON.stringify(batch));
  formData.append("course", JSON.stringify(course));
  formData.append("coArray", JSON.stringify(coArray));
  formData.append("bloomArray", JSON.stringify(bloomArray));
  formData.append("assessmentType", JSON.stringify(assessmentType));
  formData.append("subjectCode", subject_code.value);

  if (assessmentType == "sem") {
    // formData.append("mardup", JSON.stringify(Sems));
    formData.append("Marks", JSON.stringify(marks_sem));
    formData.append("QuNo", JSON.stringify(Semester));
  } else {
    // formData.append("mardup", JSON.stringify(asses));
    formData.append("Marks", JSON.stringify(marks_int));
    formData.append("QuNo", JSON.stringify(assessment_1));
  }
  fetch("goto.php", {
    method: "POST",
    body: formData,
  })
    .then(response => {
      if (!response.ok) {
        throw new Error('Network response was not ok');
      }
      return response.json();
    }).then((data) => {
      console.log(data);
      if (data.status == 'success') {
        alert(data.message); // Display success message
      } else  if(data.status == 'fault'){
        console.log(data)
        alert(data.message); // Display error message
      }
      else{
        alert('Unexpected response from the server');
      }
    })
    .catch((error) => {
      console.error(error);
    alert(error);

    });

  console.log("CO Array:", coArray);
  console.log("Bloom's Taxonomy Array:", bloomArray);
  console.log("Ass type:", assessmentType);
  console.log("form Data", formData);
});

// var selectElements = document.getElementById("drop");

// selectElements.forEach(function (selectElement) {
//   var id = selectElement.id;
//   var value = selectElement.value;

//   // Check if the select element is for CO or Bloom's Taxonomy based on its id
//   if (id.includes("coDetail")) {
//     coArray.push(value);
//   } else if (id.includes("blooms")) {
//     bloomArray.push(value);
//   }
// });

// Create a fetch API request
//   fetch("goto.php", {
//     method: "POST",
//     body: formData,
//   })
//     .then((response) => {
//       if (!response.ok) {
//         throw new Error("Network response was not ok");
//       }
//       return response.text();
//     })
//     .then((data) => {
//       console.log(data);
//       console.log("Data sent successfully:", data.split(",").pop());
//     })
//     .catch((error) => {
//       console.error("Error sending data:", error);
//     });

//   console.log("CO Array:", coArray);
//   console.log("Bloom's Taxonomy Array:", bloomArray);
// }

//Generate mark table to get marks of the student
asstab2.addEventListener("change", () => {
  console.log("5");
  if (asstab2.value == "ass1") {
    console.log(asstab2.value);

    wrapper.innerHTML = "";

    createMarkTable(12, assessment_1);
  }
  else if (asstab2.value == "ass2") {
    console.log(asstab2.value);

    wrapper.innerHTML = "";

    createMarkTable(12, assessment_1);
  }
  else if (asstab2.value == "sem") {
    console.log(asstab2.value);
    wrapper.innerHTML = "";

    createMarkTable(21, Semester);
  }
  else{
    wrapper.innerHTML='please select assessment type';
  }
});

//   Mark table
function createMarkTable(quNo, x) {
  console.log("hh");

  var formData = new FormData();

  formData.append("course", course.value);
  formData.append("batch", batch.value);

  const queryString = new URLSearchParams(formData).toString();

  const url = `fetchStudent.php?${queryString}`;
  // Fetch data and create table

  fetch(url, {
    method: "GET",
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error("Network response was not ok");
      }
      return response.text();
    })
    .then((data) => {
      var res = JSON.parse(data);
      console.log(res);
      var tableContainer = document.getElementById("wrapper");
      var table = document.createElement("table");
      table.id = "marktable";
      var form = document.createElement("form");

      // Array to store arrays of cell values for each row
      var rowsArray = [];

      let headings = ["Name", "Roll No"];
      for (var i = 1; i <= quNo; i++) {
        ("<th>Question No</th>");
        //
        headings[i + 1] = x[i - 1];
        console.log("Q" + i);
      }
      var row = document.createElement("tr");
      for (var j = 0; j < headings.length; j++) {
        var cell = document.createElement("td");
        cell.innerHTML = headings[j];
        row.appendChild(cell);
      }
      table.appendChild(row);
      console.log(res)
      // Create rows
      for (var i = 0; i < res.length; i++) {
        var rowValues = {}; // Object to store cell values for the current row
        var row = document.createElement("tr");

        // Create columns
        for (var j = 0; j < quNo + 2; j++) {
          var cell = document.createElement("td");
          console.log(j);
          if (j == 0) {
            cell.innerText = res[i].name;
            rowValues["Name"] = res[i].name; // Store cell value in the rowValues object
          } else if (j == 1) {
            var p = document.createElement("p");
            cell.innerText = res[i].rollno;
            rowValues["Roll No"] = res[i].rollno; // Store cell value in the rowValues object
          } else {
            var input = document.createElement("input");
            input.type = "number";
            input.size = 2;
            input.id = "inst";
            // input.addEventListener("change", function() {
            //     if(asstab2.value == "ass1" || asstab2.value == "ass2" ){
            //     if (!Number.isInteger(parseFloat(this.value))) {
            //         alert("Input must be an integer.");
            //         this.value = ""; // Clear the input field
            //     }
            //     // Check if the value is greater than or equal to 2
            //     else if ((j > 1 && j < 9) && parseInt(this.value) >2) {
            //         alert("Part-A must be less than 2 marks.");
            //         this.value = ""; // Clear the input field
            //     }
            //     else if(parseInt(this.value) >13){
            //       alert("Exceeds the maximum marks");
            //       this.value = "";
            //     }
            //     else{
            //       input.id = assessment_1[j-2]
            //       console.log("Input Ok");
            //     }
            //   }
            //   else{
            //     if (!Number.isInteger(parseFloat(this.value))) {
            //       alert("Input must be an integer.");
            //       this.value = ""; // Clear the input field
            //   }
            //   // Check if the value is greater than or equal to 2
            //   else if ((j-2 <= 7) && parseInt(this.value) >2) {
            //       alert("Part-A must be less than 2 marks.");
            //       this.value = ""; // Clear the input field
            //   }
            //   else if(parseInt(this.value) >13){
            //     alert("Exceeds the maximum marks");
            //     this.value = "";
            //   }
            //   else{
            //     input.id = semester[j-2]
            //   }
            //   }
            // });
            // input.value = 0;
            //document.getElementById('inst').dispatchEvent(new Event('change'));

            input.addEventListener("change", function () {
              if (asstab2.value == "ass1" || asstab2.value == "ass2") {
                if (!Number.isInteger(parseFloat(this.value))) {
                  alert("Input must be an integer.");
                  this.value = ""; // Clear the input field
                }
                // Check if the value is greater than or equal to 2
                else if (j > 1 && j < 9 && parseInt(this.value) > 2) {
                  alert("Part-A must be less than 2 marks.");
                  this.value = ""; // Clear the input field
                } else if (parseInt(this.value) > 13) {
                  alert("Exceeds the maximum marks");
                  this.value = "";
                } else {
                  input.id = assessment_1[j - 2];
                  console.log("Input Ok");
                }
              } else {
                if (!Number.isInteger(parseFloat(this.value))) {
                  alert("Input must be an integer.");
                  this.value = ""; // Clear the input field
                }
                // Check if the value is greater than or equal to 2
                else if (j - 2 <= 7 && parseInt(this.value) > 2) {
                  alert("Part-A must be less than 2 marks.");
                  this.value = ""; // Clear the input field
                } else if (parseInt(this.value) > 13) {
                  alert("Exceeds the maximum marks");
                  this.value = "";
                } else {
                  input.id = semester[j - 2];
                }
              }

              var value = this.value;
              var rollNo = res[i].rollno;
              var columnHeader = headings[j];
              console.log(columnHeader);
              if (!rowValues[rollNo]) {
                rowValues[rollNo] = {};
              }

              // Store the value in the appropriate row and column
              rowValues[res[i].rollno][columnHeader] = value;

              console.log("Row values array:", rowValues);
            });

            cell.appendChild(input);
          }

          row.appendChild(cell);
        }

        // Push the rowValues object into the rowsArray
        rowsArray.push(rowValues);

        // Append the row to the table
        table.appendChild(row);
      }

      var savebtn = document.createElement("button");
      savebtn.innerText = "save";
      savebtn.id = "saveData";
      savebtn.addEventListener("click", () => {
        var tableData = getDataFromTable();
        // console.log("Hi");
        // console.log(tableData);
        // console.log(JSON.parse(tableData)[0].Name);
        // var param = JSON.parse(tableData)
        // console.log(param)
        // Send JSON data to the server
        var markDetails = new FormData();
        markDetails.append("subject_code", subject_code.value);
        markDetails.append("assess_type", asstab2.value);
        markDetails.append("batch", batch.value);
        markDetails.append("course", course.value);
        markDetails.append("semester", semester.value);
        markDetails.append("mark", tableData);
        fetch("mark_store.php", {
          method: "POST",
          body: markDetails,
        })
          .then((response) => {
            if (!response.ok) {
              throw new Error("Network response was not ok");
            }
            return response.json();
            console.log(response.text())
          })
          .then((data) => {
            console.log(data);
            if (data.status == 'success') {
              alert(data.message); // Display success message
            } else  if(data.status == 'fault'){
              console.log(data)
              alert(data.message); // Display error message
            }
          })
          .catch((error) => {
            // alert(error);
           console.error("Error sending data:", error);
          });
      });
      form.appendChild(table);
      // form.appendChild(savebtn);
      tableContainer.appendChild(form);
      tableContainer.appendChild(savebtn);
    })
    .catch((error) => {
      console.error("Error fetching data:", error);
    });
}

function getDataFromTable() {
  var table = document.getElementById("marktable");
  var rows = table.querySelectorAll("tr");
  var jsonData = [];

  // Start from index 1 to skip the header row
  for (var i = 1; i < rows.length; i++) {
    var cells = rows[i].querySelectorAll("td");
    var marks = [];
    var rowData = {
      Name: cells[0].innerText,
      "Roll No": cells[1].innerText,
      Marks: [],
    };
    // console.log(cells)

    // Start from index 2 to skip the first two columns (Name and Roll No)
    for (var j = 2; j < cells.length; j++) {
      var input = cells[j].querySelector("input");
      if (input) {
        var mark = input.value;
        marks.push(mark);
      }
    }
    rowData.Marks.push(marks);
    //   var formData = new FormData();
    //   formData.append("Name", JSON.stringify(cells[0].innerText));
    //   formData.append("Roll No", JSON.stringify(cells[1].innerText));
    //   formData.append(
    //   "assessmentType",
    //   document.getElementById("assessment").value
    // );
    // formData.append("Marks", JSON.stringify(marks))
    // marks = [];
    jsonData.push(rowData);
  }
  return JSON.stringify(jsonData);
  // return JSON.parse(jsonData);
}

function toggleVisibility(elementId) {
  var row = document.getElementById("co");
  var marksTable = document.getElementById("marks_table");

  if (elementId === "co") {
    row.style.display = "block"; // Show the row
    marksTable.style.display = "none"; // Hide marks_table
  } else if (elementId === "marks_table") {
    row.style.display = "none"; // Hide the row
    marksTable.style.display = "block"; // Show marks_table
  }
}