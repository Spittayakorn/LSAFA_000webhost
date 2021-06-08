<?php
	session_start();
		
		$SmemCode = '';
		$SmemName = '';
		$SfacCode = '';
		$SfacName = '';
		$SdepCode = '';
		$SdepName = '';

		if(!(isset($_SESSION['memCode']) && isset($_SESSION['memName'])&& isset($_SESSION['facCode'])&& isset($_SESSION['facName'])&& isset($_SESSION['depCode']) && isset($_SESSION['depName'])))
		{
			echo "<script>
					alert('กรุณาเข้าสู่ระบบใหม่อีกครั้ง');
					window.open('login.php','_self');
			</script>";

		}else{
			
			$SmemCode = $_SESSION['memCode'];
			
			//-----
			require('connectDB.php');
			$sqlSearchSessionMember = "select * from member where memCode='$SmemCode';";
			$resultSearchSessionMember = mysqli_query($con,$sqlSearchSessionMember);
			
			if($resultSearchSessionMember == null)
			{
				echo "คำสั่งผิด";
			}

			$recnumSearchSessionMember = mysqli_fetch_array($resultSearchSessionMember);	
			$SmemName = $recnumSearchSessionMember[4];
			$SfacCode = $_SESSION['facCode'];
			$SfacName = $_SESSION['facName'];
			$SdepCode = $_SESSION['depCode'];
			$SdepName = $_SESSION['depName'];
		}	
?>
<html>
<head>
	<title>ขอใช้ห้องปฏิบัติการวิเคราะห์อาหารสัตว์</title>
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
		
		select, textarea {
			width: 300px;
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

		select:focus, textarea:focus {
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

		input[type='text']{
			border:none;
			background:none;
		}

		#anaTable input[type='text']{
			text-align: center;
		
		}

		#labName,#labTel,#objTitle{
			width: 500px;
			padding: 0.4em;
			border-radius: 0.2em;
			border: 1px solid #ccc;
			outline: none;
		}
		input[type='date'] {
			width: 300px;
			padding: 0.4em;
			border-radius: 0.2em;
			border: 1px solid #ccc;
			outline: none;
		}

		#labName:focus,#labTel:focus,#objTitle:focus {
			box-shadow: 0 0 0.5em #2a76e6;
			border-color: #2a76e6;
			padding: 0.4em;
			border: 1px solid #2a76e6;
			outline: none;
		}


		#tb1 {
			border : 0px solid black;
			border-collapse:collapse;
		}

		#simTable td,#simTable th {
			border:0px;
		}
		
	</style>
	

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script>
		$(document).ready(function(){

			$('#signOut').click(function(){
				window.open('logout.php','_self');
			});

			//setInterval ให้ดึงค่าทุก ๆ วิ
			setInterval(function(){
				
				$.get("getTime.php",function(data,status){
					if(status=='success')
					{
						$('#date').html("<div id='dateTime' class='"+data.day+"-"+data.month+"-"+data.year+"&nbsp;"+data.hour+":"+data.minute+":"+data.second+"'>&nbsp;วันที่&nbsp;"+ data.day +  "&nbsp;เดือน&nbsp;"+ data.monthTxt +"&nbsp;พ.ศ.&nbsp;"+data.year+"&nbsp;เวลา&nbsp;"+data.hour+"&nbsp;นาฬิกา&nbsp;"+data.minute+"&nbsp;นาที&nbsp;"+ data.second+"&nbsp;วินาที&nbsp;</div>");

						$('#dates').val(data.years+"-"+data.month+"-"+data.day+" "+data.hour+":"+data.minute+":"+data.second);
					
					
						//----
						day = data.day;
						month = data.month;
						year = data.year;
						yearLab = 0;

						if(month >=10 && month <=12)
						{
							yearLab = year+1;

						}
						if(month >=1 && month <=9)
						{
							yearLab = year;
						}
						
						$('#labYear').val(yearLab);
					
						//---
					}
					
					labDate = $('#dates').val();
					$('#labDate').val(labDate);
										
				});


			},100);

			//ใช้ id volume ตรวจจับ event เมื่อผู้ใช้กรอกตัวเลขปริมาณ ที่ตาราง simTable ใช้ on เพราะมีหลายช่องสำหรับกรอก แต่ถ้ามีช่องเดียวใช้ .click ไปได้เลย 
			$('#simTable').on('input','#volume',function(){
				$('#queryTable').html('');
//----
				$('#totalRowPrice').text(0);
				//ตัวแปร totalSim เก็บผลลัพธ์ผลรวมของปริมมาณที่ผู้ใช้กรอกลงใน id volume แต่ละอัน
				var totalSim = 0;
				
				//ตัวแปร countAna เก็บจำนวนค่าวิเคราะห์ทั้งหมด , ตัวแปร cb_anatxt สำหรับเตรียมสร้าง checkbox ลงไป
				var countAna = $('#countAna').val();
				var cb_anatxt = "";

				//ให้ตารางคอมลัมของ จำนวนตัวอย่างซ้ำที่ผู้ใช้เลือกจาก checkbox,คำนวณค่าใช้จ่าย ของทุกค่าวิเคราะห์ เป็น 0 เสมอ เมื่อมีการเปลี่ยนแปลง ช่องกรอกปริมาณ
				for(k=1;k<=countAna;k++)
				{
					anaValZeroWhenClick = "#resultAna"+k;
					$(anaValZeroWhenClick).html('0');

					totalPriceAnackRow = "#totalPriceAnackRow"+k;
					$(totalPriceAnackRow).val('0');
				}
				
				//ให้ทำในขอบเขตของ id simTable จัดการแต่ละ id  volume อยู่
				$('#simTable #volume').each(function(){
					//รับตัวเลขของแต่ละ volume ออกมา
					var inputVal = $(this).val();
				
					//ตรสจสอบว่าเป็นตัวเลขใช่หรือไม่
					if($.isNumeric(inputVal))
					{
						//บวกตัวเลขในแต่ละ volume เก็บผลลัพธ์ที่ totalSim
						totalSim += parseFloat(inputVal);
						
						//เตรียมข้อมูลทำ checkbox 
						//ค้นหาว่า id volume เก็บ class อะไร ผลลัพธ์ใส่ลงในตัวแปร vol_id โดย class จะเก็บแถวของชนิดตัวอย่างนั้น ๆ อยู่
						vol_id = $(this).attr('class');
						//นำแถวที่ได้ ไปหาว่า มีรหัสค่าชนิดตัวอย่างอะไรจาก id simCode ในแถวนั้นๆ
						simCode_txt = "#simCode"+vol_id;
						simCode_val = $(simCode_txt).val();
					
						//นำแถวที่ได้ ไปหาว่า มีชื่อค่าชนิดตัวอย่างอะไรจาก id simName ในแถวนั้นๆ
						simName_txt = "#simName"+vol_id;
						simName_val = $(simName_txt).val();
						
						//สร้างกล่อง checkbox ขึ้นมา id cksim บ่งบอกว่าเป็นชื่อของกล่องเลือกชื่อว่าอะไร,class เก็บปริมาณของชนิดตัวอย่างนั้นๆ สำหรับเรียกในหน้านี้ยู่ ,value เก็บรหัสชนิดตัวอย่างสำหรับส่งค่าไปอีกหน้า
						cb_anatxt +="<input type='checkbox' name='simCodeChkBox[]' id='cksim' class="+inputVal+" value="+simCode_val+">"+simName_val+"<br>";
					}
				});
				
//----			//นำผลลัพธ์การคำนวณจำนวนปริมาณชนิดตัวอย่างที่ผู้ใช้กรอกแสดงลงใน id result 
				totalSimComma = addCommas(totalSim);
				$('#result').text(totalSimComma);
				
				//สำหรับทำ checkBox
				//ทำเท่ากับจำนวนของ ค่าวิเคราะห์
				for(i=1;i<=countAna;i++)
				{	
					
					//ใส่ข้อมูลลงใน id resultSim แต่ละแถว มีชนิด tag เป็น output (กรณีใช้ tag อื่นค่าที่ได้จะไม่ทำให้อยู่ในช่องเดียว) 
					ana_row = "#resultSim"+i;
					//ใส่แถวของค่าวิเคราะห์นั้นๆ ลงใน tag div ซึ่ง ที่ครอบ checkbox อีกที โดย div บ่งบอกถึงขอบเขต checkbox แต่ละตัวอยู่
					ckRow = "ckRow"+i;
					$(ana_row).html("<div id='cksimRow' class="+ckRow+">"+cb_anatxt+"</div>");
				}
			});
			
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
		
			//เมื่อผู้ใช้ กดที่ tag div โดยดักจับ event ด้วย cksimRow ขอบเขตตาราง id anaTable 
			$('#anaTable').on('click','#cksimRow',function(){
				
				//ตัวแปร totalRepeat เก็บผลรวมของปริมาณที่ถูก checked ใน checkbox
				var totalRepeat = 0;
				
				//ตัวแปร totalPriceAna เก็บผลรวมของค่าใช้จ่ายแต่ละค่าวิเคราะห์ คำนวณจาก จำนวนทำซ้ำ*ปริมาณรวมชนิดตัวอย่างที่ถูก check*อัตราค่าบริการแต่ละค่าวิเคราะห์
				var totalPriceAna = 0;
				
				//นำ id cksimRow ตรวจสอบ class ซึ่งเก็บข้อมูลจำนวนแถวของแต่ละค่าวิเคราะห์อยู่
				ckRow = $(this).attr('class');
				
				//หรือจะใช้วิธีการหาจากตารางว่าอยู่แถวที่เท่าไหรก็ได้
				anaRow = $(this).closest('tr');
				anaNo = anaRow.find('td:eq(0)').text();

				//ทำเฉพาะพื้นที่ของ tag div ที่ id cksimRow ต่าง class จัดการที่กล่อง checkbox ที่ถูก checked 
				textCheckRow = "."+ckRow+" "+"#cksim:checked";
				$(textCheckRow).each(function(){
					//ตรวจสอบว่า cksim ที่ checked ค่า class เก็บอะไร กำหนดให้ class เก็บปริมาณของแต่ละชนิดตัวอย่าง
					inputVolume = $(this).attr('class');

					//เก็บผลรวมของปริมาณใส่ลงใน ตัวแปร totalRepeat
					totalRepeat += parseFloat(inputVolume);

				});

				//แสดงค่าผลรวมปริมาณที่ผู้ใช้เลือก ซึ่งเก็บไว้ในตัวแปร totalRepeat ใส่ลงใน id resultAna ของแถวค่าวิเคราะห์นั้นๆ
				resultAna_txt = "#resultAna"+anaNo;
//----			
				
				$(resultAna_txt).text(addCommas(totalRepeat));

				//คำนวณค่าใช้จ่าย
				//เก็บจำนวนตัวอย่างละซ้ำ จาก value ของ id labNReport ที่ถูก checked
				nRepeat = $('#labNRepeat:checked').val();
				
				//ดึงราคาค่าวิเคราะห์ จาก id price แถวที่เราคลิ๊กมา
				priceAna_txt = '#price'+ckRow;
				priceAna_val = $(priceAna_txt).val();
				
				//สูตรการคำนวณคำนวณค่าใช้จ่ายแต่ละค่าวิเคราะห์ คือ   ผลรวมของปริมาณที่เลือก*จำนวนตัวอย่างละซ้ำ*อัตราค่าวิเคราะห์
				//คำนวณใส่ผลลัพธ์ลงใน ตัวแปร totalPriceAna
//-----
				totalPriceAna = totalRepeat*parseFloat(nRepeat)*parseFloat(priceAna_val.replace(/,/g,''));
				
				//แสดงลงใน input type = text โดยใส่ค่าลงใน property val 
				totalPriceAna_txt = "#totalPriceAna"+ckRow;
//----
				 
				$(totalPriceAna_txt).val(addCommas(totalPriceAna));

				//รวมตัวเลขค่าใช้จ่ายทั้งหมด
				//ตัวแปร countAna เก็บจำนวนค่าวิเคราะห์ทั้งหมด
				totalRowPrice = 0;
				countAna = $('#countAna').val();
				for(r=1;r<=countAna;r++)
				{
					totalPriceAna_txts = "#totalPriceAnackRow"+r;
					totalPriceAna_txts = $(totalPriceAna_txts).val();
//-----				
					
					totalRowPrice += parseFloat(totalPriceAna_txts.replace(/,/g,''));

				}
				
//----
				totalRowPriceComma = addCommas(totalRowPrice);
				$('#totalRowPrice').text(totalRowPriceComma);
				
			});

			
			//เพิ่มอัตราค่าวิเคราะห์
			//เมื่อผู้ใช้เปลี่ยนประเภทนักวิจัย ตรวจจับ event ผ่าน id catCode มีปุ่มเดียวเลยใช้ .change ได้เลย
			$('#catCode').change(function(){

				//เก็บรหัสประเภทนักวิจัยลงใน ตัวแปร catCode
				catCode = $('#catCode').val();
				
				if(catCode=='-1')
				{
					var countAna = $('#countAna').val();
					//ใส่อัตราค่าวิเคราะห์ลงไปในแต่ละแถวค่าวิเคราะห์ 
					for(i=0,row=1;i<countAna;i++,row++)
					{
						//ตัวแปร price เก็บอัตราค่าวิเคราะห์แต่ละค่าวิเคราะห์
						price = "#priceckRow"+row;
						$(price).val('0');

						//ตัวแปร scCode เก็บรหัสอัตราค่าบริการ
						scCode = "#scCode"+row;
						$(scCode).val('');
					}

					//เมื่อผู้ใช้กดเปลี่ยนประเภทนักวิจัย
						//ตัวแปร countAna เก็บจำนวนค่าวิเคราะห์ทั้งหมด
						countAna = $('#countAna').val();
						
						//ตัวแปร nRepeat เก็บตัวอย่างละซ้ำ ที่ถูกเลือกไว้ -> แปลงเป็นตัวเลข
						nRepeat = $('#labNRepeat:checked').val();
						nRepeat = parseFloat(nRepeat);

						totalRowPrice = 0;
						
						//คำนวณค่าใช้จ่ายเมื่อมีการเปลี่ยนประเภทนักวิจัย
						for(i=1;i<=countAna;i++)
						{
							//ตัวแปร resultAnaVal เก็บปริมาณที่ผู้ใช้ checked ->แปลงเป็นตัวเลข
							resultAna = "#resultAna"+i;
							resultAnaVal = $(resultAna).val();
//---
							resultAnaVal = parseFloat(resultAnaVal.replace(/,/g,''));
							
							//ตัวแปร priceckRowVal เก็บอัตราค่าบริการแต่ละค่าวิเคราะห์แต่ละแถว ->แปลงเป็นตัวเลข
							priceckRow = "#priceckRow"+i;
							priceckRowVal = $(priceckRow).val();
//----
							priceckRowVal = parseFloat(priceckRowVal.replace(/,/g,''));
							
							//ตัวแปร totalPriceAnackRow เก็บค่าใช้จ่ายที่คำนวณ 
							totalPriceAnackRow = resultAnaVal*nRepeat*priceckRowVal;
							
							//ใส่ผลลัพธ์ลงในค่าวิเคราะห์แต่ละแถว ทับลงใน id totalPriceAnackRow ที่เป็น text
							totalPriceAnackRowID = "#totalPriceAnackRow"+i;
//----
							$(totalPriceAnackRowID).val(addCommas(totalPriceAnackRow));

							//รวมตัวเลขค่าใช้จ่ายทั้งหมด
							totalPriceAna_txts = "#totalPriceAnackRow"+i;
							totalPriceAna_txts = $(totalPriceAna_txts).val();
//---
							totalRowPrice += parseFloat(totalPriceAna_txts.replace(/,/g,''));
						}
//----						//รวมค่าใช้จ่ายทั้งหมดเสร็จนำไปแสดง
						$('#totalRowPrice').text(addCommas(totalRowPrice));
			
				}
				
				//ห้ามเป็น -1
				if(catCode!='-1')
				{
					//ใช้ jquery + ajax ไปหาอัตราค่าบริการ เมื่อประเภทนักวิจัยถูกเลือกเป็นเท่านี้จากฐานข้อมูล
					$.get("getServiceCharge.php?catCode="+catCode,function(data,status){
						if(status=='success')
						{
							//ใส่อัตราค่าวิเคราะห์ลงไปในแต่ละแถวค่าวิเคราะห์ 
							for(i=0,row=1;i<data.length;i++,row++)
							{
								//ตัวแปร price เก็บอัตราค่าวิเคราะห์แต่ละค่าวิเคราะห์
								price = "#priceckRow"+row;
//-----
								$(price).val(addCommas(data[i].price));

								//ตัวแปร scCode เก็บรหัสอัตราค่าบริการ
								scCode = "#scCode"+row;
								$(scCode).val(data[i].scCode);
							}
						}
						
						//เมื่อผู้ใช้กดเปลี่ยนประเภทนักวิจัย
						//ตัวแปร countAna เก็บจำนวนค่าวิเคราะห์ทั้งหมด
						countAna = $('#countAna').val();
						
						//ตัวแปร nRepeat เก็บตัวอย่างละซ้ำ ที่ถูกเลือกไว้ -> แปลงเป็นตัวเลข
						nRepeat = $('#labNRepeat:checked').val();
						nRepeat = parseFloat(nRepeat);

						totalRowPrice = 0;
						
						//คำนวณค่าใช้จ่ายเมื่อมีการเปลี่ยนประเภทนักวิจัย
						for(i=1;i<=countAna;i++)
						{
							//ตัวแปร resultAnaVal เก็บปริมาณที่ผู้ใช้ checked ->แปลงเป็นตัวเลข
							resultAna = "#resultAna"+i;
							resultAnaVal = $(resultAna).val();
//----
							resultAnaVal = parseFloat(resultAnaVal.replace(/,/g,''));
							
							//ตัวแปร priceckRowVal เก็บอัตราค่าบริการแต่ละค่าวิเคราะห์แต่ละแถว ->แปลงเป็นตัวเลข
							priceckRow = "#priceckRow"+i;
							priceckRowVal = $(priceckRow).val();
//----
							priceckRowVal = parseFloat(priceckRowVal.replace(/,/g,''));
							
							//ตัวแปร totalPriceAnackRow เก็บค่าใช้จ่ายที่คำนวณ 
							totalPriceAnackRow = resultAnaVal*nRepeat*priceckRowVal;
							
							//ใส่ผลลัพธ์ลงในค่าวิเคราะห์แต่ละแถว ทับลงใน id totalPriceAnackRow ที่เป็น text
							totalPriceAnackRowID = "#totalPriceAnackRow"+i;
//---
							$(totalPriceAnackRowID).val(addCommas(totalPriceAnackRow));

							//รวมตัวเลขค่าใช้จ่ายทั้งหมด
							totalPriceAna_txts = "#totalPriceAnackRow"+i;
							totalPriceAna_txts = $(totalPriceAna_txts).val();
							totalRowPrice += parseFloat(totalPriceAna_txts.replace(/,/g,''));
						}
						//รวมค่าใช้จ่ายทั้งหมดเสร็จนำไปแสดง
						$('#totalRowPrice').text(addCommas(totalRowPrice));
			
					});
				}
			});

			$(document).on('click','#labNRepeat',function(){
				//เมื่อผู้ใช้กดเปลี่ยนตัวอย่างละซ้ำ
				//ตัวแปร countAna เก็บจำนวนค่าวิเคราะห์ทั้งหมด
						countAna = $('#countAna').val();
						
						//ตัวแปร nRepeat เก็บตัวอย่างละซ้ำ ที่ถูกเลือกไว้ -> แปลงเป็นตัวเลข
						nRepeat = $('#labNRepeat:checked').val();
						nRepeat = parseFloat(nRepeat);

						totalRowPrice = 0;
						
						//คำนวณค่าใช้จ่ายเมื่อมีการเปลี่ยนประเภทนักวิจัย
						for(i=1;i<=countAna;i++)
						{
							//ตัวแปร resultAnaVal เก็บปริมาณที่ผู้ใช้ checked ->แปลงเป็นตัวเลข
							resultAna = "#resultAna"+i;
							resultAnaVal = $(resultAna).val();
//----
							resultAnaVal = parseFloat(resultAnaVal.replace(/,/g,''));
							
							//ตัวแปร priceckRowVal เก็บอัตราค่าบริการแต่ละค่าวิเคราะห์แต่ละแถว ->แปลงเป็นตัวเลข
							priceckRow = "#priceckRow"+i;
							priceckRowVal = $(priceckRow).val();
//----
							priceckRowVal = parseFloat(priceckRowVal.replace(/,/g,''));
							
							//ตัวแปร totalPriceAnackRow เก็บค่าใช้จ่ายที่คำนวณ 
							totalPriceAnackRow = resultAnaVal*nRepeat*priceckRowVal;
							
							//ใส่ผลลัพธ์ลงในค่าวิเคราะห์แต่ละแถว ทับลงใน id totalPriceAnackRow ที่เป็น text
							totalPriceAnackRowID = "#totalPriceAnackRow"+i;
//---
							$(totalPriceAnackRowID).val(addCommas(totalPriceAnackRow));

							//รวมตัวเลขค่าใช้จ่ายทั้งหมด
							totalPriceAna_txts = "#totalPriceAnackRow"+i;
							totalPriceAna_txts = $(totalPriceAna_txts).val();
							totalRowPrice += parseFloat(totalPriceAna_txts.replace(/,/g,''));
						}
						//รวมค่าใช้จ่ายทั้งหมดเสร็จนำไปแสดง
						$('#totalRowPrice').text(addCommas(totalRowPrice));

			});
			
			//เมื่อผู้ใช้คลิ๊กที่ id cksim  ขอบเขต id anaTable
			$('#anaTable').on('click','#cksim',function(){
				
				//ตัวแปร queryTable เก็บผลรวมคำสั่งการสร้างตาราง
				var queryTable='';
				
				// ขอบเขต คือ anaTable จัดการที่ cksim ที่ถูก checked แล้ว
				qTable = "#anaTable #cksim:checked";
				$(qTable).each(function(){
					//ตัวแปร qCatCode เก็บประเภทนักวิจัยจาก id catCode
					qCatCode = $('#catCode').val();
					
					if(qCatCode !=-1)
					{	
						//ตัวแปร numRow เก็บแถวจากการคลิ๊ก ตาราง แล้วไปดูคอลัมที่ 0
						row = $(this).closest('tr');
						numRow = row.find('td:eq(0)').text();
						
						//ตัวแปร qAnaCode เก็บรหัสค่าวิเคราะห์ อ้างจาก id anaCodeckRow แถว ที่เราเลือกอยู่
						qAnaCodeTxt = "#anaCodeckRow"+numRow;
						qAnaCode = $(qAnaCodeTxt).val();
						
						//ดูรหัสชนิดตัวอย่างที่ checked อยู่ จาก id ckSim 
						qSimCode = $(this).val();

						//รับปริมาณ จาก id ckSim อ้างจาก class
						inputVolume = $(this).attr('class');
						qVolume = inputVolume;

						//alert("ประเภทนักวิจัย "+qCatCode+" รหัสค่าวิเคราะห์" +qAnaCode+" รหัสชนิดตัวอย่าง"+qSimCode+" ปริมาณ"+qVolume);

						queryTable += "<tr><td><input type='hidden' name='anaCode[]' value="+qAnaCode+" readonly><input type='hidden' name='simCode[]' value="+qSimCode+" readonly><input type='hidden' name='volume[]' value="+qVolume+" readonly></td></tr>";
						
					}
				});
				//จับมัดใส่ลงในตัวตาราง
				$('#queryTable').html(queryTable);
			});

		});

		function chkAllData()
		{	
			check = false
			
			labName = $('#labName').val();
			catCode = $('#catCode').val();
			labTel = $('#labTel').val();
			objCode = $('#objCode').val();
			objTitle = $('#objTitle').val();
			labSDate = $('#labSDate').val();
			labEDate = $('#labEDate').val();
			boCode = $('#boCode').val();

			if(labName.trim() !='' && labTel.trim() !='' && objTitle !='' && catCode !='-1' && objCode !='-1' && labSDate !='' && labEDate !='' && boCode !='-1')
			{
				check = true;
			}else
			{
				
				if(labName.trim() =='')
				{	
					alert('กรุณากรอกชื่อผู้ขอใช้ห้องปฏิบัติการ');
					$('#labName').focus();
				}
				else
				{
					if(catCode =='-1')
					{
						alert('กรุณาเลือกประเภทนักวิจัย');
						$('#catCode').focus();
					}else
					{
						if(labTel.trim() =='')
						{
							alert('กรุณากรอกเบอร์โทรศัพท์');
							$('#labTel').focus();
					
						}else
						{
							if(objCode == '-1')
							{
								alert('กรุณาเลือกประเภทวัตถุประสงค์');
								$('#objCode').focus();
							}
							else
							{
								if(objTitle.trim() =='')
								{		
									alert('กรุณากรอกชื่อวัตถุประสงค์');
									$('#objTitle').focus();
								}else
								{
									if(labSDate.trim() == '')
									{
										alert('กรุณากำหนดช่วงเวลาเริ่มต้นกิจกรรม')
										$('#labSDate').focus();	
									}else
									{
										if(labEDate.trim() == '')
										{
											alert('กรุณากำหนดช่วงเวลาเริ่มต้นกิจกรรม')
											$('#labEDate').focus();	
										}else
										{
											if(boCode == '-1')
											{	
												alert('กรุณาเลือกชื่อผู้บริหารที่ต้องการส่ง');
												$('#boCode').focus();
											}

										}
									}
								}
							}
						}				
					}
				}
				
			}

			return check;
		}

		function chkNumber(digit)
		{

			chkTel = false;
			catCode = $('#catCode').val();
			if(catCode != '-1')
			{
				if(digit >=48 && digit <=57)
				{
					chkTel = true;
				}
				else
				{
					alert('กรุณากรอกเฉพาะตัวเลข');
				}
			
			}else
			{
				alert('กรุณาเลือกประเภทนักวิจัย');
				$('#catCode').focus();
			}

			return chkTel;
		}

		function chkNumberr(digit)
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
				<?php echo "$SmemName $SfacName วิทยาเขตหาดใหญ่";  ?>
			</td>
			<td align='center'>
				<button id='signOut'>ออกจากระบบ</button>
			</td>
		</tr>
	</table>
	
	<!--- ส่วนข้อมูล   -->
	
	<table id='myTables' width='100%' cellspacing='10' cellpadding='5'>
		<tr>
			<td colspan='3'><a href='Smain.php'> ระบบขอใช้ห้องปฏิบัติการวิเคราะห์อาหารสัตว์ > นักศึกษา</a> > <a href='SManageLab.php'>รายการแบบฟอร์มขอใช้ห้องปฏิบัติการวิเคราะห์อาหารสัตว์</a> > ขอใช้ห้องปฏิบัติการ</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>
				<div align='center'>
					<p><b>แบบฟอร์มขอใช้ห้องปฏิบัติการวิเคราะห์อาหารสัตว์ <br>ภาควิชาสัตว์ศาสตร์ คณะทรัพยากรธรรมชาติ</b></p>
				</div>

	
	<p id='date'></p>
	<input type='hidden' id='dates'>
	
	<form action='SAddFormLab.php' method='POST' onsubmit='Javascript:return chkAllData()'>
		
		<input type='hidden' id ='labDate' name='labDate'>

		<table border='0' cellpadding='5' id='tb1'>	
			
		
			<tr>
				<td><b>ชื่อผู้ขอใช้ห้องปฏิบัติการ</b></td>
				<td>
				
				<?php
					require('connectDB.php');
					
					$sqlSearchMem = "select * from member where memCode='$SmemCode';";
					$resultSearchMem = mysqli_query($con,$sqlSearchMem);

					if($resultSearchMem == null)
					{
						echo "คำสั่งผิด";
					}
					
					$recnumSearchMem = mysqli_fetch_array($resultSearchMem);

					echo "<input type='text' name='labName' id='labName' value='$recnumSearchMem[4]'>";
				?>

				</td>
			</tr>

			<tr>
				<td><b>ประเภท</b></td>
				<td>
					<select name='catCode' id='catCode'>
					<option value='-1' selected>กรุณาเลือกประเภทนักวิจัย</option>
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
								echo "<option value='$recnumSearchCat[0]'>$recnumSearchCat[1]</option>";
							}

						?>
					</select>
				</td>
			</tr>
		
			<tr>
				<td><b>โทรศัพท์</b></td>
				<td>
					<input type='text' name='labTel' id='labTel' onkeypress='return chkNumber(event.charCode)'>
				</td>
			</tr>

			<tr>
				<td><b>วัตถุประสงค์ของการขอใช้ห้องปฏิบัติการ</b></td>
				<td></td>
			</tr>
		
			<tr>
				<td><b>ประเภทวัตถุประสงค์</b></td>
				<td>
					<select name='objCode' id='objCode'>
						<option value='-1'>กรุณาเลือกประเภทวัตถุประสงค์</option>
						
						<?php
							
							$sqlSearchObj = "select * from objective;";
							$resultSearchObj = mysqli_query($con,$sqlSearchObj);

							if($resultSearchObj == null)
							{
								echo "คำสั่งผิด";
							}
							
							while($recnumSearchObj = mysqli_fetch_array($resultSearchObj))
							{
								echo "<option value='$recnumSearchObj[0]'>$recnumSearchObj[1]</option>";
							}
							
						?>
					</select>
				</td>
			</tr>

			<tr>
				<td><b>ชื่อวัตถุประสงค์</b></td>
				<td>
					<input type='text' name='objTitle' id='objTitle'>
				</td>
			</tr>

		</table>
		
		<br>
		<b>ชนิดตัวอย่างที่ต้องการวิเคราะห์</b><br><br>

		<table border='1' id='simTable' cellpadding='5'>
			
			<tr>
				<th>ลำดับที่</th>
				<th>ชื่อชนิดตัวอย่าง</th>
				<th>จำนวน</th>
				
			</tr>
			
			<?php
				
				$sqlSearchSim = "select * from simplelist;";
				$resultSearchSim = mysqli_query($con,$sqlSearchSim);

				if($resultSearchSim == null)
				{
					echo "คำสั่งผิด";
				}
				
				$i=0;
				while($recnumSearchSim = mysqli_fetch_array($resultSearchSim))
				{
					$i++;
					echo "<tr>
							<td align='center'>$i</td>
							<td>
								<input type='text' id='simName$i' value='$recnumSearchSim[1]' readonly>	
							</td>
							<td>
								<input type='text' id='volume' class='$i' style='border:1px solid black;' onkeypress='return chkNumber(event.charCode)'>
							</td>
							<td>
								<input type='hidden' id='simCode$i' value='$recnumSearchSim[0]'>
							</td>
						</tr>";
				}
				
			?>
			
			<tr>
				<td colspan='2' align='center'>จำนวนทั้งหมด</td>
				<td align='center'><output id='result'>0</output></td>
				<td>ตัวอย่าง</td>
			</tr>
		</table>
		
		<br><br>
		
		ตัวอย่างละ&nbsp;&nbsp;&nbsp;
		<input type='radio' name='labNRepeat' id='labNRepeat' value='2' checked>2 ซ้ำ
		<input type='radio' name='labNRepeat' id='labNRepeat' value='3'>3 ซ้ำ
		
		<br><br>

		<table border='0' id='anaTable' cellpadding='9'>
			<tr bgColor='#dcdcdc'>
				<th>ลำดับที่</th>
				<th>ค่าที่ต้องการวิเคราะห์</th>
				<th>ชนิดตัวอย่าง</th>
				<th>ผลรวมปริมาณชนิดตัวอย่าง</th>
				<th>อัตราค่าวิเคราะห์</th>
				<th colspan='3'>จำนวนตัวอย่างซ้ำ</th>
				<!--<th>รหัสค่าวิเคราะห์</th>-->
				<!--<th>รหัสราคา</th>-->
			</tr>

			
			<?php
				
				$sqlSearchAna = "select * from analysislist;";
				$resultSearchAna = mysqli_query($con,$sqlSearchAna);

				if($resultSearchAna == null)
				{
					echo "คำสั่งผิด";
				}
				
				$getTr ='';
				$j = 0;
				while($recnumSearchAna = mysqli_fetch_array($resultSearchAna))
				{	
					$j++;
					//ถ้าไม่ใช้ output tag ตอนรวมเลขค่าจะต่อกันไปเรื่อยๆ 
					if($j%2==0)
					{
						$getTr = '<tr valign="top" bgColor="#D2D2FF">';
					}else
					{
						$getTr = '<tr valign="top" bgColor="F0FFF0">';
					}
					
					echo	$getTr."
							<td>$j</td>
							<td>$recnumSearchAna[1]</td>
							<td><output id='resultSim$j'></output></td>
							<td align='center'><output id='resultAna$j'>0</output></td>
							<td>
								<input type='text' id='priceckRow$j' value='0' readonly>
							</td>
							<td>
								<input type='text' id='totalPriceAnackRow$j' value='0' readonly>
							</td>
							<td>
								<input type='hidden' id='anaCodeckRow$j' value='$recnumSearchAna[0]' readonly>
							</td>
							<td>
								<input type='hidden' id='scCode$j' readonly>
							</td>

						</tr>";
				}
			?>

			<tr>
				<td colspan='5' align='center'>ราคารวม</td>
				<td colspan='1' align='center'>
					<output id='totalRowPrice'>0</output>
				</td>
			</tr>
		</table>
		
		<input type= 'hidden' id='countAna' value=<?php echo $j; ?>>
		
	
		<p>โดยมีกำหนดตั้งแต่วันที่&nbsp;<input type='date' name='labSDate' value='' id='labSDate'>&nbsp;&nbsp;ถึง&nbsp;วันที่&nbsp;<input type='date' name='labEDate' value='' id='labEDate'></p>
		
		<?php
			
			$sqlSearchMember = "select * from member where memCode='$SmemCode';";
			$resultSearchMember = mysqli_query($con,$sqlSearchMember);

			if($resultSearchMember== null)
			{
				echo "คำสั่งผิด";
			}
			
			$recnumSearchMember = mysqli_fetch_array($resultSearchMember);

			echo "ลงชื่อ &nbsp;&nbsp;$recnumSearchMember[4]<input type='hidden' name='memCode' value='$recnumSearchMember[0]'>";
		?>
			
			<br><br>
			
			<table border='0' cellpadding='5'>
				<tr>
					<td>กรุณาเลือกอาจารย์</td>
					<td>
						<select name='boCode' id='boCode'>
						<option value='-1' selected>กรุณาเลือกอาจารย์</option>
					<?php
				
						$sqlSearchTeaMember = " select * from member where memlevel='2';";
						$resultSearchTeaMember = mysqli_query($con,$sqlSearchTeaMember);

						if($resultSearchTeaMember== null)
						{
							echo "คำสั่งผิด";
						}

						while($recnumSearchTeaMember = mysqli_fetch_array($resultSearchTeaMember))
						{
							echo "<option value='$recnumSearchTeaMember[0]'>$recnumSearchTeaMember[4]</option>";
						}
					?>
						</select>
					</td>
				</tr>
			</table>
			
			<br><br>
			<input type='submit' value='ยืนยันขอใช้ห้องปฏิบัติการ' id='btSubmit'>
			<table border='0' id='queryTable'>
			</table>

			

	</form>

			</td>
		</tr>
	</table>
	<br><br>
				
</body>
</html>