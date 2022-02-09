<?php
class database{
    private $host;
    private $dbusername;
    private $dbpassword;
    private $dbname;
    public function connect(){
        $this->host         = "localhost";
        $this->dbusername   = "root";
        $this->dbpassword   = "";
        $this->dbname       = "myapp";
        $con = new mysqli($this->host, $this->dbusername,$this->dbpassword,$this->dbname);        
        return $con;
    }
}
/**
 * We need transaction property only in insert,delete & update. Not in get Data.
 * So we are executing query in query_ class for getData and for others we will return query only.
 */
class query_ extends database{  
    public function getData($table,$field='*',$data='',$like='',$order_by_field='', $order_by_type='',$limit=''){
        $sql ="select $field from $table ";
        if($data!=''){
            $sql .= " where ";
            $c = count($data);
            $i=1;
            foreach($data as $key){
                if($i==$c){
                    $sql .="$key=?";
                }else{
                    $sql .="$key=? and ";
                }
                $i++;
            }
        }
        if($order_by_field!=''){
            // $sql.=" order by $order_by_field $order_by_type ";
            $sql.=" order by ? ";
            if($order_by_type!=''){
                $sql.="?";
            }
        }
        if($limit!=''){
            // $sql.=" limit $limit ";
            $sql.=" limit ? ";
        }
        //die($sql);
        // echo "QUERY : ".$sql."\n";
        return $sql;
        
        // $result=$this->connect()->query($sql);
        // if($result->num_rows>0){
        //     $arr = array();
        //     while($rows = $result->fetch_assoc()){
        //         $arr[]=$rows;
        //     }
        //     return $arr;
        // }else{
        //     return 0;
        // }

    }
    /**We are making using prepared statements for handling sql injections */
    public function insertData($tableName,$data){
        if($data!=''){
            foreach($data as $key){
                $fields[] = $key;
                $values[] ='?';    
            }
            $fields = implode(",",$fields);//this convert array to string. arguments(seperator, array)
            $values = implode(",",$values);
            // $values = "'".$values."'";
            $sql="insert into $tableName($fields) values($values) ";
            return $sql;
        }        
    }
    public function deleteData($table,$data){
        if($data!=''){
            $sql ="delete from $table where ";
            $c = count($data);
            $i=1;
            foreach($data as $key){
                if($i==$c){
                    $sql .="$key=?";
                }else{
                    $sql .="$key=? and";
                }
                $i++;
            } 
            // $result = $this->connect()->query($sql);
            return $sql;
        }
    }
    // public function updateData($table,$data,$where_field,$where_value){
    public function updateData($table,$data,$where_field){
        if($data!=''){
            $sql ="update $table set ";
            $c = count($data);
            $i=1;
            foreach($data as $key){
                if($i==$c){
                    $sql .="$key=?";
                }else{
                    $sql .="$key=?, ";
                }
                $i++;
            } 
            $sql .= " where $where_field=?"; 
            // $result = $this->connect()->query($sql);
            // return $result;
            return $sql;
        }
    }
    //Do not use it for get data only use to insert, delete, update.
    //With transaction feature
    public function executeQueries($arrayOfQuery,$valuesToBind){
        // print_r($arrayOfQuery);
        // echo "\nValues To Bind\n";
        // print_r($valuesToBind);
        $con = $this->connect();
        
        $resultquery=array();
        $con->begin_transaction();
        $log_file = globalVars::$log_file;
        for ($i=0; $i < count($arrayOfQuery); $i++) { 
            $stmt_db[$i] = $con->prepare($arrayOfQuery[$i]);
            if(!$stmt_db[$i]){
                $error_message = "$currTimeStamp |$con->error | stmt_Prepare failed $con->error\n";
            }
            // $resultquery[]=$obj->query($arrayOfQuery[$i]);
            $types = str_repeat('s', count($valuesToBind[$i])); //types
            // print_r($arrayOfQuery[$i]);
            // print_r($valuesToBind[$i]);
            // var_dump($types);
            // print_r(...$valuesToBind[$i]);
            $stmt_db[$i]->bind_param($types, ...$valuesToBind[$i]); // bind array at once
            $resultquery[$i]=$stmt_db[$i]->execute();
            $currTimeStamp = date('Y/m/d h:i:s');
            if(!$result[$i])
            {
                $error_message = "$currTimeStamp |$con->error | Error in stmt execution\n";
            }
            error_log($error_message, 3, $log_file);
            // echo "result:$i ".$resultquery[$i]."\n";
        }
//         $sql = "insert into
// store_logs_supply(medicine_id,product_name,quantity,MRP,discount,selling_to,package_type,timestamp,total_price,transaction_no)
// values(1,'combiflam',1,500,20,'medical','carton','2021/11/22 06:12:42',320,20211122061242)";
// $result = $con->query($sql);
// echo "result".$result;
        // print_r($arrayOfQuery);
        $ans = true;
        for ($i=0; $i < count($resultquery); $i++) { 
         $ans=$ans and $resultquery[$i];   
        }
        if($ans)
        {
            $con->commit();
            // echo "\nData is commited\n";
            return true;
        }else{
            $con->rollback();
            // echo "\nData is RollBacked\n";
            return false;
        }
        
    }
    function executeQueryGetData($query,$valuesToBind){
        $con = $this->connect();
        $stmt = $con->prepare($query);
        if($valuesToBind!=''){
            $types = str_repeat('s', count($valuesToBind)); //types
            $stmt->bind_param($types,...$valuesToBind); // bind array at once
        }
        if($stmt->execute()){
            $result = $stmt->get_result(); // get the mysqli result
            $dataToReturn=[];
            while( $getRowfromResult = $result->fetch_assoc()){ // fetch data
                // print_r($getRowfromResult);
                $dataToReturn[]=$getRowfromResult;
            }
            return $dataToReturn;
        }else{
            echo $con->error;
            return false;
        }
        
    }
    function executeQueryInsertData($query,$valuesToBind){
        $con = $this->connect();
        $stmt = $con->prepare($query);
        $types = str_repeat('s', count($valuesToBind)); //types
        $stmt->bind_param($types, ...$valuesToBind); // bind array at once
        $result = $stmt->execute();
        if($result){
            return true;
        }else{
            return false;
        }
    }
    function executeQueryUpdateData($query, $valuesToBind){
        $con = $this->connect();
        $stmt = $con->prepare($query);
        $types = str_repeat('s', count($valuesToBind)); //types
        $stmt->bind_param($types, ...$valuesToBind); // bind array at once
        $result = $stmt->execute();
        $affectedRows = $con->affected_rows;
        return $affectedRows;
    }
    function executeQueryDeleteData($query, $valuesToBind){
        $con = $this->connect();
        $stmt = $con->prepare($query);
        $types = str_repeat('s', count($valuesToBind)); //types
        $stmt->bind_param($types, ...$valuesToBind); // bind array at once
        $result = $stmt->execute();
        $affectedRows = $con->affected_rows;
        return $affectedRows;
    }

    

}
?>