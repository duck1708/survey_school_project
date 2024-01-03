<?php include 'db_connect.php' ?>
<?php 
$answers = $conn->query("SELECT distinct(id_khaosat) from cau_tra_loi where id_nguoidung ={$_SESSION['login_id']}");
$ans = array();
while($row=$answers->fetch_assoc()){
	$ans[$row['id_khaosat']] = 1;
}
?>
<div class="col-lg-12">
	<div class="d-flex w-100 justify-content-center align-items-center mb-2">
		<label for="" class="control-label">Tìm khảo sát</label>
		<div class="input-group input-group-sm col-sm-5">
          <input type="text" class="form-control" id="filter" placeholder="Nhập từ khóa...">
          <span class="input-group-append">
		  <input type="date" id="date" style="display: none">
            <button type="button" class="btn btn-primary btn-flat" id="search">Tìm kiếm</button>
          </span>
		  <button type="button" id = "date_search" onclick="myFunction()" style="border-radius: 0rem 0.2rem 0.2rem 0rem;" class="button_search"><i class="far fa-calendar"></i> Tìm kiếm bằng ngày bắt đầu</button>
        </div>
	</div>
	<div class=" w-100" id='ns' style="display: none"><center><b style="color: red">Không có kết quả</b></center></div>
	<div class="row">
		<?php 
		$chucvu = $_SESSION['login_chuc_vu'];
		if (isset($_GET["date"])) {
			$date = $_GET["date"];
			$survey = $conn->query("SELECT * FROM khao_sat where doi_tuong_tham_gia like '%$chucvu%' and ngay_bat_dau = '$date' order by rand() ");
		}else {
			$survey = $conn->query("SELECT * FROM khao_sat where doi_tuong_tham_gia like '%$chucvu%'  and '".date('Y-m-d')."' between date(ngay_bat_dau) and date(ngay_ket_thuc) order by rand() ");
		}
		while($row=$survey->fetch_assoc()):
		?>
		<div class="col-md-3 py-1 px-1 survey-item">
			<div class="card card-outline card-primary">
              <div class="card-header">
                <h3 class="card-title"><?php echo ucwords($row['ten_khao_sat']) ?></h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="card-body" style="display: block;">
				<?php if ($row['loai_khao_sat'] == 1) echo 'Mục tiêu chương trình đào tạo';
					elseif ($row['loai_khao_sat'] == 2) echo 'Đội ngũ giảng viên';
					elseif ($row['loai_khao_sat'] == 3) echo 'Công tác tổ chức đào tạo';
					elseif ($row['loai_khao_sat'] == 4) echo 'Phòng đào tạo';
					elseif ($row['loai_khao_sat'] == 5) echo 'Thư viện';
					elseif ($row['loai_khao_sat'] == 6) echo 'Căng tin';
					elseif ($row['loai_khao_sat'] == 7) echo 'Một số hoạt động khác của trường';
					?>
               <div class="row">
               	<hr class="border-primary">
               	<div class="d-flex justify-content-center w-100 text-center">
               		<?php if(!isset($ans[$row['id']])): ?>
               			<a href="index.php?page=answer_survey&id=<?php echo $row['id'] ?>" class="btn btn-sm bg-gradient-primary" style="margin-top: 10px"><i class="fa fa-pen-square"></i>  Đi khảo sát</a>
               		<?php else: ?>
               			<p class="text-primary border-top border-primary text-KS">Hoàn thành</p>
               		<?php endif; ?>
               	</div>
               </div>
              </div>
            </div>
		</div>
	<?php endwhile; ?>
	</div>
</div>
<style>
	.text-KS{
		margin-top: 10px;

	}
	.button_search{
    font-size: .875rem;
    line-height: 1.5;
    background-color: #f6f2f2;
    border-color: #ced4da;
	border-width: 1px;
    box-shadow: none;
	border: 1px solid #ced4da;
	cursor: pointer;
	text-decoration: none;
  	display: inline-block;
	border-left: none;
	}
	.button_search:hover{
		background-color: #e7e7e7;
	}
</style>
<script>
	function find_survey(){
		start_load()
		var filter = $('#filter').val()
			filter = filter.toLowerCase()
			console.log(filter)
		$('.survey-item').each(function(){
			var txt = $(this).text()
			if((txt.toLowerCase()).includes(filter) == true){
				$(this).toggle(true)
			}else{
				$(this).toggle(false)
			}
			if($('.survey-item:visible').length <= 0){
				$('#ns').show()
			}else{
				$('#ns').hide()
			}
		})
		end_load()
	}
	$('#search').click(function(){
		find_survey()
		if (document.getElementById("date").value != '') {
			window.location = 'index.php?page=survey_widget&date='+document.getElementById("date").value;
		}
		<?php if (isset($_GET["date"])) {
			echo("if (document.getElementById('date').value == '') {");
			echo("window.location = 'index.php?page=survey_widget';
			}");
			}
		?>
	})
	$('#filter').keypress(function(e){
		if(e.which == 13){
		find_survey()
		return false;
		}
	})
	// $('#date_search').click(function() {
    //    if(this.click){
	// 		$('#date').show()
	// 	}else{
	// 		$('#date').hide()
	// 	}
    //   });
function myFunction() {
  var loaddate = document.getElementById("date");
  if (loaddate.style.display === "none") {
    loaddate.style.display = "block";
  } else {
    loaddate.style.display = "none";
  }
}
</script>