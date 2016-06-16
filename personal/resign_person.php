<?php
if (isset($_REQUEST['del_id'])) { //ถ้า ค่า del_id ไม่เท่ากับค่าว่างเปล่า
    include 'connection/connect.php';
    $del_id = $_REQUEST['del_id'];
    $sql_del = "delete from emppersonal where empno = '$del_id';";
    mysqli_query($db,$sql_del) or die(mysql_error());
    $sqle_del = "delete from educate where empno = '$del_id';";
    mysqli_query($db,$sqle_del) or die(mysql_error());
//echo "ลบข้อมูล ID $del_id เรียบร้อยแล้ว";
    $db->close();
}?>
<section class="content-header">
              <h1><img src='images/identity-x.png' width='40'><font color='blue'> ข้อมูลบุคลากรย้าย/ลาออก </font></h1> 
            <ol class="breadcrumb">
              <li><a href="../index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
              <li class="active"><i class="fa fa-edit"></i> ข้อมูลบุคลากรย้าย/ลาออก</li>
            </ol>
</section>
<section class="content">
<div class="row">
          <div class="col-lg-12">
              <div class="box box-danger box-solid">
                <div class="box-header">
                  <h3 class="box-title"><img src='images/kuser.ico' width='25'> ตารางบุคลากรย้าย/ลาออก</h3>
                    </div><!-- /.box-header -->
                <div class="box-body">
                    <?php  
include 'connection/connect.php';
 $q="select e1.empno as empno, e1.pid as pid, concat(p2.pname,e1.firstname,'  ',e1.lastname) as fullname, p1.posname as posname from emppersonal e1 
INNER JOIN posid p1 on e1.posid=p1.posId
inner join pcode p2 on e1.pcode=p2.pcode
where e1.posid=p1.posId and e1.status !='1'
ORDER BY empno";

$qr=mysqli_query($db,$q); ?>
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr align="center" bgcolor="#898888">
                                <th align="center" width="7%">ลำดับ</th>
                                <th align="center" width="10%">เลขที่</td>
                                <th align="center" width="32%">ชื่อ-นามสกุล</th>
                                <th align="center" width="21%">ตำแหน่ง</th>
                                <th align="center" width="15%">แก้ไข</th>
                                <th align="center" width="15%">ลบ</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                             $i=1;
while($result=mysqli_fetch_assoc($qr)){?>
    <tr>
                                <td align="center"><?= $i?></td>
                                <td align="center"><?=$result['pid'];?></td>
                                <td><a href="#" onClick="window.open('personal/detial_person.php?id=<?=$result['empno']?>','','width=700,height=500'); return false;" title="Code PHP Popup"><?=$result['fullname'];?></a></td>
                                <td align="center"><?=$result['posname'];?></td>
                                <td align="center" width="12%"><a href="index.php?page=personal/add_person&method=edit&&id=<?=$result['empno'];?>"><img src='images/file_edit.ico' width='25'></a></td>
                                <td align="center" width="12%"><a href='index.php?page=personal/resign_person&del_id=<?=$result['empno'];?>' onClick="return confirm('กรุณายืนยันการลบอีกครั้ง !!!')"><img src='images/file_delete.ico' width='25'></a></td>
        </tr>
    <?php $i++; } $db->close(); ?>
                          </tbody>      
                        </table>
              </div>
          </div>
</div>
</div>
</section>
