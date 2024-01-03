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
	
	<form action="" id="manage-password">	
		<input type="hidden" name="id" value="<?php echo isset($meta['id']) ? $meta['id']: '' ?>">
		<div class="form-group">
			<label for="password">Mật khẩu Cũ</label>
			<input type="password" name="oldPassword" id="oldPassword" class="form-control" value="" autocomplete="off" required>
            <small id="#msg"></small>
		</div>
		<div class="form-group">
			<label for="password">Mật khẩu Mới</label>
			<input type="password" name="newPassword" id="newPassword" class="form-control" value="" autocomplete="off" required>
		</div>
		<div class="form-group">
			<label for="password">Xác Nhận Mật Khẩu Mới</label>
			<input type="password" name="cpass" id="cpass" class="form-control" value="" autocomplete="off" required>
            <small id="pass_match" data-status=''></small>
		</div>
		
		
		

	</form>
</div>
<script>
    $('[name="newPassword"],[name="cpass"]').keyup(function(){
        var pass = $('[name="newPassword"]').val()
        var cpass = $('[name="cpass"]').val()
        if(cpass == '' ||pass == ''){
            $('#pass_match').attr('data-status','')
        }else{
            if(cpass == pass){
                $('#pass_match').attr('data-status','1').html('<i class="text-success">Mật khẩu hợp lệ.</i>')
            }else{
                $('#pass_match').attr('data-status','2').html('<i class="text-danger">Mật khẩu xác nhận không đúng.</i>')
            }
        }
    })
	
	$('#manage-password').submit(function(e){
		e.preventDefault();
		start_load()
		$.ajax({
			url:'ajax.php?action=update_password',
			method:'POST',
			data:$(this).serialize(),
			success:function(resp){
				if(resp ==1){
					alert_toast("Đã lưu dữ liệu thành công",'success')
					setTimeout(function(){
						location.reload()
					},1500)
				}else {
					$('#msg').html('<div class="alert alert-danger">Mật khẩu cũ không chính xác</div>')
					end_load()
				}
			}
		})
	})

</script>