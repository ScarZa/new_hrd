<section class="content-header">
        <h1><img src='images/kwrite.ico' width='40'><font color='blue'>  บันทึกทะเบียนรับใบลา </font></h1> 
        <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
            <li class="active"><i class="fa fa-edit"></i> บันทึกทะเบียนรับใบลา</li>
        </ol>
</section>
<section class="content">
<div class="row">
    <div class="col-lg-12">
        <div class="box box-warning box-solid">
             <div class="box-header with-border">
                  <h3 class="box-title"><img src='images/bookcase.ico' width='25'> บันทึกทะเบียนรับใบลา</h3>
            </div>
            <div class="box-body">
                <div class="alert alert-info">
                    <div class="form-group" align="right"> 
                        <form name="form1" method="post" action="session/session.php" class="navbar-form navbar-right">
                            <label> เลือกช่วงเวลา : </label>
                            <div class="form-group">
                                <input type="date"   name='check_date01' class="form-control" value='' > 
                            </div>
                            <div class="form-group">
                                <input type="date"   name='check_date02' class="form-control" value='' >
                            </div>
                            <input type="hidden" name="method" value="check_receive">
                            <button type="submit" class="btn btn-success">ตกลง</button>
                        </form>
                        </div><br><br></div>
                                        <form name="form2" method="post" action="index.php?page=leave/receive_leave" class="navbar-form navbar-right">
                            <div class="form-group">
                                <select name="select_status" id="select_status" class="form-control">
                                    <option value="">เลือกสถานะใบลา</option>
                                    <option value="W">รอลงทะเบียน</option>
                                    <option value="A">รออนุมัติ</option>
                                    <option value="Y">อนุมัติ</option>
                                    <option value="N">ไม่อนุมัติ</option>
                                </select>
                            </div>
                                                            <input type="hidden" name="method" value="status_leave">
                            <button type="submit" class="btn btn-success">ตกลง</button>

                        </form>

                <?php

 include 'connection/connect.php';
 if( empty ($_POST['select_status'])){
     $_POST['method']=NULL;
 }
                if (isset($_SESSION['check_rec'])) {
                    $date01=$_SESSION['receive_date1'];
                    $date02=$_SESSION['receive_date2'];
//คำสั่งค้นหา
                    if($_POST['method']=='status_leave' and $regis=  isset($_POST['select_status'])){
                        $regis=$_POST['select_status'];
                    $q = "SELECT w.*,CONCAT(e1.firstname,'  ',e1.lastname) as fullname,d.depName as depname, t.nameLa as namela 
FROM work w
LEFT OUTER JOIN emppersonal e1 on e1.empno=w.enpid
LEFT OUTER JOIN department d on w.depId=d.depId
LEFT OUTER JOIN typevacation t on t.idla=w.typela
where (begindate between '$date01' and '$date02') and (enddate between '$date01' and '$date02') and regis_leave='$regis'
order by w.leave_no desc";
                    $q2 = "select t.*,CONCAT(e1.firstname,'  ',e1.lastname) as fullname,d.depName as depname from timela t
                            LEFT OUTER JOIN emppersonal e1 on e1.empno=t.empno
                            LEFT OUTER JOIN department d on t.depId=d.depId
                            where (datela between '$date01' and '$date02') and regis_time='$regis'
                            order by t.idno desc";
                    
                    }elseif(empty ($_POST['method']) and empty ($_POST['select_status'])){
                     $q = "SELECT w.*,CONCAT(e1.firstname,'  ',e1.lastname) as fullname,d.depName as depname, t.nameLa as namela 
FROM work w
LEFT OUTER JOIN emppersonal e1 on e1.empno=w.enpid
LEFT OUTER JOIN department d on w.depId=d.depId
LEFT OUTER JOIN typevacation t on t.idla=w.typela
where (begindate between '$date01' and '$date02') and (enddate between '$date01' and '$date02')
order by w.leave_no desc";  
                    $q2 = "select t.*,CONCAT(e1.firstname,'  ',e1.lastname) as fullname,d.depName as depname from timela t
                            LEFT OUTER JOIN emppersonal e1 on e1.empno=t.empno
                            LEFT OUTER JOIN department d on t.depId=d.depId
                            where datela between '$date01' and '$date02'
                            order by t.idno desc";
                     
                    }
                } else {
                    if(isset($_POST['method'])=='status_leave' and $regis=  isset($_POST['select_status'])){
                        $regis=$_POST['select_status'];
                    $q = "SELECT w.*,CONCAT(e1.firstname,'  ',e1.lastname) as fullname,d.depName as depname, t.nameLa as namela 
FROM work w
LEFT OUTER JOIN emppersonal e1 on e1.empno=w.enpid
LEFT OUTER JOIN department d on w.depId=d.depId
LEFT OUTER JOIN typevacation t on t.idla=w.typela
where regis_leave='$regis'
order by reg_date desc,w.leave_no desc";
                    $q2 = "select t.*,CONCAT(e1.firstname,'  ',e1.lastname) as fullname,d.depName as depname from timela t
                            LEFT OUTER JOIN emppersonal e1 on e1.empno=t.empno
                            LEFT OUTER JOIN department d on t.depId=d.depId
                            where regis_time='$regis'
                            order by vstdate desc,t.idno desc";
                    }elseif(empty ($_POST['method'])){
                    $q = "SELECT w.*,CONCAT(e1.firstname,'  ',e1.lastname) as fullname,d.depName as depname, t.nameLa as namela 
FROM work w
LEFT OUTER JOIN emppersonal e1 on e1.empno=w.enpid
LEFT OUTER JOIN department d on w.depId=d.depId
LEFT OUTER JOIN typevacation t on t.idla=w.typela
order by reg_date desc,w.leave_no desc";
                    $q2 = "select t.*,CONCAT(e1.firstname,'  ',e1.lastname) as fullname,d.depName as depname from timela t
                            LEFT OUTER JOIN emppersonal e1 on e1.empno=t.empno
                            LEFT OUTER JOIN department d on t.depId=d.depId
                            order by vstdate desc,t.idno desc";
                    }
                    
                }
                $qr = mysqli_query($db,$q);
                $qr2 = mysqli_query($db,$q2);

                include_once ('plugins/funcDateThai.php'); ?>
                <a class="btn btn-success" download="report_leave.xls" href="#" onClick="return ExcellentExport.excel(this, 'datatable', 'Sheet Name Here');">Export to Excel</a><br><br>
                <table id="datatable" border="0" width="100%">
                    <tr>
                        <td>
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <?php if (isset($_SESSION['check_rec']) == 'check_receive') { ?>
                    
                        <tr>
                            <td colspan="9" align="center">ตั้งแต่วันที่ <?= DateThai1($date01); ?> ถึง <?= DateThai1($date02); ?></td>
                        </tr>
                    <?php } ?>
                    <tr align="center" bgcolor="#898888">
                        <th width="4%" align="center"><b>ลำดับ</b></th>
                        <th width="10%" align="center"><b>เลขทะเบียนรับ</b></th>
                        <th width="15%" align="center"><b>ที่</b></th>
                        <th width="10%" align="center"><b>ลงวันที่</b></th>
                        <th width="15%" align="center"><b>จาก</b></th>
                        <th width="9%" align="center"><b>ถึง</b></th>
                        <th width="10%" align="center"><b>เรื่อง</b></th>
                        <th width="20%" align="center"><b>การปฏิบัติ</b></th>
                        <th width="7%" align="center"><b>รับใบลา</b></th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $i = 1;
                    while ($result = mysqli_fetch_assoc($qr)) {
                        ?>
                        <tr>
                            <td align="center"><?= $i ?></td>
                            <td align="center"><?= $result['leave_no']; ?></td>
                            <td align="center"><?= $result['depname']; ?></a></td>
                            <td align="center"><?= DateThai1($result['reg_date']); ?></td>
                            <td>&nbsp;&nbsp; <?= $result['fullname']; ?></td>
                            <td align="center"> ผู้อำนวยการ </td>
                            <td align="center"><?= $result['namela']; ?></td>
                            <td align="center"><?= DateThai1($result['begindate']); ?> <b>ถึง</b> <?= DateThai1($result['enddate']); ?></td>
                            <td align="center">
                           <?php if($result['regis_leave']=='W'){ ?>
                            <a href="#" onClick="return popup('leave/regis_leave.php?id=<?= $result['enpid']?>&Lno=<?= $result['workid']?>', popup, 450, 540);" title="รอลงทะเบียนรับใบลา"><i class="fa fa-spinner fa-spin"></i></a>
                            <?php } elseif ($result['regis_leave']=='A') {?>
                            <a href="#" onClick="return popup('leave/regis_leave.php?method=confirm_leave&id=<?= $result['enpid']?>&Lno=<?= $result['workid']?>', popup, 450, 560);" title="รออนุมัติใบลา">
                                    <img src="images/email.ico" width="20"></a>
                            <?php } elseif ($result['regis_leave']=='Y') {?>
                                    <img src="images/Symbol_-_Check.ico" width="20"  title="อนุมัติ">
                                     <?php } elseif ($result['regis_leave']=='N') {?>
                                    <img src="images/button_cancel.ico" width="20" title="ไม่อนุมัติ">
                                     <?php }?>
                                        </td>
                        </tr>
                        <?php $i++; } ?>
                    </tbody>
                </table>
                        </td></tr></table>

                <a class="btn btn-success" download="report_time_leave.xls" href="#" onClick="return ExcellentExport.excel(this, 'datatable2', 'Sheet Name Here');">Export to Excel</a><br><br>
                <table id="datatable2" border="0" width="100%">
                    <tr>
                        <td>
                <table id="example2" class="table table-bordered table-striped">
                    <thead>
                        <?php if (isset($_SESSION['check_rec']) == 'check_receive') { ?>
                    
                        <tr>
                            <td colspan="9" align="center">ตั้งแต่วันที่ <?= DateThai1($date01); ?> ถึง <?= DateThai1($date02); ?></td>
                        </tr>
<?php } ?>
                    <tr align="center" bgcolor="#898888">
                        <td width="4%" align="center"><b>ลำดับ</b></td>
                        <td width="10%" align="center"><b>เลขทะเบียนรับ</b></td>
                        <td width="15%" align="center"><b>ที่</b></td>
                        <td width="10%" align="center"><b>ลงวันที่</b></td>
                        <td width="15%" align="center"><b>จาก</b></td>
                        <td width="9%" align="center"><b>ถึง</b></td>
                        <td width="10%" align="center"><b>เรื่อง</b></td>
                        <td width="20%" align="center"><b>การปฏิบัติ</b></td>
                        <td width="7%" align="center"><b>รับใบลา</b></td>

                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $i = 1;
                    while ($result2 = mysqli_fetch_assoc($qr2)) {
                        ?>
                        <tr>
                            <td align="center"><?= $i ?></td>
                            <td align="center"><?= $result2['idno']; ?></td>
                            <td align="center"><?= $result2['depname']; ?></a></td>
                            <td align="center"><?= DateThai1($result2['vstdate']); ?></td>
                            <td>&nbsp;&nbsp; <?= $result2['fullname']; ?></td>
                            <td align="center"> ผู้อำนวยการ </td>
                            <td align="center">ลาชั่วโมง</td>
                            <td align="center"><?= DateThai1($result2['datela']); ?>&nbsp; <?= $result2['starttime']; ?> <b>ถึง</b> <?= $result2['endtime']; ?></td>
                            <td align="center">
                           <?php if($result2['regis_time']=='W'){ ?>
                            <a href="#" onClick="return popup('leave/regis_tleave.php?id=<?= $result2['empno']?>&Lno=<?= $result2['id']?>', popup, 450, 445);" title="รอลงทะเบียนรับใบลา"><i class="fa fa-spinner fa-spin"></i></a>
                            <?php } elseif ($result2['regis_time']=='A') {?>
                            <a href="#" onClick="return popup('leave/regis_tleave.php?method=confirm_tleave&id=<?= $result2['empno']?>&Lno=<?= $result2['id']?>', popup, 450, 490);" title="รออนุมัติใบลา">
                                    <img src="images/email.ico" width="20"></a>
                            <?php } elseif ($result2['regis_time']=='Y') {?>
                                    <img src="images/Symbol_-_Check.ico" width="20"  title="อนุมัติ">
                                     <?php } elseif ($result2['regis_time']=='N') {?>
                                    <img src="images/button_cancel.ico" width="20" title="ไม่อนุมัติ">
                                     <?php }?>
                                        </td>
                        </tr>
                        <?php $i++; } $db->close();?>
                    </tbody>
                </table>
                        </td></tr></table>
            </div>
        </div>
    </div>
</div>
    </section>
