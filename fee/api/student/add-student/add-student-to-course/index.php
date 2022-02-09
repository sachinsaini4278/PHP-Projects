<?php
session_start(); //start the session to use session variables
//include necessary files
require_once "../../../common.php";
require_once "../../../commonFunctions.php";
require_once "../../../database.php";
$obj = new query_();

/**
 * Insert data to student to course
 *
 **/
function insertStudentToCourse($obj,$studentData){
    $studentInfoData = array(
        STUDENT_ID        => $studentData[STUDENT_ID],
        COURSE_NAME       => $studentData[COURSE_NAME],
        JOINING_DATE      => $studentData[JOINING_DATE]    
    );
    $queryToAddData = $obj->insertData(
        TABLE_COURSE_ENROLLED,
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
    $dataToInsert = sanatizeInputData($data);
    $resultInsertStudentToCourse = insertStudentToCourse($obj,$dataToInsert);
    if($resultInsertStudentToCourse){
            $status = array("status"=>true);
    }else{
        $status = array("status"=>false);
    }                         
//}else{

//}
header('Content-type: application/json');
echo json_encode( $status );

?>