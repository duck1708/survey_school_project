<?php 
include('db_connect.php');
session_start();
$utype = array('','admin','Sinh Viên','Giảng Viên', 'Doanh Nghiệp');
if(isset($_GET['id'])){
$user = $conn->query("SELECT * FROM nguoi_dung where id =".$_GET['id']);
foreach($user->fetch_array() as $k =>$v){
	$meta[$k] = $v;
}
}
?>
<div class="container-fluid">
	<div id="msg"></div>
	<form action="" id="manage-user">	
		<input type="hidden" name="id" value="<?php echo isset($meta['id']) ? $meta['id']: '' ?>">
		<div class="row">
			<div class="col-md-6 border-right">
				<div class="form-group">
					<label for="name" class="control-label">Tên</label>
					<input type="text" name="ten" id="ten" class="form-control" value="<?php echo $meta['ten'] ?>" required>
				</div>
				<div class="form-group">
					<label for="name" class="control-label">Số Điện Thoại</label>
					<input type="text" name="so_dt" id="so_dt" class="form-control" value="<?php echo $meta['so_dt'] ?>" required>
				</div>
				<div class="form-group">
					<label for="username" class="control-label">Email</label>
					<input type="text" name="email" id="email" class="form-control" value="<?php echo isset($meta['email']) ? $meta['email']: '' ?>" required  autocomplete="off">
				</div>
				<div class="form-group">
                            <label for="" class="control-label">Giới Tính</label>
                            <select type="type" name="gioi_tinh" class="custom-select custom-select-sm">
                                <option value="1" <?php echo isset($meta['gioi_tinh']) && $meta['gioi_tinh'] == 1 ? 'selected' : '' ?>>Nam</option>
                                <option value="0" <?php echo isset($meta['gioi_tinh']) && $meta['gioi_tinh'] == 0 ? 'selected' : '' ?>>Nữ</option>
                            </select>
                 </div>
                <div class="form-group">
                    <label for="name" class="control-label">Địa Chỉ</label>
                    <input type="text" name="dia_chi" id="dia_chi" class="form-control" value="<?php echo $meta['dia_chi'] ?>" required>
                </div>
			</div>
			<div class="col-md-6">
				<div class="form-group" >
					<label for="name" class="control-label">Khoa</label>
					<input type="text" name="khoa" id="khoa" class="form-control" value="<?php echo $meta['khoa'] ?>" required>
				</div>
				<div class="form-group">
					<label for="name" class="control-label">Lớp</label>
					<input type="text" name="lop" id="lop" class="form-control" value="<?php echo $meta['lop'] ?>" required>
				</div>
                <div class="form-group">
                    <label for="name" class="control-label">Năm học</label>
                    <input type="text" name="nam" id="nam" class="form-control" value="<?php echo $meta['nam'] ?>" required>
                </div>
				<div class="form-group">
					<label for="name" class="control-label">Chức Vụ</label>
					<input type="text" name="chucVu" id="chucVu" disabled="disabled" class="form-control" value="<?php if (isset($meta['chuc_vu'])) {
					        if ($meta['chuc_vu'] == 1) echo 'Admin';
                            if ($meta['chuc_vu'] == 2) echo 'Giảng Viên';
                            if ($meta['chuc_vu'] == 3) echo 'Sinh Viên';
                            if ($meta['chuc_vu'] == 4) echo 'Doanh nghiệp';
                            if ($meta['chuc_vu'] == 5) echo 'Cựu Sinh Viên';
                    } ?>" required>
				</div>
			</div>
		</div>
	</form>
</div>
<script>
	
	$('#manage-user').submit(function(e){
		e.preventDefault();
		start_load()
		$.ajax({
			url:'ajax.php?action=update_user',
			method:'POST',
			data:$(this).serialize(),
			success:function(resp){
				if(resp ==1){
					alert_toast("Sửa tài khoản thành công",'success')
					setTimeout(function(){
						location.reload()
					},1500)
				}else{
					$('#msg').html('<div class="alert alert-danger">Tên người dùng đã tồn tại</div>')
					end_load()
				}
			}
		})
	})

</script>