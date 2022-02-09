
//--------------------------------------------------------------------------------//
//--------------------GRABBING IMPORTANT ELEMENTS FOR WORKING WITH LOGIN FORM----//

let usernameInput = document.getElementsByClassName("username")[0];
let passwordInput = document.getElementsByClassName("password")[0];
let submitButton = document.getElementsByClassName("submit")[0];
const locationHomePage="http://localhost/testing/php/fee/app/homepage.html";
const locationAPILogin="http://localhost/testing/php/fee/api/login/index.php";

submitButton.addEventListener('click',()=>{
    console.log("Hello");
    let usernameValue = usernameInput.value.trim();
    let passwordValue = passwordInput.value.trim();

    fetch(locationAPILogin, {
      method: "POST",
      headers: {"content-type":"application/json"},
      body: JSON.stringify({
        username: usernameValue,
        password: passwordValue,
      }),
    })
      .then((response) => {
        console.log(response);
        return response.json();
      })
      .then((data) => {
        console.log(data);
        if (data.status) {
          window.location = locationHomePage;
        }
      });
})