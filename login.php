<?php 
session_start();
include('./db_connect.php');
?>
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Đăng Nhập | Hệ thống khảo sát trực tuyến</title>
 	

<?php include('./header.php'); ?>
<?php 
if(isset($_SESSION['login_id']))
    header("location:index.php?page=home");
?>

</head>
<style>
body{
		width: 100%;
	    height: calc(100%);
	    position: fixed;
	    top:0;
	    left: 0
	}
main#main{
		width:100%;
		height: calc(100%);
		display: flex;
		background-image:url("./assets/dist/img/login.png");
		background-size: 100%;
	}
.login-form{
		display: inline;
	}
.card{
		margin-bottom: 0rem;
	}
.signup__overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-image:url("./assets/dist/img/60.png");
    background-repeat: no-repeat;
    background-position: 50% center;
    background-size: 75%;
}
.signup__container{
	position: absolute;
    top: 50%;
    right: 0;
    left: 0;
    margin-right: auto;
    margin-left: auto;
    -webkit-transform: translateY(-50%);
    transform: translateY(-50%);
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 50rem;
    height: 30rem;
    border-radius: 0.1875rem;
    box-shadow: 0px 0.1875rem 0.4375rem rgb(0 0 0 / 25%)
	}
.container__child {
    width: 50%;
    height: 100%;
    color: #fff;
}
.signup__thumbnail {
    position: relative;
    padding: 2rem;
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    background: linear-gradient(to right, #67D7F5, #86F7CC);
    background-repeat: no-repeat;
    background-position: 50% center;
    background-size: 100%;
}
.signup__form {
    padding: 2.5rem;
    background: #fafafa;
}
label {
    font-size: .85rem;
    text-transform: uppercase;
    color: #000;
}
.title-login{
	color:#000;
}
</style>

<body class="bg-dark">
  <main id="main" >
	 <div class="signup__container">
  		<div class="container__child signup__thumbnail col-md-6">
    		<div class="signup__overlay"></div>
  		</div>
  			<div class="container__child signup__form col-md-6">
			  <h4 class="title-login">Hệ thống khảo sát trực tuyến</h4>
 				 <form id="login-form" >
					<div class="form-group" style="margin-top:90px">
						<label for="email" class="control-label text-dark">Tên Đăng Nhập</label>
						<input type="text" id="email" name="email" class="form-control form-control-sm">
					</div>
					<div class="form-group">
						<label for="password" class="control-label text-dark">Mật khẩu</label>
						<input type="password" id="password" name="password" class="form-control form-control-sm">
        			</div>
			  		<center><button class="btn-sm btn-block btn-wave col-md-4 btn-primary">Đăng nhập</button></center>
			  	</form>  
       		 </div>
 	 </div>
  
</div>
  </main>

  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>


</body>
<script>
	$('#login-form').submit(function(e){
		e.preventDefault()
		$('#login-form button[type="button"]').attr('disabled',true).html('Đăng nhập...');
		if($(this).find('.alert-danger').length > 0 )
			$(this).find('.alert-danger').remove();
		$.ajax({
			url:'ajax.php?action=login',
			method:'POST',
			data:$(this).serialize(),
			error:err=>{
				console.log(err)
		        $('#login-form button[type="button"]').removeAttr('disabled').html('Login');

			},
			success:function(resp){
				if(resp == 1){
					location.href ='index.php?page=home';
				}else{
                    if (document.getElementById('email').value == '' || document.getElementById('password').value == '') {
                        $('#login-form').append('<div class="alert alert-danger" style = "top:20px">Vui lòng nhập đầy đủ thông tin</div>');
                        $('#login-form button[type="button"]').removeAttr('disabled').html('Login');
                    }
                    else {
                        $('#login-form').append('<div class="alert alert-danger" style = "top:20px">Tên đăng nhập hoặc tài khoản của bạn không chính xác.</div>')
                        $('#login-form button[type="button"]').removeAttr('disabled').html('Login');
                    }
				}
			}
		})
	})
	$('.number').on('input',function(){
        var val = $(this).val()
        val = val.replace(/[^0-9 \,]/, '');
        $(this).val(val)
    })
</script>	
</html>