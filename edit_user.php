<?php
include 'db_connect.php';
$qry = $conn->prepare("SELECT * FROM nguoi_dung where id = ?");
$qry->bind_param('s',$_GET['id']);
$qry->execute();

$result = $qry->get_result()->fetch_array();

foreach($result as $k => $v){
    $$k = $v;
}
include 'new_user.php';
?>