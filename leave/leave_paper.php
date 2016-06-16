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
    $workid=$_REQUEST['work_id'];
    $sql_hos=  mysqli_query($db,"SELECT CONCAT(p.pname,e.firstname,' ',e.lastname) as fullname,h.name as name 
FROM hospital h
INNER JOIN emppersonal e on e.empno=h.manager
INNER JOIN pcode p on p.pcode=e.pcode");
    $hospital=mysqli_fetch_assoc($sql_hos);
    $sql=  mysqli_query($db,"select w.*,concat(p1.pname,e1.firstname,' ',e1.lastname) as fullname,d1.depName as dep,d2.dep_name as depname,p2.posname as posi ,
ty.nameLa as namela,w.tel as telephone
            from work w 
            inner join emppersonal e1 on w.enpid=e1.empno
            inner join pcode p1 on e1.pcode=p1.pcode
            inner join department d1 on e1.depid=d1.depId
            inner join department_group d2 on d2.main_dep=d1.main_dep
            inner join posid p2 on e1.posid=p2.posId
						INNER JOIN typevacation ty on ty.idla=w.typela
            where w.enpid='$empno' and w.workid='$workid'");
    $work=  mysqli_fetch_assoc($sql);
    

         /*$sql_leave=  mysql_query("select ty.nameLa as namela, COUNT(w.workid) AS leave_type
            from work w 
                INNER JOIN typevacation ty on ty.idla=w.typela
                    where w.enpid='$empno' GROUP BY ty.idla ");*/
    
    $sql_leave=  mysqli_query($db,"select ty.nameLa,w.begindate,w.enddate,w.amount FROM print_leave p
INNER JOIN `work` w on w.workid=p.befor_workid
INNER JOIN typevacation ty on w.typela=ty.idla
where p.empno='$empno' and p.workid='$workid'");
 $leave_data=mysqli_fetch_assoc($sql_leave)                                  
?>

    <?php
require_once('../plugins/library/MPDF54/mpdf.php'); //ที่อยู่ของไฟล์ mpdf.php ในเครื่องเรานะครับ
ob_start(); // ทำการเก็บค่า html นะครับ*/
?>
<div class="col-lg-12">
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
</div><br>
<div class="col-lg-12" align="right">
เขียนที่<?=$hospital['name']?><br><br>
วันที่ <?= DateThai2($work['reg_date'])?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

</div>
<br>
<div class="col-lg-12" align="let">
    เรื่อง &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ขอลา <?= $work['namela']?> <br><br>
        เรียน &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ผู้อำนวยการ<?=$hospital['name']?><br><br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ข้าพเจ้า <?= $work['fullname']?> ตำแหน่ง <?= $work['posi']?> งาน <?= $work['dep']?> <br>ฝ่าย/กลุ่มงาน <?= $work['depname']?> 
            สังกัดกรมสุขภาพจิต  กระทรวงสาธารณสุข<br>  
            <?php
            if($work['typela']=='3'){
                                ?>
                                 มีวันลาพักผ่อนสะสม<u>&nbsp; <?=$sum_total-10?> &nbsp;</u>วันทำการ  มีสิทธิลาพักผ่อนประจำปีอีก 10 วัน รวมเป็น<u>&nbsp; <?=$sum_total?> &nbsp;</u>วันทำการ <br> 
                             <?php }?>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ขอลา<u> <?= $work['namela']?> </u>เนื่องจาก<u> <?= $work[abnote]?> </u><br>
                        ตั้งแต่วันที่<u>&nbsp; <?= DateThai2($work['begindate'])?>&nbsp; </u>ถึงวันที่<u>&nbsp; <?= DateThai2($work['enddate'])?>&nbsp; </u>มีกำหนด<u>&nbsp; <?= $work['amount']?> &nbsp;</u>วัน<br>
                        <?php  if($work['typela']!='3'){?>    
                        ข้าพเจ้าได้ลา<u>&nbsp; <?=$leave_data['nameLa']?> &nbsp;</u>ครั้งสุดท้ายตั้งแต่วันที่
                            <u>&nbsp; <?php if($leave_data['begindate']!=''){    echo DateThai2($leave_data['begindate']);}?> &nbsp;</u>ถึงวันที่
                            <u>&nbsp; <?php if($leave_data['enddate']!=''){    echo DateThai2($leave_data['enddate']);}?> &nbsp;</u>มีกำหนด<u>&nbsp; <?=$leave_data['amount']?> &nbsp;</u>วัน<br>
                            <?php }?>    
                            ในระหว่างการลาจะสามารถติดต่อข้าพเจ้าได้ที่ <?= $work['address']?> โทรศัพท์ <?= $work['telephone']?> <br>
                                 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                 <?php
                                 include '../plugins/function_date.php';
                                 
                                    $sql_total=  mysqli_query($db,"select L3 from leave_day where empno='$empno'");
                                    $leave_total= mysqli_fetch_assoc($sql_total);
                                    if($date >= $bdate and $date <= $edate){
                                     $sql_leave_t=  mysqli_query($db,"SELECT SUM(amount) sum_leave FROM work WHERE enpid='$empno' and typela='3' and 
                                                                begindate BETWEEN '$y-10-01' and '$Yy-09-30'");   
                                    }else{
                                    $sql_leave_t=  mysqli_query($db,"SELECT SUM(amount) sum_leave FROM work WHERE enpid='$empno' and typela='3' and 
                                                                begindate BETWEEN '$Y-10-01' and '$y-09-30'");
                                    }
                                    $sum_leave= mysqli_fetch_assoc($sql_leave_t);
                                    $sum_total=$leave_total['L3']+$sum_leave['sum_leave'];
                                    ?>
                                    
</div> 
                                 <div class="row">
                                 <div class="col-lg-12">
                                     <table width="100%" border="0" cellspacing="0" >
                                         <tr><td>
                                                 <br><p><u>สถิติการลาปีงบประมาณนี้</u></p><br>
                                     <table width="100%" border="1" cellspacing="" cellpadding="" frame="below" class="divider">
  <tr>
    <th scope="col">ประเภทลา</th>
    <th scope="col">ลามาแล้ว</th>
    <th scope="col">ลาครั้งนี้</th>
    <th scope="col">รวมเป็น</th>
  </tr>
  <?php
  $sql_leave2=  mysqli_query($db,"select p.*
FROM print_leave p
where p.empno='$empno' and p.workid='$workid'");
  $leave2=mysqli_fetch_assoc($sql_leave2);?>
  <?php if($leave2['last_type1']!=''){?>
  <tr>
    <th scope="row"><?=$leave2['last_type1']?></th>
    <td align="center"><?=$leave2['last_amount1']?> วัน</td>
    <?php if($work['namela']==$leave2['last_type1']){?>
    <td align="center"><?= $work['amount']?> วัน</td>
    <td align="center"><?= $work['amount']+$leave2['last_amount1']?> วัน</td>
    <?php }else{?>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <?php }?>
  </tr>
  <?php }?>
  <?php if($leave2['last_type2']!=''){?>
  <tr>
    <th scope="row"><?=$leave2['last_type2']?></th>
    <td align="center"><?=$leave2['last_amount2']?> วัน</td>
    <?php if($work['namela']==$leave2['last_type2']){?>
    <td align="center"><?= $work['amount']?> วัน</td>
    <td align="center"><?= $work['amount']+$leave2['last_amount2']?> วัน</td>
    <?php }else{?>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <?php }?>
  </tr>
  <?php }?>
  <?php if($leave2['last_type3']!=''){?>
  <tr>
    <th scope="row"><?=$leave2['last_type3']?></th>
    <td align="center"><?=$leave2['last_amount3']?> วัน</td>
    <?php if($work['namela']==$leave2['last_type3']){?>
    <td align="center"><?= $work['amount']?> วัน</td>
    <td align="center"><?= $work['amount']+$leave2['last_amount3']?> วัน</td>
    <?php }else{?>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <?php }?>
  </tr>
  <?php }?>
  <?php if($leave2['last_type4']!=''){?>
  <tr>
    <th scope="row"><?=$leave2['last_type4']?></th>
    <td align="center"><?=$leave2['last_amount4']?> วัน</td>
    <?php if($work['namela']==$leave2['last_type4']){?>
    <td align="center"><?= $work['amount']?> วัน</td>
    <td align="center"><?= $work['amount']+$leave2['last_amount4']?> วัน</td>
    <?php }else{?>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <?php }?>
  </tr>
  <?php }?>
  <?php if($leave2['last_type5']!=''){?>
  <tr>
    <th scope="row"><?=$leave2['last_type5']?></th>
    <td align="center"><?=$leave2['last_amount5']?> วัน</td>
    <?php if($work['namela']==$leave2['last_type5']){?>
    <td align="center"><?= $work['amount']?> วัน</td>
    <td align="center"><?= $work['amount']+$leave2['last_amount5']?> วัน</td>
    <?php }else{?>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <?php }?>
  </tr>
  <?php }?>
  <?php if($leave2['last_type6']!=''){?>
  <tr>
    <th scope="row"><?=$leave2['last_type6']?></th>
    <td align="center"><?=$leave2['last_amount6']?> วัน</td>
    <?php if($work['namela']==$leave2['last_type6']){?>
    <td align="center"><?= $work['amount']?> วัน</td>
    <td align="center"><?= $work['amount']+$leave2['last_amount6']?> วัน</td>
    <?php }else{?>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <?php }?>
  </tr>
  <?php }?>
  <?php if($leave2['last_type7']!=''){?>
  <tr>
    <th scope="row"><?=$leave2['last_type7']?></th>
    <td align="center"><?=$leave2['last_amount7']?> วัน</td>
    <?php if($work['namela']==$leave2['last_type7']){?>
    <td align="center"><?= $work['amount']?> วัน</td>
    <td align="center"><?= $work['amount']+$leave2['last_amount7']?> วัน</td>
    <?php }else{?>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <?php }?>
  </tr>
  <?php }?>
</table><br><br>
                                    
                                         <center>(ลงชื่อ)..........................................................ผู้ตรวจสอบ<br><br>
                                         ........../............/............<br><br></center>
                                         ในการลาครั้งนี้ได้มอบหมายให้&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br><br>
                                         นาย/นาง/น.ส..........................................................<br>
                                         ปฎิบัติงานแทน&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br><br>
                                         <center>(ลงชื่อ)..........................................................ผู้มอบ<br>
                                         ( <?= $work['fullname']?> )<br>
                                          <?= DateThai2($work['reg_date'])?><br><br>
                                         (ลงชื่อ)..........................................................ผู้รับมอบ<br><br>
                                         (..........................................................)<br><br>
                                         ........../............/............</center><br><br>
                                         <?php if($work['typela']=='3'){?>
                                         <h5><b>* สำหรับบุคลกรที่ปฏิบัตงานไม่ครบ 6 เดือนไม่ได้รับสิทธิให้ลาพักผ่อน</b></h5><br>
                                         <?php }else{?>
                                         <h5><b>** สำหรับลูกจ้างชั่วคราวภายใน 6 เดือนแรกที่ลาป่วยเกิน 3 วัน&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></h5><br>
                                         <center>ยินยอม&nbsp; (&nbsp; )&nbsp; หักเงินเดือน&nbsp; (&nbsp; )&nbsp; ทำงานชดเชย<br><br>
                                         (ลงชื่อ)..........................................................ผู้ขออนุญาต<br>
                                         ( <?= $work['fullname']?> )<br></center>
                                         <?php }?>
                                         </td>
                                         <td>
                                     <br><br>
                                         <center>ขอแสดงความนับถือ<br><br>
                                                     ..........................................................<br>
                                                     ( <?= $work['fullname']?> )<br>
                                                      <?= DateThai2($work[reg_date])?><br><br></center>
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
                                         <br>
                                         <div class="col-lg-12" align="right">
                                         <?php if($work[typela]=='3'){?>
                                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                         F-AD-018
                                         <?php }else{ ?>
                                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                         F-AD-019
                                         <?php }?>
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