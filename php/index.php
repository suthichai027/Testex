<!DOCTYPE html>
<html>
<head>
	<title>SSH Send Email</title>
</head>
<body>
	<h2>SSH Send Email</h2>
	<form action="" method="post">
		<label for="ssh_server">ssh_server:</label>
		<input type="text" name="ssh_server" id="ssh_server" required><br><br>
		<label for="username">Username:</label>
		<input type="text" name="username" id="username" required><br><br>
		<label for="password">Password:</label>
		<input type="password" name="password" id="password" required><br><br>
		<label for="To">To:</label>
		<input type="To" name="To" id="To" required><br><br>
		<label for="From">From:</label>
		<input type="From" name="From" id="From" required><br><br>
		<label for="subject">subject:</label>
		<input type="subject" name="subject" id="subject" required><br><br>
		<label for="message">message:</label>
		<input type="message" name="message" id="message" required><br><br>
		<input type="submit" name="submit" value="Submit">
	</form>

	<?php
	// กำหนดข้อมูลการเชื่อมต่อ SSH
	$ssh_server = 'ssh.example.com'; // เซิร์ฟเวอร์ SSH
	$ssh_port = 22; // พอร์ต SSH
	$ssh_username = 'your_ssh_username'; // ชื่อผู้ใช้ SSH
	$ssh_password = 'your_ssh_password'; // รหัสผ่าน SSH
	
	// กำหนดข้อมูลอีเมล์
	$to = 'recipient@example.com'; // อีเมล์ผู้รับ
	$from = 'sender@example.com'; // อีเมล์ผู้ส่ง
	$subject = 'Test email'; // หัวข้ออีเมล์
	$message = 'This is a test email'; // เนื้อหาอีเมล์
	
	// กำหนดค่าสำหรับฟังก์ชั่น mail()
	$headers = 'From: '.$from."\r\n".'Reply-To: '.$from."\r\n".'X-Mailer: PHP/'.phpversion();
	
	// เชื่อมต่อ SSH
	$connection = ssh2_connect($ssh_server, $ssh_port);
	
	if ($connection) {
		// ทำการยืนยันตัวตนด้วยชื่อผู้ใช้และรหัสผ่าน
		if (ssh2_auth_password($connection, $ssh_username, $ssh_password)) {
			// สร้าง SSH tunnel ให้กับ SMTP server
			$tunnel = ssh2_tunnel($connection, 'localhost', 25);
	
			// กำหนดพารามิเตอร์สำหรับฟังก์ชั่น mail()
			$additional_params = '-f ' . $from . ' -r ' . $from;
	
			// ส่งอีเมล์
			if (mail($to, $subject, $message, $headers, $additional_params)) {
				echo 'Email sent successfully';
			} else {
				echo 'Email sending failed';
			}
		} else {
			echo 'Authentication failed';
		}
	} else {
		echo 'Connection failed';
	}
	?>
	
</body>
</html>