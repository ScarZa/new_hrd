<section class="content-header">
        <h1><font color='blue'><img src='images/kchart.ico' width='40'>  สถิติบุคลากรแยกตามหน่วยงาน </font></h1> 
        <ol class="breadcrumb">
            <li><a href="../index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
            <li class="active"><i class="fa fa-edit"></i> สถิติบุคลากรแยกตามหน่วยงาน</li>
        </ol>
</section>
<section class="content">
<div class="row">
    <div class="col-lg-12">
        <div class="box box-warning box-solid">
                <div class="box-header">
                  <h3 class="box-title"><img src='images/kchart.ico' width='25'> ตารางสถิติของบุคลากรแยกตามหน่วยงาน</h3>
            </div>
            <div class="box-body">
              <form class="navbar-form navbar-right" name="frmSearch" role="search" method="post" action="index.php?page=personal/statistics_person">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td>
                                <div class="form-group">
 				<select name="dep" id="dep"  class="form-control"  onkeydown="return nextbox(event, 'line');"> 
				<?php include 'connection/connect.php';
                                $sql = mysqli_query($db,"SELECT *  FROM department order by depId");
				 echo "<option value=''>--เลือกหน่วยงาน--</option>";
				 while( $result = mysqli_fetch_assoc( $sql ) ){
  				 echo "<option value='".$result['depId']."' $selected>".$result['depName']." </option>";
				 } ?>
			 </select></div> 
                                <input type="hidden"   name='method' class="form-control" value='Lperson_dep' >
                                <button type="submit" class="btn btn-success"><i class="fa fa-search"></i> ตกลง</button> </td>


                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                    </table>
                </form>

               <?php
               if(isset($_REQUEST['method'])){
                if($_REQUEST['method']=='Lperson_dep'){ 
               $depno=$_REQUEST['dep'];}}else{$depno='';}
                if(isset($depno)){
                    include 'connection/connect.php';
                $q="SELECT CONCAT(p.pname,e.firstname,' ',e.lastname) as fullname,p1.posname as position ,e1.TypeName as type,e.empno as empno, e.pid as pid
FROM emppersonal e
LEFT OUTER JOIN pcode p ON e.pcode=p.pcode
LEFT OUTER JOIN emptype  e1 ON e1.EmpType=e.emptype
LEFT OUTER JOIN posid p1 ON p1.posId=e.posid
WHERE e.depid='$depno' and e.status='1'
ORDER BY position";
                $qr=  mysqli_query($db,$q);
                $sql_dep=  mysqli_query($db,"select depName as name from department where depId='$depno'");
$depname = mysqli_fetch_assoc($sql_dep);
                }
?>

                    <?php include_once ('plugins/funcDateThai.php'); ?>
                 <table id="example2" class="table table-bordered table-striped">
                            <thead>
                    <?php if(isset($_REQUEST['method'])){if ($_REQUEST['method']=='Lperson_dep') { ?>
                        <tr>
                            <td colspan="5" align="center"><?= $depname['name']?></td>
                        </tr>
                    <?php }} ?>
                    <tr align="center" bgcolor="#898888">
                        <td width="22" align="center"><b>ลำดับ</b></td>
                        <td width="22" align="center"><b>เลขที่</b></td>
                        <td width="22" align="center"><b>ชื่อ-นามสกุล</b></td>
                        <td width="45" align="center"><b>ตำแหน่ง</b></td>
                        <td width="21" align="center"><b>ประเภทพนักงาน</b></td>
                        
                    </tr>
                            </thead>
                            <tbody>
                    <?php if(isset($_REQUEST['method'])){
                    $i = 1;
                    while ($result = mysqli_fetch_assoc($qr)) {
                        ?>
                        <tr>
                            <td align="center"><?= $i ?></td>
                            <td align="center"><?= $result['pid']?></td>
                             <td><a href="#" onClick="window.open('personal/detial_person.php?id=<?=$result['empno']?>','','width=700,height=500'); return false;" title="Code PHP Popup">
                              <?= $result['fullname']; ?></a></td>
                            <td align="center"><?= $result['position']; ?></td>
                            <td align="center"><?= $result['type']; ?></td>
                         </tr>
                    <?php $i++; }} ?>
                            </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</section>
