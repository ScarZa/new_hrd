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
                    function insert_date(&$take_date_conv,&$take_date)
                    {
                        $take_date=explode("/",$take_date_conv);
			 $take_date_year=$take_date[2]-543;
			 $take_date="$take_date_year-$take_date[1]-$take_date[0]";
                    }
                    
$empno=$_REQUEST['id'];
if(isset($_REQUEST['method'])){
        $Lno=$_REQUEST['leave_no'];
         $edit_per=  mysqli_query($db,"select * from timela where empno='$empno' and id='$Lno'");
        $edit_person=  mysqli_fetch_assoc($edit_per);
    }
    ?>
      <!--<section class="content-header">
              <?php if(isset($_REQUEST['method'])){?>
              <h1><font color='blue'>  แก้ไขการลาชั่วโมง </font></h1> 
            <ol class="breadcrumb">
              <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
              <li><a href="detial_leave.php?id=<?=$edit_person['empno'];?>"><i class="fa fa-home"></i> รายละเอียดข้อมูลการลาของบุคลากร</a></li>
              <li class="active"><i class="fa fa-edit"></i> บันทึกการลาชั่วโมง</li>
              </ol>
              <?php }else{?>
              <h1><font color='blue'>  บันทึกการลาชั่วโมง </font></h1> 
            <ol class="breadcrumb">
              <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
              <li><a href="pre_leave.php"><i class="fa fa-home"></i> ข้อมูลการลา</a></li>
              <li class="active"><i class="fa fa-edit"></i> บันทึกการลาชั่วโมง</li>
              </ol>
              <?php }?>
      </section>-->
      <section class="content">
<form class="navbar-form" role="form" action='../process/prcleave.php' enctype="multipart/form-data" method='post' onSubmit="return Check_txt()">
<div class="row">
          <div class="col-lg-12">
              <div class="panel panel-primary">
                <div class="panel-heading" align="center">
                    <h3 class="panel-title">บันทึกการลาชั่วโมงของบุคลากร</h3>
                    </div>
                <div class="panel-body" align="center">
                    <div class="form-group" align="center">
                        <?php
                        
                            $select_det=  mysqli_query($db,"select concat(p1.pname,e1.firstname,' ',e1.lastname) as fullname,d1.depName as dep,e1.depid as depno,p2.posname as posi,e1.empno as empno
                                                        from emppersonal e1 
                                                        inner join pcode p1 on e1.pcode=p1.pcode
                                                        inner join department d1 on e1.depid=d1.depId
                                                        inner join posid p2 on e1.posid=p2.posId
                                                        where e1.empno='$empno'");
                            $detial_l= mysqli_fetch_assoc($select_det);
                        ?>
                        <table align="center" width='100%'>
                        <thead>
                            <tr><td width='50%' align="right" valign="top"><b>ชื่อ-นามสกุล : &nbsp;</b></td><td width="50%">&nbsp;<?=$detial_l['fullname'];?></td></tr>
              <tr><td align="right"><b>ฝ่าย-งาน : &nbsp;</b></td><td><?=$detial_l['dep'];?></td></tr>
              <tr><td align="right"><b>ตำแหน่ง : &nbsp;</b></td><td><?=$detial_l['posi'];?></td></tr>
              <?php if(isset($_REQUEST['method'])){?>              
              <tr>
                <th align="right">&nbsp;</th>
                <td>&nbsp;</td>
              </tr>

              <tr>
                <td align="right"><b>เลขที่ใบลา : &nbsp;</b></td>
                <td>
                    <div class="form-group">
                <input value="<?php if(isset($_REQUEST['method'])){ echo $edit_person['idno'];}?>" type="text" name="leave_no" id=leave_no" class="form-control" placeholder="เลขที่ใบลา">
                </div>
                </td>
              </tr>
              <tr>
                <th align="right">&nbsp;</th>
                <td>&nbsp;</td>
              </tr>
                <?php }?>
              <tr><td align="right"><b>วันที่เขียนใบลา : &nbsp;</b></td>
                  <td>
                      <div class="form-group">
                          <?php include_once'indexDatepicker.php'; 
 		if(isset($_GET['method'])){
 			$vstdate=$edit_person['vstdate'];
 			edit_date($vstdate);
                        }
 		?>
                      <input value="<?php if(isset($_REQUEST['method'])){ echo $vstdate;}?>" name="date_reg" type="text" id="datepicker-th-1"  placeholder='รูปแบบ 22/07/2557' class="form-control" required>
                      </div></td></tr>
              <tr>
                <th align="right">&nbsp;</th>
                <td>&nbsp;</td>
              </tr>
              <tr><td align="right"><b>วันที่ลา : &nbsp;</b></td><td>
                      <div class="form-group">
                        <?php
 		if(isset($_GET['method'])){
 			$datela=$edit_person['datela'];
 			edit_date($datela);
                        }
 		?>  
                          <input value="<?php if(isset($_REQUEST['method'])){ echo $datela;}?>" name="date_l" type="text" id="datepicker-th-2"  placeholder='รูปแบบ 22/07/2557' class="form-control" required>
                      </div></td></tr>
              <tr>
                <th align="right">&nbsp;</th>
                <td>&nbsp;</td>
              </tr>
              <tr><td align="right"><b>ตั้งแต่ : &nbsp;</b></td><td>
                      <div class="form-group">
                      <input value="<?php if(isset($_REQUEST['method'])){ echo $edit_person['starttime'];}?>" type="time" name="time_s" id="time_s" placeholder="รูปแบบ 13:35" class="form-control" required>
                      
                      
                      </div>                 <b> ถึง</b>
                    <div class="form-group">
                      <input value="<?php if(isset($_REQUEST['method'])){ echo $edit_person['endtime'];}?>" type="time" name="time_e" id="time_e" placeholder="รูปแบบ 13:35" class="form-control" required>
                    </div>
                </td>
                </tr>
              <tr>
                <th align="right">&nbsp;</th>
                <td>&nbsp;</td>
                </tr>
              <tr>
                <td align="right"><b>รวมจำนวน : &nbsp;</b></td>
                <td>
                    <div class="form-group">
                        <input value="<?php if(isset($_REQUEST['method'])){ echo $edit_person['total'];}?>" type="text" name="amount" id="amount" size="2" class="form-control" placeholder="จำนวน" onKeyUp="javascript:inputDigits(this);" required>
                    </div><b> ชัวโมง</b>
                </td>
                </tr>
              <tr>
                <th align="right">&nbsp;</th>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td align="right" valign="top"><b>เหตุผลการลา : &nbsp;</b></td>
                <td>
                    <div class="form-group">
                        <textarea value='' name="reason_l" cols="50" rows="" required class="form-control" placeholder="เหตุผลการลา"><?php if(isset($_REQUEST['method'])){ echo $edit_person['comment'];}?></textarea>
                     </div> 
                </td>
              </tr>
              <tr>
                <th align="right">&nbsp;</th>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td align="right"><b>เพิ่มใบลา : &nbsp;</td>
                <td>
                  <div class="form-group">
                    <input type="file" name="image"  id="image" class="form-control"/>
                    </div>
                  </td>
              </tr>
                        </thead>
              </table>
                    </div><br><br>
                    <?php if(isset($_REQUEST['method'])){?>
                    <div class="form-group">
                        <input type="hidden" name="Lno" value="<?=$edit_person['id'];?>">
                        <input type="hidden" name="empno" value="<?=$detial_l['empno'];?>">
                        <input type="hidden" name="depno" value="<?=$detial_l['depno'];?>">
                        <input type="hidden" name="method" value="edit_Tleave">    
                        <input class="btn btn-warning" type="submit" name="submit" value="แก้ไข">
                    </div>
                    <?php }else{
     include_once'../plugins/function_date.php';
    if($date >= $bdate and $date <= $edate){
        $sql_leave=  mysqli_query($db,"SELECT COUNT(total) as tcount,SUM(total) as tsum
                                                FROM timela
                                                WHERE empno='$empno' and `status`='N' AND 
                                                datela BETWEEN '$y-10-01' and '$Yy-09-30'");    
    }else{
                        $sql_leave=  mysqli_query($db,"SELECT COUNT(total) as tcount,SUM(total) as tsum
                                                FROM timela
                                                WHERE empno='$empno' and `status`='N' AND 
                                                datela BETWEEN '$Y-10-01' and '$y-09-30'");
    }?>
                    <div class="form-group">
                        <table name="leave" border="1" cellspacing="" cellpadding="">
                            <tr>
                                <th colspan="2" align="center">สถิติการลาชั่วโมง</th>
                            </tr>
                        <?php $leave=mysqli_fetch_assoc($sql_leave)?>
                            <tr>
                                <td><input type="text" name="countla" id="countla" value='<?=$leave['tcount']?>' readonly="" size="1"> ครั้ง</td>
                            <td><input type="text" name="sumt" id="sumt" value='<?=$leave['tsum']?>' readonly="" size="1"> ชั่วโมง</td>
                        </tr>
                        </table><br>
                        <input type="hidden" name="empno" value="<?=$detial_l['empno'];?>">
                        <input type="hidden" name="depno" value="<?=$detial_l['depno'];?>">
                        <input type="hidden" name="method" value="time_leave">    
                        <input class="btn btn-success" type="submit" name="submit" value="บันทึก">
                    </div>
                    <?php }?>
                    </div>
                  </div>
              </div>
    </div>
</form>
          <?php $db->close();?> 
      </section>