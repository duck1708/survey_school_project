<?php include'db_connect.php'; ?>
<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-header">
			<div class="card-tools">
				<a class="btn btn-block btn-sm btn-default btn-flat border-primary" href="./index.php?page=new_survey"><i class="fa fa-plus"></i> Tạo khảo sát</a>
			</div>
		</div>
		<div class="card-body">
			<table class="table tabe-hover table-bordered" id="list">
				<colgroup>
					<col width="5%">
					<col width="20%">
					<col width="20%">
					<col width="20%">
					<col width="20%">
					<col width="15%">
				</colgroup>
				<thead>
					<tr>
						<th class="text-center">STT</th>
						<th>Tên khảo sát</th>
						<th>Loại khảo sát</th>
						<th>Ngày bắt đầu</th>
						<th>Ngày kết thúc</th>
						<th>Lựa chọn</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					$qry = $conn->query("SELECT * FROM khao_sat order by date(ngay_bat_dau) asc,date(ngay_ket_thuc) asc ");
					while($row= $qry->fetch_assoc()):
					?>
					<tr>
						<th class="text-center"><?php echo $i++ ?></th>
						<td><b><?php echo ucwords($row['ten_khao_sat']) ?></b></td>
						<td><b class="truncate"><?php if ($row['loai_khao_sat'] == 1) echo 'Mục tiêu chương trình đào tạo';
						                                elseif ($row['loai_khao_sat'] == 2) echo 'Đội ngũ giảng viên';
                                                        elseif ($row['loai_khao_sat'] == 3) echo 'Công tác tổ chức đào tạo';
                                                        elseif ($row['loai_khao_sat'] == 4) echo 'Phòng đào tạo';
                                                        elseif ($row['loai_khao_sat'] == 5) echo 'Thư viện';
                                                        elseif ($row['loai_khao_sat'] == 6) echo 'Căng tin';
                                                        elseif ($row['loai_khao_sat'] == 7) echo 'Một số hoạt động khác của trường';?></b></td>
						<td><b><?php echo date("d/m/Y",strtotime($row['ngay_bat_dau'])) ?></b></td>
						<td><b><?php echo date("d/m/Y",strtotime($row['ngay_ket_thuc'])) ?></b></td>
						<td class="text-center">
		                    <div class="btn-group">
		                        <a href="./index.php?page=edit_survey&id=<?php echo $row['id'] ?>" class="btn btn-primary btn-flat">
		                          <i class="fas fa-edit"></i>
		                        </a>
		                        <a  href="./index.php?page=view_survey&id=<?php echo $row['id'] ?>" class="btn btn-info btn-flat">
		                          <i class="fas fa-eye"></i>
		                        </a>
		                        <button type="button" class="btn btn-danger btn-flat delete_survey" data-id="<?php echo $row['id'] ?>">
		                          <i class="fas fa-trash"></i>
		                        </button>
	                      </div>
						</td>
					</tr>	
				<?php endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
	$('.delete_survey').click(function(){
	_conf("Bạn có chắc chắn xóa khảo sát này không?","delete_survey",[$(this).attr('data-id')])
	})
	})
	function delete_survey($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_survey',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Đã xóa khảo sát thành công",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
</script>
