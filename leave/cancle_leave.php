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
            <form class="navbar-form navbar-left" role="form" action='../process/prcleave.php' enctype="multipart/form-data" method='post' onsubmit="return confirm('กรุณายืนยันการยกเลิกอีกครั้ง !!!')">
    <?php
        $empno=$_REQUEST['id'];
        $Lno=$_REQUEST['Lno'];
        
        $select_det=  mysqli_query($db,"select concat(p1.pname,e1.firstname,' ',e1.lastname) as fullname,d1.depName as dep,p2.posname as posi,e1.empno as empno,w.typela as typela,w.amount as amount,w.*
                                                        from emppersonal e1 
                                                        inner join pcode p1 on e1.pcode=p1.pcode
                                                        inner join department d1 on e1.depid=d1.depId
                                                        inner join posid p2 on e1.posid=p2.posId
                                                        inner join work w on e1.empno=w.enpid
                                                        where e1.empno='$empno' and w.workid='$Lno'");
                            $detial_l= mysqli_fetch_assoc($select_det);
    ?>
<div class="row">
          <div class="col-lg-12">
              <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">ยกเลิกการลา</h3>
                    </div>
                <div class="panel-body">
                    <table align="center" width='100%'>
                        <thead>
              <tr>
                  <td width='50%' align="right" valign="top"><b>ชื่อ-นามสกุล : </b></td>
                  <td colspan="3">&nbsp;&nbsp;<?=$detial_l['fullname'];?></td>
              </tr>
              <tr>
                  <td align="right"><b>ฝ่าย-งาน : </b></td>
                  <td colspan="3">&nbsp;&nbsp; <?=$detial_l['dep'];?></td></tr>
              <tr>
                  <td align="right"><b>ตำแหน่ง : </b></td>
                  <td colspan="3">&nbsp;&nbsp; <?=$detial_l['posi'];?></td></tr>
              <tr>
                  <td align="right"><b>เลขที่ใบลา : </b></td>
                  <td colspan="3">&nbsp;&nbsp; <?=$detial_l['leave_no'];?></td></tr>
                        </thead>
                    </table><br>
                    <div class="form-group"> 
                <label>เหตุผลการยกเลิก &nbsp;</label>
                <TEXTAREA NAME="reason" id="reason"  class="form-control" placeholder="เหตุผลที่ยกเลิก" required ></TEXTAREA>
             	</div><br>
                    <div class="form-group">
                        <label>ใบยกเลิกการลา &nbsp;</label>
                <input type="file" name="image"  id="image" class="form-control"/>
                    </div><br><br>
                    <div class="form-group" align="center">
                        <input type="hidden" name="empno" value="<?=$empno?>">
                        <input type="hidden" name="Lno" value="<?=$Lno?>">
                        <input type="hidden" name="typela" value="<?=$detial_l['typela']?>">
                        <input type="hidden" name="amount" value="<?=$detial_l['amount']?>">
                        <input type="hidden" name="method" value="cancle_leave">
                        <input type="submit" name="sumit" value="ยกเลิก" class="btn btn-danger">
                    </div>   
                    </div>
              </div>
          </div>
</div>
</form> 
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