<?php
session_start();
//include necessary files
require_once "../../common.php";
require_once "../../commonFunctions.php";
require_once "../../database.php";
$obj = new query_();
/**
 * Function to delete a student based on ID
 */

function deleteStudent($obj,$studentID){
    $studentAbout = array(
        STUDENT_ID => $studentID       
    );
    $queryToAddData = $obj->deleteData(
        TABLE_STUDENT_INFO,
        array_keys($studentAbout)
    );
    //echo $queryToAddData."\n";
    $valuesToAddData = array_values($studentAbout);
    //print_r($valuesToAddData);
    $result = $obj->executeQueryDeleteData($queryToAddData,$valuesToAddData);
    return $result;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {//Get data only is request_method is post
    $data = json_decode(file_get_contents('php://input'));
}
//  if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
    $studentData = sanatizeInputdata($data);
    //print_r($courseData[COURSE_ID]);
    $resultDeleteStudent = deleteStudent($obj,$studentData[STUDENT_ID]);
    if($resultDeleteStudent){
            $status = array("status"=>true);
    }else{
        $status = array("status"=>false);
    }                         
//}else{

//}
header('Content-type: application/json');
echo json_encode( $status );

?>