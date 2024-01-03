<?php
ini_set('display_errors', 1);
Class User
{
    public $id, $email, $matKhau, $ten, $diaChi, $soDT, $chucVu, $gioiTinh, $khoa, $lop, $nam;

    public function getId()
    {
        return $this->id;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getMatKhau()
    {
        return $this->matKhau;
    }

    public function getTen()
    {
        return $this->ten;
    }

    public function getDiaChi()
    {
        return $this->diaChi;
    }

    public function getSoDT()
    {
        return $this->soDT;
    }

    public function getChucVu()
    {
        return $this->chucVu;
    }

    public function getGioiTinh()
    {
        return $this->gioiTinh;
    }


    public function getKhoa()
    {
        return $this->khoa;
    }


    public function getLop()
    {
        return $this->lop;
    }

    public function getNam()
    {
        return $this->nam;
    }

    protected $db;

    public function createUser($id, $email, $matKhau, $ten, $diaChi, $soDT, $chucVu, $gioiTinh, $khoa, $lop, $nam) {
        $this -> setId($id);
        $this -> setEmail($email);
        $this -> setMatKhau(md5($matKhau));
        $this -> setTen($ten);
        $this -> setDiaChi($diaChi);
        $this -> setSoDT($soDT);
        $this -> setChucVu($chucVu);
        $this -> setGioiTinh($gioiTinh);
        $this -> setKhoa($khoa);
        $this -> setLop($lop);
        $this -> setNam($nam);
    }

    public function __construct()
    {
        ob_start();
        include 'db_connect.php';

        $this->db = $conn;
    }

    function __destruct()
    {
        $this->db->close();
        ob_end_flush();
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setMatKhau($matKhau)
    {
        $this->matKhau = $matKhau;
    }

    public function setTen($ten)
    {
        $this->ten = $ten;
    }

    public function setDiaChi($diaChi)
    {
        $this->diaChi = $diaChi;
    }

    public function setSoDT($soDT)
    {
        $this->soDT = $soDT;
    }

    public function setChucVu($chucVu)
    {
        $this->chucVu = $chucVu;
    }

    public function setGioiTinh($gioiTinh)
    {
        $this->gioiTinh = $gioiTinh;
    }


    public function setKhoa($khoa)
    {
        $this->khoa = $khoa;
    }


    public function setLop($lop)
    {
        $this->lop = $lop;
    }

    public function setNam($nam)
    {
        $this->nam = $nam;
    }

    function dangNhap()
    {
        extract($_POST);
        $login = new User();
        $login->setEmail($_POST['email']);
        $login->setMatKhau($_POST['password']);
        $qry = $this->db->query("SELECT * FROM nguoi_dung where email = '" . $login->email . "' and mat_khau = '" . md5($login->matKhau) . "' ");
        if ($qry->num_rows > 0) {
            foreach ($qry->fetch_array() as $key => $value) {
                if ($key != 'matKhau' && !is_numeric($key))
                    $_SESSION['login_' . $key] = $value;
            }
            return 1;
        } else {
            return 3;
        }
    }

    function dangXuat()
    {
        session_destroy();
        foreach ($_SESSION as $key => $value) {
            unset($_SESSION[$key]);
        }
        header("location:login.php");
    }

    function luuCauTraLoi()
    {
        extract($_POST);
        $userId = $_SESSION['login_id'];
    
        foreach($answer as $key=>$value) {
            if (is_array($value)) {
                $noi_dung = '['.implode("],[",$value).']';
            }else {
                $noi_dung = $value;
            }
            $qry = $this->db->query("INSERT INTO cau_tra_loi (id_khaosat, id_nguoidung, id_cauhoi, noi_dung)
            VALUES ($id, $userId, $key, '$noi_dung')");
        }
        return 1;
    }

    function doiMatKhau() {
        extract($_POST);
        $oPassword = md5($oldPassword);
        $nPassword = md5($newPassword);
        $check = $this -> db -> query("SELECT mat_khau FROM nguoi_dung where id = $id") -> fetch_assoc();
        if ($check['mat_khau'] != $oPassword) {
            return 2;
        }
        $qry = $this -> db -> query("UPDATE nguoi_dung set mat_khau = '" . $nPassword. "' where id = $id");
        if ($qry) {
            return 1;
        }
    }

    function suaTaiKhoan(){
        extract($_POST);
        $data = "";
        foreach($_POST as $k => $v){
            if(empty($data)){
                $data .= " $k='$v' ";
            } else {
                if ($k != 'chucVu')
                    if ($v == '')
                        $data .= ", $k=null ";
                    else
                        $data .= ", $k='$v' ";
            }
        }
        $check = $this->db->query("SELECT * FROM nguoi_dung where email ='". $email . "' ".(!empty($id) ? " and id != {$id} " : ''))->num_rows;
        if($check > 0){
            return 2;
            exit;
        }

        $save = $this->db->query("UPDATE nguoi_dung set $data where id = $id");

        if($save){
            foreach ($_POST as $key => $value) {
                if($key != 'password' && !is_numeric($key))
                    $_SESSION['login_'.$key] = $value;
            }
            return 1;
        }
        else
            return 3;
    }

    function thongKe()
    {
    }

    function xemLichSu()
    {
    }
}