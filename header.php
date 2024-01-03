<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
<?php 
  ob_start();
  $pageList = ['home','user_list','alumni_list','lecturers_list','enterprise_list', 'new_user','edit_user', 'survey_list','new_survey', 'edit_survey', 'view_survey', 'survey_report', 'view_survey_report','survey_widget','survey_history','view_survey_history'];
  $pageListVN = ['Trang chủ','Danh sách Sinh Viên','Danh sách Cựu Sinh Viên','Danh sách Giảng Viên','Danh sách Doanh Ngiệp', 'Người dùng mới', 'Sửa thông tin người dùng', 'Danh sách khảo sát', 'Khảo sát mới', 'Sửa thông tin khảo sát', 'Xem thông tin khảo sát', 'Thống kê', 'Xem thông tin thống kê','Danh Sách Khảo Sát','Lịch Sử Khảo Sát','Chi Tiết Lịch Sử Khảo Sát'];
  $title = isset($_GET['page']) ? $pageListVN[array_search($_GET['page'], $pageList)] : "Trang Chủ";
  setlocale(LC_ALL, "vit");
  ?>
  <title><?php echo $title ?> | Hệ thống khảo sát trực tuyến</title>
<?php ob_end_flush() ?>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- DataTables -->
  <link rel="stylesheet" href="assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
   <!-- Select2 -->
  <link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
   <!-- SweetAlert2 -->
  <link rel="stylesheet" href="assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="assets/plugins/toastr/toastr.min.css">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="assets/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="assets/dist/css/styles.css">
	<script src="assets/plugins/jquery/jquery.min.js"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="assets/plugins/jquery-ui/jquery-ui.min.js"></script>
 <!-- summernote -->
  <link rel="stylesheet" href="assets/plugins/summernote/summernote-bs4.min.css">
</head>