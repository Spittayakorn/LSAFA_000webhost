<?php
						require('connectDB.php');
						$sqlSearchAna = "select * from analysislist;";
						$resultSearchAna = mysqli_query($con,$sqlSearchAna);

						//วนรอบเท่ากับแถวของ ค่าวิเคราะห์ที่มีอยู่ในระบบ
						$p=0;
						while($recnumSearchAna = mysqli_fetch_array($resultSearchAna))
						{	$p++;
							$chkBreak = true;

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
												
												
												$sqlSearchAndPutDataInNewSimple = "select * from servicechargelist where anaCode='$recnumSearchAna[0]' and catCode='$recnumSearchCatCode[0]' limit 1;";
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
												
												$sqlInsertServiceChagelistAll = "INSERT INTO servicechargelist( catCode, anaCode, simCode, price) VALUES ($recnumSearchCatCode[0],$recnumSearchAna[0],$recnumSearchSimpleList[0],$price);";

												$resultInsertServiceChagelistAll = mysqli_query($con,$sqlInsertServiceChagelistAll);

												if($resultInsertServiceChagelistAll == null)
												{
													echo "คำสั่ง4ผิด";
												}
												
												

												if($j == $numRowSearchSimpleList)
												{
													$price = number_format($price,2,'.',',');
													$chkBreak = true;
													
												}

											}else
											{
												$j++;
												$chkBreak = false;
												$recnumSelectServiceChagelistAll = mysqli_fetch_array($resultSelectServiceChagelistAll);
												
												
												if($j == $numRowSearchSimpleList)
												{	$priceB = number_format($recnumSelectServiceChagelistAll[4],2,'.',',');
													$chkBreak = true;
													
												}
												

											}
											
											if($chkBreak)
											{
												break;
											}
											
										}		
									}			
						}

						echo "<script>
							window.open('AManageAnalysis.php?pageNo=1','_self');
							</script>";
                        //	
					?>