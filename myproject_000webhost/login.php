<?php
	session_start();

		$username ='';
		$password = '';
		
		if((isset($_SESSION['memCode']) && isset($_SESSION['username']) && isset($_SESSION['password'])))
		{
			$username = $_SESSION['username']; 
			$password = $_SESSION['password'];
			
			echo "
			<script>
				window.open('chkLogin.php?username=$username&password=$password','_self');
			</script>";
		}	
?>

<html>
<head>
	<title>ลงชื่อเข้าสู่ระบบ - ระบบขอใช้ห้องปฏิบัติการวิเคราะห์อาหารสัตว์ ภาควิชาสัตวศาสตร์ คณะทรัพยากรธรรมชาติ</title>
	<meta charset="UTF-8">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<style>

		html,body {
			font-family: sarabun;
			font-size: 100%;	
			line-height: 1.5;
			height:100%
		}

		#con1 {
			height:90%;
			width:100%;
			display:table;
		}

		#con2 {
			vertical-align:middle;
			display:table-cell;
			height:90%
		}
		
		#mytable {
			border-collapse: collapse;
			margin:0 auto;
		}
		
		input[type="text"]{
			width: 200px;
			padding: 0.4em;
			border-radius: 0.2em;
			border: 1px solid #ccc;
			outline: none;
		}

		input[type="password"]{
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
		
		input[type="password"]:focus {
			box-shadow: 0 0 0.5em #2a76e6;
			border-color: #2a76e6;
			padding: 0.4em;
			border: 1px solid #2a76e6;
			outline: none;
		}	
	</style>

	<script>
		
		function chkLogin()
		{
			chk = false;
			user = $('#username').val();
			pwd = $('#password').val();
			
			if(user.trim()!= '' && pwd.trim()!='')
			{
				chk = true;

			}else
			{
				if(user.trim() =='')
				{
					$('#username').focus();
				}
				if(user.trim() !='' && pwd.trim()=='')
				{
					$('#password').focus();
				}
			}
			
			return chk;
		}

	</script>
</head>
<body>
	
	<form name='Login' action='chkLogin.php' method='post' onsubmit='Javascript: return chkLogin()'>
		<div id='con1'>
			<div id='con2'>
				
				<div align='center'>
					<img src='img/hrm_2.jpg'><br><br>
					<font size='5'>เข้าสู่ระบบขอใช้ห้องปฏิบัติการวิเคราะห์อาหารสัตว์ ภาควิชาสัตวศาสตร์ คณะทรัพยากรธรรมชาติ</font>
				</div>
	
				<table id='mytable' align='center' width='30%' cellpadding='10px'>		
					
					<tr>
						<td>
							<label for='username'>รหัสบัญชี</label>	
						</td>
				
						<td>
							<input type='text' id='username' name='username'>
						</td>
					</tr>

					<tr>
						<td>
							<label for='password'>รหัสผ่าน</label>
						</td>
						
						<td>
							<input type='password' id='password' name='password'>
						</td>
					</tr>

					<tr>
						<td colspan='2' align='center'>
							<input type='submit' id='submit' value='เข้าสู่ระบบ'>
						</td>
					</tr>
		
				</table>
			</div>
		</div>
	</form>


</body>
</html>