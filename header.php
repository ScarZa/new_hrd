<?php session_start(); ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>ระบบข้อมูลบุคคลากรโรงพยาบาล</title>
    <LINK REL="SHORTCUT ICON" HREF="images/logo.png">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="plugins/iCheck/flat/blue.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
    <!-- Morris chart -->
    <link rel="stylesheet" href="plugins/morris/morris.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="plugins/select2/select2.min.css">
    <!-- Date Picker -->
    <!--<link rel="stylesheet" href="plugins/datepicker/datepicker3.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker-bs3.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <script src="plugins/excellentexport.js"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script type="text/javascript">
		function popup(url,name,windowWidth,windowHeight){    
				myleft=(screen.width)?(screen.width-windowWidth)/2:100;	
				mytop=(screen.height)?(screen.height-windowHeight)/2:100;	
				properties = "width="+windowWidth+",height="+windowHeight;
				properties +=",scrollbars=yes, top="+mytop+",left="+myleft;   
				window.open(url,name,properties);
	}
</script>

  </head>
  <body class="hold-transition skin-green fixed sidebar-collapse sidebar-mini">
    <div class="wrapper">

      <header class="main-header">
        <!-- Logo -->
        <a href="index.php" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>H</b>RD</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>HRD-</b>System v.2.0</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <?php if(empty($_SESSION['user'])){?>
                <li class="dropdown messages-menu">
                    
                        <a href="#" onClick="return popup('login_page.php', popup, 300, 330);" title="เข้าสู่ระบบบุคลากร">
                            <img src="images/key-y.ico" width="18"> เข้าสู่ระบบ
                  </a>
                   
                </li>
                <?php }else{
                    include 'connection/connect.php';
                    if(!$db){
     die ('Connect Failed! :'.mysqli_connect_error ());
     exit;
}
                                    $user_id = $_SESSION['user'];
                                    if (!empty($user_id)) {
                                        $sql = $db->prepare("select em.photo,po.posname ,d1.depName from emppersonal em 
                                                        INNER JOIN posid po on em.posid=po.posId
                                                        INNER JOIN department d1 on em.depid=d1.depId
                                                        WHERE empno=?");
                                        $sql->bind_param("i",$user_id);
                                        $sql->execute();
                                        $sql->bind_result($empno_photo,$posname,$depname);
                                        $sql->fetch();
                                        if (empty($empno_photo)) {
                                    $photo = 'person.png';
                                    $fold = "images/";
                                } else {
                                    $photo = $empno_photo;
                                    $fold = "photo/";
                                }
                                        $db->close();
                                    }
                                    
                    ?>
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="<?= $fold.$photo?>" class="user-image" alt="User Image">
                  <span class="hidden-xs"><?= $_SESSION['fullname']?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <img src="<?= $fold.$photo?>" class="img-circle" alt="User Image">
                    <p>
                      <?= $posname?>
                      <small><?= $depname?></small>
                    </p>
                  </li>
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="#" class="btn btn-default btn-flat">ข้อมูลส่วนตัว</a>
                    </div>
                    <div class="pull-right">
                        <a href="process/logout.php" class="btn btn-default btn-flat">ออกจากระบบ</a>
                    </div>
                  </li>
                </ul>
              </li>
              <!-- Control Sidebar Toggle Button -->
              <li>
                <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
              </li>
                <?php }?>
            </ul>
          </div>
        </nav>
      </header>
        <?php include 'connection/connect.php';
            if(!$db){
            die ('Connect Failed! :'.mysqli_connect_error ());
            exit;
            }
//===ชื่อโรงพยาบาล
                    $sql = "select * from  hospital";
                    $query=  mysqli_query($db, $sql);
                    $resultHos = mysqli_fetch_assoc($query);
                    if ($resultHos['logo'] != '') {
                                    $pic = $resultHos['logo'];
                                    $fol = "logo/";
                                } else {
                                    $pic = 'agency.ico';
                                    $fol = "images/";
                                }
                                $db->close();
                    ?>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $fol.$pic?>" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
              <p>โรงพยาบาลจิตเวชเลยฯ</p>
              <a href="#"><i class="fa fa-circle text-success"></i> ระบบข้อมูลบุคลากร</a>
            </div>
          </div>
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header">เมนูหลัก</li>
            <li class=""><a href="index.php">
                    <img src="images/gohome.ico" width="20"> <span>หน้าหลัก</span></a>
            </li>
            <?php if(isset($_SESSION['user'])){ ?>
            <li class="treeview">
              <a href="#">
                  <img src="images/kuser.ico" width="20">
                <span>ระบบบุคลากร</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                  <li><a href="index.php?page=personal/add_person"><i class="fa fa-circle-o text-green"></i> เพิ่มข้อมูลบุคลากร</a></li>
                <li><a href="index.php?page=personal/pre_person"><i class="fa fa-circle-o text-green"></i> ข้อมูลบุคลากร</a></li>
                <li><a href="index.php?page=personal/pre_educate"><i class="fa fa-circle-o text-green"></i> ประวัตฺการศึกษา</a></li>
                <li><a href="index.php?page=personal/resign_person"><i class="fa fa-circle-o text-green"></i> ข้อมูลบุคลากรย้าย/ลาออก</a></li>
                <li>
                  <a href="#"><i class="fa fa-circle-o text-blue"></i> รายงาน <i class="fa fa-angle-left pull-right"></i></a>
                  <ul class="treeview-menu">
                    <li><a href="index.php?page=personal/statistics_person"><i class="fa fa-circle-o text-aqua"></i> สถิติบุคลากร</a></li>
                    <li><a href="#" onClick="window.open('personal/detial_type.php','','width=400,height=350'); return false;" title="สถิติประเภทพนักงาน"><i class="fa fa-circle-o text-aqua"></i> สถิติประเภทพนักงาน</a></li>
                    <li><a href="#" onClick="window.open('personal/detial_position.php','','width=600,height=680'); return false;" title="สถิติตำแหน่งพนักงาน"><i class="fa fa-circle-o text-aqua"></i> สถิติตำแหน่งพนักงาน</a></li>
                    </ul>
            </li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                  <img src="images/Letter.png" width="20">
                <span>ระบบการลา</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                  <li><a href="index.php?page=leave/receive_leave"><i class="fa fa-circle-o text-red"></i> บันทึกทะเบียนรับใบลา</a></li>
                <li><a href="index.php?page=leave/pre_leave"><i class="fa fa-circle-o text-red"></i> บันทึกการลาบุคลากร</a></li>
                <li><a href="pages/layout/fixed.html"><i class="fa fa-circle-o text-red"></i> ยกเลิกใบลา</a></li>
                <li><a href="pages/layout/collapsed-sidebar.html"><i class="fa fa-circle-o text-red"></i> การลาชั่วโมง</a></li>
                <li>
                  <a href="#"><i class="fa fa-circle-o text-orange"></i> รายงาน <i class="fa fa-angle-left pull-right"></i></a>
                  <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> สถิติการลาแยกหน่วยงาน</a></li>
                    <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> สถิติการลา</a></li>
                    </ul>
                </li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                  <img src="images/training.ico" width="20">
                <span>ระบบอบรมภายนอก</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="pages/charts/chartjs.html"><i class="fa fa-circle-o text-maroon"></i> บันทึกโครงการฝึกอบรมภายนอก</a></li>
                <li><a href="pages/charts/morris.html"><i class="fa fa-circle-o text-maroon"></i> บันทึกการฝึกอบรมภายนอก</a></li>
                <li>
                  <a href="#"><i class="fa fa-circle-o text-fuchsia"></i> รายงาน <i class="fa fa-angle-left pull-right"></i></a>
                  <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-circle-o text-fuchsia"></i> สถิติการฝึกอบรมภายนอก</a></li>
                    </ul>
                </li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                  <img src="images/trainin.ico" width="20">
                <span>ระบบอบรมภายใน</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="pages/charts/chartjs.html"><i class="fa fa-circle-o text-purple"></i> บันทึกโครงการฝึกอบรมภายใน</a></li>
                <li><a href="pages/charts/morris.html"><i class="fa fa-circle-o text-purple"></i> บันทึกการฝึกอบรมภายใน</a></li>
                <li>
                  <a href="#"><i class="fa fa-circle-o text-maroon"></i> รายงาน <i class="fa fa-angle-left pull-right"></i></a>
                  <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-circle-o text-fuchsia"></i> สถิติการฝึกอบรมภายใน</a></li>
                    </ul>
                </li>
              </ul>
            </li>
                        <li>
                <a href="plugins/fullcalendar/fullcalendar1.php">
                    <img src="images/notes.ico" width="20"> <span>ประชาสัมพันธ์</span>
                <small class="label pull-right bg-red">3</small>
              </a>
            </li>
            <?php }?>
            <li>
                <a href="#" onClick="return popup('plugins/fullcalendar/fullcalendar1.php', popup, 820, 650);" title="ดูวันลาของบุคลากร">
                    <img src="images/Calendar.ico" width="20"> <span>ปฏิทินการลา</span>
              </a>
            </li>
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
          <?php
                    function insert_date(&$take_date_conv,&$take_date)
                    {
                        $take_date=explode("/",$take_date_conv);
			 $take_date_year=$take_date[2]-543;
			 $take_date="$take_date_year-$take_date[1]-$take_date[0]";
                    }
?>