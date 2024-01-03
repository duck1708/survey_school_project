<?php
Class Question {
    protected $db;
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

    function themCauHoi(){
        extract($_POST);
        $data = " id_khaosat=$sid ";
        $data .= ", noi_dung='$question' ";
        $data .= ", loai_cau_hoi='$type' ";
        if($type != 'textfield_s'){
            $arr = array();
            foreach ($label as $k => $v) {
                $i = 0 ;
                while($i == 0){
                    $k = substr(str_shuffle(str_repeat($x='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(5/strlen($x)) )),1,5);
                    if(!isset($arr[$k]))
                        $i = 1;
                }
                $arr[$k] = $v;
            }
            $option = json_encode($arr, JSON_UNESCAPED_UNICODE);
            $data .= ", lua_chon='".$option."' ";
        }else{
            $data .= ", lua_chon='' ";
        }
        if(empty($id)){
            $save = $this->db->query("INSERT INTO cau_hoi set $data");
        }
        else{
            $save = $this->db->prepare("UPDATE cau_hoi set $data where id = ?");
            $save->bind_param('s',$id);
            $save->execute();
            $update = $this->db->query("UPDATE cau_tra_loi set lua_chon = '{$option}' where id_cauhoi = {$id}");
        }

        if($save)
            return 1;
        else 
            return 2;
    }

    function xoaCauHoi(){
        extract($_POST);
        $delete = $this->db->prepare("DELETE FROM cau_hoi where id = ?");
        $delete->bind_param('s',$id);
        $delete->execute();
        if($delete){
            return 1;
        }
    }

    function thuTuCauHoi(){
        extract($_POST);
        $i = 0;
        foreach($qid as $k => $v){
            $i++;
            $update[] = $this->db->query("UPDATE cau_hoi set thu_tu = $i where id = $v");
        }
        if(isset($update))
            return 1;
    }
}
