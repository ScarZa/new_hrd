<?php require'connection/connect.php'; ?>
<?php $result=$_GET['result'];
$select_id=$_GET['select_id'];
if ($result == 'amphur') { ?>
    
    <?php
    $rstTemp = mysqli_query($db,"select * from amphur Where PROVINCE_ID ='" . $select_id . "' Order By AMPHUR_ID ASC");
    echo "<option value=''>---โปรดเลือกอำเภอ---</option>";
    while ($arr_2 = mysqli_fetch_array($rstTemp)) {
if($arr_2['AMPHUR_ID']==$edit_person['empure']){$selected='selected';}else{$selected='';}
      echo "<option value='".$arr_2['AMPHUR_ID']."' $selected>".$arr_2['AMPHUR_NAME']."</option>";
}
} $db->close();?>

    <?php if ($result == 'district') {  include 'connection/connect.php';
     $rstTemp = mysqli_query($db,"select * from district Where AMPHUR_ID ='" . $select_id . "'  Order By DISTRICT_ID ASC");
        echo "<option value=''>---โปรดเลือกตำบล---</option>";
        while ($arr_2 = mysqli_fetch_array($rstTemp)) {
        echo "<option value='".$arr_2['DISTRICT_ID']."'>".$arr_2['DISTRICT_NAME']."</option>";
    } } $db->close(); ?>