<?php include 'connection/connect.php';
if(isset($_POST["check_id"])) {
$check_id = $_POST["check_id"];}
if (empty($_POST['leave_id'])) {
    echo "<div class='alert alert-dismissable alert-danger'>
	  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
	  <a class='alert-link' target='_blank' href='#'><center>***ยังไม่ได้เลือกรายการที่จะโอน***</center></a> 
</div>";

    echo "<meta http-equiv='refresh' content='2;URL=index.php?page=leave/detial_leave&id=$check_id' />";
}else{ if(!empty($_POST['leave_id'])){
for ($i = 0; $i < count($_POST['leave_id']); $i++) {
    if (trim($_POST['leave_id'][$i]) != '') {
        $empno[$i] = $_POST['check'][$i];
        $id_l[$i] = $_POST['leave_id'][$i];
        
        $sql=  mysqli_query($db,"update timela set status='Y' where id='$id_l[$i]' and empno='$empno[$i]'");
}}}
$Detial_name = mysqli_query($db,"select e1.depid as depno,concat(p1.pname,e1.firstname,' ',e1.lastname) as fullname,
                            d1.depName as dep,p2.posname as posi,e1.empno as empno
                            from emppersonal e1 
                            inner join pcode p1 on e1.pcode=p1.pcode
                            inner join department d1 on e1.depid=d1.depId
                            inner join posid p2 on e1.posid=p2.posId
                            where e1.empno='$check_id'");
$NameDetial = mysqli_fetch_assoc($Detial_name);
?>
<section class="content-header">
              <h1><font color='blue'>  โอนการลา </font></h1> 
            <ol class="breadcrumb">
              <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
              <li><a href="index.php?page=leave/detial_leave&id=<?=$check_id?>"><i class="fa fa-home"></i> รายละเอียดข้อมูลการลา</a></li>
              <li class="active"><i class="fa fa-edit"></i> โอนการลา</li>
              </ol>
</section>
<section class="content">
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">ข้อมูลบุคลากร</h3>
            </div>
            <div class="panel-body">
                ชื่อ นามสกุล : <?= $NameDetial['fullname']; ?><br>
                ตำแหน่ง : <?= $NameDetial['posi']; ?><br>
                ฝ่าย-งาน : <?= $NameDetial['dep']; ?><br><br>
                <form class="navbar-form" role="form" action='process/prcleave.php' enctype="multipart/form-data" method='post' onSubmit="return Check_txt()">

                <table align="center" width='100%'>
                    <thead>
                        <tr>
                <th align="right">เลขที่ใบลา : </th>
                <td colspan="3">
                    <div class="form-group">
                <input type="text" name="leave_no" id=leave_no" class="form-control" placeholder="เลขที่ใบลา" required>
                </div>
                </td>
              </tr><tr>
                <th align="right">&nbsp;</th>
                <td colspan="3">&nbsp;</td>
              </tr>
              <tr><th align="right">วันที่เขียนใบลา : </th>
                  <td  colspan="3">
                      <div class="form-group">
                      <input type="date" name="date_reg" id="date_reg" class="form-control" required>
                      </div></td></tr>
              <tr>
                <th align="right">&nbsp;</th>
                <td  colspan="3">&nbsp;</td>
              </tr><tr><th align="right">ประเภทการลา : </th><td colspan="3">
                      <div class="form-group">
                          <select name="typel" id="typel" class="form-control" required>
                              <?php	$sql = mysqli_query($db,"SELECT *  FROM typevacation order by idla  ");
				 echo "<option value=''>--เลือกประเภทการลา--</option>";
				 while( $result = mysqli_fetch_assoc( $sql ) ){
          //if($result[idla]==$edit_person[pcode]){$selected='selected';}else{$selected='';}
				 echo "<option value='".$result['idla']."' $selected>".$result['nameLa'] ."</option>";
				 } ?>
			 </select>
                      </div></td></tr>
              
              <tr>
                <th align="right">&nbsp;</th>
                <td  colspan="3">&nbsp;</td>
              </tr>
              <tr>
                <th align="right">รวมจำนวน : </th>
                <td colspan="3">
                    <div class="form-group">
                    <input type="text" name="amount" id="amount" class="form-control" placeholder="จำนวนวันลา" onKeyUp="javascript:inputDigits(this);" required>
                    </div> วัน
                </td>
                </tr>
              <tr>
                <th align="right">&nbsp;</th>
                <td colspan="3">&nbsp;</td>
              </tr>
              <tr>
                <th align="right" valign="top">หมายเหตุ : </th>
                <td colspan="3">
                    <div class="form-group">
                    <textarea class="form-control" name="note" cols="50" rows="" placeholder="หมายเหตุ"></textarea>
                    </div>
                </td>
              </tr>
                    </thead>
                </table>
                    <br><br>
                    <center>
                    <div class="form-group">
                        <input type="hidden" name="empno" value="<?=$check_id;?>">
                        <input type="hidden" name="depno" value="<?=$NameDetial['depno'];?>">
                        <input type="hidden" name="method" value="transfer">    
                        <input class="btn btn-success" type="submit" name="submit" value="บันทึก">
                    </div>
                        </center>
                </form>
                </div></div></div></div>
<?php } $db->close();?>
</section>