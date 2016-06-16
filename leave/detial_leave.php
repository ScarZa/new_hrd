<?php include 'connection/connect.php';
if (isset($_REQUEST['work_id'])) {
    $work_id = $_REQUEST['work_id'];
    $sql_delw = "delete from work where workid ='$work_id'";
    mysqli_query($db,$sql_delw) or die(mysqli_error());
    $del_event = "delete from tbl_event where workid ='$work_id'";
    mysqli_query($db,$del_event) or die(mysqli_error());
} elseif (isset ($_REQUEST['time_id'])) {
    $time_id = $_REQUEST['time_id'];
    $sql_delt = "delete from timela where id='$time_id'";
    mysqli_query($db,$sql_delt) or die(mysqli_error());
}
?>
<?php
$empno = $_REQUEST['id'];
if (isset($_SESSION['emp'])) {
    $empno = $_SESSION['emp'];
} elseif ($_SESSION['Status'] == 'USER') {
    $empno = $_SESSION['user'];
}
$name_detial = mysqli_query($db,"select concat(p1.pname,e1.firstname,' ',e1.lastname) as fullname,
                            d1.depName as dep,p2.posname as posi,e1.empno as empno
                            from emppersonal e1 
                            inner join pcode p1 on e1.pcode=p1.pcode
                            inner join department d1 on e1.depid=d1.depId
                            inner join posid p2 on e1.posid=p2.posId
                            where e1.empno='$empno'");
if (isset($_SESSION['check_dl'])) {
    $date01 = $_SESSION['leave_date1'];
    $date02 = $_SESSION['leave_date2'];

    $detial = mysqli_query($db,"SELECT * from work w1
                        inner join typevacation t1 on w1.typela=t1.idla
                        where enpid='$empno' and w1.begindate between '$date01' and '$date02' and w1.enddate between '$date01' and '$date02'
                            AND statusla='Y' order by workid desc");

    $detiatl = mysqli_query($db,"SELECT * from timela where empno='$empno' and (datela between '$date01' and '$date02') and status='N' order by id desc");
} else {

    $detial = mysqli_query($db,"SELECT * from work w1
                        inner join typevacation t1 on w1.typela=t1.idla
                        where enpid='$empno' AND statusla='Y' order by workid desc");

    $detiatl = mysqli_query($db,"SELECT * from timela where empno='$empno' and status='N' order by id desc");
}
$NameDetial = mysqli_fetch_assoc($name_detial);

include_once ('plugins/funcDateThai.php');
?>
<section class="content-header">
        <h1><font color='blue'>  รายละเอียดข้อมูลการลาของบุคลากร </font></h1> 
        <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
<?php if ($_SESSION['Status'] != 'USER') {
    if(isset($_REQUEST['method'])){
    if ($_REQUEST['method'] == 'check_page') {
        $depno = $_REQUEST['depno'];
        ?> 

                    <li class="active"><a href="Lperson_report.php?depname=<?= $depno ?>"><i class="fa fa-edit"></i> สถิติการลาของของของบุคลากรหน่วยงาน</a></li>
                <?php } elseif ($_REQUEST['method'] == 'check_page2') { ?>
                    <li class="active"><a href="statistics_leave.php"><i class="fa fa-edit"></i> สถิติการลา</a></li>
<?php }else{?>
    <li class="active"><a href="index.php?page=leave/pre_leave"><i class="fa fa-edit"></i> ข้อมูลการลา</a></li>
<?php }}else{ ?>
            <li class="active"><a href="index.php?page=leave/pre_leave"><i class="fa fa-edit"></i> ข้อมูลการลา</a></li>
<?php }}?>
            <li class="active"><i class="fa fa-edit"></i> รายละเอียดข้อมูลการลา</li>
        </ol>
</section>
<section class="content">
<div class="row">
    <div class="col-lg-12">
        <div class="box box-warning box-solid">
             <div class="box-header with-border">
                  <h3 class="box-title">ข้อมูลการลาของบุคลากร</h3>
            </div>
            <div class="box-body">
                <div class="alert alert-info alert-dismissable">
                    <div class="form-group" align="right"> 
                        <form method="post" action="session/session.php" class="navbar-form navbar-right">
                            <label> เลือกช่วงเวลา : </label>
                            <div class="form-group">
                                <input type="date"   name='check_date01' class="form-control" value='' > 
                            </div>
                            <div class="form-group">
                                <input type="date"   name='check_date02' class="form-control" value='' >
                            </div>
                            <input type="hidden" name="method" value="check_detial_leave">
                            <input type="hidden" name="empno" value="<?= $empno ?>">
                            <button type="submit" class="btn btn-success">ตกลง</button>
                        </form>
                    </div>
                    <br><br></div>
                 <a class="btn btn-success" download="report_person_leave.xls" href="#" onClick="return ExcellentExport.excel(this, 'datatable', 'Sheet Name Here');">Export to Excel</a><br><br>
                <table  id="datatable" width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td><font size="3">ชื่อ นามสกุล :
                            <?= $NameDetial['fullname']; ?>
                            <br />
                            ตำแหน่ง :
<?= $NameDetial['posi']; ?>
                            <br />
                            ฝ่าย-งาน :
<?= $NameDetial['dep']; ?>
                            <br />
                            <?php
                                 include 'plugins/function_date.php';
                                 
                                    $sql_total=  mysqli_query($db,"select L1,L2,L3 from leave_day where empno='$empno'");
                                    $leave_total= mysqli_fetch_assoc($sql_total);
                                    if($date >= $bdate and $date <= $edate){
                                        $sql_leave_t=  mysql_query($db,"SELECT SUM(amount) sum_leave FROM work WHERE enpid='$empno' and typela='3' and 
                                                                begindate BETWEEN '$y-10-01' and '$Yy-09-30' and statusla='Y' and regis_leave!='N'");   
                                    }else{
                                        $sql_leave_t=  mysqli_query($db,"SELECT SUM(amount) sum_leave FROM work WHERE enpid='$empno' and typela='3' and 
                                                                begindate BETWEEN '$Y-10-01' and '$y-09-30' and statusla='Y' and regis_leave!='N'");
                                    }
                                    $sum_leave= mysqli_fetch_assoc($sql_leave_t);
                                    $sum_total=$leave_total['L3']+$sum_leave['sum_leave'];
                                ?>
                            วันลาพักผ่อนปีนี้<u>&nbsp; 10 &nbsp;</u>วัน  วันลาพักผ่อนสะสม<u>&nbsp; <?=$sum_total-10?> &nbsp;</u>รวม<u>&nbsp; <?=$sum_total?> &nbsp;</u>วัน
                            <br />
                            จำนวนวันลาที่เหลือ&nbsp; &nbsp;ลาป่วย<u>&nbsp; <?=$leave_total['L1']?> &nbsp;</u>วัน&nbsp; ลากิจ<u>&nbsp; <?=$leave_total['L2']?> &nbsp;</u>วัน&nbsp; ลาพักผ่อน<u>&nbsp; <?=$leave_total['L3']?> &nbsp;</u>วัน
                            <br /><br>
                            </font></td>
                    </tr>
                    <tr>
                        <td>
                            <div class="box box-primary box-solid">
             <div class="box-header with-border">
                  <h3 class="box-title">ข้อมูลการลา</h3>
                                </div>
                                <div class="box-body">
                                    <table align="center" width="100%" border="0" cellspacing="0" cellpadding="0" class="divider" rules="rows" frame="below">
                                                <?php if (isset($_SESSION['check_dl'])) { ?>
                                            <tr>
                                                <td colspan="9" align="center">ตั้งแต่วันที่
    <?= DateThai1($date01); ?>
                                                    ถึง
    <?= DateThai1($date02); ?></td>
                                            </tr>
<?php } ?>
                                        <tr align="center" bgcolor="#898888">
                                            <td align="center" width="6%"><b>ลำดับ</b></td>
                                            <td align="center" width="10%"><b>เลขที่ใบลา</b></td>
                                            <td align="center" width="10%"><b>วันที่เขียนใบลา</b></td>
                                            <td align="center" width="20%"><b>ประเภทการลา</b></td>
                                            <td align="center" width="10%"><b>ตั้งแต่</b></td>
                                            <td align="center" width="10%"><b>ถึง</b></td>
                                            <td align="center" width="6%"><b>จำนวนวัน</b></td>
                                            <td align="center" width="6%"><b>พิมพ์ใบลา</b></td>
                                            <td align="center" width="6%"><b>ใบลา</b></td>
                                            <td align="center" width="6%"><b>สถานะใบลา</b></td>
                                        <?php if ($_SESSION['Status'] != 'USER') { ?>
                                                <td align="center" width="6%"><b>แก้ไข</b></td>
                                                <td align="center" width="6%"><b>ลบ</b></td>
<?php } ?>
                                        </tr>
                                                    <?php
                                                    $i = 1;
                                                    while ($result = mysqli_fetch_assoc($detial)) {
                                                        ?>
                                            <tr>
                                                <td align="center"><?= $i ?></td>
                                                <td align="center"><a href="#" onclick="return popup('leave/leave_detail.php?id=<?= $result['enpid'] ?>&amp;&amp;Lno=<?= $result['workid'] ?>', popup, 500, 550);">
                                                        <?= $result['leave_no']; ?>
                                                    </a></td>
                                                <td align="center"><a href="#" onclick="return popup('leave/leave_detail.php?id=<?= $result['enpid'] ?>&amp;&amp;Lno=<?= $result['workid'] ?>', popup, 500, 550);">
                                                    <?= DateThai1($result['reg_date']); ?>
                                                    </a></td>
                                                <td align="center"><a href="#" onclick="return popup('leave/leave_detail.php?id=<?= $result['enpid'] ?>&amp;&amp;Lno=<?= $result['workid'] ?>', popup, 500, 550);">
                                                    <?= $result['nameLa']; ?>
                                                    </a></td>
                                                <td align="center"><?= DateThai1($result['begindate']); ?></td>
                                                <td align="center"><?= DateThai1($result['enddate']); ?></td>
                                                <td align="center"><?= $result['amount']; ?></td>
                                                <td align="center"><a href="#" onClick="window.open('leave/leave_paper.php?empno=<?= $empno; ?>&amp;work_id=<?= $result['workid']; ?>','','width=700,height=1000'); return false;" title="พิมพ์ใบลา"><img src='images/printer.ico' alt="" width='30' /></a></td>
                                                <td align="center"><?php if (is_null($result['pics'])) {
                                                echo "<a href='myfile/".$result['pics']."' target='_blank'><span class='fa fa-download'></span> ใบลา" . "<br />";
                                            }
                                                    ?></td>
                                                <td align="center">
                                                    <?php if($result['regis_leave']=='W'){ ?>
                            <i class="fa fa-spinner fa-spin" title="รอลงทะเบียนรับใบลา"></i></a>
                            <?php } elseif ($result['regis_leave']=='A') {?>
                            <img src="images/email.ico" width="20" title="รออนุมัติใบลา"></a>
                            <?php } elseif ($result['regis_leave']=='Y') {?>
                                    <img src="images/Symbol_-_Check.ico" width="20"  title="อนุมัติ">
                                     <?php } elseif ($result['regis_leave']=='N') {?>
                                    <img src="images/button_cancel.ico" width="20" title="ไม่อนุมัติ">
                                     <?php }?>
                                                </td>
                                                
    <?php if ($_SESSION['Status'] != 'USER') { ?>
                                                    <td align="center"><a href="#" onClick="return popup('leave/main_leave.php?id=<?= $result['enpid']; ?>&amp;&amp;method=edit&amp;&amp;leave_no=<?= $result['workid']; ?>', popup, 800, 890);" title="แก้ไขใบลา"><img src='images/file_edit.ico' alt="" width='25' /></a></td>
                                                    <td align="center" width="12%"><a href='index.php?page=leave/detial_leave&id=<?= $empno; ?>&work_id=<?= $result['workid']; ?>' onclick="return confirm('กรุณายืนยันการลบอีกครั้ง !!!')"><img src='images/file_delete.ico' alt="" width='25' /></a></td>
    <?php } ?>
                                            </tr>
    <?php $i++;
}
?>
                                    </table>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="box box-info box-solid">
             <div class="box-header with-border">
                  <h3 class="box-title">ข้อมูลการลาชั่วโมง</h3>
                                </div>
<?php
$count_check = mysqli_query($db,"select sum(total) as sum from timela where empno='$empno' and status='N' ");
$check_tl = mysqli_fetch_assoc($count_check);
?>
                                <div class="box-body">
                                    <form action="index.php?page=leave/transfer_leave" method="post" name="form" enctype="multipart/form-data" id="form" >
                                        <table align="center" width="100%" border="0" cellspacing="0" cellpadding="0" class="divider" rules="rows" frame="below">
                                            <tr align="center" bgcolor="#898888">
                                                <td align="center" width="5%"><b>ลำดับ</b></td>
                                                <td align="center" width="10%"><b>เลขที่ใบลา</b></td>
                                                <td align="center" width="10%"><b>วันที่ลา</b></td>
                                                <td align="center" width="10%"><b>ตั้งแต่</b></td>
                                                <td align="center" width="10%"><b>ถึง</b></td>
                                                <td align="center" width="10%"><b>จำนวนชั่วโมง</b></td>
                                                <td align="center" width="6%"><b>พิมพ์ใบลา</b></td>
                                                <td width="7%" align="center"><b>ใบลา</b></td>
                                                <td width="10%" align="center"><b>สถานะใบลา</b></td>
                                            <?php if ($_SESSION['Status'] != 'USER') { ?>
                                                    <td width="6%" align="center"><b>แก้ไข</b></td>
                                                    <td align="center" width="6%"><b>ลบ</b></td>
    <?php if ($check_tl['sum'] >= 8) { ?>
                                                        <td align="center" width="10%"><b>โอนการลา</b></td>
                                                            <?php } ?>
<?php } ?>
                                            </tr>
                                                        <?php
                                                        $i = 1;
                                                        while ($result = mysqli_fetch_assoc($detiatl)) {
                                                            ?>
                                                <tr>
                                                    <td align="center"><?= $i ?></td>
                                                    <td align="center"><a href="#" onclick="return popup('leave/Tleave_detail.php?id=<?= $result['empno'] ?>&amp;&amp;Lno=<?= $result['id'] ?>', popup, 700, 450);">
                                                        <?= $result['idno']; ?>
                                                        </a></td>
                                                    <td align="center"><a href="#" onclick="return popup('leave/Tleave_detail.php?id=<?= $result['empno'] ?>&amp;&amp;Lno=<?= $result['id'] ?>', popup, 700, 450);">
                                                    <?= DateThai1($result['datela']); ?>
                                                        </a></td>
                                                    <td align="center"><?= $result['starttime']; ?></td>
                                                    <td align="center"><?= $result['endtime']; ?></td>
                                                    <td align="center"><?= $result['total']; ?></td>
                                                    <td align="center"><a href="#" onClick="window.open('leave/leavet_paper.php?empno=<?= $empno; ?>&amp;Lno=<?= $result['id'] ?>','','width=700,height=1000'); return false;" title="พิมพ์ใบลาชั่วโมง"><img src='images/printer.ico' alt="" width='30' /></a></td>
                                                    <td align="center"><?php if ($result['pics_t'] != '') {
                                                    echo "<a href='time_l/".$result['pics_t']."' target='_blank'><span class='fa fa-download'></span> ใบลา" . "<br />";
                                                }
                                                    ?></td>
                                                    <td align="center">
                                                    <?php if($result['regis_time']=='W'){ ?>
                            <i class="fa fa-spinner fa-spin" title="รอลงทะเบียนรับใบลา"></i></a>
                            <?php } elseif ($result['regis_time']=='A') {?>
                            <img src="images/email.ico" width="20" title="รออนุมัติใบลา"></a>
                            <?php } elseif ($result['regis_time']=='Y') {?>
                                    <img src="images/Symbol_-_Check.ico" width="20"  title="อนุมัติ">
                                     <?php } elseif ($result['regis_time']=='N') {?>
                                    <img src="images/button_cancel.ico" width="20" title="ไม่อนุมัติ">
                                     <?php }?>
                                                </td>
                                            <?php if ($_SESSION['Status'] != 'USER') { ?>
                                                        <td align="center"><a href="#" onClick="return popup('leave/time_leave.php?id=<?= $result['empno']; ?>&amp;&amp;method=edit_Tleave&amp;&amp;leave_no=<?= $result['id']; ?>', popup, 800, 650);" title="แก้ไขใบลา"><img src='images/file_edit.ico' alt="" width='25' /></a></td>
                                                        <td align="center" width="12%"><a href='index.php?page=leave/detial_leave&id=<?= $empno; ?>&time_id=<?= $result['id']; ?>' onclick="return confirm('กรุณายืนยันการลบอีกครั้ง !!!')"><img src='images/file_delete.ico' alt="" width='25' /></a></td>
        <?php if ($check_tl['sum'] >= 8) { ?>
                                                            <td align="center"><input id="leave_id[]" name="leave_id[]" type="checkbox" value="<?= $result['id']; ?>"/>
                                                                <input id="check[]" name="check[]" type="hidden" value="<?= $result['empno']; ?>" /></td>
                                                <?php } ?>
                                            <?php } ?>
                                                </tr>
    <?php $i++;
}?>
                                        </table>
<?php if ($_SESSION['Status'] != 'USER') { ?>
    <?php if ($check_tl['sum'] >= 8) { ?>
                                                <br />
                                                <center>
                                                    <input type="hidden" name="check_id" id="check_id" value="<?= $empno; ?>" />
                                                    <input class="btn btn-warning" name="submit" type="submit"  value="โอน" onClick="return confirm('กรุณายืนยันการโอนอีกครั้ง !!!')"/>
                                                </center>
    <?php } ?>
<?php } ?>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
        </div>
    </div>
</div>
</div>
</section>