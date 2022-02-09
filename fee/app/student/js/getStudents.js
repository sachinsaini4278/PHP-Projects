function sendNameToanother(){
    let firstName =document.getElementById("firstName").value;
    let lastName = document.getElementById("lastName").value; 
    localStorage.setItem("firstname",(firstName));
    localStorage.setItem("lastname", (lastName));
    localStorage.setItem("method","usingName");
    window.location = "http://localhost//testing/php/fee/app/student/addStudentToCourse.html";
}
function sendIdToanother(){
    localStorage.clear();
    let studentID =document.getElementById("student_id").value;
    localStorage.setItem("studentID",studentID);
    localStorage.setItem("method","usingID");
    window.location = "http://localhost//testing/php/fee/app/student/addStudentToCourse.html";
}