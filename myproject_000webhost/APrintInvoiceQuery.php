<?php
	require_once __DIR__. '/vendor/autoload.php';
	ob_start();
	$labNo = $_POST['labNo'];
						$labYear = $_POST['labYear'];
						$labName = $_POST['labName'];
						$volumeSim = $_POST['volumeSim'];
						$totalPrice = $_POST['totalPrice'];
						$totalPriceTxt = $_POST['totalPriceTxt'];
						$staffName = $_POST['staffName'];
						$hiddenDate = $_POST['hiddenDate'];
						$labCode = $_POST['labCode'];

					
						require('connectDB.php');
						
						$updateLabFinish = "update lab set labStatus='1' where labCode='$labCode';";
						$resultLabFinish = mysqli_query($con,$updateLabFinish);

						if($resultLabFinish == null)
						{
							echo "คำสั่งผิด";
						}
?>


<html>
<head>
	<title>ขอใช้ห้องปฏิบัติการวิเคราะห์อาหารสัตว์</title>
	<meta charset='UTF-8'>

	<style>
		body,textarea {
			font-family: sarabun;
			font-size: 100%;	
			line-height: 1.5;
		}
		
		#date {
			text-align:right;	
		}

		#header {
			text-align: center;
			font-weight: bold;
		}

		#tb {
			font-weight: bold;
		}

		#scoptTb {
			padding: 5px;
		}

		#tbSim {
			
			border-collapse: collapse;
			width:50%;
		}
		.datatext{
			border-bottom:1px dotted;   
			width : 250px;
		}

		#no,#volume,#sumSim {
			text-align:center;
		}

		table {
			border-collapse:1px solid black;
			overflow: wrap;
		}
		
	</style>

</head>
<body>
	<table id='myTable' width='100%' align='center'>
		<tr>
			<td>
				<table border='0' width='100%' cellpadding='5' style='table-layout:fixed;' >
					<?php
						

						echo "<tr>
								<td colspan='3' align='right'>
									ใบขอรับบริการเลขที่&nbsp;$labNo.$labYear
								</td>
							</tr>
							<tr>
								<td colspan='3' align='right'>
									(ส่วนที่ 1)
								</td>
							</tr>";
					?>
						<tr>
							<td align='center' colspan='3'>
								<div id='header' >
									<b>
										ใบแจ้งค่าบริการวิเคราะห์ตัวอย่าง<br>
										ห้องปฏิบัติการอาหารสัตว์ สาขาวิชานวัตกรรมการผลิตสัตว์และจัดการ<br>
										คณะทรัพยากรธรรมชาติ มหาวิทยาลัยสงขลานครินทร์
									</b>
								</div>
							</td>
						</tr>

					<?php
						echo "
							<tr><td>&nbsp;</td></tr>
							<tr>
								<td colspan='3'><b>เรียน</b> &nbsp;&nbsp;&nbsp;&nbsp;$labName</td>
							</tr>";
					
						echo "
							<tr>
								<td colspan='3'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							ตามที่ท่านได้ส่งตัวอย่างมาขอรับบริการวิเคราะห์ จำนวน&nbsp;".number_format($volumeSim)."&nbsp; 
							ตัวอย่าง &nbsp;มีค่าบริการรวมทั้งสิ้น&nbsp;".number_format($totalPrice)."&nbsp;บาท&nbsp;($totalPriceTxt)
								</td>
							</tr>";

						echo "
							<tr><td colspan='3'>&nbsp;</td></tr>
							<tr>
								<td width='50%'></td>
								<td width='5%'></td>
								<td>ลงชื่อ&nbsp;&nbsp;$staffName&nbsp;&nbsp;เจ้าหน้าที่ห้องปฏิบัติการ</td>
							</tr>
							<tr>
								<td width='50%'></td>
								<td width='5%'></td>
								<td>$hiddenDate</td>
							</tr>
					";
									
					
					?>
							
				</table>
			</td>
		</tr>

		<tr>

			<td align='center'>
				<p>.......................................................................................................................................................................................................................................................................</p>
			</td>
		</tr>

		<tr>
			<td>
				
				<table border='0' width='100%' cellpadding='5' style='table-layout:fixed;'>
					<?php
						
						echo "<tr>
								<td colspan='3' align='right'>
									ใบขอรับบริการเลขที่&nbsp;$labNo&nbsp;.&nbsp;$labYear
								</td>
							</tr>
							<tr>
								<td colspan='3' align='right'>
									(ส่วนที่ 2)
								</td>
							</tr>";
					?>
						<tr>
							<td align='center' colspan='3'>
								<div id='header' >
									<b>
										สำหรับเจ้าหน้าที่การเงิน
									</b>
								</div>
							</td>
						</tr>

					<?php
						echo "
							<tr><td colspan='3'>&nbsp;</td></tr>
							";
					
						echo "
							<tr>
								<td colspan='3'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							ได้รับเงินจาก&nbsp;$labName&nbsp;<br>จำนวน&nbsp;&nbsp;".number_format($totalPrice)."&nbsp;&nbsp;บาท&nbsp;&nbsp;($totalPriceTxt)&nbsp;ตามใบเสร็จเล่มที่...........เลขที่...........ไว้เรียบร้อยแล้ว
								</td>
							</tr>
							
							
							";

					
						echo "
							<tr><td colspan='3'>&nbsp;</td></tr>
							<tr>
								<td width='50%'></td>
								<td width='5%'></td>
								<td>ลงชื่อ&nbsp;&nbsp;$staffName&nbsp;&nbsp;เจ้าหน้าที่การเงิน</td>
							</tr>
							<tr>
								<td width='50%'></td>
								<td width='5%'></td>
								<td>วันที่.........../............/.........</td>
							</tr>
					";
									
					
					?>
							
				</table>
				
				<tr>
					<td>
						<p>
							หมายเหตุ : ผู้ขอรับบริการจะต้องชำระเงินค่าบริการวิเคราะห์ในวันที่มาส่งตัวอย่างที่งานคลังคณะ ฯ ตั้งแต่เวลา 09.00-11.30 น. หรือ 13.00-15.30 น. และต้องนำใบเสร็จรับเงินมาแสดงในวันรับผลวิเคราะห์ด้วย
						</p>
					</td>
				</tr>


			</td>
		</tr>
	</table>
	

	
</body>	
</html>

<?php

	use Mpdf\Mpdf;
	$html = ob_get_contents();
	

	$mpdf = new Mpdf();
	$mpdf->showImageErrors = true;
	//--
	$mpdf->shrink_tables_to_fit = 1;
	$mpdf->simpleTables = true;
	$mpdf->packTableData = true;
	$keep_table_proportions = TRUE;
	

	//---
	$mpdf->WriteHTML($html);
	
	$fileName = "$labName.pdf";
	$mpdf->Output($fileName,'D');

	ob_end_flush();
	//chrome://settings/content/pdfDocuments

?>

