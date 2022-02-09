<?php
session_start(); //start the session to use session variables
//include necessary files
require_once "../../../common.php";
require_once "../../../commonFunctions.php";
require_once "../../../database.php";
$obj = new query_();

/**
 * Insert data to student inforamtion table which contains only details about student.
 * */
function insertStudentInfo($obj,$studentData){
    $studentID = date("Ymdhis");
    $studentInfoData = array(
        STUDENT_ID        => $studentID,
        FIRST_NAME        => $studentData[FIRST_NAME],
        LAST_NAME         => $studentData[LAST_NAME],
        CLASS_NAME        => $studentData[CLASS_NAME],
        FATHER_NAME       => $studentData[FATHER_NAME],
        MOTHER_NAME       => $studentData[MOTHER_NAME],
        GENDER            => $studentData[GENDER],
        CONTACT_NUMBER    => $studentData[CONTACT_NUMBER],
        ADDRESS           => $studentData[ADDRESS]
    
    );
    $queryToAddData = $obj->insertData(
        TABLE_STUDENT_INFO,
        array_keys($studentInfoData)
    );
    // echo $queryToAddData."\n";
    $valuesToAddData = array_values($studentInfoData);
    // print_r($valuesToAddData);
    $result = $obj->executeQueryInsertData($queryToAddData,$valuesToAddData);
    return $result;

}

if ($_SERVER["REQUEST_METHOD"] == "POST") {//Get data only is request_method is post
    $data = json_decode(file_get_contents('php://input'));
}
//  if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
    $studentData = sanatizeInputData($data);
    $resultInsertStudentInfo = insertStudentInfo($obj,$studentData);
    if($resultInsertStudentInfo){
            $status = array("status"=>true);
    }else{
        $status = array("status"=>false);
    }                         
//}else{

//}
header('Content-type: application/json');
echo json_encode( $status );

?>