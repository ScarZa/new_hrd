<?php
if (isset($_REQUEST['del_id'])) { //ถ้า ค่า del_id ไม่เท่ากับค่าว่างเปล่า
    include 'connection/connect.php';
    $del_id = $_REQUEST['del_id'];
    $edu=$_REQUEST['edu'];
    $sqle_del = "delete from educate where empno = '$del_id' and ed_id='$edu'";
    mysqli_query($db,$sqle_del) or die(mysqli_error());
//echo "ลบข้อมูล ID $del_id เรียบร้อยแล้ว";
    $db->close();
}?>
<?php
$empno = $_REQUEST['id'];
if (isset($_SESSION['emp'])) {
    $empno = $_SESSION['emp'];
} elseif ($_SESSION['Status'] == 'USER') {
    $empno = $_SESSION['user'];
}
 include 'connection/connect.php';
$name_detial = mysqli_query($db,"select concat(p1.pname,e1.firstname,' ',e1.lastname) as fullname,
                            d1.depName as dep,p2.posname as posi,e1.empno as empno
                            from emppersonal e1 
                            inner join pcode p1 on e1.pcode=p1.pcode
                            inner join department d1 on e1.depid=d1.depId
                            inner join posid p2 on e1.posid=p2.posId
                            where e1.empno='$empno'");


    $detial = mysqli_query($db,"SELECT * from educate e1
                        INNER JOIN education e2 on e1.educate=e2.education
                        where e1.empno='$empno' ORDER BY e1.educate DESC");


$NameDetial = mysqli_fetch_assoc($name_detial);

include_once ('plugins/funcDateThai.php');
?>
<section class="content-header">
        <h1><font color='blue'>  รายละเอียดข้อมูลการศึกษาของบุคลากร </font></h1> 
        <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
            
<?php if ($_SESSION['Status'] == 'ADMIN') {?>
    <li><a href="index.php?page=personal/pre_educate"><i class="fa fa-edit"></i> ข้อมูลการศึกษา</a></li>
<?php } ?>
            <li class="active"><i class="fa fa-edit"></i> รายละเอียดข้อมูลการศึกษาของบุคลากร</li>
        </ol>
        </section>
<section class="content">
<div class="row">
    <div class="col-lg-12">
        <div class="box box-info box-solid">
                <div class="box-header">
                    <h3 class="box-title">ข้อมูลบุคลากร</h3>
            </div>
            <div class="box-body">
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
                                ?>
                            </font></td>
                    </tr>
                    <tr>
                        <td>
                            <div class="box box-primary box-solid">
                <div class="box-header">
                    <h3 class="box-title">ข้อมูลการศึกษา</h3>
                                </div>
                                <div class="box-body">
                                    <table id="example"  align="center" width="100%" border="0" cellspacing="0" cellpadding="0" class="divider table table-bordered table-striped" rules="rows" frame="below">
                                        <thead>
                                        <tr align="center" bgcolor="#898888">
                                            <td align="center" width="6%"><b>ลำดับ</b></td>
                                            <td align="center" width="10%"><b>วุฒิการศึกษา</b></td>
                                            <td align="center" width="10%"><b>สาขา/วิชาเอก</b></td>
                                            <td align="center" width="20%"><b>สถาบัน</b></td>
                                            <td align="center" width="10%"><b>จบการศึกษาเมื่อ</b></td>
                                            <?php if($_SESSION['Status']=='ADMIN'){?>
                                            <th align="center" width="7%">แก้ไข</th>
                                            <th align="center" width="7%">ลบ</th>
                                            <?php }?>

                                        </tr>
                                        </thead>
                                        <tbody>
                                                    <?php
                                                    $i = 1;
                                                    while ($result = mysqli_fetch_assoc($detial)) {
                                                        ?>
                                            <tr>
                                                <td align="center"><?= $i ?></td>
                                                <td align="center"><?= $result['eduname']; ?></td>
                                                <td align="center"><?= $result['major'] ?></td>
                                                <td align="center"><?= $result['institute']; ?></td>
                                                <td align="center"><?= DateThai1($result['enddate']); ?></td>
                                                <?php if($_SESSION['Status']=='ADMIN'){?>
                                                <td align="center" width="12%"><a href="#" onclick="return popup('personal/add_educate.php?id=<?= $empno?>&amp;method=edit_edu&amp;edu=<?= $result['ed_id']?>', popup, 500, 550);">
                                                        <img src='images/file_edit.ico' width='25'></a></td>
                                                        <td align="center" width="12%"><a href='index.php?page=personal/detial_educate&id=<?= $empno?>&del_id=<?=$result['empno'];?>&edu=<?= $result['ed_id']?>' onClick="return confirm('กรุณายืนยันการลบอีกครั้ง !!!')"><img src='images/file_delete.ico' width='25'></a></td>
                                                <?php }?>
                                            </tr>
    <?php $i++;
}$db->close();
?>
                                        </tbody>
                                    </table>
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
