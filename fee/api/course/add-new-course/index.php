<?php
session_start();
//include necessary files
require_once "../../common.php";
require_once "../../commonFunctions.php";
require_once "../../database.php";
$obj = new query_();
/**
 * Function to add course details
 */

function addNewCourse($obj,$courseData){
    $courseAbout = array(
        COURSE_ID          => $courseData[COURSE_ID          ],        
        COURSE_NAME        => $courseData[COURSE_NAME        ],
        COURSE_START_DATE  => $courseData[COURSE_START_DATE  ],
        COURSE_TEACHER_NAME=> $courseData[COURSE_TEACHER_NAME],
        COURSE_FEE         => $courseData[COURSE_FEE         ],
        COURSE_TYPE        => $courseData[COURSE_TYPE        ]

    );
    $queryToAddData = $obj->insertData(
        TABLE_COURSE_INFO,
        array_keys($courseAbout)
    );
    //echo $queryToAddData."\n";
    $valuesToAddData = array_values($courseAbout);
    //print_r($valuesToAddData);
    $result = $obj->executeQueryInsertData($queryToAddData,$valuesToAddData);
    return $result;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {//Get data only is request_method is post
    $data = json_decode(file_get_contents('php://input'));
}
//  if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
    $courseData = sanatizeInputData($data);
    //print_r($courseData);
    $resultInsertCourse = addNewCourse($obj,$courseData);
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