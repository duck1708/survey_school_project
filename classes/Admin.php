<?php
define('SITE_ROOT', __DIR__);
include __DIR__.'/User.php';
Class Admin extends User {
    function themTaiKhoan(User $user){
        if (empty($user -> getMatKhau())) {
            $data = "email = '" . $user -> getEmail(). "', 
                 ten = '" . $user -> getTen() . "', dia_chi = '" . $user -> getDiaChi() . "', 
                 chuc_vu = '" . $user -> getChucVu(). "',so_DT = '" . $user -> getSoDT() . "',
                 gioi_tinh = " . $user -> getGioiTinh() . ", khoa = '" . $user -> getKhoa() . "', 
                 lop = '" . $user -> getLop() . "', nam = '" . $user -> getNam() . "'";
        }
        else
            $data = "email = '" . $user -> getEmail(). "', mat_khau = '". $user->getMatKhau() . "', 
                     ten = '" . $user -> getTen() . "', dia_chi = '" . $user -> getDiaChi() . "', 
                     chuc_vu = '" . $user -> getChucVu(). "',so_DT = '" . $user -> getSoDT() . "',
                     gioi_tinh = " . $user -> getGioiTinh() . ", khoa = '" . $user -> getKhoa() . "', 
                     lop = '" . $user -> getLop() . "', nam = '" . $user -> getNam() . "'";
        $check = $this->db->query("SELECT * FROM nguoi_dung where email ='". $user -> getEmail() . "' ".(!empty($user->getId()) ? " and id != {$user->getId()} " : ''))->num_rows;
        if($check > 0){
            return 2;
            exit;
        }
        if(empty($user->getId())){
            $save = $this->db->query("INSERT INTO nguoi_dung set $data");
        }else{
            $save = $this->db->query("UPDATE nguoi_dung set $data where id = ".$user->getId());
        }

        if($save) {
            return 1;
        }
        else return 2;
    }

    function xoaTaiKhoan(){
        extract($_POST);
        $delete = $this->db->prepare("DELETE FROM nguoi_dung where id = ? ");
        $delete->bind_param('s',$id);
        $delete->execute();
        if($delete)
            return 1;
    }

    function thongKeNguoiDung($chucVu) {
        $res = $this->db->query("SELECT * FROM nguoi_dung where chuc_vu = $chucVu order by ten asc");
        return $res;
    }

}
