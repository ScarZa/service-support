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
	function DateTimeThai($strDate)//แสดงวันที่ไทย เวลา
	{
		$strYear = date("Y",strtotime($strDate))+543;
		$strMonth= date("n",strtotime($strDate));
		$strDay= date("j",strtotime($strDate));
		$strHour= date("H",strtotime($strDate));
		$strMinute= date("i",strtotime($strDate));
		$strSeconds= date("s",strtotime($strDate));
		$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
		$strMonthThai=$strMonthCut[$strMonth];
		return "$strDay $strMonthThai $strYear $strHour:$strMinute";
	}
$thai_day_arr=array("อาทิตย์","จันทร์","อังคาร","พุธ","พฤหัสบดี","ศุกร์","เสาร์");
$thai_month_arr=array(
    "0"=>"",
    "1"=>"มกราคม",
    "2"=>"กุมภาพันธ์",
    "3"=>"มีนาคม",
    "4"=>"เมษายน",
    "5"=>"พฤษภาคม",
    "6"=>"มิถุนายน", 
    "7"=>"กรกฎาคม",
    "8"=>"สิงหาคม",
    "9"=>"กันยายน",
    "10"=>"ตุลาคม",
    "11"=>"พฤศจิกายน",
    "12"=>"ธันวาคม"                 
);
function thai_date($time){//แสดงวันไทย วันที่ เวลา ทำงานกับtimestamp
    global $thai_day_arr,$thai_month_arr;
    $thai_date_return="วัน".$thai_day_arr[date("w",$time)];
    $thai_date_return.= "ที่ ".date("j",$time);
    $thai_date_return.=" เดือน".$thai_month_arr[date("n",$time)];
    $thai_date_return.= " พ.ศ.".(date("Y",$time)+543);
    $thai_date_return.= "  ".date("H:i",$time)." น.";
    return $thai_date_return;
}
 ?>