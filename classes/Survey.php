<?php
Class Survey {
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

    function taoKhaoSat(){
        extract($_POST);

        $type_join_list = $type_join[0];
        $detail = null;

        for ($i = 1; $i < sizeof($type_join); $i++) {
            $type_join_list .= ', '. $type_join[$i];
        }

        if ($type == 2) {
            $detail = $major . ',' . $class . ',' . $lecturer_name . ',' . $subject;
        }

        if(empty($id)){

            $save = $this->db->prepare("INSERT INTO khao_sat (ten_khao_sat, loai_khao_sat, doi_tuong_tham_gia, ngay_bat_dau, ngay_ket_thuc, chi_tiet) VALUES (?,?,?,?,?,?)");
            $save->bind_param('ssssss',$title, $type, $type_join_list, $start_date, $end_date, $detail);
            $save->execute();

        }else{
            $save = $this->db->prepare("UPDATE khao_sat SET ten_khao_sat = ?, loai_khao_sat = ?, doi_tuong_tham_gia = ?, ngay_bat_dau = ?, ngay_ket_thuc = ?, chi_tiet = ? where id = ?");
            $save->bind_param('sssssss',$title, $type, $type_join_list, $start_date, $end_date, $detail, $id);
            $save->execute();
        }

        if($save)
            return 1;
    }
    function xoaKhaoSat(){
        extract($_POST);
        $delete = $this->db->query("DELETE FROM khao_sat where id = ".$id);
        if($delete){
            return 1;
        }
    }

}
