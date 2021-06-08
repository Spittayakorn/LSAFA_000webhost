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
			$memName = $_SESSION['memName'];
			$facCode = $_SESSION['facCode'];
			$facName = $_SESSION['facName'];
			$depCode = $_SESSION['depCode'];
			$depName = $_SESSION['depName'];
		}	
?>

<html>
<head>
	<title>กำหนดอัตราค่าบริการ</title>
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

		#editPrice{
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

		
		function chkDigit(data)
		{
			check = false;
			
			if( data == 13 || data == 46|| (data >= 48 && data<= 57))
			{
				check=true;
			}else
			{
				alert('กรุณากรอกเฉพาะตัวเลข');
			}
			return check;
		}
	
	</script>

</head>
<body>
	
<?php
	$anaCode = $_REQUEST['anaCode'];
	$anaName = $_REQUEST['anaName'];
?>


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
		<tr>
			<td colspan='3'><a href='Amain.php'> ระบบขอใช้ห้องปฏิบัติการวิเคราะห์อาหารสัตว์ > เจ้าหน้าที่ห้องปฏิบัติการ</a> > <a href='AManageServiceCharge.php'>จัดการอัตราค่าบริการ</a> > แก้ไขอัตราค่าบริการ</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>
				<div align='center'>
					<h2>แก้ไขอัตราค่าบริการ</h2>
				</div>


	<form id='myfrom' action='AAddQueryService.php' method='POST'>
		<table border='0' align='center' cellpadding='10' id='tbPrice'>
			<tr>
				<!--<td>รหัสค่าวิเคราะห์</td>-->
				<td>
				
				<?php
				
					echo "<input type='hidden' name='anaCode' value='".$anaCode."' readonly style='color:gray'>";

				?>

				</td>

			</tr>
			
			<tr>
				<td>ชื่อค่าวิเคราะห์</td>
				<td>
				
				<?php
					//readonly แก้ไขไม่ได้
					echo "<input type='text' name='anaName' value='".$anaName."' readonly style='color:gray'>";

				?>

				</td>
			</tr>

			<tr>
				<td>อัตราค่าบริการแต่ละประเภทนักวิจัย</td>
			</tr>
	
			<?php
				require('connectDB.php');
				
				//แสดงประเภทนักวิจัยออกมา
				$sqlSearchCat = "select * from categorys order by catCode;";
				$resultSearchCat = mysqli_query($con,$sqlSearchCat);
			
				if($resultSearchCat== null)
				{
					echo "คำสั่งผิด";
				}
			
				//วนแสดง เก็บค่าใส่ array
				while($recnumSearchCat = mysqli_fetch_array($resultSearchCat))
				{
					echo "<tr>
								<td>$recnumSearchCat[1]</td>";
								
					//ไปดูราคาในดาต้าดิก 
					$sqlSearchPrice = "select * from servicechargelist where anaCode='$anaCode' and catCode='$recnumSearchCat[0]' ;";

					$resultSearchPrice = mysqli_query($con,$sqlSearchPrice);

					if($resultSearchPrice == null)
					{
						echo "คำสั่งผิด";
					}

					$recnumRow = mysqli_num_rows($resultSearchPrice);
					
					//กรณีไม่ เพิ่มข้อมูล ให้แสดง 0 
					if($recnumRow == 0)
					{
								
					}else
					{
						//เมื่อมีการเพิ่มข้อมูลไปแล้วให้แสดง ค่านั้น
						$recnumSearchPrice = mysqli_fetch_array($resultSearchPrice);
						
						echo "	<td>
									<input type='text' name='price[]' value=$recnumSearchPrice[4] onkeypress='return chkDigit(event.charCode)'>";
					}
					
					echo "			<input type='hidden' name='level[]' value='".$recnumSearchCat[0]."'>
								</td>
							<td>บาท</td>
						</tr>";
				}
			?>
				<tr align='center'>
					<td colspan='3'>
						<button id='editPrice'>แก้ไขอัตราค่าบริการ</button>
					</td>
				</tr>
		</table>
	<form>

			</td>
		</tr>
	</table>
	<br><br>
				

</body>
</html>