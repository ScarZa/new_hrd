<?php
	function DateThai1($strDate1)
	{
		$strYear = date("Y",strtotime($strDate1))+543;
		$strMonth= date("n",strtotime($strDate1));
		$strDay= date("j",strtotime($strDate1));
		$strHour= date("H",strtotime($strDate1));
		$strMinute= date("i",strtotime($strDate1));
		$strSeconds= date("s",strtotime($strDate1));
		$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
		$strMonthThai=$strMonthCut[$strMonth];
		return "$strDay $strMonthThai $strYear ";
	}
		function DateThai2($strDate2)
	{
		$strYear = date("Y",strtotime($strDate2))+543;
		$strMonth= date("n",strtotime($strDate2));
		$strDay= date("j",strtotime($strDate2));
		$strHour= date("H",strtotime($strDate2));
		$strMinute= date("i",strtotime($strDate2));
		$strSeconds= date("s",strtotime($strDate2));
		$strMonthCut = Array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
		$strMonthThai=$strMonthCut[$strMonth];
		return "$strDay $strMonthThai $strYear ";
	}
			function DateThai3($strDate3)
	{
		$strYear = date("Y",strtotime($strDate3))+543;
		$strMonth= date("n",strtotime($strDate3));
		$strDay= date("j",strtotime($strDate3));
		$strHour= date("H",strtotime($strDate2));
		$strMinute= date("i",strtotime($strDate3));
		$strSeconds= date("s",strtotime($strDate3));
		$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
		$strMonthThai=$strMonthCut[$strMonth];
		return "$strDay $strMonthThai $strYear ";
	}
 ?>