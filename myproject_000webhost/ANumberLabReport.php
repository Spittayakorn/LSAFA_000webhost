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
	<title>ระบบขอใช้ห้องปฏิบัติการวิเคราะห์อาหารสัตว์ - ภาควิชาสัตวศาสตร์ คณะทรัพยากรธรรมชาติ </title>
	
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

		#myTable {
			border: 1px solid black;
			border-collapse: separate;
			border-radius: 5px;
			padding:10px;
		}
		
		#search{
			background-color: blue;
			border: none;
			color: white;
			padding:7px 7px;
			text-align:center;
			text-decoration:none;
			display: inline-block;
			font-size: 16px;
			margin: 4px 2px;
			cursor: pointer;
		}
		
		#fixTB,#fixTB td {
			table-layout: fixed;
			width : 100%;
			border-collapse: separate;
			border-radius: 20px;
			border:0px;
		}

		input[type='date'] {
			width: 200px;
			padding: 0.4em;
			border-radius: 0.2em;
			border: 1px solid #ccc;
			outline: none;
		}

		#line{
			cursor: pointer;
		}
		#bar{
			cursor: pointer;
		}

		#radar{
			cursor: pointer;
		}
	
		#Doughnut{
			cursor: pointer;
		}

		#Pie{
			cursor: pointer;
		}

		#PolarArea{
			cursor: pointer;
		}

		
	</style>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script>
		$(document).ready(function(){
			
			
			
			$('#signOut').click(function(){
				window.open('logout.php','_self');
			});

			$('#line').click(function(){
				sDate = $('#sDate').val();
				lDate = $('#lDate').val();
				
				window.open("ANumberLabReport.php?sDate="+sDate+"&lDate="+lDate+"&typeG=line","_self");
			});
			
			$('#bar').click(function(){
				sDate = $('#sDate').val();
				lDate = $('#lDate').val();
				
				window.open("ANumberLabReport.php?sDate="+sDate+"&lDate="+lDate+"&typeG=bar","_self");
			});

			$('#radar').click(function(){
				sDate = $('#sDate').val();
				lDate = $('#lDate').val();
				
				window.open("ANumberLabReport.php?sDate="+sDate+"&lDate="+lDate+"&typeG=radar","_self");
			});

			$('#Doughnut').click(function(){
				sDate = $('#sDate').val();
				lDate = $('#lDate').val();
				
				window.open("ANumberLabReport.php?sDate="+sDate+"&lDate="+lDate+"&typeG=doughnut","_self");
			});

			$('#Pie').click(function(){
				sDate = $('#sDate').val();
				lDate = $('#lDate').val();
				
				window.open("ANumberLabReport.php?sDate="+sDate+"&lDate="+lDate+"&typeG=pie","_self");
			});

			$('#PolarArea').click(function(){
				sDate = $('#sDate').val();
				lDate = $('#lDate').val();
				
				window.open("ANumberLabReport.php?sDate="+sDate+"&lDate="+lDate+"&typeG=polarArea","_self");
			});

		
		
		});
	
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

	<table id='myTable' width='100%' cellspacing='10' cellpadding='5'>
		<tr>
			<td colspan='3'><a href='Amain.php'> ระบบขอใช้ห้องปฏิบัติการวิเคราะห์อาหารสัตว์ > เจ้าหน้าที่ห้องปฏิบัติการ</a> > รายงานจำนวนเอกสารขอใช้ห้องปฏิบัติการแบ่งตามประเภทนักวิจัย</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>
				<!--- -->
				<table style='border:none;' width='100%' cellpadding='10'>
					<tr>
						<form action='ANumberLabReport.php' method='POST'>
						<?php
							$sDate = $_REQUEST['sDate'];
							$lDate = $_REQUEST['lDate'];
							$typeG = $_REQUEST['typeG'];
							echo "<input type='hidden' id='typeG' name='typeG' value='$typeG'>";

							echo "
								<td style='text-align:center'><b>ค้นหา</b>&nbsp;&nbsp;เริ่มต้น <input type='date' id='sDate' name='sDate' value='$sDate'>
							สิ้นสุด 
								<input type='date' id='lDate' name='lDate' value='$lDate'>&nbsp;&nbsp;<button id='search'>ค้นหา</button>
							</td>";
						?>

						</form>
					</tr>
			
					<tr>
						<td>
							<table  style='border:none;' width='100%' cellpadding='10'>
								<tr>
									<th><h2>รายงานจำนวนเอกสารขอใช้ห้องปฏิบัติการ</h2></th>
								</tr>
								
								<tr>
									<td>
										<table border='1' width='50%' cellpadding='10' align='center'>
											<tr bgColor='E6FFE6'>
												<th width='7%'>ลำดับที่</th>
												<th width='20%'>ประเภทนักวิจัย</th>
												<th width='20%'>จำนวน(ฉบับ)</th>
											</tr>
											
											<?php
												require('connectDB.php');

												$sqlSearchCat = "select * from categorys;";
												$resultSearchCat = mysqli_query($con,$sqlSearchCat);
												
												if($resultSearchCat == null)
												{
													echo "คำสั่งผิด";
												}
												
												$j=0;
												$total = 0;
												while($recnumSearchCat = mysqli_fetch_array($resultSearchCat))
												{
													$j++;
													$rowCount = countLabCat($recnumSearchCat[0],$sDate,$lDate);
													$total += $rowCount; 
													//---
													$cat[] = $recnumSearchCat[1];
													$numberCat[] = $rowCount;
													$colorCharts[] = "rgba(".rand(100,255).",".rand(100,255).",".rand(100,255).",".rand(100,255).")";
													//---
													
													echo "<tr>
															<td align='center'>$j</td>
															<td>$recnumSearchCat[1]</td>
															<td align='center'>".number_format($rowCount)."</td>
															";
															
													echo "</tr>";

												}

												echo "<tr bgColor='FDF5E6'>
														<td colspan='2' align='center'>รวม</td>
														<td align='center'>".number_format($total)."</td>
														";
														
												echo "</tr>";
												
												function countLabCat($catCode,$startDate,$endDate)
												{	
													require('connectDB.php');
													
													$countLab = 0;

													$sqlSearchLabCat = "select count(labCode) from lab where labDate between '$startDate 00:00:00' and '$endDate 23:59:59' and catCode='$catCode' and ( (teaStatus='1' and offStatus='1' and boStatus='1') or (teaStatus='0' and offStatus='1' and boStatus='1') );";

													$resultSearchLabCat = mysqli_query($con,$sqlSearchLabCat);
													
													if($resultSearchLabCat == null)
													{
														echo "คำสั่งผิด";
													}
													
													$recnumSearchLabCat = mysqli_fetch_array($resultSearchLabCat);
													
													$countLab = $recnumSearchLabCat[0]; 

													return $countLab;
													
												}

											?>
										</table>
									</td>
								</tr>

							</table>
						</td>
					</tr>
					<tr>
						
					</tr>
				</table>
	
				<!-- -->
			</td>
		</tr>

		<tr>
			<td>
			กรุณาเลือกกราฟที่ต้องการแสดง : <u id='line'>Line</u> / <u id='bar'>Bar</u> / <u id='radar'>Radar</u> / <u id='Doughnut'>Doughnut</u> / <u id='Pie'>Pie</u> / <u id='PolarArea'>Polar Area</u>
			</td>
		</tr>
		<tr>
			<td align='center'>
			
				<div class="chart-container" style="position: relative; height:80vh; width:50vw;">
					<canvas id="myChart"></canvas>
				</div>

				<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.js"></script>
				<script>
	var ctx = document.getElementById("myChart");
	typeGraph = $('#typeG').val();
	
	var myChart = new Chart(ctx, {
		//type: 'bar',
		//type: 'line',
		//type: 'pie',
		type: typeGraph,
		data: {
			labels: <?=json_encode($cat)?>,
			datasets: [{
				label: 'รายงาน',
				data: <?=json_encode($numberCat, JSON_NUMERIC_CHECK);?>,
				backgroundColor: <?=json_encode($colorCharts)?>,
				borderColor: <?=json_encode($colorCharts)?>,
				borderWidth: 0
			}]
		},
		options: {
			scales: {
				yAxes: [{
					ticks: {
						beginAtZero:true
					}
				}]
			},
			 responsive: true,
			 maintainAspectRatio: false,

			 title: {
				display: true,
				text: 'กราฟรายงานสรุปค่าใช้จ่ายขอใช้ห้องปฏิบัติการวิเคราะห์อาหารสัตว์ คณะทรัพยากรธรรมชาติ ภาควิชาสัตวศาสตร์'
			}
		}
	});
	</script>
			

			</td>
		</tr>




	</table>
	<br><br>

</body>
</html>