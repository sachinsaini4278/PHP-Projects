<?php
function sanatizeInputData($data){
    $dataArr=array();
    foreach($data as $key=>$val){
        $dataArr[$key]=htmlspecialchars($val);
    }
    return $dataArr;
}

function innerJoinOfStudentInfoAndCourseEnrolled($table1,$table2,$fieldToCompare,$fieldCondition){

    $query = "SELECT * from $table1 
            INNER JOIN $table2 on $table1.$fieldToCompare = $table2.$fieldToCompare
            WHERE $table2.$fieldCondition = ?";
    return $query;

}

// SELECT * from student_info
// INNER JOIN course_enrolled on student_info.student_id = course_enrolled.student_id
// WHERE course_enrolled.course_name = "Physics";
?>