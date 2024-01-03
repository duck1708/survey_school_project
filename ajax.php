<?php
ob_start();
session_start();
$action = $_GET['action'];
include './classes/Admin.php';
include 'classes/Question.php';
include 'classes/Survey.php';
$crud = new User();
$question = new Question();
$survey = new Survey();
if (isset($_SESSION['login_chuc_vu']) and $_SESSION['login_chuc_vu'] == 1) {
	$crud = new Admin();
}
if($action == 'login'){
	$login = $crud->dangNhap();
	if($login)
		echo $login;
}
if($action == 'logout'){
	$logout = $crud->dangXuat();
	if($logout)
		echo $logout;
}

if($action == 'update_password'){
	$uPass = $crud->doiMatKhau();
	if($uPass)
		echo $uPass;
}

if($action == 'save_user'){
	extract($_POST);
	$save_user = new User();
	$save_user -> createUser($_POST['id'], $_POST['email'], $_POST['password'], $_POST['ten'], $_POST['diaChi'], $_POST['soDT'], $_POST['chuc_vu'], $_POST['gioiTinh'], $_POST['khoa'], $_POST['lop'], $_POST['nam']);
	$res = $crud -> themTaiKhoan($save_user);
	if ($res) {
		echo $res;
	}
}

if($action == 'update_user'){
	$update = $crud->suaTaiKhoan();
	if($update)
		echo $update;
}

if ($action == 'delete_user') {
	$res = $crud -> xoaTaiKhoan();
	if ($res) {
		echo $res;
	}
}

if ($action == 'save_survey') {
	$res = $survey -> taoKhaoSat();
	if ($res) {
		echo $res;
	}
}

if ($action == 'delete_survey') {
	$res = $survey -> xoaKhaoSat();
	if ($res) {
		echo $res;
	}
}

if ($action == 'save_question') {
	$res = $question -> themCauHoi();
	if ($res) {
		echo $res;
	}
}

if ($action == 'delete_question') {
	$res = $question -> xoaCauHoi();
	if ($res) {
		echo $res;
	}
}

if ($action == 'action_update_qsort') {
	$res = $question -> thuTuCauHoi();
	if ($res) {
		echo $res;
	}
}

if ($action == 'save_answer') {
	$res = $crud -> luuCauTraLoi();
	if ($res) {
		echo $res;
	}
}

ob_end_flush();
?>
