<?php
session_start(); //start the session to use session variables
//include necessary files
require_once "../../common.php";
require_once "../../commonFunctions.php";
require_once "../../database.php";
$obj = new query_();

function feeEntry($obj,$data){
    $currTimeStamp = date('Ymdhis');
    $feeData = array(
        TRANSACTION_NUMBER => $currTimeStamp,
        STUDENT_ID         => $data[STUDENT_ID],
        COURSE_NAME        => $data[COURSE_NAME   ],
        SUBMIT_AMOUNT      => $data[SUBMIT_AMOUNT ],
        SUBMIT_DATE        => $data[SUBMIT_DATE   ]
    );
    $queryToAddData = $obj->insertData(
        TABLE_FEE_ENTRY,
        array_keys($feeData)
    );
    // echo $queryToAddData."\n";
    $valuesToAddData = array_values($feeData);
    // print_r($valuesToAddData);
    $result = $obj->executeQueryInsertData($queryToAddData,$valuesToAddData);
    return $result;

}

if ($_SERVER["REQUEST_METHOD"] == "POST") {//Get data only is request_method is post
    $data = json_decode(file_get_contents('php://input'));
}
//  if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
    $data = sanatizeInputData($data);
    $result = feeEntry($obj,$data);
    if($result){
            $status = array("status"=>true);
    }else{
        $status = array("status"=>false);
    }                         
//}else{

//}
header('Content-type: application/json');
echo json_encode( $status );

?>