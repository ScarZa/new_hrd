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
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="../plugins/iCheck/flat/blue.css">
    <!-- Morris chart -->
    <link rel="stylesheet" href="../plugins/morris/morris.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="../plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="../plugins/daterangepicker/daterangepicker-bs3.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

  </head>
  <body class="hold-transition skin-green fixed sidebar-mini" onLoad="KillMe();self.focus();window.opener.location.reload();">
<?php include '../connection/connect.php';
if (!empty($_REQUEST['work_id'])) {
    $work_id = $_REQUEST['work_id'];
    echo $work_id;
    $sql_delw = "delete from work where workid ='$work_id'";
    mysqli_query($db,$sql_delw) or die(mysqli_error());
} elseif (!empty ($_REQUEST['time_id'])) {
    $time_id = $_REQUEST['time_id'];
    $sql_delt = "delete from timela where id='$time_id'";
    mysqli_query($db,$sql_delt) or die(mysqli_error());
}
?>
<?php
$empno = $_REQUEST['id'];
/*if (!empty($_SESSION['emp'])) {
    $empno = $_SESSION['emp'];
} elseif ($_SESSION['status'] == 'USER') {
    $empno = $_SESSION['user'];
}*/
$name_detial = mysqli_query($db,"select concat(p1.pname,e1.firstname,' ',e1.lastname) as fullname,
                            d1.depName as dep,p2.posname as posi,e1.empno as empno, e2.TypeName as typename,e2.EmpType as emptype
                            from emppersonal e1 
                            inner join pcode p1 on e1.pcode=p1.pcode
                            inner join department d1 on e1.depid=d1.depId
                            inner join posid p2 on e1.posid=p2.posId
                            inner join emptype e2 on e2.EmpType=e1.emptype
                            where e1.empno='$empno'");
$NameDetial = mysqli_fetch_assoc($name_detial);

$sql_leave=  mysqli_query($db,"SELECT empno FROM leave_day WHERE empno='$empno'");
         $num_row1=  mysqli_num_rows($sql_leave);
         if($num_row1 >= 1){
             $Sql_leave=  mysqli_query($db,"SELECT * FROM leave_day WHERE empno='$empno'");
             $Sql_Leave=  mysqli_fetch_assoc($Sql_leave);
         }

include_once ('../plugins/funcDateThai.php');
?>
      <section class="content">
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">เพิ่มวันลาบุคลากร</h3>
            </div>
            <div class="panel-body">
                <form class="navbar-form navbar-left" role="form" action='../process/prcleave.php' enctype="multipart/form-data" method='post' onSubmit="return Check_txt()">

<font size="3">ชื่อ นามสกุล :
                            <?= $NameDetial['fullname']; ?>
                            <br />
                            ตำแหน่ง :
<?= $NameDetial['posi']; ?>
                            <br />
                            ฝ่าย-งาน :
<?= $NameDetial['dep']; ?>
                            <br />
                            ประเภทพนักงาน :
<?= $NameDetial['typename']; ?>
                            <br /><br />
                            </font> 
                            <div class="row">
                            <div class="col-lg-1 col-xs-6">
                            <label>ลาป่วย &nbsp;</label>
                            <input value='<?php if($num_row1 >= 1){ echo $Sql_Leave['L1'];}?>' type="text" class="form-control" name="L1" id="L1" placeholder="ลาป่วย" onkeydown="return nextbox(event, 'L2')" required>
                            </div>
                            <div class="col-lg-1 col-xs-6"> 
                            <label>ลากิจ &nbsp;</label>
                            <input value='<?php if($num_row1 >= 1){ echo $Sql_Leave['L2'];}?>' type="text" class="form-control" name="L2" id="L2" placeholder="ลากิจ" onkeydown="return nextbox(event, 'L3')" required>
                            </div>
                            <div class="col-lg-1 col-xs-6"> 
                            <label>ลาพักผ่อน &nbsp;</label>
                            <input value='<?php if($num_row1 >= 1){ echo $Sql_Leave['L3'];}?>' type="text" class="form-control" name="L3" id="L3" placeholder="ลาพักผ่อน" onkeydown="return nextbox(event, 'L4')" required>
                            </div>
                            
                            <div class="col-lg-1 col-xs-6">
                            <label>ลาคลอด &nbsp;</label>
                            <input value='<?php if($num_row1 >= 1){ echo $Sql_Leave['L4'];}?>' type="text" class="form-control" name="L4" id="L4" placeholder="ลาคลอด" onkeydown="return nextbox(event, 'L5')">
                            </div>
                            <div class="col-lg-1 col-xs-6"> 
                            <label>ลาบวช &nbsp;</label>
                            <input value='<?php if($num_row1 >= 1){ echo $Sql_Leave['L5'];}?>' type="text" class="form-control" name="L5" id="L5" placeholder="ลาบวช" onkeydown="return nextbox(event, 'L6')">
                            </div>
                            <div class="col-lg-1 col-xs-6">
                            <label>ลาศึกษาต่อ &nbsp;</label>
                            <input value='<?php if($num_row1 >= 1){ echo $Sql_Leave['L6'];}?>' type="text" class="form-control" name="L6" id="L6" placeholder="ลาศึกษาต่อ" onkeydown="return nextbox(event, 'L7')">
                            </div>
                            <div class="col-lg-1 col-xs-6">
                            <label>ลาเลี้ยงดูบุตร &nbsp;</label>
                            <input value='<?php if($num_row1 >= 1){ echo $Sql_Leave['L7'];}?>' type="text" class="form-control" name="L7" id="L7" placeholder="ลาเลี้ยงดูบุตร" onkeydown="return nextbox(event, 'Submit')">
                            </div></div>
                            <br><br>
                            <?php
                            $sql=  mysqli_query($db,"SELECT empno FROM leave_day WHERE empno='$empno'");
         $num_row=  mysqli_num_rows($sql);
         if($num_row >= 1){?>
                            <input type="hidden" name="method" id="method" value="edit_add_leave">
                             <input type="hidden" name="empno" id="method" value="<?=$empno?>">
                             <input type="hidden" name="emptype" id="method" value="<?= $NameDetial['emptype']; ?>">
                             <input class="btn btn-warning" type="submit" name="Submit" id="Submit" value="บันทึก">
        <?php }else{?>
                             <input type="hidden" name="method" id="method" value="add_leave">
                             <input type="hidden" name="empno" id="method" value="<?=$empno?>">
                             <input type="hidden" name="emptype" id="method" value="<?= $NameDetial['emptype']; ?>">
                             <input class="btn btn-success" type="submit" name="Submit" id="Submit" value="บันทึก">
         <?php }?>
                </form>
        </div>
    </div>
</div>
</div>
<?php $db->close();?> 
      </section>
          <script src="../plugins/jQuery/jQuery-2.1.4.min.js"></script>
        <!-- jQuery UI 1.11.4 -->
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 3.3.5 -->
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <!-- DataTables -->
    <script src="../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../plugins/datatables/dataTables.bootstrap.min.js"></script>
    <!-- page script -->
    <script>
      $(function () {
        $("#example1").DataTable();
        $('#example2').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": false,
          "ordering": true,
          "info": true,
          "autoWidth": false
        });
      });
    </script>
    <!-- Morris.js charts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="../plugins/morris/morris.min.js"></script>
    <!-- Sparkline -->
    <script src="../plugins/sparkline/jquery.sparkline.min.js"></script>
    <!-- jvectormap -->
    <script src="../plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="../plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="../plugins/knob/jquery.knob.js"></script>
    <!-- daterangepicker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
    <script src="../plugins/daterangepicker/daterangepicker.js"></script>
    <!-- datepicker -->
    <script src="../plugins/datepicker/bootstrap-datepicker.js"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
    <!-- Slimscroll -->
    <script src="../plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="../plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../dist/js/app.min.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="../dist/js/pages/dashboard.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../dist/js/demo.js"></script>

  </body>
</html>
