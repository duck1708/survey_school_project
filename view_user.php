<?php include 'db_connect.php' ?>
<?php
if(isset($_GET['id'])){
	$type_arr = array('',"Admin","Sinh Viên","Giảng Viên", "Doanh nghiệp");
	$qry = $conn->query("SELECT * FROM nguoi_dung where id = ".$_GET['id'])->fetch_array();
foreach($qry as $k => $v){
	$$k = $v;
}
}
?>
<div class="container-fluid">
	<table class="table">
		<tr>
			<th>Tên:</th>
			<td><b><?php echo ucwords($ten) ?></b></td>
		</tr>
		<tr>
			<th>Email:</th>
			<td><b><?php echo $email ?></b></td>
		</tr>
		<tr>
			<th>Số điện thoại:</th>
			<td><b><?php echo $so_dt ?></b></td>
		</tr>
		<tr>
			<th>Địa chỉ:</th>
			<td><b><?php echo $dia_chi ?></b></td>
		</tr>
		<tr>
			<th>Vai Trò Người Dùng:</th>
			<td><b><?php echo $type_arr[$chuc_vu] ?></b></td>
		</tr>
	</table>
</div>
<div class="modal-footer display p-0 m-0">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
</div>
<style>
	#uni_modal .modal-footer{
		display: none
	}
	#uni_modal .modal-footer.display{
		display: flex
	}
</style>