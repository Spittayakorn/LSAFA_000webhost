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
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
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
			#btYes{
			background-color: green;
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

			#btNo{
			background-color: red;
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
			#myTable ,#innerTable{
			border:none;
			
			}
			#tb {
			font-weight: bold;
			}
			#scoptTb {
			padding: 5px;
			}
			#tbSim {
			border-collapse: collapse;
			width:70%;
			}
			#no,#volume,#sumSim {
			text-align:center;
			}
			select{
			width: 300px;
			padding: 0.4em;
			border-radius: 0.2em;
			border: 1px solid #ccc;
			outline: none;
			
		}
		#labName,#labTel,#objTitle{
			width: 500px;
			padding: 0.4em;
			border-radius: 0.2em;
			border: 1px solid #ccc;
			outline: none;
		}
		#labName:focus{
			box-shadow: 0 0 0.5em #2a76e6;
			border-color: #2a76e6;
			padding: 0.4em;
			border: 1px solid #2a76e6;
			outline: none;
		}
		</style>
		<script>
			$(document).ready(function(){
				
				$('#signOut').click(function(){
					window.open('logout.php','_self');
				});
				
				$('#btYes').click(function(){
					
					statusYes = $(this).attr('class');
					$('#btOffSubmit').val(statusYes);
				});

				//setInterval ให้ดึงค่าทุก ๆ วิ
				setInterval(function(){	
					$.get("getTime.php",function(data,status){
						if(status=='success')
						{
							day = parseFloat(data.day);
							month = data.month;
							year = data.year;
							yearLab = 0;
							
							monthTxt = '';
							
							if(month =='1'){ monthTxt = 'มกราคม'; }
							if(month =='2'){ monthTxt = 'กุมภาพันธ์'; }
							if(month =='3'){ monthTxt = 'มีนาคม'; }
							if(month =='4'){ monthTxt = 'เมษายน'; }
							if(month =='5'){ monthTxt = 'พฤษภาคม'; }
							if(month =='6'){ monthTxt = 'มิถุนายน'; }
							if(month =='7'){ monthTxt = 'กรกฏาคม'; }
							if(month =='8'){ monthTxt = 'สิงหาคม'; }
							if(month =='9'){ monthTxt = 'กันยายน'; }
							if(month =='10'){ monthTxt = 'ตุลาคม'; }
							if(month =='11'){ monthTxt = 'พฤศจิกายน'; }
							if(month =='12'){ monthTxt = 'ธันวาคม'; }
							
							$('#date').html('วันที่&nbsp;'+day+"&nbsp;/&nbsp;"+monthTxt+"&nbsp;/&nbsp;"+year);
							$('#hiddenDate').val('วันที่ '+day+" / "+monthTxt+" / "+year);
						}
					
					});

			},100);
			
		});
			

		function chkDigit(digit)
		{
			chkTel = false;
			if(digit >=48 && digit <=57)
			{
				chkTel = true;
			}
			else
			{
				alert('กรุณากรอกเฉพาะตัวเลข');
			}
			return chkTel;
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
		<table id='myTables' width='100%' cellspacing='10' cellpadding='5'>
			
			<?php
				$statusLab = $_REQUEST['statusLab'];
				$labStatus = $_REQUEST['labStatus'];
				$pageNo = $_REQUEST['pageNo'];
				echo "<tr>
						<td colspan='3'><a href='Amain.php'> ระบบขอใช้ห้องปฏิบัติการวิเคราะห์อาหารสัตว์ > เจ้าหน้าที่ห้องปฏิบัติการ</a> > <a href='AGetLabH.php?statusLab=$statusLab&labStatus=$labStatus&pageNo=$pageNo'>เอกสารที่อนุมัติขอใช้ห้องปฏิบัติการจากผู้บริหาร</a> > พิมพ์ใบแจ้งหนี้</td>
					</tr>";
			?>
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>
					<form action='APrintInvoiceQuery.php' method='POST'>		
						<table id='myTable' width='100%' >
							<tr>
								<td>
									<table border='0' width='100%' cellpadding='5' style='table-layout:fixed;'>
										
										<!--- -->
								<?php
									$labCode = $_GET['labCode'];
									
									require('connectDB.php');
									
									$sqlSearchLab = "select * from lab where labCode='$labCode';";
									$resultSearchLab = mysqli_query($con,$sqlSearchLab);
									
									if($resultSearchLab== null)
									{
										echo "คำสั่งผิด";
									}
									
									$recnumSearchLab = mysqli_fetch_array($resultSearchLab);
									
									if($recnumSearchLab == 0)
									{
										echo "ไม่พบข้อมูล";
									}
									
									function getDocNo()
									{
										require('connectDB.php');
										//ตั้งค่าพื้นที่เวลา
										date_default_timezone_set("Asia/Bangkok");

										$today = getdate();
										//รับวัน-เดือน-ปี
										$day = $today["mday"];
										$month = $today["mon"];
										$year = $today["year"]+543;
										$docnoLab = 0;


										$sqlSearchDocNo = "select * from documentlab order by docnoLab;";
										$resultSearchDocNo = mysqli_query($con,$sqlSearchDocNo);

										if($resultSearchDocNo == null)
										{
											echo "คำสั่งผิด";
										}
										
										$numRowSearchDocNo = mysqli_num_rows($resultSearchDocNo);
										if($numRowSearchDocNo == 0)
										{
											
											$docnoLab=1;
										
										}else
										{
											$i =1 ;
											while($recnumSearchDocNo = mysqli_fetch_array($resultSearchDocNo))
											{
												if($recnumSearchDocNo[0] == $i)
												{
													$i++;
												}

											}
											$docnoLab = $i;
										}
										return $docnoLab;
									}

									if($recnumSearchLab[2] !='')
									{
										echo "
									<tr>
										<td colspan='2' align='right'>
											ใบขอรับบริการเลขที่
											<input type='text' name='labNo' id='labNo' style='width:50px;text-align:right' value='$recnumSearchLab[2]'  onkeypress='return chkDigit(event.charCode)'>&nbsp;.&nbsp;
											<input type='text' name='labYear' style='width:50px; border:none;' value='$recnumSearchLab[3]'>	
										</td>
									</tr>";
	
									}else
									{
										echo "
									<tr>
										<td colspan='2' align='right'>
											เลขที่&nbsp;
											<input type='text' name='labNo' id='labNo' style='width:50px;' value=".getDocNo()." onkeypress='return chkDigit(event.charCode)'>&nbsp;/&nbsp;
											<input type='text' name='labYear' id='labYear' style='width:50px; border:none;'>	
										</td>
									</tr>";

									}

									echo "<tr><td colspan='2' align='right'>(ส่วนที่ 1)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>";
									
									?>

										<!-- -->
										<tr>
											<td align='center' colspan='2'>
												<div id='header' >
													<b>
														ใบแจ้งค่าบริการวิเคราะห์ตัวอย่าง<br>
														ห้องปฏิบัติการอาหารสัตว์ สาขาวิชานวัตกรรมการผลิตสัตว์และจัดการ<br>
														คณะทรัพยากรธรรมชาติ มหาวิทยาลัยสงขลานครินทร์
													</b>
												</div>
											</td>
										</tr>
										<!-- -->
										
										<tr>
											<td colspan='2'>&nbsp;</td>
										</tr>
										
										<?php
										echo "<tr>
												<td id='tb' colspan='2'>เรียน  &nbsp;&nbsp;&nbsp;&nbsp;<input type='text' name='labName' value='$recnumSearchLab[5]' id='labName' style='width:1200px;'></td>
											</tr>";
										?>
										<!-- -->
										
									<tr>
										<?php 

											$sqlSearchCat = "select * from categorys where catCode='$recnumSearchLab[6]';";
											$resultSearchCat = mysqli_query($con,$sqlSearchCat);
											
											if($resultSearchCat == null)
											{
												echo "คำสั่งผิด";
											}
											
											$resultSearchCat = mysqli_fetch_array($resultSearchCat);
											
											if($resultSearchCat == 0)
											{
												echo "ไม่พบข้อมูล";
											}


											$sqlSearchSim = "select * from simplelist;";
											$resultSearchSim = mysqli_query($con,$sqlSearchSim);
													
											if($resultSearchSim == null)
											{
												echo "คำสั่งผิด";
											}
													
											function getVolume($labCode,$simCode)
											{
												require('connectDB.php');
													
												$volume = 0;
													
												$sqlSearchVal = "select da.daCode,da.volume,da.repeats,da.labCode,da.scCode,sc.scCode,sc.catCode,sc.anaCode,sc.simCode,sc.price from dataanalysis as da,servicechargelist as sc where da.scCode=sc.scCode and da.labCode='$labCode' and simCode='$simCode' limit 1;";
													
												$resultSearchVal = mysqli_query($con,$sqlSearchVal);
													
												if($resultSearchVal == null)
												{
													echo "คำสั่งผิด";
												}
													
												$numRowSearchVal = mysqli_num_rows($resultSearchVal);
													
												if($numRowSearchVal!=0)
												{
													
													$recnumSearchVal = mysqli_fetch_array($resultSearchVal);
													$volume = $recnumSearchVal[1];
													
												}
													
												return $volume;
											}
													
											$i = 0;
											$sumValume = 0;
													
											while($recnumSearchSim = mysqli_fetch_array($resultSearchSim))
											{
													
												$volumeSim = getVolume($labCode,$recnumSearchSim[0]);
												if($volumeSim != 0)
												{
													$i++;													
													$sumValume +=$volumeSim;
												}
											}
										
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
													
											$j = 0;
											$sumTotalAnaBefore = 0;
											while($recnumSearchAna = mysqli_fetch_array($resultSearchAna))
											{
														
												list($getSimName,$getSumSim) = getSimName($labCode,$recnumSearchAna[0]);
														
												//คำนวณในแต่ละค่าวิเคราะห์
												$anaVal = 0;
														
												if($getSimName!='')
												{
													$j++;
													$anaVal = $getSumSim*$recnumSearchLab[10]*getCharge($recnumSearchAna[0],$resultSearchCat[0]);
													$sumTotalAnaBefore += $anaVal;
													
												}
													
											}
													
											$sumTotalAnaAfter = 0;
											if($recnumSearchLab[17]=='1')
											{
										
												$sqlSearchAna = "select * from analysislist;";
												$resultSearchAna = mysqli_query($con,$sqlSearchAna);
													
												if($resultSearchAna == null)
												{
													echo "คำสั่งผิด";
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
													
												$j = 0;
													
												while($recnumSearchAna = mysqli_fetch_array($resultSearchAna))
												{
														
													list($getSimName,$getSumSim,$getRepeat) = getSimNameRepeat($labCode,$recnumSearchAna[0]);
														
													//คำนวณในแต่ละค่าวิเคราะห์
													$anaVal = 0;
														
													if($getSimName!='' && $getRepeat!= '0')
													{
														$j++;
														$anaVal = $getSumSim*$recnumSearchLab[10]*getChargeRepeat($recnumSearchAna[0],$resultSearchCat[0])*$getRepeat;
															$sumTotalAnaAfter += $anaVal;
													
														
														}
													
													}
										}

								//----- แปลง ตัวเลข เป็น ภาษาไทย
function Convert($amount_number)
{
	$ret = "";
	if($amount_number =='0')
	{
		$ret  = 'ศูนย์บาทถ้วน';
	}else{


    $amount_number = number_format($amount_number, 2, ".","");
    $pt = strpos($amount_number , ".");
    $number = $fraction = "";
    if ($pt === false) 
        $number = $amount_number;
    else
    {
        $number = substr($amount_number, 0, $pt);
        $fraction = substr($amount_number, $pt + 1);
    }
    
   
    $baht = ReadNumber ($number);
    if ($baht != "")
        $ret .= $baht . "บาท";
    
    $satang = ReadNumber($fraction);
    if ($satang != "")
        $ret .=  $satang . "สตางค์";
    else 
        $ret .= "ถ้วน";
	}
    return $ret;
}

function ReadNumber($number)
{
    $position_call = array("แสน", "หมื่น", "พัน", "ร้อย", "สิบ", "");
    $number_call = array("", "หนึ่ง", "สอง", "สาม", "สี่", "ห้า", "หก", "เจ็ด", "แปด", "เก้า");
    $number = $number + 0;
    $ret = "";
    if ($number == 0) return $ret;
    if ($number > 1000000)
    {
        $ret .= ReadNumber(intval($number / 1000000)) . "ล้าน";
        $number = intval(fmod($number, 1000000));
    }
    
    $divider = 100000;
    $pos = 0;
    while($number > 0)
    {
        $d = intval($number / $divider);
        $ret .= (($divider == 10) && ($d == 2)) ? "ยี่" : 
            ((($divider == 10) && ($d == 1)) ? "" :
            ((($divider == 1) && ($d == 1) && ($ret != "")) ? "เอ็ด" : $number_call[$d]));
        $ret .= ($d ? $position_call[$pos] : "");
        $number = $number % $divider;
        $divider = $divider / 10;
        $pos++;
    }
    return $ret;
}


								//----
									$totoalBeforeAndAfter = $sumTotalAnaBefore+$sumTotalAnaAfter;
									
									$totoalBeforeAndAfterTxt = Convert($totoalBeforeAndAfter);

									echo "
										
										<td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											ตามที่ท่านได้ส่งตัวอย่างมาขอรับบริการวิเคราะห์ จำนวน 
												<input type='text' name='volumeSim' value='$sumValume' style='text-align:center;' onkeypress='return chkDigit(event.charCode)'> 
												ตัวอย่าง มีค่าบริการรวมทั้งสิ้น ".number_format($totoalBeforeAndAfter)." บาท ($totoalBeforeAndAfterTxt)</td>";
									
									echo "<input type='hidden' name='totalPrice' value='$totoalBeforeAndAfter'>
										<input type='hidden' name='totalPriceTxt' value='$totoalBeforeAndAfterTxt'>";
									
									?>

									</tr>
										<!-- -->

									<tr>
										<td colspan='2'>
											
											<table id='innerTable' border='0' width='100%' cellpadding='5' style='table-layout:fixed;'>

	<?php 
		
		function searchNameMem($memCode)
		{
			require('connectDB.php');

			$memName ='';
			$sqlSearchMemName = "select * from member where memCode='$memCode';";
			$resultSearchMemName = mysqli_query($con,$sqlSearchMemName);

			if($resultSearchMemName == null)
			{
				echo "คำสั่งผิด";
			}
			
			$numRowSearchMemName = mysqli_num_rows($resultSearchMemName);
			
			if($numRowSearchMemName != 0)
			{
				$recnumSearchMemName = mysqli_fetch_array($resultSearchMemName);
				$memName = $recnumSearchMemName[4];
			}
			
			return $memName;
		}



		function getStatusAndComment($status,$comment,$memCode)
		{
			$name='';
			$memComment = '';
			$memStatus = '';

			if( $status == '1' || $status == '2')
			{
				$name = searchNameMem($memCode);
				$memComment = $comment;
				if($status == '1')
				{
					$memStatus = 'อนุมัติ';
				}
				
				if($status == '2')
				{
					$memStatus = 'ไม่อนุมัติ';
				}
			}
			
			return array($name,$memComment,$memStatus);
		}
		
		if($recnumSearchLab[15] !='0')
			{
				list($staffName,$staffComment,$staffStatus) = getStatusAndComment($recnumSearchLab[15],$recnumSearchLab[19],$recnumSearchLab[23]);
				
				echo "
					<tr><td colspan='3'>&nbsp;</td></tr>
					<tr>
						<td width='70%'></td>
						<td></td>
						<td>ลงชื่อ&nbsp;&nbsp;".$staffName."&nbsp;&nbsp;เจ้าหน้าที่ห้องปฏิบัติการ</td>
					</tr>
					<tr>
						<td width='70%'></td>
						<td></td>
						<td><div id='date'></div></td>
					</tr>
					<input type='hidden' id='hiddenDate' name='hiddenDate'>
					<input type='hidden' id='staffName' name='staffName' value='$staffName'>
					<input type='hidden' name='labCode' value='$labCode'>

					";
				
			}
				
		
		?>
		
	</table>




										</td>
									</tr>

									</table>			
								</td>
							</tr>
						</table>
						
						<tr>
							<td>
								<input type='submit' value='พิมพ์ใบแจ้งหนี้'>
							</td>
						<tr>	
					</form>

				</td>
			</tr>
		</table>
		<br><br>
	</body>
</html>