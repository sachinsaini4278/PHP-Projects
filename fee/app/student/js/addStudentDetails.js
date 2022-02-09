
let firstName     = document.getElementById("FName");
let lastName      = document.getElementById("LName");
let className     = document.getElementById("Class");
let fatherName    = document.getElementById("fatherName");
let motherName    = document.getElementById("motherName");
let contactNumber = document.getElementById("contactNumber");
let address       = document.getElementById("address");
let genderChoice  = document.getElementsByName("gender");
let gender='';


let submitButton = document.getElementsByClassName("submit")[0];

const locationStudentAddInfo="http://localhost/testing/php/fee/api/student/add-student/add-new-student/index.php";

submitButton.addEventListener('click',()=>{
    // console.log("Hello");
    // let usernameValue = usernameInput.value.trim();
    // let passwordValue = passwordInput.value.trim();
    if(genderChoice[0].checked){
      gender='M';
  }else{
      gender='F';
  }
// JSON to send
let data ={
	first_name    :firstName.value    ,
	last_name     :lastName.value     ,
	class_name    :className.value    ,
	father_name   :fatherName.value   ,
	mother_name   :motherName.value   ,
	gender        :gender             ,
	contact_number:contactNumber.value,
	address       :address.value
};

    fetch(locationStudentAddInfo, {
      method: "POST",
      headers: {"content-type":"application/json"},
      body: JSON.stringify(data),
    })
      .then((response) => {
        console.log(response);
        return response.json();
      })
      .then((data) => {
        console.log(data);        
      });
})