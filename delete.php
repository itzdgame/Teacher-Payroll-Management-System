<?php
ob_start();
require_once 'sessions.php';
if($_SESSION['login'] == false) {
    header('location:login.php');
}

require_once 'database.php';
$db = new database();

$t_id = filter_input(INPUT_POST, 't_id');
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $result = $db -> run_query("DELETE FROM `teachers`
                                WHERE t_id='$t_id'");
    if($result){
        echo "<script type='text/javascript'>alert('Teacher Deleted Successfully!!');</script>";


    }else{
        echo "<script type='text/javascript'>alert('Failed!!');</script>";

    }
    header('location:index.php');

}
