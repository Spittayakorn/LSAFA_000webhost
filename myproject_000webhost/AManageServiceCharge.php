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
	<title>จัดการอัตราค่าบริการ</title>
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

		#editCharge {
			background-color: #73EAA8;
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

	</style>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script>
		
		$(document).ready(function(){

			$('#signOut').click(function(){
				window.open('logout.php','_self');
			});
			
			$('#tbService').on('click','#editCharge',function(){
				
				//รับรหัสค่าวิเคราะห์
				ana = $(this).closest('tr');
				anaCode = ana.find('td:eq(0)').text();
				anaCode = '#'+anaCode;
				anaCode = $(anaCode).attr('class');

				anaName = ana.find('td:eq(1)').text();
				
				//ส่งค่าไปหน้ากำหนดค่าวิเคราะห์ 
				window.open('AAddServiceCharge.php?anaCode='+anaCode+'&anaName='+anaName,'_self');

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
	
	<table id='myTables' width='100%' cellspacing='10' cellpadding='5'>
		<tr>
			<td colspan='3'><a href='Amain.php'> ระบบขอใช้ห้องปฏิบัติการวิเคราะห์อาหารสัตว์ > เจ้าหน้าที่ห้องปฏิบัติการ</a> > จัดการอัตราค่าบริการ</td>
		</tr>

		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td align='center'><h2>จัดการอัตราค่าบริการ</h2></td>
		</tr>
		<tr>
			<td>
				<table border='1' width='100%' cellpadding='5' id='tbService'>	
					<tr>
						<th width='7%'>ลำดับที่</th>
						<th width='15%'>ชื่อค่าวิเคราะห์</th>
						
						<?php
							require('connectDB.php');

							$sqlSearchCat = "select * from categorys order by catCode;";
							$resultSearchCat = mysqli_query($con,$sqlSearchCat);
							$recNumRow = mysqli_num_rows($resultSearchCat);

							if($resultSearchCat == null)
							{
								echo "คำสั่งผิด";
							}
	
							while($recnumSearchCat = mysqli_fetch_array($resultSearchCat))
							{
								echo "<th width='5%'>$recnumSearchCat[1]</th>";
							}
						?>

						<th width='10%'>จัดการอัตราค่าบริการ</th>
					</tr>
					
					<?php
						
						$sqlSearchAna = "select * from analysislist;";
						$resultSearchAna = mysqli_query($con,$sqlSearchAna);

						//วนรอบเท่ากับแถวของ ค่าวิเคราะห์ที่มีอยู่ในระบบ
						$p=0;
						while($recnumSearchAna = mysqli_fetch_array($resultSearchAna))
						{	$p++;
							$chkBreak = true;

							echo "<tr>
									<td style='text-align:center' ><div id='$p' class='$recnumSearchAna[0]'>$p</div></td>
									<td>$recnumSearchAna[1]</td>";
				
									//ไปดูประเภทนักวิจัย
									$sqlSearchCatCode = "select * from categorys order by catCode;";
									$resultSearchCatCode = mysqli_query($con,$sqlSearchCatCode);

									
									//วนให้เท่ากับประเภทนักวิจัย
									while($recnumSearchCatCode = mysqli_fetch_array($resultSearchCatCode))
									{

										$sqlSearchSimpleList = "select * from simplelist;";
										$resultSearchSimpleList = mysqli_query($con,$sqlSearchSimpleList);
										
										
										if($resultSearchSimpleList == null)
										{
											echo "คำสั่ง1ผิด";
										}
										$numRowSearchSimpleList = mysqli_num_rows($resultSearchSimpleList);
										$j=0;
										while($recnumSearchSimpleList = mysqli_fetch_array($resultSearchSimpleList))
										{
											$sqlSelectServiceChagelistAll = "select * from servicechargelist where anaCode='$recnumSearchAna[0]' and catCode='$recnumSearchCatCode[0]' and simCode='$recnumSearchSimpleList[0]';";
	
											$resultSelectServiceChagelistAll = mysqli_query($con,$sqlSelectServiceChagelistAll);

											if($resultSelectServiceChagelistAll == null)
											{
												echo "คำสั่ง2ผิด";	
											}

											$numRowSelectServiceChagelistAll = mysqli_num_rows($resultSelectServiceChagelistAll);
											
											if($numRowSelectServiceChagelistAll == '0')
											{	
												$j++;
												$chkBreak = false;
												
												
												$sqlSearchAndPutDataInNewSimple = "select * from serviceChargelist where anaCode='$recnumSearchAna[0]' and catCode='$recnumSearchCatCode[0]' limit 1;";
												$resultSearchAndPutDataInNewSimple = mysqli_query($con,$sqlSearchAndPutDataInNewSimple);

												if($resultSearchAndPutDataInNewSimple == null)
												{
													echo "คำสั่ง3ผิด";
												}

												$numRowSearchAndPutDataInNewSimple = mysqli_num_rows($resultSearchAndPutDataInNewSimple);
												
												$price =0;
												if($numRowSearchAndPutDataInNewSimple == 0)
												{
													$price =0;
												}else
												{
													$recnumSearchAndPutDataInNewSimple = mysqli_fetch_array($resultSearchAndPutDataInNewSimple);

													$price = $recnumSearchAndPutDataInNewSimple[4];
													
												}
												
												$sqlInsertServiceChagelistAll = " insert into servicechargelist values('',$recnumSearchCatCode[0],$recnumSearchAna[0],$recnumSearchSimpleList[0],$price);";

												$resultInsertServiceChagelistAll = mysqli_query($con,$sqlInsertServiceChagelistAll);

												if($resultInsertServiceChagelistAll == null)
												{
													echo "คำสั่ง4ผิด";
												}
												
												

												if($j == $numRowSearchSimpleList)
												{
													$price = number_format($price,2,'.',',');
													$chkBreak = true;
													echo "<td align='center'>$price</td>";
												}

											}else
											{
												$j++;
												$chkBreak = false;
												$recnumSelectServiceChagelistAll = mysqli_fetch_array($resultSelectServiceChagelistAll);
												
												
												if($j == $numRowSearchSimpleList)
												{	$priceB = number_format($recnumSelectServiceChagelistAll[4],2,'.',',');
													$chkBreak = true;
													echo "<td align='center'>$priceB</td>";
												}
												

											}
											
											if($chkBreak)
											{
												break;
											}
											
										}		
									}
					
								echo	"<td style='text-align: center;'>
											<button id='editCharge'>แก้ไขอัตราค่าบริการ</button>
										</td>
								</tr>";
						}
					?>
				</table>
			</td>
		</tr>
	</table>
	<br><br>
</body>
</html>