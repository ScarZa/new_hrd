<?php
function compareDate($date1,$date2) { 
$arrDate1 = explode("-",$date1); 
$arrDate2 = explode("-",$date2); 
$timStmp1 = mktime(0,0,0,$arrDate1[1],$arrDate1[2],$arrDate1[0]); 
$timStmp2 = mktime(0,0,0,$arrDate2[1],$arrDate2[2],$arrDate2[0]); 
}
                                 $y=  date("Y");
                                 $Y=$y-1;
                                 $Yy=$y+1;
                                 
                                 $date=date("Y-m-d");
                                 $bdate="$y-10-01";
                                 $edate="$y-12-31";
                                 compareDate($date, $bdate);
                                 compareDate($date, $edate);
                                 ?>
