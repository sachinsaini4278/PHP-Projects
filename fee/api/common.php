<?php
// header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
// header('Access-Control-Allow-Credentials: true');

header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 86400');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
     
date_default_timezone_set("Asia/Kolkata");
/**Define table names */
define("TABLE_STUDENT_INFO","student_info");
define("TABLE_COURSE_INFO","course_info");
define("TABLE_FEE_ENTRY","fee_entry");
define("TABLE_COURSE_ENROLLED","course_enrolled");

/**Define common names */
define("STUDENT_ID"     ,"student_id");
define("FIRST_NAME"     ,"first_name");
define("LAST_NAME"      ,"last_name");
define("ADDRESS"        ,"address");
define("GENDER"         ,"gender");
define("CLASS_NAME"     ,"class_name");
define("FATHER_NAME"    ,"father_name");
define("MOTHER_NAME"    ,"mother_name");
define("CONTACT_NUMBER" ,"contact_number");

define("JOINING_DATE"   ,"joining_date");
define("TRANSACTION_NUMBER"   ,"transaction_number");
define("FEE"            ,"fee");
define("CURRENT_DATE"   ,"current_date");
define("SUBMIT_DATE"    ,"submit_date");
define("SUBMIT_AMOUNT"  ,"submit_amount");
define("PAYMENT_ID"     ,"payment_id");

define("COURSE_NAME"         ,"course_name");
define("COURSE_START_DATE"   ,"course_start_date");
define("COURSE_TEACHER_NAME" ,"course_teacher_name");
define("COURSE_FEE"          ,"course_fee");
define("COURSE_TYPE"         ,"course_type");
define("COURSE_ID"           ,"course_id");



?>