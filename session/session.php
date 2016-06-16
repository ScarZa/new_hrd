<?PHP @session_start(); ?>
<META content="text/html; charset=utf8" http-equiv=Content-Type>
<?php
if ($_POST[checkdate] == '1' and $_POST[check_date01]!='')  {
    $_SESSION[checkdate] = $_POST[checkdate];
    $_SESSION[check_date01]=$_POST[check_date01];
    $_SESSION[check_date02]=$_POST[check_date02];
    echo "<meta http-equiv='refresh' content='0;url=statistics_leave.php' />";
}elseif ($_POST[checkdate] == '1' and $_POST[check_date01]=='') {
    $_SESSION[checkdate] = '';
    $_SESSION[check_date01]= '';
    $_SESSION[check_date02]='';
    echo "<meta http-equiv='refresh' content='0;url=statistics_leave.php' />";

    
}elseif ($_POST[method]=='check_date_cancle' and $_POST[check_date01]!='') {
    $_SESSION[check_cancle]=$_POST[method];
    $_SESSION[cancle_date1]=$_POST[check_date01];
    $_SESSION[cancle_date2]=$_POST[check_date02];
    echo "<meta http-equiv='refresh' content='0;url=conclude_cancle.php' />";
}elseif ($_POST[method]=='check_date_cancle' and $_POST[check_date01]=='') {
    $_SESSION[check_cancle] = '';
    $_SESSION[cancle_date1]='';
    $_SESSION[cancle_date2]='';
    echo "<meta http-equiv='refresh' content='0;url=conclude_cancle.php' />";

    
}elseif ($_POST[method]=='check_trainin' and $_POST[check_date01]!='') {
    $_SESSION[check_trainin]=$_POST[method];
    $_SESSION[trainin_date1]=$_POST[check_date01];
    $_SESSION[trainin_date2]=$_POST[check_date02];
    echo "<meta http-equiv='refresh' content='0;url=pre_trainin.php' />";
}elseif ($_POST[method]=='check_trainin' and $_POST[check_date01]=='') {
    $_SESSION[check_trainin] = '';
    $_SESSION[trainin_date1]='';
    $_SESSION[trainin_date2]='';
    echo "<meta http-equiv='refresh' content='0;url=pre_trainin.php' />";

    
}elseif ($_POST[method]=='check_pro_trainin' and $_POST[check_date01]!='') {
    $_SESSION[check_pro]=$_POST[method];
    $_SESSION[pro_date1]=$_POST[check_date01];
    $_SESSION[pro_date2]=$_POST[check_date02];
    echo "<meta http-equiv='refresh' content='0;url=statistics_trainin.php' />";
}elseif ($_POST[method]=='check_pro_trainin' and $_POST[check_date01]=='') {
    $_SESSION[check_pro] = '';
    $_SESSION[pro_date1]='';
    $_SESSION[pro_date2]='';
    echo "<meta http-equiv='refresh' content='0;url=statistics_trainin.php' />";

    
}elseif ($_POST[method]=='check_trainout' and $_POST[check_date01]!='') {
    $_SESSION[check_trainout]=$_POST[method];
    $_SESSION[trainout_date1]=$_POST[check_date01];
    $_SESSION[trainout_date2]=$_POST[check_date02];
    echo "<meta http-equiv='refresh' content='0;url=pre_trainout.php' />";
}elseif ($_POST[method]=='check_trainout' and $_POST[check_date01]=='') {
    $_SESSION[check_trainout] = '';
    $_SESSION[trainout_date1]='';
    $_SESSION[trainout_date2]='';
    echo "<meta http-equiv='refresh' content='0;url=pre_trainout.php' />";

    
}elseif ($_POST[method]=='check_pro_trainout' and $_POST[check_date01]!='') {
    $_SESSION[check_out]=$_POST[method];
    $_SESSION[out_date1]=$_POST[check_date01];
    $_SESSION[out_date2]=$_POST[check_date02];
    echo "<meta http-equiv='refresh' content='0;url=statistics_trainout.php' />";
}elseif ($_POST[method]=='check_pro_trainout' and $_POST[check_date01]=='') {
    $_SESSION[check_out] = '';
    $_SESSION[out_date1]='';
    $_SESSION[out_date2]='';
    echo "<meta http-equiv='refresh' content='0;url=statistics_trainout.php' />";

    
}elseif ($_POST[method]=='check_statistics_trainout' and $_POST[check_date01]!='') {
    $_SESSION[check_stat]=$_POST[method];
    $_SESSION[stat_date1]=$_POST[check_date01];
    $_SESSION[stat_date2]=$_POST[check_date02];
    $emp=$_POST[empno];
    
    echo "<meta http-equiv='refresh' content='0;url=detial_trainin.php?&id=$emp' />";
}elseif ($_POST[method]=='check_statistics_trainout' and $_POST[check_date01]=='') {
    $_SESSION[check_stat] = '';
    $_SESSION[stat_date1]='';
    $_SESSION[stat_date2]='';
    $emp=$_POST[empno];
    echo "<meta http-equiv='refresh' content='0;url=detial_trainin.php?&id=$emp' />";

    
}elseif ($_POST['method']=='check_detial_leave' and $_POST['check_date01']!='') {
    $_SESSION['check_dl']=$_POST['method'];
    $_SESSION['leave_date1']=$_POST['check_date01'];
    $_SESSION['leave_date2']=$_POST['check_date02'];
    $emp=$_POST['empno'];
    echo "<meta http-equiv='refresh' content='0;url=../index.php?page=leave/detial_leave&id=$emp' />";
}elseif ($_POST[method]=='check_detial_leave' and $_POST['check_date01']=='') {
    $_SESSION['check_dl'] = NULL;
    $_SESSION['leave_date1']=NULL;
    $_SESSION['leave_date2']=NULL;
    $emp=$_POST['empno'];
    echo "<meta http-equiv='refresh' content='0;url=../index.php?page=leave/detial_leave&id=$emp' />";

    
}elseif ($_POST[method]=='check_receive' and $_POST[check_date01]!='') {
    $_SESSION[check_rec]=$_POST[method];
    $_SESSION[receive_date1]=$_POST[check_date01];
    $_SESSION[receive_date2]=$_POST[check_date02];
    echo "<meta http-equiv='refresh' content='0;url=../index.php?page=leave/receive_leave' />";
}elseif ($_POST[method]=='check_receive' and $_POST[check_date01]=='') {
    $_SESSION[check_rec] = null;
    $_SESSION[receive_date1]=null;
    $_SESSION[receive_date2]=null;
    echo "<meta http-equiv='refresh' content='0;url=../index.php?page=leave/receive_leave' />";

    
}elseif ($_POST[method]=='Lperson_date' and $_POST[take_date01]!='') {
    $_SESSION[check_Lperson]=$_POST[method];
    $_SESSION[Lperson_date1]=$_POST[take_date01];
    $_SESSION[Lperson_date2]=$_POST[take_date02];
    echo "<meta http-equiv='refresh' content='0;url=Lperson_report.php' />";
}elseif ($_POST[method]=='Lperson_date' and $_POST[take_date01]=='') {
    $_SESSION[check_Lperson] = '';
    $_SESSION[Lperson_date1]='';
    $_SESSION[Lperson_date2]='';
    echo "<meta http-equiv='refresh' content='0;url=Lperson_report.php' />";

    
}elseif ($_POST[method]=='Lperson_dep' and $_POST[dep]!='') {
    $_SESSION[dep_Lperson]=$_POST[method];
    $depname=$_POST[dep];
    echo "<meta http-equiv='refresh' content='0;url=Lperson_report.php?&depname=$depname' />";
}elseif ($_POST[method]=='Lperson_dep' and $_POST[dep]=='') {
    $_SESSION[dep_Lperson] = '';
    $_SESSION[depname]='';
    echo "<meta http-equiv='refresh' content='0;url=Lperson_report.php' />";

    
}
 ?>   