<?php  
header("Content-type:text/json; charset=UTF-8");                
header("Cache-Control: no-store, no-cache, must-revalidate");               
header("Cache-Control: post-check=0, pre-check=0", false);     
$con_db=mysql_connect("localhost","root","6529") or die("Cannot connect db server");  
$select_db=mysql_select_db("calender");  
if($_GET['gData']){  
    $event_array=array();  
    $i_event=0;  
    $q="SELECT * FROM tbl_event WHERE date(event_start)>='".date("Y-m-d",$_GET['start'])."'  ";  
    $q.=" AND date(event_end)<='".date("Y-m-d",$_GET['end'])."' ORDER by event_id";  
    $qr=mysql_query($q);  
    while($rs=mysql_fetch_array($qr)){  
        $event_array[$i_event]['id']=$rs['event_id'];  
        $event_array[$i_event]['title']=$rs['event_title'];  
        $event_array[$i_event]['start']=$rs['event_start'];  
        $event_array[$i_event]['end']=$rs['event_end'];  
        $event_array[$i_event]['url']=$rs['event_url'];  
        $event_array[$i_event]['allDay']=($rs['event_allDay']=="true")?true:false;  
        $i_event++;  
    }  
    echo json_encode($event_array);  
    exit;     
}  
?>  