<?php session_start(); ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>ระบบข้อมูลบุคคลากรโรงพยาบาล</title>
    <LINK REL="SHORTCUT ICON" HREF="images/logo.png">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="../plugins/iCheck/flat/blue.css">
    <!-- Morris chart -->
    <link rel="stylesheet" href="../plugins/morris/morris.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="../plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <!-- Date Picker -->
    <link rel="stylesheet" href="../plugins/datepicker/datepicker3.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="../plugins/daterangepicker/daterangepicker-bs3.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
<script language="JavaScript" type="text/javascript"> 
var StayAlive = 1; // เวลาเป็นวินาทีที่ต้องการให้ WIndows เปิดออก 
function KillMe()
{ 
setTimeout("self.close()",StayAlive * 1000); 
} 
</script>
<?php
                    function insert_date(&$take_date_conv,&$take_date)
                    {
                        $take_date=explode("/",$take_date_conv);
			 $take_date_year=$take_date[2]-543;
			 $take_date="$take_date_year-$take_date[1]-$take_date[0]";
                    }
?>
  </head>
  <body class="hold-transition skin-green fixed sidebar-mini" onLoad="KillMe();self.focus();window.opener.location.reload();">
      <section class="content">
<?php
require '../connection/connect.php';
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

    $empno = $_POST['empno'];
    $teducat = $_POST['teducat'];
    $major = $_POST['major'];
    $inst = $_POST['inst'];
    $grad_conv = $_POST['Graduation'];
    $grad='';
    insert_date($grad_conv,$grad);
    
if($_POST['method']=='add_educate'){
        $add_educate = mysqli_query($db,"insert into educate set empno='$empno', educate='$teducat',
                        major='$major', institute='$inst', enddate='$grad'");
        if ($add_educate == false) {
            echo "<p>";
            echo "Insert not complete" . mysqli_error();
            echo "<br />";
            echo "<br />";

            echo "	<span class='glyphicon glyphicon-remove'></span>";
            echo "<a href='../personal/add_educate.php' >กลับ</a>";
        } else { $db->close();
            }
}elseif($_POST['method']=='update_educate'){
    $edu=$_POST['edu'];
    $update_educate = mysqli_query($db,"update educate set educate='$teducat',
                        major='$major', institute='$inst', enddate='$grad' where empno='$empno' and ed_id='$edu'");
        if ($update_educate == false) {
            echo "<p>";
            echo "Update not complete" . mysqli_error();
            echo "<br />";
            echo "<br />";

            echo "	<span class='glyphicon glyphicon-remove'></span>";
            echo "<a href='../personal/add_educate.php' >กลับ</a>";
        } else {  $db->close();          }
}
        ?>
      </section></body></html>
