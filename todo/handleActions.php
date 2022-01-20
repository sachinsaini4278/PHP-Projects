<?php
include("database.php");
if($_SERVER["REQUEST_METHOD"]=="POST")
{
    if(isset($_POST["add"]))
    {
        if($_POST["inputBox"]!=NULL)
        {
            add_items($_POST["inputBox"]);
        }
    }
    else if(isset($_POST["checked"]))
    {
        // echo $_POST["checked"];
        update_items($_POST["checked"]);
    }
    else if(isset($_POST["deleted"]))
    {
       delete_items($_POST["deleted"]);
    }
    header("Location:index.php");
}
?>