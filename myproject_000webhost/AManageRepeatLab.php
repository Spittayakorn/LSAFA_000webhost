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

<!DOCTYPE html>
<html>
<head>
	<title>รายการแบบฟอร์มขอใช้ห้องปฏิบัติการวิเคราะห์อาหารสัตว์</title>
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
			border:1px solid black;
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
		
		#myTables {
			border: 1px solid black;
			border-collapse: separate;
			border-radius: 5px;
			padding:10px;
		}

		#myTable{
			border:none;
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

	</style>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script>
		
		$(document).ready(function(){
			
			labCode = $('#labCodeQ').val();
			
			$.get('getAnalysisCode.php?labCode='+labCode,function(data,status){
				
				if(status=='success')
				{
					$('#queryAddRepeat').html('');
					tableRepeatQ = '';

					for(i=0;i<data.length;i++)
					{
						tableRepeatQ +=  "<tr><td><input type='hidden' name='labCode[]' value='"+data[i].labCode+"'></td><td><input type='hidden' name='anaCode[]' value='"+data[i].anaCode+"'></td><td><input type='hidden' name='repeat[]' value='"+data[i].repeat+"'></td></tr>";
					}

					$('#queryAddRepeat').html(tableRepeatQ);
				}
			});

			
			$('#signOut').click(function(){
				window.open('logout.php','_self');
			});

			
			$('#tbSim').on('input','#countRepeatAna',function(){
				
				labCode = $('#labCodeQ').val();
				
				repeatQuery = '#tbSim #countRepeatAna';
				
				tableRepeatQ = '';
				sum = 0;
				$(repeatQuery).each(function(){
					
					anaCode = $(this).attr('class');
					countRepeatAna = $(this).val();

					if(countRepeatAna =='')
					{
						countRepeatAna = 0;
					}
					countRepeatAna = parseFloat(countRepeatAna);

					tableRepeatQ += "<tr><td><input type='hidden' name='labCode[]' value='"+labCode+"'></td><td><input type='hidden' name='anaCode[]' value='"+anaCode+"'></td><td><input type='hidden' name='repeat[]' value='"+countRepeatAna+"'></td></tr>";
				});
				

				$('#queryAddRepeat').html(tableRepeatQ);
				
			});




		});

		function chkDigit(Digit)
		{
			check = false;
			if(Digit>=48 && Digit <=57)
			{
				check = true;
			}else
			{
				alert('กรุณากรอกเฉพาะตัวเลขสำหรับวิเคราะห์เพิ่มเติม');
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
	
	<table id='myTables' width='100%' cellspacing='10' cellpadding='5' border='0'>
		<tr>
			<?php
				$pageNo = $_REQUEST['pageNo'];
				
				echo "<td colspan='3'><a href='Amain.php'> ระบบขอใช้ห้องปฏิบัติการวิเคราะห์อาหารสัตว์ > เจ้าหน้าที่ห้องปฏิบัติการ</a> > <a href='AGetLabH.php?statusLab=1&labStatus=0&pageNo=$pageNo'>เอกสารที่อนุมัติขอใช้ห้องปฏิบัติการจากผู้บริหาร</a> > วิเคราะห์เพิ่มเติม</td>";

			?>
			
		</tr>
		<tr>
			<td>
				<div align='center'>
					<h2>รายการแบบฟอร์มขอใช้ห้องปฏิบัติการวิเคราะห์อาหารสัตว์</h2>
				</div>
	<?php
		
		$labCode= $_REQUEST['labCode'];		
	?>

	<table id='tbSim' border='1' width='100%' cellpadding='5'>
		<tr>
			<th>ลำดับที่</th>
			<th>ค่าที่ต้องการวิเคราะห์</th>
			<th>ชนิดตัวอย่าง</th>
			<th>จำนวนตัวอย่าง (ซ้ำ)</th>
			<th width='15%'>จำนวนเพิ่มเติม(ครั้ง)</th>
		</tr>
		<?php
			require('connectDB.php');

			$sqlSearchLab = "select * from lab where labCode='$labCode'";
			$resultSearchLab = mysqli_query($con,$sqlSearchLab);

			if($resultSearchLab == null)
			{
				echo "คำสั่งผิด";
			}

			$recnumSearchLab = mysqli_fetch_array($resultSearchLab);

			$sqlSearchAna = "select * from analysislist;";
			$resultSearchAna = mysqli_query($con,$sqlSearchAna);
													
			if($resultSearchAna == null)
			{
				echo "คำสั่งผิด";
			}
													
													
			function getSimName($labCode,$anaCode)
			{
				require('connectDB.php');
														
				$simName= '';
				$sumSim = 0;
				$repeat = 0;
													
				$sqlSearchAna = "select da.daCode,da.volume,da.repeats,da.labCode,da.scCode,sc.scCode,sc.catCode,sc.anaCode,sc.simCode,sc.price,sl.simCode,sl.simName from dataanalysis as da,servicechargelist as sc,simplelist as sl where da.scCode=sc.scCode and sc.simCode=sl.simCode and da.labCode='$labCode' and anaCode='$anaCode';";
													
				$resultSearchAna = mysqli_query($con,$sqlSearchAna);
													
				if($resultSearchAna== null)
				{
					echo "คำสั่งผิด";
				}
														
				$numRowSearchAna = mysqli_num_rows($resultSearchAna);
													
				if($numRowSearchAna!=0)
				{
					$count = 1;
					
					while($recnumSearchAna = mysqli_fetch_array($resultSearchAna))
					{
						$simName .= $recnumSearchAna[11];
						$sumSim += $recnumSearchAna[1];
						$repeat = $recnumSearchAna[2];							
						if($count != $numRowSearchAna)
						{
							$simName .= " ,";
						}
						$count++;
					}
				}
														
				return array($simName,$sumSim,$repeat);
			}
													
													
			function getCharge($anaCode,$catCode)
			{
				require('connectDB.php');
				$price = 0;
													
				$sqlSearchCharge = "select * from servicechargelist where anaCode='$anaCode' and catCode='$catCode' limit 1;";
														
				$resultSearchCharge = mysqli_query($con,$sqlSearchCharge);
													
				if($resultSearchCharge == null)
				{
					echo "คำสั่งผิด";
				}
														
				$numRowSearchCharge = mysqli_num_rows($resultSearchCharge);
													
				if($numRowSearchCharge !=0)
				{
					$recnumSearchCharge = mysqli_fetch_array($resultSearchCharge);
					$price = $recnumSearchCharge[4];
				}
													
				return $price;
			}
													
			$j = 0;
			$sumTotalAna = 0;
			while($recnumSearchAna = mysqli_fetch_array($resultSearchAna))
			{
														
				list($getSimName,$getSumSim,$getRepeat) = getSimName($labCode,$recnumSearchAna[0]);
														
				//คำนวณในแต่ละค่าวิเคราะห์
				$anaVal = 0;
														
				if($getSimName!='')
				{
					$j++;
					$anaVal = $getSumSim*$recnumSearchLab[10]*getCharge($recnumSearchAna[0],$recnumSearchLab[6]);
					$sumTotalAna += $anaVal;
													
					echo "<tr>
						<td id='no'>$j</td>
						<td>&nbsp;&nbsp;$recnumSearchAna[1]</td>
						<td>&nbsp;".$getSimName."</td>
						<td id='volume' align='center'>".number_format($anaVal)."</td>
						<td style='text-align:center'>
							<input type='text' id='countRepeatAna' class='$recnumSearchAna[0]' value='$getRepeat' onkeypress='return chkDigit(event.charCode)'>
						</td>
						</tr>";
				}
			
			}
		?>
				</table>
			</td>
		</tr>
		<tr>
			<td style='text-align:center;'>
				<form action='AManageRepeatLabQuery.php' method='POST'>
					<input type='submit' value='บันทึกวิเคราะห์ทำซ้ำ'>
					<input type='hidden' id='page' name ='pageNo' value=<?php echo "$pageNo"; ?>>
						<table id='queryAddRepeat' style='border:none;'>
						</table>
				</form>
			</td>
		</tr>

	</table>
	<br><br>
	<?php
		echo "<input type='hidden' name='labCodeQ' id='labCodeQ' value='$labCode' readonly>";
	?>
	
</body>
</html>