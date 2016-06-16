<?php @session_start(); ?>
<?php include '../connection/connect.php'; ?>
<?php
if (empty($_SESSION['user'])) {
    echo "<meta http-equiv='refresh' content='0;url=index.php'/>";
    exit();
}
?>
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
  </head>

    <?php
    $empno = $_REQUEST['id'];
if ($_SESSION['Status']=='USER') {
    $empno = $_SESSION['user'];
}       
    $detial = mysqli_query($db,"SELECT *,e7.statusname as emp_status,e6.statusname as wstatus from emppersonal e1
INNER JOIN pcode p1 on e1.pcode=p1.pcode
INNER JOIN district d1 on e1.tambol=d1.DISTRICT_ID
INNER JOIN amphur a1 on e1.empure=a1.AMPHUR_ID
INNER JOIN province p2 on e1.provice=p2.PROVINCE_ID
INNER JOIN posid p3 on e1.posid=p3.posId
INNER JOIN department d2 on e1.depid=d2.depId
INNER JOIN department_group d3 on d2.main_dep=d3.main_dep
INNER JOIN empstuc e2 on e1.empstuc=e2.Emstuc
INNER JOIN emptype e3 on e1.emptype=e3.EmpType
INNER JOIN education e4 on e1.education=e4.education
LEFT OUTER JOIN educate e5 on e1.empno=e5.empno
INNER JOIN emstatus e6 on e1.`status`=e6.statusid
INNER JOIN empstatus e7 on e1.emp_status=e7.`status`
where e1.empno='$empno' order by e5.educate desc");

    $topedu = mysqli_query($db,"SELECT eduname topadu from education ed1
INNER JOIN educate ed2 on ed1.education=ed2.educate
INNER JOIN emppersonal em on ed2.empno=em.empno
WHERE em.empno='$empno' order by ed2.educate desc");

    $Detial = mysqli_fetch_assoc($detial);
    $Topedu = mysqli_fetch_assoc($topedu);
$db->close();
    include_once ('../plugins/funcDateThai.php');
    ?>
    <!--<div class="row">
              <div class="col-lg-12">
                <h1><font color='blue'>  รายละเอียดข้อมูลบุคลากร </font></h1> 
                <ol class="breadcrumb alert-success">
                  <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
                  <li class="active"><a href="pre_person.php"><i class="fa fa-edit"></i> ข้อมูลพื้นฐาน</a></li>
                  <li class="active"><i class="fa fa-edit"></i> รายละเอียดข้อมูลบุคลากร</li>
                </ol>
              </div>
          </div>-->
    <body class="hold-transition skin-green fixed sidebar-mini">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">ข้อมูลบุคลากร</h3>
                    </div>
                    <div class="panel-body">
                        <div class="col-lg-12">
              <div class="box box-success box-solid collapsed-box">
                <div class="box-header with-border">
                  <h3 class="box-title"><img src='../images/phonebook.ico' width='25'> ข้อมูลทั่วไป</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                  </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div class="box-body">
                                <?php
                                if ($Detial['photo'] != '') {
                                    $pic = $Detial['photo'];
                                    $fol = "../photo/";
                                } else {
                                    $pic = 'person.png';
                                    $fol = "../images/";
                                }
                                ?>
                                <div class="text-right">
                                    <right></right>
                                </div>
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td width="92%">รหัสพนักงาน :
<?= $Detial['pid']; ?></td>
                                        <td width="8%" rowspan="5" align="right" valign="top"><img  src="<?= $fol . $pic; ?>" width="true" height="100" /></td>
                                    </tr>
                                    <tr>
                                        <td>ชื่อ นามสกุล :
                                            <?= $Detial['pname']; ?> <?= $Detial['firstname']; ?>&nbsp; <?= $Detial['lastname']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>วัน เดือน ปีเกิด :
<?= DateThai1($Detial['birthdate']); ?></td>
                                    </tr>
                                    <tr>
                                        <td>หมายเลขบัตรประชาชน :&nbsp;<?= $Detial['idcard']; ?> &nbsp;&nbsp; สถานะภาพ :
<?= $Detial['emp_status']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>ที่อยู่ :
                                            <?= $Detial['address']; ?>
                                            <?= $Detial['baan']; ?>
                                            ต.
                                            <?= $Detial['DISTRICT_NAME']; ?>
                                            อ.
                                            <?= $Detial['AMPHUR_NAME']; ?>
                                            จ.
                                            <?= $Detial['PROVINCE_NAME']; ?>
                                            รหัสไปรษณีย์
<?= $Detial['zipcode']; ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">โทรศัพท์บ้าน :
                                            <?= $Detial['telephone']; ?>
                                            &nbsp;&nbsp; โทรศัพท์มือถือ :
                                            <?= $Detial['mobile']; ?>
                                            &nbsp;&nbsp; E-mail :
<?= $Detial['email']; ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>

              <div class="box box-primary box-solid collapsed-box">
                <div class="box-header with-border">
                  <h3 class="box-title"><img src='../images/work.ico' width='25'> ข้อมูลการปฏิบัติงาน</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                  </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div class="box-body">
                                เลขที่คำสั่ง : <?= $Detial['empcode']; ?><br>
                                วันที่เริ่มงาน : <?= DateThai1($Detial['dateBegin']); ?>&nbsp;&nbsp;ตำแหน่ง : <?= $Detial['posname']; ?><br>
                                ฝ่ายงาน : <?= $Detial['dep_name']; ?>&nbsp;&nbsp; กลุ่มงาน : <?= $Detial['depName']; ?>&nbsp;&nbsp; สายงาน : <?= $Detial['StucName']; ?>
                                <br>ประเภทพนักงาน : <?= $Detial['TypeName']; ?>&nbsp;&nbsp; 
                                วุฒิที่บรรจุ : <?= $Detial['eduname']; ?>
                            </div>
                        </div>
                        <div class="box box-info box-solid collapsed-box">
                <div class="box-header with-border">
                  <h3 class="box-title"><img src='../images/Student.ico' width='25'> ข้อมูลการศึกษา</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                  </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div class="box-body">
                                วุฒิการศึกษาสูงสุด : <?= $Topedu['topadu']; ?>&nbsp;&nbsp; สาขา/วิชาเอก :  <?= $Detial['major']; ?><br>
                                สถาบันการศึกษาที่จบ : <?= $Detial['institute']; ?>&nbsp;&nbsp; วันที่จบการศึกษา :  <?= DateThai1($Detial['enddate']); ?>
                            </div>
                        </div>
                        <div class="box box-warning box-solid collapsed-box">
                <div class="box-header with-border">
                  <h3 class="box-title"><img src='../images/Other.ico' width='25'> ข้อมูลอื่นๆ</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                  </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div class="box-body">
                                สถานะการทำงาน : <?= $Detial['wstatus']; ?><br>
                                เหตุผลการย้าย/สถานที่ย้าย/มาช่วยราชการ/ไปช่วยราชการ :<br>
<?= $Detial['empnote']; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <div class="control-sidebar-bg"></div>
        <!-- jQuery 2.1.4 -->
     <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->
        <!-- jQuery 2.1.4 -->
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
