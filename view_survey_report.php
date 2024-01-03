<?php include 'db_connect.php' ?>
<?php 
$qry = $conn->query("SELECT * FROM khao_sat where id = ".$_GET['id'])->fetch_array();
foreach($qry as $k => $v){
	if($k == 'title')
		$k = 'stitle';
	$$k = $v;
}
$mon_hoc = $conn -> query("SELECT * FROM mon_hoc");
$taken = $conn->query("SELECT distinct(id_nguoidung) from cau_tra_loi where id_khaosat ={$id}")->num_rows;
?>
<style>
	.tfield-area{
		max-height: 30vh;
		overflow: auto;
	}
</style>
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
								<small>
								<?php if ($loai_khao_sat == 1) echo 'Mục tiêu chương trình đào tạo';
									elseif ($loai_khao_sat == 2) echo 'Đội ngũ giảng viên';
									elseif ($loai_khao_sat == 3) echo 'Công tác tổ chức đào tạo';
									elseif ($loai_khao_sat == 4) echo 'Phòng đào tạo';
									elseif ($loai_khao_sat == 5) echo 'Thư viện';
									elseif ($loai_khao_sat == 6) echo 'Căng tin';
									elseif ($loai_khao_sat == 7) echo 'Một số hoạt động khác của trường';?></small>
							</p>
							<p>Bắt đầu: <b><?php echo date("d/m/Y",strtotime($ngay_bat_dau)) ?></b></p>
							<p>Kết thúc: <b><?php echo date("d/m/Y",strtotime($ngay_ket_thuc)) ?></b></p>
							<?php if ($loai_khao_sat == 2) {
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
							<p>Số lượng người tham gia: <b><?php echo number_format($taken) ?></b></p>
					</div>
					<hr class="border-primary">
				</div>
			</div>
			<div class="card card-outline card-primary">
				<div class="card-header">
					<h3 class="card-title"><b>Lọc Khảo Sát</b></h3>
				</div>
				<form method="post" id='conds' class="card-body p-0 py-2">
					<div class="container-fluid">
						<p><b>Chức Vụ</b><br>
						<input type="checkbox" id="" name="chucVu[]" value="3">
						<label for=""> Sinh Viên</label><br>
						<input type="checkbox" id="" name="chucVu[]" value="2">
						<label for=""> Giảng Viên</label><br>
						<input type="checkbox" id="" name="chucVu[]" value="4">
						<label for=""> Doanh Nghiệp</label><br>
						<input type="checkbox" id="" name="chucVu[]" value="5">
						<label for=""> Cựu Sinh Viên</label>
						</p>
						<p><b>Giới Tính</b><br>
						<input type="checkbox" id="" name="gioiTinh[]" value="1">
						<label for=""> Nam</label><br>
						<input type="checkbox" id="" name="gioiTinh[]" value="0">
						<label for=""> Nữ</label><br>
						</p>
                        <p><b>Môn học</b><br>
                        <?php while($row = $mon_hoc -> fetch_assoc()):
                        ?>
                            <input type="checkbox" id="" name="monHoc[]" value="<?php echo $row['ten_mon_hoc']?>">
                            <label class="AA" for=""><?php echo $row['ten_mon_hoc']?></label><br>
                        <?php endwhile; ?>
						<p><b>Điểm</b><br>				
						<input type="checkbox" id="" name="" value="">
						<label class="AA" for=""> A</label>
						<input type="checkbox" id="" name="" value="">
						<label class="AA" for=""> B</label>
						<input type="checkbox" id="" name="" value="">
						<label class="AA" for=""> C</label>
						<input type="checkbox" id="" name="" value="">
						<label class="AA" for=""> D</label>
						<input type="checkbox" id="" name="" value="">
						<label class="AA" for=""> F</label>
						</p>
                        <button class="btn btn-primary mr-2" type="submit" id='reload' name="submitButton">Lọc khảo sát</button>

					</div>
					<hr class="border-primary">
				</form>
			</div>
		</div>
		
		<div class="col-md-8">
			<div class="card card-outline card-success">
				<div class="card-header">
					<h3 class="card-title"><b>Báo cáo khảo sát</b></h3>
					<div class="card-tools">
						<button class="btn btn-flat btn-sm bg-gradient-success" type="button" id="print"><i class="fa fa-print"></i> In</button>
					</div>
				</div>
				<div id='scores' class="card-body ui-sortable">
					<?php
                    include 'view_survey_report_conds.php';
					$question = $conn->query("SELECT * FROM cau_hoi where id_khaosat = $id order by abs(thu_tu) asc,abs(id) asc");
					while($row=$question->fetch_assoc()):	
					?>
					<div class="callout callout-info">
						<h5><?php echo $row['noi_dung'] ?></h5>
						<div class="col-md-12">
						<input type="hidden" name="qid[<?php echo $row['id'] ?>]" value="<?php echo $row['id'] ?>">	
						<input type="hidden" name="type[<?php echo $row['id'] ?>]" value="<?php echo $row['loai_cau_hoi'] ?>">
							
							<?php if($row['loai_cau_hoi'] != 'textfield_s'):?>
								<ul>
							<?php foreach(json_decode($row['lua_chon']) as $k => $v):
								$prog = ((isset($ans[$row['id'][0]][$k]) ? count($ans[$row['id'][0]][$k]) : 0) / ($taken == 0 ? 1 : $taken)) * 100;
								$prog = round($prog,2);
								?>
								<li>
									<div class="d-block w-100">
										<b><?php echo $v ?></b>
									</div>
									<div class="d-flex w-100">
									<span class=""><?php echo isset($ans[$row['id'][0]][$k]) ? count($ans[$row['id'][0]][$k]) : 0 ?>/<?php echo $taken ?></span>
									<div class="mx-1 col-sm-8"">
									<div class="progress w-100" >
					                  <div class="progress-bar bg-primary progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $prog ?>%">
					                    <span class="sr-only"><?php echo $prog ?>%</span>
					                  </div>
					                </div>
					                </div>
					                <span class="badge badge-info"><?php echo $prog ?>%</span>
									</div>
								</li>
								<?php endforeach; ?>
								</ul>
						<?php else: ?>
							<div class="d-block tfield-area w-100 bg-dark">
								<?php if(isset($ans[$row['id'][0]])): ?>
								<?php foreach($ans[$row['id'][0]] as $val): ?>
								<blockquote class="text-dark"><?php echo $val ?></blockquote>
								<?php endforeach; ?>
								<?php endif; ?>
							</div>
						<?php endif; ?>
						</div>	
					</div>
					<?php endwhile; ?>
				</div>
			</div>
		</div>
	</div>
</div>
<style>
	.AA{
		padding-right: 15px;
	}
</style>