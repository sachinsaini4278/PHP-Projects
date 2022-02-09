<?php
session_start(); //start the session to use session variables
//include necessary files
require_once "../../../common.php";
require_once "../../../commonFunctions.php";
require_once "../../../database.php";
$obj = new query_();

/**
 * Show all  students in a batch/Course.
 **/
function getAllStudentFromACourse($obj,$courseName){
    $course= array(
        COURSE_NAME       => $courseName
    );
    
    $queryToGetData = innerJoinOfStudentInfoAndCourseEnrolled(TABLE_STUDENT_INFO,
                                                            TABLE_COURSE_ENROLLED,
                                                            STUDENT_ID,
                                                            COURSE_NAME
    );
    
    //echo $queryToGetData."\n";
    $valuesToGetData = array_values($course);
    // print_r($valuesToGetData);
    $result = $obj->executeQueryGetData($queryToGetData,$valuesToGetData);
    return $result;

}

if ($_SERVER["REQUEST_METHOD"] == "POST") {//Get data only is request_method is post
    $data = json_decode(file_get_contents('php://input'));
}
//  if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
    $dataToInsert = sanatizeInputData($data);
    $resultGetStudentFromCourse = getAllStudentFromACourse($obj,$dataToInsert[COURSE_NAME]);
    if($resultGetStudentFromCourse){
            $status = $resultGetStudentFromCourse;
    }else{
        $status = array("status"=>false);
    }                         
//}else{

//}
header('Content-type: application/json');
echo json_encode( $status );

?>