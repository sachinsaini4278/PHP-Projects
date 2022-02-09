<?php
session_start(); //start the session to use session variables

//include necessary files
require_once "../../../common.php";
require_once "../../../commonFunctions.php";
require_once "../../../database.php";
$obj = new query_();
/**
* Get all past fee data of a student after entering id
*  
*/


function getStudentFeeInfo($obj,$data){
    $arrayToSend= array(
        STUDENT_ID => $data[STUDENT_ID]
    );
   
    $queryToGetData = $obj->getData(
        TABLE_FEE_ENTRY,'*',array_keys($arrayToSend)
    );
    //  echo $queryToGetData."\n";
     $valuesToGetData = array_values($arrayToSend);
    //  print_r($valuesToGetData);
     $result = $obj->executeQueryGetData($queryToGetData,$valuesToGetData);
     return $result;
 
}



if ($_SERVER["REQUEST_METHOD"] == "POST") {//Get data only is request_method is post
    $data = json_decode(file_get_contents('php://input'));
}
//  if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
    $data = sanatizeInputData($data);
    $feeInfo = getStudentFeeInfo($obj,$data);
    if($feeInfo){
        $status = $feeInfo;
    }else{
        $status = array("status"=>false);
    }

// }else{
//     $status = array("status"=>false,"reason"=>"not_logged_in");  
// }



header('Content-type: application/json');
echo json_encode( $status );
?>