window.onload=getAllData;

function getAllData(){
    console.log("Called");
    fetch("http://localhost/testing/php/fee/api/course/show-all-course/index.php")
    .then((response)=>{
      console.log(response);
      return response.json();
    })
    .then((data) => {
      console.log(data);
    })
}
  