<?php
session_start(); //start the session to use session variables

//include necessary files
require_once "../../common.php";
require_once "../../commonFunctions.php";
require_once "../../database.php";
$obj = new query_();
/**
* Return all courses data based on received;
* 
*/


function getAllcourseInfo($obj){
    $queryToGetData = $obj->getData(
        TABLE_COURSE_INFO,
        '*' 
    );
    // echo $queryToGetData; 
    $result = $obj->executeQueryGetData($queryToGetData,'');    
    if($result){
        return $result;
    }else{
        return false;
    }
}



//  if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
    $courseInfo = getAllCourseInfo($obj);
    if($courseInfo){
        $status = $courseInfo;
    }else{
        $status = array("status"=>false,"reason"=>"No Course Exist");
    }

// }else{
//     $status = array("status"=>false,"reason"=>"not_logged_in");  
// }



header('Content-type: application/json');
echo json_encode( $status );
?>