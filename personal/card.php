<?php @session_start(); ?>
<?php if(empty($_SESSION['user'])){echo "<meta http-equiv='refresh' content='0;url=index.php'/>";exit();} ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
        <title>ระบบข้อมูลบุคคลากรโรงพยาบาล</title>
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
    <!-- DataTables -->
    <link rel="stylesheet" href="../plugins/datatables/dataTables.bootstrap.css">
    <!-- Morris chart -->
    <link rel="stylesheet" href="../plugins/morris/morris.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="../plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="../plugins/select2/select2.min.css">
    <!-- Date Picker -->
    <!--<link rel="stylesheet" href="plugins/datepicker/datepicker3.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="../plugins/daterangepicker/daterangepicker-bs3.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <script src="../plugins/excellentexport.js"></script>

    </head>
    <body class="hold-transition skin-green fixed sidebar-mini">

<?php $empno=$_REQUEST['id'];
include '../connection/connect.php';
$sql = $db->prepare("SELECT CONCAT(e1.firstname,' ',e1.lastname) as fullname,p1.posname as posion,e1.photo as photo FROM emppersonal e1
INNER JOIN posid p1 on e1.posid=p1.posId
WHERE e1.empno= ?");
$sql->bind_param("i",$empno);
$sql->execute();
$sql->bind_result($name,$posion,$photo);
$sql->fetch();
$db->close();
if ($photo != '') {
                                    $photo = $photo;
                                    $folder = "../photo/";
                                } else {
                                    $photo = 'person.png';
                                    $folder = "../images/";
                                }
include '../connection/connect.php';
if(!$db){
     die ('Connect Failed! :'.mysqli_connect_error ());
     exit;
}
$query=mysqli_query($db,"select * from hospital");
$hospital=  mysqli_fetch_assoc($query);
if (isset($hospital['logo'])) {
                                    $pic = $hospital['logo'];
                                    $fol = "../logo/";
                                } else {
                                    $pic = 'agency.ico';
                                    $fol = "../images/";
                                }
?>
<style type="text/css">
    body{
  -webkit-print-color-adjust:exact;
}
p.small {line-height: 90%}
p.big {line-height: 200%}
table {
  border-collapse: separate;
  border-spacing: 0px;
}
</style>
    <?php
require_once('../plugins/library/MPDF54/mpdf.php'); //ที่อยู่ของไฟล์ mpdf.php ในเครื่องเรานะครับ
ob_start(); // ทำการเก็บค่า html นะครับ*/
?>
<table border="1" name="card" background="images/card.png" color="blue">
    <tr bg="images/card.png">
        <td align="center" width="190" height="295" >
            <img src='<?= $fol . $pic; ?>' width="35"><br>
            <font size="2" color="blue"><p><b><?= $hospital['name']?><br>
                    กรมสุขภาพจิต กระทรวงสาธารณสุข</b></p></font>
            <img src='<?= $folder . $photo; ?>' height="120"><br>
            <p class="small"><b><font size="3"><?= $name?><br>
                <?= $posion?></font></b></p>
            <p><img src='../images/logogrom.png' width="25"> <img src='../images/URS.png' width="45">&nbsp;</p>
        </td>
    </tr>
</table>
<?php
$time_re=  date('Y_m_d');
$reg_date=$work['reg_date'];
$html = ob_get_contents();
ob_clean();
$pdf = new mPDF('th', 'A4', '0', '');
$pdf->SetAutoFont();
$pdf->SetDisplayMode('fullpage');
$pdf->WriteHTML($html, 2);
$pdf->Output("../card/card$empno$Code.pdf");
echo "<meta http-equiv='refresh' content='0;url=../card/card$empno$Code.pdf' />";
$db->close();
?>
    </body>