<?php
session_start();
//include necessary files
require_once "../../common.php";
require_once "../../commonFunctions.php";
require_once "../../database.php";
$obj = new query_();
/**
 * Function to delete a course based on ID
 */

function deleteCourse($obj,$courseID){
    $courseAbout = array(
        COURSE_ID => $courseID       
    );
    $queryToAddData = $obj->deleteData(
        TABLE_COURSE_INFO,
        array_keys($courseAbout)
    );
    //echo $queryToAddData."\n";
    $valuesToAddData = array_values($courseAbout);
    //print_r($valuesToAddData);
    $result = $obj->executeQueryDeleteData($queryToAddData,$valuesToAddData);
    return $result;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {//Get data only is request_method is post
    $data = json_decode(file_get_contents('php://input'));
}
//  if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
    $courseData = sanatizeInputData($data);
    //print_r($courseData[COURSE_ID]);
    $resultInsertCourse = deleteCourse($obj,$courseData[COURSE_ID]);
    if($resultInsertCourse){
            $status = array("status"=>true);
    }else{
        $status = array("status"=>false);
    }                         
//}else{

//}
header('Content-type: application/json');
echo json_encode( $status );

?>