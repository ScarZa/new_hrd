<section class="content-header">
              <h1><img src='images/Student.ico' width='25'><font color='blue'>  ข้อมูลการศึกษา </font></h1> 
            <ol class="breadcrumb">
              <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
              <li class="active"><i class="fa fa-edit"></i> ข้อมูลการศึกษา</li>
            </ol>
</section>
<section class="content">
<div class="row">
          <div class="col-lg-12">
              <div class="box box-info box-solid">
                <div class="box-header">
                    <h3 class="box-title"><img src='images/Lfolder.ico' width='25'> ตารางประวัติการศึกษาของบุคลากร</h3>
                    </div>
                <div class="box-body">

                    <?php  
include 'connection/connect.php';
if($_SESSION['Status']=='ADMIN'){

 $q="select e1.empno as empno, e1.pid as pid, concat(p2.pname,e1.firstname,'  ',e1.lastname) as fullname, p1.posname as posname from emppersonal e1 
INNER JOIN posid p1 on e1.posid=p1.posId
inner join pcode p2 on e1.pcode=p2.pcode
where e1.posid=p1.posId and e1.status ='1'
ORDER BY empno";
 }else{
     $empno=$_SESSION['user'];
   $q="select e1.empno as empno, e1.pid as pid, concat(p2.pname,e1.firstname,'  ',e1.lastname) as fullname, p1.posname as posname from emppersonal e1 
INNER JOIN posid p1 on e1.posid=p1.posId
inner join pcode p2 on e1.pcode=p2.pcode
where e1.posid=p1.posId and e1.empno='$empno' and e1.status ='1'
ORDER BY empno";  
 }
$qr=mysqli_query($db,$q);

?>
 
  
                        <table id="example1" class="table table-bordered table-striped" width="100%">
                            <thead>
                            <tr align="center" bgcolor="#898888">
                                <th align="center" width="5%"><b>ลำดับ</b></th>
                                <th align="center" width="10%"><b>เลขที่</b></th>
                                <th align="center" width="20%"><b>ชื่อ-นามสกุล</b></th>
                                <th align="center" width="25%"><b>ตำแหน่ง</b></th>
                                <th align="center" width="30%"><b>เพิ่มประวัติการศึกษา</b></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                             $i=1;
while($result=mysqli_fetch_assoc($qr)){?>
    <tr>
                                <td align="center"><?=$i?></td>
                                <td align="center"><?=$result['pid'];?></td>
                                <td><a href="index.php?page=personal/detial_educate&id=<?=$result['empno'];?>"><?=$result['fullname'];?></a></td>
                                <td align="center"><?=$result['posname'];?></td>
                                <td align="center"><a href="#" onclick="return popup('personal/add_educate.php?id=<?= $result['empno'] ?>', popup, 500, 500);">
                                <img src='images/edit_add.ico' width='30'></a></td>
        </tr>
    
    <?php $i++; } $db->close(); ?>
        </tbody>
    <tfoot>
        <tr>
                                <th align="center" width="6%"><b>ลำดับ</b></th>
                                <th align="center" width="10%"><b>เลขที่</b></th>
                                <th align="center" width="20%"><b>ชื่อ-นามสกุล</b></th>
                                <th align="center" width="20%"><b>ตำแหน่ง</b></th>
                                <th align="center" width="10%"><b>เพิ่มประวัติการศึกษา</b></th>
                            </tr>
    </tfoot>
                                
                        </table>

              </div>
          </div>
          </div></div>
</section>
