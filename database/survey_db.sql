CREATE TABLE `nguoi_dung` (
    `id` int NOT NULL,
    `email` varchar NOT NULL,
    `mat_khau` varchar NOT NULL,
    `ten` varchar(100) NOT NULL,
    `gioi_tinh` tinyint(1) COMMENT '0 = Nữ, 1 = Nam',
    `dia_chi` varchar NOT NULL,
    `chuc_vu` tinyint(1) NOT NULL DEFAULT 3 COMMENT '1=Admin,2 = GV, 3= SV, 4 = DN',
    `so_dt` numeric NOT NULL,
    `khoa` varchar,
    `lop` varchar,
    `nam` varchar
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


INSERT INTO `nguoi_dung` (id, email, mat_khau, ten, gioi_tinh, dia_chi, chuc_vu, so_dt, khoa, lop, nam) VALUES
(1, 'admin@admin.com', '0192023a7bbd73250516f069df18b500', 'Admin', 1, 'Thuy Loi', 1, 1223231, null, null, null),
(2, 'tmq@tmq.com', '1254737c076cf867dc53d60a0364f38e', 'Quang', 1, 'Thuy Loi', 3, 213213123, 'CNTT', '61TH5', '2020-2024'),
(3, 'ctd@ctd.com', '4744ddea876b11dcb1d169fadf494418', 'Duc', 1, 'Thuy Loi', 3, 213213, 'QTKD', '62QT3', '2020-2024'),
(4, 'lmq@lmq.com', '3cc93e9a6741d8b40460457139cf8ced', 'Le', 0, 'Thuy Loi', 3, 453455, 'CNTT', '61TH3', '2020-2024');

CREATE TABLE `mon_hoc` (
                              `id` int(10) NOT NULL,
                              `ten_mon_hoc` varchar NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `mon_hoc` (id, ten_mon_hoc) VALUES
(1, 'Tin đại cương'),
(2, 'Quản trị mạng'),
(3, 'Trí tuệ nhân tạo'),
(4, 'Triết học');

CREATE TABLE `diem` (
    `id_nguoidung` int(10) NOT NULL,
    `id_monhoc` int(10) NOT NULL,
    `diem` varchar(50)
);

INSERT INTO `diem` (id_nguoidung, id_monhoc, diem) VALUES
(2, 1, 'A'),
(2, 3, 'C'),
(4, 1, 'B'),
(3, 2, 'B');

CREATE TABLE `khao_sat` (
   `id` int NOT NULL,
   `ten_khao_sat` nvarchar(50) NOT NULL,
   `loai_khao_sat` int(1) NOT NULL,
   `doi_tuong_tham_gia` varchar NOT NULL,
   `ngay_bat_dau` date NOT NULL,
   `ngay_ket_thuc` date NOT NULL,
   `ngay_tao` datetime NOT NULL DEFAULT current_timestamp(),
   `chi_tiet` varchar
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `khao_sat` (id, ten_khao_sat, loai_khao_sat, doi_tuong_tham_gia, ngay_bat_dau, ngay_ket_thuc, ngay_tao, chi_tiet) VALUES
(1, 'Sample Survey', 1, 2, '2023-03-06', '2024-03-30', '2023-03-06 09:57:47', null),
(2, 'Survey 1', 2, 2, '2023-03-10', '2024-03-30', '2023-03-10 14:12:09', 'CNTT, 61TH1, Nguyễn Văn A, Tin đại cương'),
(3, 'Survey 2', 3, 3, '2023-03-10', '2024-03-30', '2023-03-10 14:12:33', null),
(4, 'Survey 3', 4, 4, '2023-03-10', '2024-03-30', '2023-03-10 14:14:03', null),
(5, 'Survey 101', 7, '2, 3, 4', '2023-03-10', '2024-03-30', '2023-03-10 14:14:29', null);

CREATE TABLE `cau_hoi` (
    `id` int(10) NOT NULL,
    `noi_dung` varchar(500) NOT NULL,
    `lua_chon` varchar(500) NOT NULL,
    `loai_cau_hoi` nvarchar(50) NOT NULL,
    `thu_tu` int(11) NOT NULL DEFAULT 0,
    `id_khaosat` int(10) NOT NULL,
    `ngay_tao` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `cau_hoi` (id, noi_dung, lua_chon, loai_cau_hoi, thu_tu, id_khaosat, ngay_tao) VALUES
(1, 'Test 1 dap an', '{\"cKWLY\":\"Option 1\",\"esNuP\":\"Option 2\",\"dAWTD\":\"Option 3\",\"eZCpf\":\"Option 4\"}', 'radio_opt', 3, 1, '2023-03-10 12:04:46'),
(2, 'Test nhieu dap an', '{\"qCMGO\":\"Checkbox label 1\",\"JNmhW\":\"Checkbox label 2\",\"zZpTE\":\"Checkbox label 3\",\"dOeJi\":\"Checkbox label 4\"}', 'check_opt', 2, 1, '2023-03-10 12:25:13'),
(4, 'Test text field', '', 'textfield_s', 1, 1, '2023-03-10 13:34:21');


CREATE TABLE `cau_tra_loi` (
  `id` int(10) NOT NULL,
  `id_khaosat` int(10) NOT NULL,
  `id_nguoidung` int(10) NOT NULL,
  `noi_dung` varchar NOT NULL,
  `id_cauhoi` int(30) NOT NULL,
  `ngay_tao` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


INSERT INTO `cau_tra_loi` (id, id_khaosat, id_nguoidung, noi_dung, id_cauhoi, ngay_tao) VALUES
(1, 1, 2, 'Test 1', 4, '2023-03-10 14:46:07'),
(2, 1, 2, '[JNmhW],[zZpTE]', 2, '2023-03-10 14:46:07'),
(3, 1, 2, 'dAWTD', 1, '2023-03-10 14:46:07'),
(4, 1, 3, 'Test 4', 4, '2023-03-10 15:59:43'),
(5, 1, 3, '[qCMGO],[JNmhW]', 2, '2023-03-10 15:59:43'),
(6, 1, 3, 'esNuP', 1, '2023-03-10 15:59:43');

ALTER TABLE `cau_tra_loi`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `cau_hoi`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `khao_sat`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `nguoi_dung`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `mon_hoc`
    ADD PRIMARY KEY (`id`);

ALTER TABLE `diem`
    ADD PRIMARY KEY (`id_monhoc`, `id_nguoidung`);

ALTER TABLE `cau_tra_loi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

ALTER TABLE `cau_hoi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

ALTER TABLE `khao_sat`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

ALTER TABLE `nguoi_dung`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

ALTER TABLE `mon_hoc`
    MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

COMMIT;

