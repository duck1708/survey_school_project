<?php include'classes/Admin.php' ?>
<div class="col-lg-12">
    <div class="card card-outline card-success">
        <div class="card-header">
            <div class="card-tools">
                <a class="btn btn-block btn-sm btn-default btn-flat border-primary" href="./index.php?page=new_user"><i class="fa fa-plus"></i> Thêm Người Dùng Mới</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table tabe-hover table-bordered" id="list">
                <thead>
                <tr>
                    <th class="text-center">STT</th>
                    <th>Tên</th>
                    <th>Số điện thoại</th>
                    <th>Loại tài khoản</th>
                    <th>Email</th>
                    <th>Giới Tính</th>
                    <th>Khoa</th>
                    <th>Lớp</th>
                    <th>Năm học</th>
                    <th>Địa Chỉ</th>
                    <th>Trạng thái</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $i = 1;
                $chuc_vu = array('',"Admin","Giảng Viên", "Sinh Viên", "Doanh nghiệp");
                $qry = new Admin();
                $res = $qry->thongKeNguoiDung(3);
                while($row= $res->fetch_assoc()):
                    ?>
                    <tr>
                        <th class="text-center"><?php echo $i++ ?></th>
                        <td><b><?php echo ucwords($row['ten']) ?></b></td>
                        <td><b><?php echo $row['so_dt'] ?></b></td>
                        <td><b><?php echo $chuc_vu[$row['chuc_vu']] ?></b></td>
                        <td><b><?php echo $row['email'] ?></b></td>
                        <td><b><?php echo $row['gioi_tinh'] == 1 ? 'Nam' : 'Nữ' ?></b></td>
                        <td><b><?php echo $row['khoa'] ?></b></td>
                        <td><b><?php echo $row['lop'] ?></b></td>
                        <td><b><?php echo $row['nam'] ?></b></td>
                        <td><b><?php echo $row['dia_chi'] ?></b></td>
                        <td class="text-center">
                            <div class="btn-group">
                                <a href="./index.php?page=edit_user&id=<?php echo $row['id'] ?>" class=" btn btn-primary btn-flat">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <!-- <a  href="javascript:void(0)" data-id="<?php echo $row['id'] ?>" class="view_user btn btn-info btn-flat">
		                          <i class="fas fa-eye"></i>
		                        </a> -->
                                <button type="button" class="delete_user btn btn-danger btn-flat delete_survey" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <div>
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
        $('.view_user').click(function(){
            uni_modal("<i class='fa fa-id-card'></i> Chi tiết người dùng","view_user.php?id="+$(this).attr('data-id'))
        })
        $('.delete_user').click(function(){
            _conf("Có chắc chắn xóa người dùng này không?","delete_user",[$(this).attr('data-id')])
        })
    })
    function delete_user($id){
        start_load()
        $.ajax({
            url:'ajax.php?action=delete_user',
            method:'POST',
            data:{id:$id},
            success:function(resp){
                if(resp==1){
                    alert_toast("Xoá tài khoản thành công",'success')
                    setTimeout(function(){
                        location.reload()
                    },1500)

                }
            }
        })
    }
</script>
