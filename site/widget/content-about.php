<?php
	if ($_POST["submit"]) {
		$name = $_POST['name'];
		$email = $_POST['email'];
		$message = $_POST['message'];
		$human = intval($_POST['human']);
		$from = 'Demo Contact Form'; 
		$to = 'example@domain.com'; 
		$subject = 'Message from Contact Demo ';
		
		$body ="From: $name\n E-Mail: $email\n Message:\n $message";
		// Check if name has been entered
		if (!$_POST['name']) {
			$errName = 'Please enter your name';
		}
		
		// Check if email has been entered and is valid
		if (!$_POST['email'] || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
			$errEmail = 'Please enter a valid email address';
		}
		
		//Check if message has been entered
		if (!$_POST['message']) {
			$errMessage = 'Please enter your message';
		}
		//Check if simple anti-bot test is correct
		if ($human !== 5) {
			$errHuman = 'Your anti-spam is incorrect';
		}
// If there are no errors, send the email
if (!$errName && !$errEmail && !$errMessage && !$errHuman) {
	if (mail ($to, $subject, $body, $from)) {
		$result='<div class="alert alert-success">Thank You! I will be in touch</div>';
	} else {
		$result='<div class="alert alert-danger">Sorry there was an error sending your message. Please try again later.</div>';
	}
}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Introduction</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
		<!-- Bootstrap -->
<link type="text/css" rel="stylesheet" href="public/css/bootstrap.css">
<script src ="public/js/bootstrap.js"></script>
</head>
<body>       
    <h1>BSLK là ai?</h1>
    <p>BSLK team hiện đang là các sinh viên năm cuối thuộc trường đại học Bách Khoa thành phố Hồ Chí Minh.
    BLSK là viết tắt của tên các thành viên trong nhóm bao gồm:</p>
    <ul>
      <li>Nguyễn Đôn Bình</li>
      <li>Hoàng Nguyễn Thiên Sơn</li>
      <li>Đinh Hữu Lộc</li>
      <li>Phạm Ngọc Khánh</li>
    </ul>
    <img src="../../public/images/logo_hcmut.png" width="500" height="500" title="Đại học Bách Khoa Hồ Chí Minh"/>
    <h1>BSLK website nằm trong khuôn khổ bài tập lớn môn "Lập trình web" thuộc khoa Khoa học và Kỹ thuật máy tính.</h1>
    <p> Trong quá trình tạo lập không tránh khỏi gặp nhiều sai sót, mọi chi tiết xin liên hệ với chúng tôi thông qua bảng thông tin liên hệ sau, chúng tôi sẽ trả lời sớm nhất có thể.</p>
    <div class="container">
  		<div class="row">
  			<div class="col-md-6 col-md-offset-3">
  				<h1 class="page-header text-center">Contact Form Example</h1>
				<form class="form-horizontal" role="form" method="post" action="index.php">
					<div class="form-group">
						<label for="name" class="col-sm-2 control-label">Name</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="name" name="name" placeholder="First & Last Name" value="<?php echo htmlspecialchars($_POST['name']); ?>">
							<?php echo "<p class='text-danger'>$errName</p>";?>
						</div>
					</div>
					<div class="form-group">
						<label for="email" class="col-sm-2 control-label">Email</label>
						<div class="col-sm-10">
							<input type="email" class="form-control" id="email" name="email" placeholder="example@domain.com" value="<?php echo htmlspecialchars($_POST['email']); ?>">
							<?php echo "<p class='text-danger'>$errEmail</p>";?>
						</div>
					</div>
					<div class="form-group">
						<label for="message" class="col-sm-2 control-label">Message</label>
						<div class="col-sm-10">
							<textarea class="form-control" rows="4" name="message"><?php echo htmlspecialchars($_POST['message']);?></textarea>
							<?php echo "<p class='text-danger'>$errMessage</p>";?>
						</div>
					</div>
					<div class="form-group">
						<label for="human" class="col-sm-2 control-label">2 + 3 = ?</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="human" name="human" placeholder="Your Answer">
							<?php echo "<p class='text-danger'>$errHuman</p>";?>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-10 col-sm-offset-2">
							<input id="submit" name="submit" type="submit" value="Send" class="btn btn-primary">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-10 col-sm-offset-2">
							<?php echo $result; ?>	
						</div>
					</div>
				</form> 
			</div>
		</div>
	</div>   
</div>


 
</body>
</html>

