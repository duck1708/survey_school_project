<?php include 'db_connect.php' ?>
    <?php
    $id = $_GET['id'];
	$check = $conn->query("SELECT distinct(id_khaosat) from cau_tra_loi where id_nguoidung = {$_SESSION['login_id']} and id_khaosat = $id ");
	if($check->num_rows > 0) {
		echo 'Ban da tham gia khao sat';
		return;
   }
    $survey = $conn->query("SELECT * FROM khao_sat where id = $id ");
    $row=$survey->fetch_assoc();
	$qry = $conn->query("SELECT * FROM khao_sat where id = ".$_GET['id'])->fetch_array();
	foreach($qry as $k => $v){
		if($k == 'title')
			$k = 'stitle';
		$$k = $v;
	}
	$taken = $conn->query("SELECT distinct(id_nguoidung) from cau_tra_loi where id_khaosat ={$id}")->num_rows;
	$answers = $conn->query("SELECT a.*,q.loai_cau_hoi from cau_tra_loi a inner join cau_hoi q on q.id = a.id_cauhoi where a.id_khaosat ={$id}");
	$ans = array();
	
	while($row=$answers->fetch_assoc()){
		if($row['loai_cau_hoi'] == 'radio_opt'){
			$ans[$row['id_cauhoi']][$row['noi_dung']][] = 1;
		}
		if($row['loai_cau_hoi'] == 'check_opt'){
			foreach(explode(",", str_replace(array("[","]"), '', $row['noi_dung'])) as $v){
			$ans[$row['id_cauhoi']][$v][] = 1;
			}
		}
		if($row['loai_cau_hoi'] == 'textfield_s'){
			$ans[$row['id_cauhoi']][] = $row['noi_dung'];
		}
	}
?>
<div class="col-lg-12">
	<div class="row">
		<div class="col-md-4">
			<div class="card card-outline card-primary">
				<div class="card-header">
					<h3 class="card-title"><b>Chi tiết khảo sát</b></h3>
				</div>
				<div class="card-body p-0 py-2">
					<div class="container-fluid">
						<p>Tiêu đề: <b><?php echo $ten_khao_sat ?></b></p>
						<p>Loại Khảo Sát : 
							<small><?php if ($loai_khao_sat == 1) echo 'Mục tiêu chương trình đào tạo';
								elseif ($loai_khao_sat == 2) echo 'Đội ngũ giảng viên';
								elseif ($loai_khao_sat == 3) echo 'Công tác tổ chức đào tạo';
								elseif ($loai_khao_sat == 4) echo 'Phòng đào tạo';
								elseif ($loai_khao_sat == 5) echo 'Thư viện';
								elseif ($loai_khao_sat == 6) echo 'Căng tin';
								elseif ($loai_khao_sat == 7) echo 'Một số hoạt động khác của trường';?></small>
							<p>Bắt đầu: <b><?php echo date("d/m/Y",strtotime($ngay_bat_dau)) ?></b></p>
							<p>Kết thúc: <b><?php echo date("d/m/Y",strtotime($ngay_ket_thuc)) ?></b></p>
							<?php if ($loai_khao_sat == 2){
							$chi_tiet_khao_sat = explode(",", $chi_tiet);
							echo(
								"<div>
								<p>Khoa: <b>$chi_tiet_khao_sat[0]</b></p>
								<p>Lớp: <b>$chi_tiet_khao_sat[1]</b></p>
								<p>Tên Giáo Viên: <b>$chi_tiet_khao_sat[2]</b></p>
								<p>Môn Học: <b>$chi_tiet_khao_sat[3]</b></p>
								</div>");
							}								
							?>
						</p>
					</div>
					<hr class="border-primary">
				</div>
			</div>
		</div>
        <div class="col-md-8">
			<div class="card card-outline card-success">
				<div class="card-header">
					<h3 class="card-title"><b><?php echo $ten_khao_sat.'</br>'; ?></b></h3>
				</div>
				<form action="" id="question">
				<div class="card-body ui-sortable">
					<?php 
					$question = $conn->query("SELECT * FROM cau_hoi where id_khaosat = $id order by abs(thu_tu) asc,abs(id) asc");
					while($row=$question->fetch_assoc()):	
					?>
					<div class="callout callout-info">
						<h5><?php echo $row['noi_dung'] ?></h5>
						<div class="col-md-12">
                            <input type="hidden" name="qid[]" value="<?php echo $row['id'] ?>">	
                            <?php
                                if($row['loai_cau_hoi'] == 'radio_opt'):
                                    foreach(json_decode($row['lua_chon']) as $k => $v):
                            ?>
                                <div class="icheck-primary">
                                    <input type="radio" id="option_<?php echo $k ?>" name="answer[<?php echo $row['id'] ?>]" value="<?php echo $k ?>" checked="">
                                    <label for="option_<?php echo $k ?>"><?php echo $v ?></label>
                                </div>
                                <?php endforeach; ?>
                            <?php elseif($row['loai_cau_hoi'] == 'check_opt'):
                                        foreach(json_decode($row['lua_chon']) as $k => $v):
                                ?>
                                <div class="icheck-primary">
                                    <input type="checkbox" id="option_<?php echo $k ?>" name="answer[<?php echo $row['id'] ?>][]" value="<?php echo $k ?>" >
                                    <label for="option_<?php echo $k ?>"><?php echo $v ?></label>
                                </div>
                                    <?php endforeach; ?>
                            <?php else: ?>
                                <div class="form-group">
                                    <textarea name="answer[<?php echo $row['id'] ?>]" id="" cols="30" rows="4" class="form-control" placeholder="Viết gì đó ở đây..."></textarea>
                                </div>
                            <?php endif; ?>
						</div>	
					</div>
					<?php endwhile; ?>
				</div>
                <div class="col-lg-12 text-right justify-content-center d-flex">
					<button class="btn btn-primary mr-2">Lưu</button>
				</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script>
    
	$('#question').submit(function(e){
        formData = new FormData($('#question')[0]);
        formData.append('id', <?php echo $id?>);
		e.preventDefault()
		$('input').removeClass("border-danger")
		start_load()
		$('#msg').html('')
		$.ajax({
			url:'ajax.php?action=save_answer',
			data: formData,
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp == 1){
					alert_toast('Đã lưu dữ liệu thành công.',"success");
					setTimeout(function(){
						location.replace('index.php?page=survey_widget')
					},1500)
				}
			}
		})
	})
</script>



