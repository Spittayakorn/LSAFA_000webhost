<?php
	session_start();

		if(!(isset($_SESSION['memCode']) && isset($_SESSION['memName'])&& isset($_SESSION['facCode'])&& isset($_SESSION['facName'])&& isset($_SESSION['depCode']) && isset($_SESSION['depName'])))
		{
			echo "<script>
					alert('กรุณาเข้าสู่ระบบใหม่อีกครั้ง');
					window.open('login.php','_self');
			</script>";

		}else{
			
			$memCode = $_SESSION['memCode'];
			
			//-----
			require('connectDB.php');
			$sqlSearchSessionMember = "select * from member where memCode='$memCode';";
			$resultSearchSessionMember = mysqli_query($con,$sqlSearchSessionMember);
			
			if($resultSearchSessionMember == null)
			{
				echo "คำสั่งผิด";
			}

			$recnumSearchSessionMember = mysqli_fetch_array($resultSearchSessionMember);
			
			$memName = $recnumSearchSessionMember[4];
			
			//---

			$facCode = $_SESSION['facCode'];
			$facName = $_SESSION['facName'];
			$depCode = $_SESSION['depCode'];
			$depName = $_SESSION['depName'];
		}	
?>

<html>
<head>
	<title>แก้ไขประเภทนักวิจัย</title>
	<meta charset='UTF-8'>

<style>
		body {
			font-family: sarabun;
			font-size: 100%;	
			line-height: 1.5;
			height:90%
		}
		img {
			height:40%;
			width:100%;
		}
		table,#fixTB{
			border:0px solid black;
			border-collapse: collapse;
		}

		#tbLog {
			border-left: none;
			border-right:none;
			border-top:none;
			border-bottom:none;
		}
		
		#signOut{
			background-color: #4CAF50;
			border: none;
			color: white;
			padding:10px 10px;
			text-align:center;
			text-decoration:none;
			display: inline-block;
			font-size: 16px;
			margin: 4px 2px;
			cursor: pointer;
		}
		
		input[type="text"]{
			width: 200px;
			padding: 0.4em;
			border-radius: 0.2em;
			border: 1px solid #ccc;
			outline: none;
		}

		input[type="submit"]{
			width: 100%;
			padding: 1em;
			border-radius: 30px; 
			border: none;
			color: #fff;
			background-color: #5ABEFF;
			font-size: 1em;
			cursor:pointer;
		}

		input[type="text"]:focus {
			box-shadow: 0 0 0.5em #2a76e6;
			border-color: #2a76e6;
			padding: 0.4em;
			border: 1px solid #2a76e6;
			outline: none;
		}

		#myTables {
			border: 1px solid black;
			border-collapse: separate;
			border-radius: 5px;
			padding:10px;
		}

	</style>
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script>
		$(document).ready(function(){
			
			$('#signOut').click(function(){
				window.open('logout.php','_self');
			});
		});

		function chkdata()
		{
			check = false;

			data = $('#anaName').val();
			
			if(data.trim() !='')
			{
				check = true;
			}else
			{
				alert('กรุณากรอกชื่อประเภทนักวิจัย');
				$('#anaName').focus();
			}

			return check;
		}
	
	</script>
</head>
<body>
	
	
	<center>
		<img src='img/hrm_3.jpg'>
	</center>

	<table id='tbLog' cellpadding='5' width='100%'>
		
		<tr align='right'>
			<td width='90%'>
				<?php echo "$memName $facName วิทยาเขตหาดใหญ่";  ?>
			</td>
			<td align='center'>
				<button id='signOut'>ออกจากระบบ</button>
			</td>
		</tr>
	</table>
	
	<!--- ส่วนข้อมูล   -->
	
	<table id='myTables' width='100%' cellspacing='10' cellpadding='5'>
		
		<td colspan='3'><a href='Amain.php'> ระบบขอใช้ห้องปฏิบัติการวิเคราะห์อาหารสัตว์ > เจ้าหน้าที่ห้องปฏิบัติการ</a> > <a href='AManageCat.php'>จัดการรายการประเภทนักวิจัย</a> > แก้ไขประเภทนักวิจัย</td>

		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>
				<div align='center'>
					<h2>แก้ไขรายการประเภทนักวิจัย</h2>
				</div>

	
	<form name='analysis' action='AEditQueryCat.php' method='POST' onsubmit='Javascript:return chkdata()'>
		<table border='0' align='center' cellpadding='20' >
<?php 

	$anaCode = $_REQUEST['anaCode'];
	$pageNo = $_REQUEST['pageNo'];
	//echo $anaCode;

	require('connectDB.php');

	$sqlSearchAna = "select * from categorys where catCode='$anaCode';";
	$resultSearchAna = mysqli_query($con,$sqlSearchAna);
	$recnumSearchAna = mysqli_fetch_array($resultSearchAna);

?>
			<tr>
				<td>ชื่อค่าวิเคราะห์</td>
			
			<!-- กรณี มีช่องว่างระหว่างคำ -->
			<?php echo "<td>
					<input type='text' name='anaName' value='".$recnumSearchAna[1]."' id='anaName'> 
				</td>";
				
			?>

			</tr>
			<tr>
				
				<td colspan='2'>
					<input type='hidden' name='anaCode' value=<?php echo $anaCode; ?>>
					<input type='hidden' name='pageNo' value=<?php echo $pageNo; ?>>
					<input type='submit' value='แก้ไขประเภทนักวิจัย'>
				</td>
			</tr>
		</table>
	</form>
			</td>
		</tr>
	</table>
	<br><br>

</body>
</html>