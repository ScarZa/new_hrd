<section class="content-header">            
    <h1><img src='images/Lfolder.ico' width='40'><font color='blue'>  ข้อมูลการลา </font></h1> 
            <ol class="breadcrumb">
              <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
              <li class="active"><i class="fa fa-edit"></i> ข้อมูลการลา</li>
            </ol>
</section>
<section class="content">
<div class="row">
          <div class="col-lg-12">
              <div class="box box-info box-solid">
             <div class="box-header with-border">
                  <h3 class="box-title"><img src='images/Lfolder.ico' width='25'> ตารางบุคลากร</h3>
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
$qr=mysqli_query($db,$q); ?>
                        <table id="example1" class="table table-bordered table-striped" width="100%" border="0" cellspacing="0" cellpadding="0" rules="rows" frame="below">
                            <thead>
                            <tr align="center" bgcolor="#898888">
                                <td align="center" width="6%"><b>ลำดับ</b></td>
                                <td align="center" width="9%"><b>เลขที่</b></td>
                                <td align="center" width="29%"><b>ชื่อ-นามสกุล</b></td>
                                <td align="center" width="20%"><b>ตำแหน่ง</b></td>
                                <td align="center" width="11%"><b>บันทึกการลา</b></td>
                                <td align="center" width="11%"><b>บันทึกการลาชั่วโมง</b></td>
                                <?php if($_SESSION['Status']=='ADMIN'){?>
                                <td align="center" width="11%"><b>เพิ่มวันลา</b></td>
                                <?php }?>
                            </tr>
                            </thead> 
                            <tbody>
                            <?php
                             $i=1;
while($result=mysqli_fetch_assoc($qr)){?>
    <tr>
                                <td align="center"><?= $i?></td>
                                <td align="center"><?=$result['pid'];?></td>
                                <td><a href="index.php?page=leave/detial_leave&id=<?=$result['empno'];?>"><?=$result['fullname'];?></a></td>
                                <td align="center"><?=$result['posname'];?></td>
                                <td width="11%" align="center"><a href="#" onClick="return popup('leave/main_leave.php?id=<?=$result['empno'];?>', popup, 800, 890);" title="เขียนใบลา"><img src='images/Letter.png' width='30'></a></td>
                                <td width="12%" align="center"><a href="#" onClick="return popup('leave/time_leave.php?id=<?=$result['empno'];?>', popup, 800, 650);" title="เขียนใบลาชั่วโมง"><img src='images/Time.png' width='30'></a></td>
                                <?php if($_SESSION['Status']=='ADMIN'){?>
                                <td align="center"><a href="add_leave.php?id=<?=$result['empno'];?>"><a href="#" onClick="return popup('leave/add_leave.php?id=<?=$result['empno'];?>', popup, 750, 580);" title="เขียนใบลาชั่วโมง"><img src='images/edit_add.ico' width='30'></a></td>
                                <?php }?>
    </tr>
    <?php $i++; } ?>
                            </tbody>        
                        </table>

              </div>
          </div>
</div>
</div>
</section>
