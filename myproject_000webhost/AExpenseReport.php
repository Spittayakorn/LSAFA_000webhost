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


		
	</style>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script>

		
		$(document).ready(function(){
			
			col = $('#countCol').val();
			
			row = $('#countRow').val();
			
			for(c=1;c<=col;c++)
			{
				sumCol = 0;

				for(r=1;r<=row;r++)
				{
					ColTxt = '#'+r+c;
					ColVale = $(ColTxt).val();
					
					sumCol += parseFloat(ColVale.replace(/,/g,'')); 
					
					if(r==row)
					{
						$(ColTxt).val(addCommas(sumCol));
					}
				}
			}
			
			function addCommas(nStr)
			{
				nStr += '';
				x = nStr.split('.');
				x1 = x[0];
				x2 = x.length > 1 ? '.' + x[1] : '';
				var rgx = /(\d+)(\d{3})/;
				while (rgx.test(x1)) {
					x1 = x1.replace(rgx, '$1' + ',' + '$2');
				}
				return x1 + x2;
			}

			$('#signOut').click(function(){
				window.open('logout.php','_self');
			});
			
			$('#line').click(function(){
				sDate = $('#sDate').val();
				lDate = $('#lDate').val();
				
				window.open("AExpenseReport.php?sDate="+sDate+"&lDate="+lDate+"&typeG=line","_self");
			});
			
			$('#bar').click(function(){
				sDate = $('#sDate').val();
				lDate = $('#lDate').val();
				
				window.open("AExpenseReport.php?sDate="+sDate+"&lDate="+lDate+"&typeG=bar","_self");
			});

			$('#radar').click(function(){
				sDate = $('#sDate').val();
				lDate = $('#lDate').val();
				
				window.open("AExpenseReport.php?sDate="+sDate+"&lDate="+lDate+"&typeG=radar","_self");
			});

			$('#Doughnut').click(function(){
				sDate = $('#sDate').val();
				lDate = $('#lDate').val();
				
				window.open("AExpenseReport.php?sDate="+sDate+"&lDate="+lDate+"&typeG=doughnut","_self");
			});

			$('#Pie').click(function(){
				sDate = $('#sDate').val();
				lDate = $('#lDate').val();
				
				window.open("AExpenseReport.php?sDate="+sDate+"&lDate="+lDate+"&typeG=pie","_self");
			});

			$('#PolarArea').click(function(){
				sDate = $('#sDate').val();
				lDate = $('#lDate').val();
				
				window.open("AExpenseReport.php?sDate="+sDate+"&lDate="+lDate+"&typeG=polarArea","_self");
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
			<td colspan='3'><a href='Amain.php'> ระบบขอใช้ห้องปฏิบัติการวิเคราะห์อาหารสัตว์ > เจ้าหน้าที่ห้องปฏิบัติการ</a> > รายงานค่าใชจ่าย</td>
		</tr>
		
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>
				<!--- -->
				<table style='border:none;' width='100%' cellpadding='10'>
					<tr>
						<form action='AExpenseReport.php' method='POST'>
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
							<table  style='border:none;' width='100%' cellpadding='10' >
								<tr>
									<th><h2>รายงานสรุปค่าใช้จ่าย</h2></th>
								</tr>
								
								<tr>
									<td>
										<table border='1' width='100%' cellpadding='10'>
											<tr bgColor='E6FFE6'>
												<th width='7%'>ลำดับที่</th>
												<th>รายการค่าวิเคราะห์</th>
												<?php
													require('connectDB.php');

													$sqlSearchCat = "select * from categorys;";
													$resultSearchCat = mysqli_query($con,$sqlSearchCat);

													if($resultSearchCat == null)
													{
														echo "คำสั่งผิด";
													}

													while($recnumSearchCat = mysqli_fetch_array($resultSearchCat))
													{
														echo "<th width='10%'>$recnumSearchCat[1]</th>";

													}
													echo "<th width='10%' bgColor='FDF5E6'>รวม</th>";
												?>
											</tr>
											
											<?php

												$sqlSearchAna = "select * from analysislist;";
												$resultSearchAna = mysqli_query($con,$sqlSearchAna);

												if($resultSearchAna == null)
												{
													echo "คำสั่งผิด";
												}
												
												$b=0;
												$j=0;
												while($recnumSearchAna = mysqli_fetch_array($resultSearchAna))
												{
													//---charts
													$cat[] = $recnumSearchAna[1];
													$colorCharts[] = "rgba(".rand(100,255).",".rand(100,255).",".rand(100,255).",".rand(100,255).")";

													//--
													$j++;
													$rowTotal = 0;	
													if($j%2==0)
													{
														echo "<tr bgColor='EBFFEB'>";
													}else
													{
														echo "<tr bgColor='white'>";
													}
													
													echo "
														
															<td align='center'>$j</td>
															<td>
																$recnumSearchAna[1]		
															</td>";
															

															$sqlSearchInCat = "select * from categorys;";
															$resultSearchInCat = mysqli_query($con,$sqlSearchInCat);
															
															
															if($resultSearchInCat == null)
															{
																echo "คำสั่งผิด";
															}
															
															$b = 0;
															$priceInRow = 0;
															while($recnumSearchInCat = mysqli_fetch_array($resultSearchInCat))
															{
																$b++;
																
																$priceInRow = getLabPrice($recnumSearchAna[0],$recnumSearchInCat[0],$sDate,$lDate);
																
																$rowTotal += $priceInRow;
																
																echo "<td align='center' ><output id='$j$b'>".number_format($priceInRow)."</output></td>";
															}
															$b = $b+1;
															
															echo "<td align='center' bgColor='FDF5E6'><output id='$j$b'>".number_format($rowTotal)."</output></td>";

															$numberCat[] = $rowTotal;


													echo	
														"</tr>";


												}
												
												echo "<tr bgColor='FDF5E6'>
														<td colspan='2' align='center'>รวม</td>";
														
														$j= $j+1;
														for($i=1;$i<=$b;$i++)
														{	
															
															echo "<td align='center'><output id='$j$i'>0</output></td>";
														}

												echo "</tr>";

												echo "<input type='hidden' id='countRow' value='$j'>
													<input type='hidden' id='countCol' value='$b'>
													";


												function getLabPrice($anaCode,$catCode,$startDate,$endDate)
												{
													$price =0;

													require('connectDB.php');
													$sqlSearchLab = "select * from lab where labDate between '$startDate 00:00:00' and '$endDate 23:59:59' and catCode='$catCode';";

													$resultSearchLab = mysqli_query($con,$sqlSearchLab);
													
													if($resultSearchLab == null)
													{
														echo "คำสั่งผิด";
													}
													
													$totalSimBefore = 0;
													$sumTotalAnaAfter = 0;
													$allTotoalBeforeAndAfter = 0;

													while($recnumSearchLab = mysqli_fetch_array($resultSearchLab))
													{
														$anaVal = 0;
														
														if(($recnumSearchLab[14]=='1' && $recnumSearchLab[15]=='1' && $recnumSearchLab[16]=='1') || ($recnumSearchLab[14]=='0' && $recnumSearchLab[15]=='1' && $recnumSearchLab[16]=='1'))
														{
															list($simName,$sumSim) = getSimName($recnumSearchLab[0],$anaCode);
														
															if($simName !='')
															{
																$anaVal = $sumSim*$recnumSearchLab[10]*getCharge($anaCode,$catCode);
																
																$totalSimBefore += $anaVal;
																
																if($recnumSearchLab[17]=='1')
																{
																	list($getSimName,$getSumSim,$getRepeat) = getSimNameRepeat($recnumSearchLab[0],$anaCode);
														
																	//คำนวณในแต่ละค่าวิเคราะห์
																	$anaValRepeat = 0;

																	if($getSimName!='' && $getRepeat!= '0')
																	{
																		
																		$anaValRepeat = $getSumSim*$recnumSearchLab[10]*getChargeRepeat($anaCode,$catCode)*$getRepeat;
															
																		$sumTotalAnaAfter += $anaValRepeat;
																	}
																}
															
															}
														}
													}
											
													$allTotoalBeforeAndAfter = $totalSimBefore+$sumTotalAnaAfter;
													return $allTotoalBeforeAndAfter;
												}


												function getSimName($labCode,$anaCode)
												{
													require('connectDB.php');
					
													$simName= '';
													$sumSim = 0;
				
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

															if($count != $numRowSearchAna)
															{
																$simName .= " ,";
															}
														$count++;
														}
													}
					
													return array($simName,$sumSim);
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

												function getSimNameRepeat($labCode,$anaCode)
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
													
													
												function getChargeRepeat($anaCode,$catCode)
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