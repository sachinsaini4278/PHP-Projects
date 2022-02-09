<?php
session_start(); //start the session to use session variables

//include necessary files
require_once "../../../common.php";
require_once "../../../commonFunctions.php";
require_once "../../../database.php";
$obj = new query_();
/**
* Show Student base on name;
* 
*/


function getAllStudentInfoOnName($obj,$data){
    $names= array(
        FIRST_NAME       => $data[FIRST_NAME],
        LAST_NAME       => $data[LAST_NAME]
    );
   
    $queryToGetData = $obj->getData(
        TABLE_STUDENT_INFO,'*',array_keys($names)
    );
    //  echo $queryToGetData."\n";
     $valuesToGetData = array_values($names);
    //  print_r($valuesToGetData);
     $result = $obj->executeQueryGetData($queryToGetData,$valuesToGetData);
     return $result;
 
}



if ($_SERVER["REQUEST_METHOD"] == "POST") {//Get data only is request_method is post
    $data = json_decode(file_get_contents('php://input'));
}
//  if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
    $data = sanatizeInputData($data);
    $studentInfo = getAllStudentInfoOnName($obj,$data);
    if($studentInfo){
        $status = $studentInfo;
    }else{
        $status = array("status"=>false);
    }

// }else{
//     $status = array("status"=>false,"reason"=>"not_logged_in");  
// }



header('Content-type: application/json');
echo json_encode( $status );
?>