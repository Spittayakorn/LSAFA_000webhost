<?php
	
	header('Content-type: application/json; charset=UTF-8');
	//ตั้งค่าพื้นที่เวลา
	date_default_timezone_set("Asia/Bangkok");

	$today = getdate();
	//รับวัน-เดือน-ปี
	$day = $today["mday"];
	$month = $today["mon"];
	$year = $today["year"]+543;
	$years = $today["year"];
			
	$hour = $today["hours"];
	$minute = $today["minutes"];
	$second = $today["seconds"];
	
	$monthTxt = '';
	switch($month)
	{
		case '1' : $monthTxt = 'มกราคม';		break;
		case '2' : $monthTxt = 'กุมภาพันธ์';	break;
		case '3' : $monthTxt = 'มีนาคม';		break;
		case '4' : $monthTxt = 'เมษายน';		break;
		case '5' : $monthTxt = 'พฤษภาคม';	break;
		case '6' : $monthTxt = 'มิถุนายน';		break;
		case '7' : $monthTxt = 'กรกฏาคม';		break;
		case '8' : $monthTxt = 'สิงหาคม';		break;
		case '9' : $monthTxt = 'กันยายน';		break;
		case '10' : $monthTxt = 'ตุลาคม';		break;
		case '11' : $monthTxt = 'พฤศจิกายน';	break;
		case '12' :	$monthTxt = 'ธันวาคม';		break;
	}

	$json_record = new stdClass();
	
	$json_record->day = $day;
	$json_record->month= $month;
	$json_record->monthTxt= $monthTxt;
	$json_record->year= $year;
	$json_record->years= $years;

	$json_record->hour= $hour;
	$json_record->minute= $minute;
	$json_record->second= $second;

	echo json_encode($json_record);
?>
		