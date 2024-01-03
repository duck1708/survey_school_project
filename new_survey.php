<?php
if(!isset($conn)){
	include 'db_connect.php' ;
}
?>
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <form action="" id="manage_survey">
                <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
                <div class="row">
                    <div class="col-md-6 border-right">
                        <div class="form-group">
                            <label for="" class="control-label">Tên khảo sát</label>
                            <input type="text" name="title" class="form-control form-control-sm" required
                                value="<?php echo isset($ten_khao_sat) ? $ten_khao_sat : '' ?>">
                        </div>
                        <div class="form-group">
                            <label for="" class="control-label">Ngày bắt đầu</label>
                            <input type="date" name="start_date" class="form-control form-control-sm" required
                                value="<?php echo isset($ngay_bat_dau) ? $ngay_bat_dau : '' ?>">
                        </div>
                        <div class="form-group">
                            <label for="" class="control-label">Ngày kết thúc</label>
                            <input type="date" name="end_date" class="form-control form-control-sm" required
                                value="<?php echo isset($ngay_ket_thuc) ? $ngay_ket_thuc : '' ?>">
                        </div>
                        <div class="form-group">
                            <label for="" class="control-label">Loại Khảo Sát</label>
                            <select type="type" name="type" class="custom-select custom-select-sm" id="check"
                                onchange="showHideCode()" required>
                                <option value="1"
                                    <?php echo isset($loai_khao_sat) && $loai_khao_sat == 1 ? 'selected' : '' ?>>Mục
                                    tiêu chương trình đào tạo</option>
                                <option value="2" 
                                    <?php echo isset($loai_khao_sat) && $loai_khao_sat == 2 ? 'selected' : '' ?>>Đội ngũ
                                    giảng viên</option>
                                <option value="3"
                                    <?php echo isset($loai_khao_sat) && $loai_khao_sat == 3 ? 'selected' : '' ?>>Công
                                    tác tổ chức đào tạo</option>
                                <option value="4"
                                    <?php echo isset($loai_khao_sat) && $loai_khao_sat == 4 ? 'selected' : '' ?>>Phòng
                                    đào tạo</option>
                                <option value="5"
                                    <?php echo isset($loai_khao_sat) && $loai_khao_sat == 4 ? 'selected' : '' ?>>Thư
                                    viện</option>
                                <option value="6"
                                    <?php echo isset($loai_khao_sat) && $loai_khao_sat == 4 ? 'selected' : '' ?>>Căng
                                    tin</option>
                                <option value="7"
                                    <?php echo isset($loai_khao_sat) && $loai_khao_sat == 4 ? 'selected' : '' ?>>Một số
                                    hoạt động khác của trường</option>
                            </select>
                        </div>
                        <div class="form-group form-check-box">
                            <label for="" class="control-label">Người Tham Gia Khảo Sát</label>
                            <div id="example">
                                    <select class="" name="type_join[]" style="width: 103%;" multiple multiselect-search="true" multiselect-select-all="true" multiselect-max-items="4" required>
                                        <option value="2"
                                            <?php if (isset($list_doi_tuong_tham_gia) && in_array(2, $list_doi_tuong_tham_gia)) echo 'selected' ?>>
                                            Giảng viên</option>
                                        <option value="3"
                                            <?php if (isset($list_doi_tuong_tham_gia) && in_array(3, $list_doi_tuong_tham_gia)) echo 'selected' ?>>
                                            Sinh viên</option>
                                        <option value="4"
                                            <?php if (isset($list_doi_tuong_tham_gia) && in_array(4, $list_doi_tuong_tham_gia)) echo 'selected' ?>>
                                            Doanh nghiệp</option>
                                    </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div id="load" style="display:none;">
                            <div class="form-group">
                                <label for="" class="control-label">Khoa</label>
                                <input type="text" name="major" class="form-control form-control-sm"
                                    value="<?php echo isset($chi_tiet_khao_sat[0]) ? $chi_tiet_khao_sat[0] : '' ?>">
                             </div>
                             <div class="form-group">
                                <label for="" class="control-label">Lớp</label>
                                <input type="text" name="class" class="form-control form-control-sm"
                                    value="<?php echo isset($chi_tiet_khao_sat[1]) ? $chi_tiet_khao_sat[1] : '' ?>">
                             </div>
                             <div class="form-group">
                                <label for="" class="control-label">Tên Giáo Viên</label>
                                <input type="text" name="lecturer_name" class="form-control form-control-sm"
                                    value="<?php echo isset($chi_tiet_khao_sat[2]) ? $chi_tiet_khao_sat[2] : '' ?>">
                             </div>
                             <div class="form-group">
                                <label for="" class="control-label">Môn Học</label>
                                <input type="text" name="subject" class="form-control form-control-sm"
                                    value="<?php echo isset($chi_tiet_khao_sat[3]) ? $chi_tiet_khao_sat[3] : '' ?>">
                             </div>
                        </div>
                    </div>
                    <hr>
                    <div class="col-lg-12 text-right justify-content-center d-flex " style="margin-top: 20px">
                        <button class="btn btn-primary mr-2">Lưu</button>
                        <button class="btn btn-secondary" type="button"
                            onclick="location.href = 'index.php?page=survey_list'">Thoát</button>
                    </div>
            </form>
        </div>
    </div>
</div>
<style>
</style>
<script>
$('#manage_survey').submit(function(e) {
    e.preventDefault()
    $('input').removeClass("border-danger")
    start_load()
    $('#msg').html('')
    $.ajax({
        url: 'ajax.php?action=save_survey',
        data: new FormData($(this)[0]),
        cache: false,
        contentType: false,
        processData: false,
        method: 'POST',
        type: 'POST',
        success: function(resp) {
            if (resp == 1) {
                alert_toast('Thêm lưu dữ liệu thành công.', "success");
                setTimeout(function() {
                    location.replace('index.php?page=survey_list')
                }, 1500)
            }
        }
    })
})

function showHideCode() {
    var select = document.getElementById("check");
    var load = document.getElementById("load");
    var req = load.getElementsByTagName("input");
    console.log(req);
    if (select.value == "2") {
        load.style.display = "block";
        for (var i = 0; i < req.length; i++) {
            req[i].setAttribute('required', '');
        }
    }
     else {
        load.style.display = "none";
        for (var i = 0; i < req.length; i++) {
            req[i].removeAttribute('required');
        }
    }
}
showHideCode() 
</script>