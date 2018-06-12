<?php
require_once 'database.php';
$db = new database();
//echo '<pre>';
////print_r($_GET);
////print_r($_SERVER);
//echo '</pre>';
if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['t_id'])) {
    $t_id = filter_input(INPUT_GET, 't_id');
    $sql = "SELECT * FROM teachers WHERE t_id='$t_id'";
    $result = $db -> run_query($sql);
//    print_r($result);
    $data =array();
    foreach($result as $key => $value){
        array_push($data, $value);
    }
//    print_r($data);
    echo  json_encode($data);
}else{
    echo  'not working';
}