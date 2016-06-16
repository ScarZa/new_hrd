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
    </head>
    <body class="hold-transition skin-green fixed sidebar-mini">            

<?php include_once ('../plugins/funcDateThai.php');
    $empno=$_REQUEST['id'];
    $Lno=$_REQUEST['Lno'];
?>
<form class="navbar-form" role="form" action='../process/prcleave.php' enctype="multipart/form-data" method='post'>
<div class="row">
          <div class="col-lg-12">
              <div class="panel panel-primary">
                  <?php if(isset($_REQUEST['method'])){?> 
            <div class="panel-heading" align="center">
                <h3 class="panel-title"> ยืนยันการอนมัติใบลา</h3>
            </div>
            <div class="panel-body" align='center'>
                <div class="well well-sm">
                <b>ยืนยันการอนมัติใบลา</b>
                <div class="form-group">
                    <input type="radio" name="confirm" id="confirm" value="Y" required="">&nbsp;&nbsp; อนุมัติ<br> 
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="confirm" id="confirm" value="N" required="">&nbsp;&nbsp; ไม่อนุมัติ
                </div>
                </div>
                <?php }else{?>
                <div class="panel-heading" align="center">
                    <h3 class="panel-title">รายละเอียดใบลาของบุคลากร</h3>
                    </div>
                <div class="panel-body" align="center">
                    <div class="form-group" align="center">
                <b>เลขที่ใบลา : &nbsp;</b></td>
                    <div class="form-group">
                <input value="" type="text" name="leave_no" id=leave_no" class="form-control" placeholder="เลขที่ใบลา" required>
                </div>
                    <?php }
                    include_once ('../plugins/funcDateThai.php');
                            $select_det=  mysqli_query($db,"select concat(p1.pname,e1.firstname,' ',e1.lastname) as fullname,d1.depName as dep,p2.posname as posi,e1.empno as empno,t.*
                                                        from emppersonal e1 
                                                        inner join pcode p1 on e1.pcode=p1.pcode
                                                        inner join department d1 on e1.depid=d1.depId
                                                        inner join posid p2 on e1.posid=p2.posId
                                                        inner join timela t on e1.empno=t.empno
                                                        where e1.empno='$empno' and t.id='$Lno'");
                            $detial_l= mysqli_fetch_assoc($select_det);
                            $idAdmin=$detial_l['idAdmin'];
                            $select_admin=mysqli_query($db,"select concat(e.firstname,' ',e.lastname) as adminname
                                                        from emppersonal e
                                                        inner join timela t on e.empno=t.idAdmin
                                                        where t.idAdmin='$idAdmin'");
                            $detial_admin= mysqli_fetch_assoc($select_admin);
                        ?>
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
                <td colspan="3">&nbsp;&nbsp; <?=$detial_l['idno'];?></td>
              </tr>
              <tr><td align="right"><b>วันที่เขียนใบลา : </b></td>
                  <td  colspan="3">&nbsp;&nbsp; <?=DateThai1($detial_l['vstdate']);?></td>
              </tr>
              <tr>
                  <td align="right"><b>วันที่ลา : </b></td>
                  <td colspan="3">&nbsp;&nbsp; <?=DateThai1($detial_l['datela']);?></td>
              </tr>
              <tr>
                <td align="right"><b>ช่วงเวลาที่ลา : </b></td>
                  <td  colspan="3">&nbsp;&nbsp; <?=$detial_l['starttime'];?> <b>ถึง</b> <?=$detial_l['endtime'];?></td>
              </tr>
              <tr>
                <td align="right"><b>รวมจำนวน : </b></td>
                <td colspan="3">&nbsp;&nbsp; <?=$detial_l['total'];?>&nbsp; <b>ชั่วโมง</b></td>
              </tr>
              <tr>
                <td align="right" valign="top"><b>เหตุผลการลา : </b></td>
                <td colspan="3">&nbsp;&nbsp; <?=$detial_l['comment'];?></td>
              </tr>
              <tr>
                <td align="right" valign="top"><b>ผู้บันทึก : </b></td>
                <td colspan="3">&nbsp;&nbsp; <?=$detial_admin['adminname'];?></td>  
              </tr>
              </thead>
              </table><br>
                                  <div class="form-group">
                        <center>
                            <input type="hidden" name="empno" value="<?=$detial_l['empno'];?>">
                            <input type="hidden" name="workid" value="<?=$detial_l['id'];?>">
                            <?php if(isset($_REQUEST['method'])){?> 
                    <input type="hidden" name="method" value="check_tleave">    
                    <input class="btn btn-success" type="submit" name="submit" value="ยืนยันกระบวนการ">
                        <?php }else{?>
                            <input type="hidden" name="method" value="regis_tleave">    
                            <input class="btn btn-success" type="submit" name="submit" value="ลงทะเบียน">
                            <?php } $db->close();?>
                       </center>
                    </div>
          
                    </div>
                     </div>
                  </div>
              </div>
    </div>
</form>
