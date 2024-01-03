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
            <button type="button" class="btn btn-primary btn-flat" id="search">Tìm kiếm</button>
          </span>
        </div>
	</div>
	<div class=" w-100" id='ns' style="display: none"><center><b>Không có kết quả</b></center></div>
	<div class="row">
		<?php 
		$survey = $conn->query("SELECT * FROM khao_sat");
		while($row=$survey->fetch_assoc()):
            
		?>
        <?php if(!isset($ans[$row['id']])): ?>
        <?php else: ?>
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
               		<a href="index.php?page=view_survey_history&id=<?php echo $row['id'] ?>" class="btn btn-sm bg-gradient-primary" style="margin-top: 10px"><i class="fa fa-pen-square"></i>  Xem </a>
               	</div>
               </div>
              </div>
            </div>
		</div>
        <?php endif; ?>
	<?php endwhile; ?>
	</div>
</div>
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
	})
	$('#filter').keypress(function(e){
		if(e.which == 13){
		find_survey()
		return false;
		}
	})
</script>