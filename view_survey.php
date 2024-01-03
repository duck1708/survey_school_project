<?php include 'db_connect.php' ?>
<?php 
$qry = $conn->query("SELECT * FROM khao_sat where id = ".$_GET['id'])->fetch_array();
foreach($qry as $k => $v){
	if($k == 'title')
		$k = 'stitle';
	$$k = $v;
}
$answers = $conn->query("SELECT distinct(id_nguoidung) from cau_tra_loi where id_khaosat ={$id}")->num_rows;
?>
<div class="col-lg-12">
	<div class="row">
		<div class="col-md-4">
			<div class="card card-outline card-primary">
				<div class="card-header">
					<h3 class="card-title">Chi Tiết khảo sát</h3>
				</div>
				<div class="card-body p-0 py-2">
					<div class="container-fluid">
						<p>Tên: <b><?php echo $ten_khao_sat ?></b></p>
						<p class="mb-0">Loại khảo sát:</p>
						<small><?php if ($loai_khao_sat == 1) echo 'Mục tiêu chương trình đào tạo';
                            elseif ($loai_khao_sat == 2) echo 'Đội ngũ giảng viên';
                            elseif ($loai_khao_sat == 3) echo 'Công tác tổ chức đào tạo';
                            elseif ($loai_khao_sat == 4) echo 'Phòng đào tạo';
                            elseif ($loai_khao_sat == 5) echo 'Thư viện';
                            elseif ($loai_khao_sat == 6) echo 'Căng tin';
                            elseif ($loai_khao_sat == 7) echo 'Một số hoạt động khác của trường';?></small>
						<p>Bắt đầu: <b><?php echo date("d/m/Y",strtotime($ngay_bat_dau)) ?></b></p>
						<p>Kết thúc: <b><?php echo date("d/m/Y",strtotime($ngay_ket_thuc)) ?></b></p>
						<p>Số lượng người tham gia: <b><?php echo number_format($answers) ?></b></p>

					</div>
					<hr class="border-primary">
				</div>
			</div>
		</div>
		<div class="col-md-8">
			<div class="card card-outline card-success">
				<div class="card-header">
					<h3 class="card-title"><b>Bảng câu hỏi khảo sát</b></h3>
					<div class="card-tools">
						<button class="btn btn-block btn-sm btn-default btn-flat border-success new_question" type="button"><i class="fa fa-plus"></i> Thêm câu hỏi mới</button>
					</div>
				</div>
				<form action="" id="manage-sort">
				<div class="card-body ui-sortable">
					<?php 
					$question = $conn->query("SELECT * FROM cau_hoi where id_khaosat = $id order by abs(thu_tu) asc,abs(id) asc");
					while($row=$question->fetch_assoc()):	
					?>
					<div class="callout callout-info">
						<div class="row">
							<div class="col-md-12">	
								<span class="dropleft float-right">
									<a class="fa fa-ellipsis-v text-dark" href="javascript:void(0)" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></a>
									<div class="dropdown-menu" style="">
								        <a class="dropdown-item edit_question text-dark" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">Sửa</a>
								        <div class="dropdown-divider"></div>
								        <a class="dropdown-item delete_question text-dark" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">Xóa</a>
								     </div>
								</span>	
							</div>	
						</div>	
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
				</form>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('.ui-sortable').sortable({
			placeholder: "ui-state-highlight",
			 update: function( ) {
			 	alert_toast("Lưu thứ tự câu hỏi?","info")
		        $.ajax({
		        	url:"ajax.php?action=action_update_qsort",
		        	method:'POST',
		        	data:$('#manage-sort').serialize(),
		        	success:function(resp){
		        		if(resp == 1){
			 				alert_toast("Đã lưu thứ tự câu hỏi","success")
		        		}
		        	}
		        })
		    }
		})
	})
	$('.new_question').click(function(){
		uni_modal("Câu hỏi mới","manage_question.php?sid=<?php echo $id ?>","large")
	})
	$('.edit_question').click(function(){
		uni_modal("Câu hỏi mới","manage_question.php?sid=<?php echo $id ?>&id="+$(this).attr('data-id'),"large")
	})
	
	$('.delete_question').click(function(){
	_conf("Bạn có chắc muốn xóa câu hỏi này không?","delete_question",[$(this).attr('data-id')])
	})
	function delete_question($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_question',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Đã xóa thành công",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
</script>