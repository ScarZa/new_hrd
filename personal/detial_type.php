<?php @session_start(); ?>
<?php include '../connection/connect.php'; ?>
<?php
if (empty($_SESSION['user'])) {
    echo "<meta http-equiv='refresh' content='0;url=index.php'/>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
        <title>ระบบข้อมูลบุคคลากรโรงพยาบาล</title>
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
    <!-- DataTables -->
    <link rel="stylesheet" href="../plugins/datatables/dataTables.bootstrap.css">
    <!-- Morris chart -->
    <link rel="stylesheet" href="../plugins/morris/morris.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="../plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="../plugins/select2/select2.min.css">
    <!-- Date Picker -->
    <!--<link rel="stylesheet" href="plugins/datepicker/datepicker3.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="../plugins/daterangepicker/daterangepicker-bs3.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <script src="../plugins/excellentexport.js"></script>

    </head>
    <body class="hold-transition skin-green fixed sidebar-mini">
        <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-primary">
                    <div class="panel-heading" align="center">
                        <h3 class="panel-title">ข้อมูลบุคลากร</h3>
                    </div>
                    <div class="panel-body">
                        <?php
                            $sql=  mysqli_query($db,"SELECT COUNT(e.emptype) AS sum,
(SELECT COUNT(e.emptype) FROM emppersonal e WHERE e.emptype='1' and e.status='1') d1,
(SELECT COUNT(e.emptype) FROM emppersonal e WHERE e.emptype='2' and e.status='1') d2,
(SELECT COUNT(e.emptype) FROM emppersonal e WHERE e.emptype='3' and e.status='1') d3,
(SELECT COUNT(e.emptype) FROM emppersonal e WHERE e.emptype='4' and e.status='1') d4,
(SELECT COUNT(e.emptype) FROM emppersonal e WHERE e.emptype='5' and e.status='1') d5,
(SELECT COUNT(e.emptype) FROM emppersonal e WHERE e.emptype='6' and e.status='1') d6,
(SELECT COUNT(e.emptype) FROM emppersonal e WHERE e.emptype='7' and e.status='1') d7
FROM emppersonal e
INNER JOIN emptype e2 on e.emptype=e2.EmpType
where e.status='1'");
                            $detial_type=  mysqli_fetch_assoc($sql);
                            
                            
                        ?>
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                              <td colspan="2" align="center" valign="middle"><h4><b>ประเภทของพนักงานในองค์กร</b></h4></td>
                          </tr>
                          <tr>
                              <td align="right" valign="middle" width="50%"><b><a href="detial_emptype.php?emptype=1">ข้าราชการ : </a></b></td>
                            <td align="left" valign="middle"width="50%"><b> <font color="red">&nbsp; <?=$detial_type['d1']?></font> คน</b></td>
                          </tr>
                          <tr>
                            <td align="right" valign="middle"><b><a href="detial_emptype.php?emptype=2">ลูกจ้างประจำ : </a></b></td>
                            <td align="left" valign="middle"><b> <font color="red">&nbsp; <?=$detial_type['d2']?></font> คน</b></td>
                          </tr>
                          <tr>
                            <td align="right" valign="middle"><b><a href="detial_emptype.php?emptype=3">พนักงานราชการ : </a></b></td>
                            <td align="left" valign="middle"><b> <font color="red">&nbsp; <?=$detial_type['d3']?></font> คน</b></td>
                          </tr>
                          <tr>
                            <td align="right" valign="middle"><b><a href="detial_emptype.php?emptype=4">พกส. : </a></b></td>
                            <td align="left" valign="middle"><b> <font color="red">&nbsp; <?=$detial_type['d4']?></font> คน</b></td>
                          </tr>
                          <tr>
                            <td align="right" valign="middle"><b><a href="detial_emptype.php?emptype=5">ลูกจ้างชั่วคราวรายเดือน : </a></a></b></td>
                            <td align="left" valign="middle"><b> <font color="red">&nbsp; <?=$detial_type['d5']?></font> คน</b></td>
                          </tr>
                          <tr>
                            <td align="right" valign="middle"><b><a href="detial_emptype.php?emptype=6">ลูกจ้างชั่วคราวรายวัน : </a></b></td>
                            <td align="left" valign="middle"><b> <font color="red">&nbsp; <?=$detial_type['d6']?></font> คน</b></td>
                          </tr>
                          <tr>
                              <td align="right" valign="middle"><b><a href="detial_emptype.php?emptype=7">นักศึกษาฝึกงาน : </a></b></td>
                            <td align="left" valign="middle"><b> <font color="red">&nbsp; <?=$detial_type['d7']?></font> คน</b></td>
                          </tr>
                          <tr>
                            <td align="right" valign="middle"><b>รวม : </b></td>
                            <td align="left" valign="middle"><b> <font color="red">&nbsp; <?=$detial_type['sum']?></font> คน</b></td>
                          </tr>
                      </table>
                    </div>
                </div>
            </div>
        </div>
        </section>
<script src="../plugins/jQuery/jQuery-2.1.4.min.js"></script>
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
    <!-- jQuery UI 1.11.4 -->
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 3.3.5 -->
    <script src="../bootstrap/js/bootstrap.min.js"></script>
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
