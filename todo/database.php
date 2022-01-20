<?php
function make_connection()
{
    $host = "localhost";
    $username = "root";
    $password = "";
    $dbname ="todoapp";
    $con = new mysqli($host,$username,$password,$dbname);
    if($con->connect_error)
    {
        echo "There is an error in Database connection ".$con->connect_error;
    }
    return $con;
    // echo "Successfully connected";
}
function add_items($value)
{
    $con = make_connection();
    $query = "INSERT INTO todolist(id,item,status) VALUES(NULL,'$value','0')";
    $con->query($query);
}
function get_items()
{
    $con = make_connection();
    $query = "SELECT id,item from todolist WHERE status='0'";
    $result = $con->query($query);
    return $result;
}
function get_items_checked()
{
    $con = make_connection();
    $query = "SELECT id,item from todolist WHERE status='1'";
    $result = $con->query($query);
    return $result;
}
function update_items($id)
{
    $con = make_connection();
    $query = "UPDATE todolist set status='1' WHERE id='$id'";
    $result = $con->query($query);
}

function delete_items($id)
{
    $con = make_connection();
    $query = "DELETE from todolist WHERE id='$id'";
    $result = $con->query($query);
}
?>