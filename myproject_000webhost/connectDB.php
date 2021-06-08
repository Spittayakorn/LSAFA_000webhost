<?php
//connect database
	$ip ='localhost';
	$user ='id16820335_lsafa_user';
	$pass = 'OxD4P-*3MBsK&B=#';
	$db = 'id16820335_lsafa';
	$query = 'SET NAMES UTF8';

	$con = mysqli_connect($ip,$user,$pass,$db);
	if($con == null)
	{
		echo "คำสั่งผิด";
		exit;
	}

	mysqli_query($con,$query);
	
?>
