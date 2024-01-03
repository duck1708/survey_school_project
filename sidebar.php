  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <div class="dropdown">
      <a href="javascript:void(0)" class="brand-link dropdown-toggle" style = "padding: 13px 25px;" data-toggle="dropdown" aria-expanded="true">
          <img src="assets/dist/img/Logo.png" class="brand-image img-circle elevation-3 d-flex justify-content-center align-items-center bg-primary text-white font-weight-500" style="width: 38px;height:50px">
          <span class="brand-text font-weight-light"><?php echo ucwords($_SESSION['login_ten']) ?></span>
      </a>
        <div class="dropdown-menu" style="">
          <a class="dropdown-item manage_account" href="javascript:void(0)" data-id="<?php echo $_SESSION['login_id'] ?>">Xem Thông Tin Cá Nhân</a>
          <a class="dropdown-item manage_password" href="javascript:void(0)"data-id="<?php echo $_SESSION['login_id'] ?>">Thay Đổi Mật Khẩu</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="ajax.php?action=logout">Đăng xuất</a>
      </div>
    </div>
    <div class="sidebar">
      <nav class="mt-2" >
        <ul class="nav nav-pills nav-sidebar flex-column nav-flat" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item dropdown">
            <a href="index.php?page=home" class="nav-link nav-home" >
              <i class="nav-icon fas fa-tachometer-alt "></i>
              <p>
                Bảng điều khiển
              </p>
            </a>
          </li>    
          <?php if($_SESSION['login_chuc_vu'] == 1): ?>
                <li class="nav-item">
                  <a href="./index.php?page=" class="nav-link nav-edit_user">
                    <i class="nav-icon fas fa-users"></i>
                    <p>
                      Quản Lý Người dùng
                      <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
              <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./index.php?page=user_list" class="nav-link nav-user_list tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Quản Lý Sinh Viên</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index.php?page=lecturers_list" class="nav-link nav-lecturers_list tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Quản Lý Giảng Viên</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index.php?page=enterprise_list" class="nav-link nav-enterprise_list tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Quản Lý Doanh Nghiệp</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index.php?page=alumni_list" class="nav-link nav-alumni_list tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Quản Lý Cựu Sinh Viên</p>
                </a>
              </li>
            </ul>
                </li>
              <li class="nav-item">
                <a href="./index.php?page=survey_list" class="nav-link nav-is-tree nav-edit_survey nav-view_survey ">
                  <i class="nav-icon fa fa-poll-h"></i>
                  <p>
                  Quản Lý khảo sát
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index.php?page=survey_report" class="nav-link nav-survey_report">
                  <i class="nav-icon fas fa-poll"></i>
                  <p>
                    Thống kê
                  </p>
                </a>
              </li>     
            <?php else: ?>
              <li class="nav-item">
                  <a href="./index.php?page=survey_widget" class="nav-link nav-survey_widget nav-answer_survey">
                      <i class="nav-icon fas fa-poll-h"></i>
                      <p>
                          Danh sách khảo sát
                      </p>
                  </a>
              </li>
              <li class="nav-item">
                  <a href="./index.php?page=survey_history" class="nav-link nav-survey_history">
                      <i class="nav-icon fas fa-poll-h"></i>
                      <p>
                          Lịch sử khảo sát
                      </p>
                  </a>
              </li>

          <?php endif; ?>
      </ul>
      </nav>
    </div>
  </aside>
<style>
      ul li:is(:link, :active, :visited).active{
          text-decoration: none;
    }
    li:is(:link, :active, :visited).active{
          background-color: #007bff;
    }
    .manage_account{
      border-bottom: 1px solid #e9ecef;
      margin-bottom: 5px;
    }

</style>
 <script>
    const activePage = window.location;
    const navLinks = document.querySelectorAll('nav a').forEach(link => {
      if(link.href.includes(`${activePage}`)){
        link.classList.add('active');
      }
      // if(link.href.includes(`index.php?page=new_user`)){
      //   link.classList.add('active');
      // }
      // if(link.href.includes(`index.php?page=new_user`)){
      //   link.classList.add('active');
      // }
    })

</script>
  <script>
  	$(document).ready(function(){
  		var page = '<?php echo isset($_GET['page']) ? $_GET['page'] : 'Trang Chủ' ?>';
  		if($('.nav-link.nav-'+page).length > 0){
  			$('.nav-link.nav-'+page).addClass('active')
          console.log($('.nav-link.nav-'+page).hasClass('tree-item'))
  			if($('.nav-link.nav-'+page).hasClass('tree-item') == true){
          $('.nav-link.nav-'+page).closest('.nav-treeview').siblings('a').addClass('active')
  				$('.nav-link.nav-'+page).closest('.nav-treeview').parent().addClass('menu-open')
  			}
        if($('.nav-link.nav-'+page).hasClass('nav-is-tree') == true){
          $('.nav-link.nav-'+page).parent().addClass('menu-open')
        }
  		}
      $('.manage_account').click(function(){
        uni_modal('Quản Lý Thông Tin Cá Nhân','manage_user.php?id='+$(this).attr('data-id'))
      })
      $('.manage_password').click(function(){
        uni_modal('Thay Đổi Mật Khẩu','manage_password.php?id='+$(this).attr('data-id'))
      })
  	})
  </script>
