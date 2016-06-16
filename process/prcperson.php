<?php include 'header.php';?>
<section class="content">
<?php
echo	 "<p>&nbsp;</p>	"; 
echo	 "<p>&nbsp;</p>	";
echo "<div class='bs-example'>
	  <div class='progress progress-striped active'>
	  <div class='progress-bar' style='width: 100%'></div>
</div>";
echo "<div class='alert alert-dismissable alert-success'>
	  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
	  <a class='alert-link' target='_blank' href='#'><center>กำลังดำเนินการ</center></a> 
</div>";

    $empid = $_POST['empid'];
    $cid = $_POST['cidid'];
    $pname = $_POST['pname'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $sex = $_POST['sex'];
    $take_date_conv = $_POST['bday'];
    $bday='';
    insert_date($take_date_conv,$bday);
    $address = $_POST['address'];
    $hname = $_POST['hname'];
    $Province = $_POST['province'];
    $Amphur = $_POST['amphur'];
    $district = $_POST['district'];
    $postcode = $_POST['postcode'];
    $status = $_POST['status'];
    $htell = $_POST['htell'];
    $mtell = $_POST['mtell'];
    $email = $_POST['email'];
    $order = $_POST['order'];
    $posid=$_POST['position'];
    $dep = $_POST['dep'];
    $line = $_POST['line'];
    $pertype = $_POST['pertype'];
    $educat = $_POST['educat'];
    $swday_conv = $_POST['swday'];
    $swday ='';
    insert_date($swday_conv,$swday);
    $teducat = $_POST['teducat'];
    $major = $_POST['major'];
    $inst = $_POST['inst'];
    $grad_conv = $_POST['Graduation'];
    $grad='';
    insert_date($grad_conv,$grad);
    $statusw = $_POST['statusw'];
    $reason = $_POST['reason'];
    $movedate = $_POST['movedate'];
    if ($_POST['method'] == 'add_person') {
        function removespecialchars($raw) {
    return preg_replace('#[^a-zA-Z0-9.-]#u', '', $raw);
}

if (trim($_FILES["image"]["name"] != "")) {
    if (move_uploaded_file($_FILES["image"]["tmp_name"], "../photo/" . removespecialchars(date("d-m-Y/") . "1" . $_FILES["image"]["name"]))) {
        $file1 = date("d-m-Y/") . "1" . $_FILES["image"]["name"];
        $image = removespecialchars($file1);
    }
}  else {
    $image ='';
}
include '../connection/connect.php';
    $add = mysqli_query($db,"insert into emppersonal set pid='$empid', idcard='$cid', pcode='$pname', firstname='$fname',
                lastname='$lname', sex='$sex', birthdate='$bday', address='$address', baan='$hname', provice='$Province',
                   empure='$Amphur', tambol='$district', zipcode='$postcode', emp_status='$status', telephone='$htell',
                      mobile='$mtell', email='$email', empcode='$order', posid='$posid', depid='$dep', empstuc='$line', emptype='$pertype',
                         education='$educat', dateBegin='$swday', status='$statusw', empnote='$reason', dateEnd='$movedate', photo='$image' ");
    $db->close();
    if ($add == false) {
        echo "<p>";
        echo "Insert not complete" . mysql_error();
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='../index.php?page=personal/add_person.php' >กลับ</a>";
    } else {
        include '../connection/connect.php';
        $select_ed = mysqli_query($db,"select empno from emppersonal where pid='$empid'");
        $educ = mysqli_fetch_assoc($select_ed);
        $empno = $educ['empno'];

        $add_educate = mysqli_query($db,"insert into educate set empno='$empno', educate='$teducat',
                                                                            major='$major', institute='$inst', enddate='$grad'");
        $db->close();
        if ($add_educate == false) {
            echo "<p>";
            echo "Insert not complete" . mysql_error();
            echo "<br />";
            echo "<br />";

            echo "	<span class='glyphicon glyphicon-remove'></span>";
            echo "<a href='../index.php?page=personal/add_person' >กลับ</a>";
        } else {
            echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=../index.php?page=personal/add_person'>";
        }
    }
}else if ($_POST['method'] == 'edit') {
    $empno=$_REQUEST['edit_id'];
    include '../connection/connect.php';
    function removespecialchars($raw) {
    return preg_replace('#[^a-zA-Z0-9.-]#u', '', $raw);}
if (trim($_FILES["image"]["name"] == "")) {
    $edit = mysqli_query($db,"update emppersonal set pid='$empid', idcard='$cid', pcode='$pname', firstname='$fname',
                lastname='$lname', sex='$sex', birthdate='$bday', address='$address', baan='$hname', provice='$Province',
                   empure='$Amphur', tambol='$district', zipcode='$postcode', emp_status='$status', telephone='$htell',
                      mobile='$mtell', email='$email', empcode='$order', posid='$posid', depid='$dep', empstuc='$line', emptype='$pertype',
                         education='$educat', dateBegin='$swday', status='$statusw', empnote='$reason', dateEnd='$movedate'
                             where empno='$empno'");
    $db->close();
}else{
    if (move_uploaded_file($_FILES["image"]["tmp_name"], "../photo/" . removespecialchars(date("d-m-Y/") . "1" . $_FILES["image"]["name"]))) {
        $file1 = date("d-m-Y/") . "1" . $_FILES["image"]["name"];
        $image = removespecialchars($file1);
    
} else{
    $image ='';
}
$edit = mysqli_query($db,"update emppersonal set pid='$empid', idcard='$cid', pcode='$pname', firstname='$fname',
                lastname='$lname', sex='$sex', birthdate='$bday', address='$address', baan='$hname', provice='$Province',
                   empure='$Amphur', tambol='$district', zipcode='$postcode', emp_status='$status', telephone='$htell',
                      mobile='$mtell', email='$email', empcode='$order', posid='$posid', depid='$dep', empstuc='$line', emptype='$pertype',
                         education='$educat', dateBegin='$swday', status='$statusw', empnote='$reason', dateEnd='$movedate', photo='$image'
                             where empno='$empno'");
    $db->close();
}
    if ($edit == false) {
        echo "<p>";
        echo "Update not complete" . mysql_error();
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='../index.php?page=personal/pre_person' >กลับ</a>";
    
    } else {
 include '../connection/connect.php';
        $update_educate = mysqli_query($db,"update educate set educate='$teducat',
                                            major='$major', institute='$inst', enddate='$grad'
                                                where empno='$empno'");
        $db->close();
        if ($update_educate == false) {
            echo "<p>";
            echo "Update not complete" . mysql_error();
            echo "<br />";
            echo "<br />";

            echo "	<span class='glyphicon glyphicon-remove'></span>";
            echo "<a href='../index.php?page=personal/pre_person' >กลับ</a>";
        } else {
            echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=../index.php?page=personal/pre_person'>";
        }
    }
}
?>
</section>
<?phpinclude 'footer.php';?>