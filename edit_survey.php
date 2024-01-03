<?php
include 'db_connect.php';
$qry = $conn->prepare("SELECT * FROM khao_sat where id = ?");
$qry->bind_param('s',$_GET['id']);
$qry->execute();

$result = $qry->get_result()->fetch_array();

foreach($result as $k => $v){
	if($k == 'title')
		$k = 'stitle';
	$$k = $v;
}
$list_doi_tuong_tham_gia = explode(",", $doi_tuong_tham_gia);
$chi_tiet_khao_sat = explode(',', $chi_tiet);
include 'new_survey.php';
?>