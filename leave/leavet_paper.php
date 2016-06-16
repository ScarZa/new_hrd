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
    <LINK REL="SHORTCUT ICON" HREF="../images/logo.png">
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
        <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="../plugins/iCheck/all.css">

    </head>
    <body class="hold-transition skin-green fixed sidebar-mini">
        <section class="content">
<?php
include_once ('../plugins/funcDateThai.php');
    $empno=$_REQUEST['empno'];
    $workid=$_REQUEST['Lno'];
    $sql_hos=  mysqli_query($db,"SELECT CONCAT(p.pname,e.firstname,' ',e.lastname) as fullname,h.name as name 
FROM hospital h
INNER JOIN emppersonal e on e.empno=h.manager
INNER JOIN pcode p on p.pcode=e.pcode");
    $hospital=mysqli_fetch_assoc($sql_hos);
    $sql=  mysqli_query($db,"select t1.*,concat(p1.pname,e1.firstname,' ',e1.lastname) as fullname,d1.depName as dep,d2.dep_name as depname,p2.posname as posi 
            from timela t1 
            inner join emppersonal e1 on t1.empno=e1.empno
            inner join pcode p1 on e1.pcode=p1.pcode
            inner join department d1 on e1.depid=d1.depId
            inner join department_group d2 on d2.main_dep=d1.main_dep
            inner join posid p2 on e1.posid=p2.posId
            where t1.empno='$empno' and t1.id='$workid'");
    $work=  mysqli_fetch_assoc($sql);
    
    $sql_leave=  mysqli_query($db,"select ty.nameLa,w.begindate,w.enddate,w.amount FROM print_leave p
INNER JOIN `work` w on w.workid=p.befor_workid
INNER JOIN typevacation ty on w.typela=ty.idla
where p.empno='$empno' and p.workid='$workid'");
 $leave_data=mysqli_fetch_assoc($sql_leave);                                  

require_once('../plugins/library/MPDF54/mpdf.php'); //ที่อยู่ของไฟล์ mpdf.php ในเครื่องเรานะครับ
ob_start(); // ทำการเก็บค่า html นะครับ*/
?>
<div class="col-lg-12" align="center">
<table width="20%" border="0" align="right">
  <tr>
    <th scope="col">ฝ่ายทรัพยากรบุคคล</th>
  </tr>
  <tr>
    <td align="left">เลขรับ.............................................</td>
  </tr>
  <tr>
    <td align="left">วันที่................................................</td>
  </tr>
  <tr>
    <td align="left">เวลา................................................</td>
  </tr>
</table>
    <h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        ใบขออนุญาตออกนอกสถานที่ราชการในเวลาราชการ</h3>
</div>
<div class="col-lg-12" align="right">
เขียนที่<?=$hospital[name]?><br><br>
วันที่ <?= DateThai2($work['vstdate'])?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

</div>
<br>
<div class="col-lg-12" align="let">
        เรียน &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ผู้อำนวยการ<?=$hospital['name']?><br><br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ด้วยข้าพเจ้า <?= $work['fullname']?> ตำแหน่ง <?= $work['posi']?> งาน <?= $work['dep']?> <br>ฝ่าย/กลุ่มงาน <?= $work['depname']?> 
            สังกัดกรมสุขภาพจิต  กระทรวงสาธารณสุข<br>  
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ขออนุญาตออกนอกสถานที่ราชการในเวลาราชการ เนื่องจาก<u> <?= $work['comment']?> </u><br>
                        ในวันที่วันที่<u>&nbsp; <?= DateThai2($work['datela'])?>&nbsp; </u>ตั้งแต่เวลา<u>&nbsp; <?= $work['starttime']?>&nbsp; </u>น. ถึงเวลา<u>&nbsp; <?= $work['endtime']?> &nbsp;</u>น.รวม<u> <?=$work['total']?> </u>ชั่วโมง<br>
                         เมื่อครบกำหนดเวลาดังกล่าวแล้ว ข้าพเจ้าจะกลับมาปฏิบัติหน้าที่ตามปกติ <br><br>
</div>
<div class="col-lg-12" align="center">ขอแสดงความนับถือ<br><br>
                                                     ..........................................................<br>
                                                     ( <?= $work['fullname']?> )<br>
                                                      <?= DateThai2($work['vstdate'])?></div><br><br>

                                 <div class="row">
                                 <div class="col-lg-12">
                                     <table width="100%" border="0" cellspacing="0" >
                                         <tr><td valign="top">
                                         <u>สถิติการออกนอกสถานที่ราชการ</u><br><br>
                                     <table width="100%" border="1" cellspacing="" cellpadding="" frame="below" class="divider">
  <tr>
    <th colspan="2" scope="col">ลามาแล้ว</th>
    <th rowspan="2" scope="col">ลาครั้งนี้</th>
    <th rowspan="2" scope="col">รวมเป็น</th>
  </tr>
  <tr>
    <th scope="col">ครั้ง</th>
    <th scope="col">ชั่วโมง</th>
  </tr>
  <?php
  $sql_leave2=  mysqli_query($db,"select * FROM print_tleave 
where empno='$empno' and tleave_id='$workid'");
  $leave2=mysqli_fetch_assoc($sql_leave2);?>
  <tr>
    <td align="center" scope="row"><?=$leave2['last_tleave']?></td>
    <td align="center" scope="row"><?=$leave2['last_tamount']?></td>
    <td align="center"><?=$work['total']?> ชม.</td>
    <td align="center"><?= $work['total']+$leave2['last_tamount']?> ชม.</td>
   </tr>

</table><br><br>
                                    
                                         <center>(ลงชื่อ)..........................................................ผู้ตรวจสอบ<br><br>
                                         ........../............/............<br><br></center>
                                         </td>
                                         <td>
                                     
                                         
                                         <left> เรียน  หัวหน้า <?= $work['depname']?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                                             - เห็นควรเสนอผู้อำนวยการพิจารณาอนุญาต&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br><br></left>
                                         <center>(ลงชื่อ).............................................หัวหน้างาน/รักษาการ<br><br>
                                             (..........................................................)<br><br>
                                         ........../............/............<br><br></center>
                                         <left>เรียน  ผู้อำนวยการ <?=$hospital['name']?>&nbsp;&nbsp;<br>
                                                     - เพื่อพิจารณาอนุญาต&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br><br></left>
                                         <center>(ลงชื่อ).............................................หัวหน้าฝ่าย/รักษาการ<br><br>
                                         (..........................................................)<br><br>
                                         ........../............/............<br><br>
                                         <u>คำสั่ง</u>&nbsp; (&nbsp; )&nbsp; อนุญาต &nbsp;    (&nbsp; )&nbsp; ไม่อนุญาต<br><br><br>
                                         (ลงชื่อ)..........................................................ผู้อำนวยการฯ<br>
                                         (<?=$hospital['fullname']?>)<br><br>
                                         ........../............/............</center>
                                         <br><div class="col-lg-12" align="right">
                                         
                                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                         F-AD-017
                                         
                                     </div>
                                                     </td> </tr></table>
                                 </div>
                                     
                                      </div>
<?php
$time_re=  date('Y_m_d');
$reg_date=$work[reg_date];
$html = ob_get_contents();
ob_clean();
$pdf = new mPDF('th', 'A4', '0', '');
$pdf->SetAutoFont();
$pdf->SetDisplayMode('fullpage');
$pdf->WriteHTML($html, 2);
$pdf->Output("../MyPDF/leave$empno$Code.pdf");
echo "<meta http-equiv='refresh' content='0;url=../MyPDF/leave$empno$Code.pdf' />";
$db->close();
?>
</section>
            <!-- jQuery 2.1.4 -->
    <script src=../plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <!-- Select2 -->
    <script src="../plugins/select2/select2.full.min.js"></script>
    <!-- InputMask -->
    <script src="../plugins/input-mask/jquery.inputmask.js"></script>
    <script src="../plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
    <script src="../plugins/input-mask/jquery.inputmask.extensions.js"></script>
    <!-- date-range-picker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
    <script src="../plugins/daterangepicker/daterangepicker.js"></script>
    <!-- bootstrap color picker -->
    <script src="../plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
    <!-- bootstrap time picker -->
    <script src="../plugins/timepicker/bootstrap-timepicker.min.js"></script>
    <!-- SlimScroll 1.3.0 -->
    <script src="../plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- iCheck 1.0.1 -->
    <script src="../plugins/iCheck/icheck.min.js"></script>
    <!-- FastClick -->
    <script src="../plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../dist/js/demo.js"></script>
    </body>
</html>