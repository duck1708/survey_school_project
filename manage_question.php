<?php include 'db_connect.php' ?>
<?php
if(isset($_GET['id'])){
	$qry = $conn->query("SELECT * FROM cau_hoi where id = ".$_GET['id'])->fetch_array();
foreach($qry as $k => $v){
	$$k = $v;
}
}
?>
<div class="container-fluid">
	<form action="" id="manage-question">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-sm-6 border-right">
						<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
						<input type="hidden" name="sid" value="<?php echo isset($_GET['sid']) ? $_GET['sid'] : '' ?>">
						<div class="form-group">
							<label for="" class="control-label">Câu hỏi</label>
							<textarea name="question" id="" cols="30" rows="4" class="form-control" required><?php echo isset($noi_dung)? $noi_dung: '' ?></textarea>
						</div>
						<div class="form-group">
							<label for="" class="control-label">Loại câu hỏi câu trả lời</label>
							<select name="type" id="type" class="custom-select custom-select-sm">
								<?php if(isset($id)): ?>
								<option value="" disabled="" selected="">Vui lòng chọn ở đây</option>
								<?php endif; ?>
								<option value="radio_opt" <?php echo isset($loai_cau_hoi) && $loai_cau_hoi == 'radio_opt' ? 'selected':'' ?>>Trả lời đơn/Radio button</option>
								<option value="check_opt" <?php echo isset($loai_cau_hoi) && $loai_cau_hoi == 'check_opt' ? 'selected':'' ?>>Nhiều câu trả lời/Check boxs</option>
								<option value="textfield_s" <?php echo isset($loai_cau_hoi) && $loai_cau_hoi == 'textfield_s' ? 'selected':'' ?>>Văn bản/Text area</option>
							</select>
						</div>
						
				</div>
				<div class="col-sm-6">
					<b>Xem trước</b>
					<div class="preview">
						<?php if(!isset($id)): ?>
						<center><b>Lựa Chọn Câu hỏi Đầu Tiên.</b></center>
						<?php else: ?>
							<div class="callout callout-info">
							<?php if($loai_cau_hoi != 'textfield_s'):
								$opt= $loai_cau_hoi =='radio_opt' ? 'radio': 'checkbox';
							?>
						      <table width="100%" class="table">
						      	<colgroup>
						      		<col width="10%">
						      		<col width="80%">
						      		<col width="10%">
						      	</colgroup>
						      	<thead>
							      	<tr class="">
								      	<th class="text-center"></th>

								      	<th class="text-center">
								      		<label for="" class="control-label">Nhãn</label>
								      	</th>
								      	<th class="text-center"></th>
							     	</tr>
						     	</thead>
						     	<tbody>
						     		<?php  
						     		$i = 0;
						     		foreach(json_decode($lua_chon) as $k => $v):
						     			$i++;
						     		?>
						     		<tr class="">
								      	<td class="text-center">
								      		<div class="icheck-primary d-inline" data-count = '<?php echo $i ?>'>
									        	<input type="<?php echo $opt ?>" id="<?php echo $opt ?>Primary<?php echo $i ?>" name="<?php echo $opt ?>" checked="">
									        	<label for="<?php echo $opt ?>Primary<?php echo $i ?>">
									        	</label>
									        </div>
								      	</td>

								      	<td class="text-center">
								      		<input type="text" class="form-control form-control-sm check_inp"  name="label[]" value="<?php echo $v ?>">
								      	</td>
								      	<td class="text-center"></td>
							     	</tr>
						     		<?php  endforeach; ?>

						     	</tbody>
						      </table>
						      <div class="row">
						      <div class="col-sm-12 text-center">
						      	<button class="btn btn-sm btn-flat btn-default" type="button" onclick="<?php echo $type ?>($(this))"><i class="fa fa-plus"></i> Thêm</button>
						      </div>
						      </div>
						    </div>
						</div>

						<?php else: ?>
								<textarea name="frm_opt" id="" cols="30" rows="10" class="form-control" disabled="" placeholder="Viết một cái gì đó ở đây ..."></textarea>
						<?php endif; ?>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
<div id="check_opt_clone"  style="display: none">
	<div class="callout callout-info">
      <table width="100%" class="table">
      	<colgroup>
      		<col width="10%">
      		<col width="80%">
      		<col width="10%">
      	</colgroup>
      	<thead>
	      	<tr class="">
		      	<th class="text-center"></th>

		      	<th class="text-center">
		      		<label for="" class="control-label">Nhãn</label>
		      	</th>
		      	<th class="text-center"></th>
	     	</tr>
     	</thead>
     	<tbody>
     		<tr class="">
		      	<td class="text-center">
		      		<div class="icheck-primary d-inline" data-count = '1'>
			        	<input type="checkbox" id="checkboxPrimary1" checked="">
			        	<label for="checkboxPrimary1">
			        	</label>
			        </div>
		      	</td>

		      	<td class="text-center">
		      		<input type="text" class="form-control form-control-sm check_inp" name="label[]" required>
		      	</td>
		      	<td class="text-center"></td>
	     	</tr>
	     	<tr class="">
		      	<td class="text-center">
		      		<div class="icheck-primary d-inline" data-count = '2'>
			        	<input type="checkbox" id="checkboxPrimary2" >
			        	<label for="checkboxPrimary2">
			        	</label>
			        </div>
		      	</td>

		      	<td class="text-center">
		      		<input type="text" class="form-control form-control-sm check_inp" name="label[]" required>
		      	</td>
		      	<td class="text-center"></td>
	     	</tr>
     	</tbody>
      </table>
      <div class="row">
      <div class="col-sm-12 text-center">
      	<button class="btn btn-sm btn-flat btn-default" type="button" onclick="new_check($(this))"><i class="fa fa-plus"></i> Thêm</button>
      </div>
      </div>
    </div>
</div>
<div id="radio_opt_clone" style="display: none">
	<div class="callout callout-info">
      <table width="100%" class="table">
      	<colgroup>
      		<col width="10%">
      		<col width="80%">
      		<col width="10%">
      	</colgroup>
      	<thead>
	      	<tr class="">
		      	<th class="text-center"></th>

		      	<th class="text-center">
		      		<label for="" class="control-label">Nhãn</label>
		      	</th>
		      	<th class="text-center"></th>
	     	</tr>
     	</thead>
     	<tbody>
     		<tr class="">
		      	<td class="text-center">
		      		<div class="icheck-primary d-inline" data-count = '1'>
			        	<input type="radio" id="radioPrimary1" name="radio" checked="">
			        	<label for="radioPrimary1">
			        	</label>
			        </div>
		      	</td>

		      	<td class="text-center">
		      		<input type="text" class="form-control form-control-sm check_inp"  name="label[]">
		      	</td>
		      	<td class="text-center"></td>
	     	</tr>
	     	<tr class="">
		      	<td class="text-center">
		      		<div class="icheck-primary d-inline" data-count = '2'>
			        	<input type="radio" id="radioPrimary2" name="radio" >
			        	<label for="radioPrimary2">
			        	</label>
			        </div>
		      	</td>

		      	<td class="text-center">
		      		<input type="text" class="form-control form-control-sm check_inp"  name="label[]">
		      	</td>
		      	<td class="text-center"></td>
	     	</tr>
     	</tbody>
      </table>
      <div class="row">
      <div class="col-sm-12 text-center">
      	<button class="btn btn-sm btn-flat btn-default" type="button" onclick="new_radio($(this))"><i class="fa fa-plus"></i> Thêm</button>
      </div>
      </div>
    </div>
</div>
<div id="textfield_s_clone" style="display: none">
	<div class="callout callout-info">
		<textarea name="frm_opt" id="" cols="30" rows="10" class="form-control" disabled=""  placeholder="Viết một cái gì đó ở đây ..."></textarea>
	</div>
</div>
<script>
	function new_check(_this){
		var tbody=_this.closest('.row').siblings('table').find('tbody')
		var count = tbody.find('tr').last().find('.icheck-primary').attr('data-count')
			count++;
		console.log(count)
		var opt = '';
			opt +='<td class="text-center pt-1"><div class="icheck-primary d-inline" data-count = "'+count+'"><input type="checkbox" id="checkboxPrimary'+count+'"><label for="checkboxPrimary'+count+'"> </label></div></td>';
			opt +='<td class="text-center"><input type="text" class="form-control form-control-sm check_inp" name="label[]" required></td>';
			opt +='<td class="text-center"><a href="javascript:void(0)" onclick="$(this).closest(\'tr\').remove()"><span class="fa fa-times" ></span></a></td>';
		var tr = $('<tr></tr>')
		tr.append(opt)
		tbody.append(tr)
	}
	function new_radio(_this){
		var tbody=_this.closest('.row').siblings('table').find('tbody')
		var count = tbody.find('tr').last().find('.icheck-primary').attr('data-count')
			count++;
		console.log(count)
		var opt = '';
			opt +='<td class="text-center pt-1"><div class="icheck-primary d-inline" data-count = "'+count+'"><input type="radio" id="radioPrimary'+count+'" name="radio"><label for="radioPrimary'+count+'"> </label></div></td>';
			opt +='<td class="text-center"><input type="text" class="form-control form-control-sm check_inp" name="label[]" required></td>';
			opt +='<td class="text-center"><a href="javascript:void(0)" onclick="$(this).closest(\'tr\').remove()"><span class="fa fa-times" ></span></a></td>';
		var tr = $('<tr></tr>')
		tr.append(opt)
		tbody.append(tr)
	}
	function check_opt(){
		var check_opt_clone = $('#check_opt_clone').clone()
		$('.preview').html(check_opt_clone.html())
	}
	function radio_opt(){
		var radio_opt_clone = $('#radio_opt_clone').clone()
		$('.preview').html(radio_opt_clone.html())
	}
	function textfield_s(){
		var textfield_s_clone = $('#textfield_s_clone').clone()
		$('.preview').html(textfield_s_clone.html())
	}
	$('[name="type"]').change(function(){
		window[$(this).val()]()
	})
	$(function () {
	$('#manage-question').submit(function(e){
		e.preventDefault()
		start_load()
		// $('#msg').html('')
		$.ajax({
			url:'ajax.php?action=save_question',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp == 1){
					alert_toast('Đã lưu dữ liệu thành công.',"success");
					setTimeout(function(){
						location.reload()
					},1500)
				}
			}
		})
	})

  })
</script>