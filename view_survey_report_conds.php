<?php
$select_qry = '';
$from_qry = '';
$where_qry = '';
if (isset($_POST['submitButton'])) {
    if (isset($_POST['chucVu'])) {
        $select_qry = ', u.chuc_vu, u.gioi_tinh ';
        $from_qry .= 'inner join nguoi_dung u on a.id_nguoidung = u.id';
        $where_qry .= ' and ';
        foreach($_POST['chucVu'] as $value) {
            if ($value == end($_POST['chucVu']))
                $where_qry .= "u.chuc_vu = ".$value;
            else
                $where_qry .= "u.chuc_vu = ".$value." or ";
        }
    }
    if (isset($_POST['gioiTinh'])) {
        if ($select_qry == '')
            $select_qry = ', u.chuc_vu, u.gioi_tinh ';
        if ($from_qry == '')
            $from_qry .= 'inner join nguoi_dung u on a.id_nguoidung = u.id';
        $where_qry .= ' and ';
        foreach($_POST['gioiTinh'] as $value) {
            if ($value == end($_POST['gioiTinh']))
                $where_qry .= "u.gioi_tinh = ".$value;
            else
                $where_qry .= "u.chuc_vu = ".$value." or ";
        }
    }
}
$answers = $conn->query("SELECT a.*,q.loai_cau_hoi".$select_qry." from cau_tra_loi a inner join cau_hoi q on q.id = a.id_cauhoi ". $from_qry ." where a.id_khaosat ={$id} " .$where_qry);
$taken = $conn->query("SELECT distinct(id_nguoidung)".$select_qry." from cau_tra_loi a ". $from_qry ." where a.id_khaosat ={$id} ".$where_qry)->num_rows;
//echo "<p><b>SELECT a.*,q.loai_cau_hoi $select_qry from cau_tra_loi a inner join cau_hoi q on q.id = a.id_cauhoi $from_qry where a.id_khaosat ={$id} $where_qry</b></p>";
$ans = array();

while($row=$answers->fetch_assoc()){
    if($row['loai_cau_hoi'] == 'radio_opt'){
        $ans[$row['id_cauhoi']][$row['noi_dung']][] = 1;
    }
    if($row['loai_cau_hoi'] == 'check_opt'){
        foreach(explode(",", str_replace(array("[","]"), '', $row['noi_dung'])) as $v){
            $ans[$row['id_cauhoi']][$v][] = 1;
        }
    }
    if($row['loai_cau_hoi'] == 'textfield_s'){
        $ans[$row['id_cauhoi']][] = $row['noi_dung'];
    }
}