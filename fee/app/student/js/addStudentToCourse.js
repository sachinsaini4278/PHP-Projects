//It create option tag and assign the data to options (Courses)
let assignCourses=(data)=>{
    // console.log(data);
    let courses = document.getElementsByClassName("courses")[0];
    // console.log()
    // console.log(data[0].course_name);
    for (let index = 0;  index < data.length; index++) {
      const element = data[index].course_name;
      const option = document.createElement("OPTION");
      option.innerHTML = element;
      courses.appendChild(option);
    }
}

//It create option tag and assign the data to options (Students)
let assignStudents=(data)=>{
  // console.log(data);
  let student = document.getElementsByClassName("students")[0];
  // console.log()
  // console.log(data[0].course_name);
  for (let index = 0;  index < data.length; index++) {
    const element = data[index].first_name + " " +data[index].last_name + " " +data[index].class_name;
    const option = document.createElement("OPTION");
    const studentId = data[index].student_id;
    option.innerHTML = element;
    option.value = studentId;
    student.appendChild(option);
  }

}

let getAllCourses=()=>{
    let URL_getAllCourses = "http://localhost/testing/php/fee/api/course/show-all-course/index.php";
    // console.log("Called");
    fetch(URL_getAllCourses)
    .then((response)=>{
      // console.log(response);
      return response.json();
    })
    .then((data) => {
      assignCourses(data);
    })
}

// Get students based on name
let getAllStudentByName=()=>{
 // console.log(localStorage.getItem("firstname"));
 // console.log(localStorage.getItem("lastname"));
  let firstName =localStorage.getItem("firstname");
  let lastName = localStorage.getItem("lastname");
  // console.log("First Name ",firstName);
  // console.log("last Name ",lastName);
  let URL = "http://localhost/testing/php/fee/api/student/show-student/show-by-name/index.php";
  // console.log("Called");
  fetch(URL,{
   method:"POST",
   headers:{"content-type":"application/json"},
   body: JSON.stringify({
     first_name:firstName,
     last_name:lastName,
   }),
  })
  .then((response)=>{
  //  console.log(response);
   return response.json();
  })
  .then((data) => {
  //  console.log(data);
   assignStudents(data);

  })
}
// Get students based on id
let getAllStudentByID=()=>{
  let studentID = localStorage.getItem('studentID');
  let URL = "http://localhost/testing/php/fee/api/student/show-student/show-by-id/index.php";
  fetch(URL,{
    method:"POST",
    headers:{"content-type":"application/json"},
    body: JSON.stringify({
      student_id:studentID
    }),
  })
  .then((response)=>{
    // console.log(response);
    return response.json();
  })
  .then((data) => {
    // console.log(data);
    assignStudents(data);
  })
}


function callRequireFuncitons(){
  getAllCourses();
  let method = localStorage.getItem("method");
  // console.log(method);
  if(method=="usingName"){
    console.log("using Name");
    getAllStudentByName();
  }
  else if(method=="usingID"){
    console.log("using ID");
    getAllStudentByID();
  }
}
window.onload = callRequireFuncitons;

//***************************************************/

let submitButton = document.getElementsByClassName("submit")[0];

submitButton.addEventListener('click',()=>{
  // console.log("Called submit button");
let studentId  =document.getElementsByClassName("students")[0].value;
let courseName = document.getElementsByClassName("courses")[0].value;
let joiningDate = document.getElementById("joiningDate").value;
// console.log(studentId,courseName,joiningDate);
let URL = "http://localhost/testing/php/fee/api/student/add-student/add-student-to-course/index.php";
fetch(URL,{
  method:"POST",
  headers:{"content-type":"application/json"},
  body:JSON.stringify({
    student_id:studentId,
    course_name:courseName,
    joining_date:joiningDate
    }),
  })
  .then((response)=>{
    // console.log(response);
    return response.json();
  })
  .then((data) => {
    // console.log(data);
    alert("Student ADDED to course");
    document.getElementById("addStudentForm").reset();

  })
})