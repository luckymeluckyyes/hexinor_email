<?php 
session_start();
include("config.php");
require("assets/src/PHPMailer.php");
require("assets/src/SMTP.php");
if(isset($_POST['submit'])) {
	$user = $_SESSION['user'];
	$pass = $_POST['password'];

	$query = "UPDATE companies SET password = '".$pass."' WHERE email = '".$user."'";
	$q = mysqli_query($conn, $query);
	if($q) {
		$com = $_SESSION['company_name'];
		$user = $_SESSION['user'];
		header("location: company_register_step_three.php");
		$mail = new PHPMailer\PHPMailer\PHPMailer();
	    $mail->IsSMTP(); // enable SMTP

	    $mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
	    $mail->SMTPAuth = true; // authentication enabled
	    $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
	    $mail->Host = "smtp.gmail.com";
	    $mail->Port = 465; // or 587
	    $mail->IsHTML(true);
	    $mail->Username = "abc@gmail.com";
	    $mail->Password = "12345678";
	    $mail->SetFrom("abc@gmail.com");
	    $mail->Subject = "Test";
	    $mail->Body = "You have submitted your employer account request. We will be touch once it is reviewed, which may take up to 24 hours.";
	    $mail->AddAddress($user);

	     if(!$mail->Send()) {
	        echo "Mailer Error: " . $mail->ErrorInfo;
	     } else {
	        echo "Message has been sent";
	        // session_unset();
	        // session_destroy();
	     }


	     $mail = new PHPMailer\PHPMailer\PHPMailer();
	    $mail->IsSMTP(); // enable SMTP

	    $mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
	    $mail->SMTPAuth = true; // authentication enabled
	    $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
	    $mail->Host = "smtp.gmail.com";
	    $mail->Port = 465; // or 587
	    $mail->IsHTML(true);
	    $mail->Username = "abc@gmail.com";
	    $mail->Password = "12345678";
	    $mail->SetFrom("abc@gmail.com");
	    $mail->Subject = "New company registration request.(Company: ".$com.")";
	    $mail->Body = "Hello Admin, New company ".$com." has submited request for new account. Please review.";
	    $mail->AddAddress("yashwant@hexinor.com");

	     if(!$mail->Send()) {
	        echo "Mailer Error: " . $mail->ErrorInfo;
	     } else {
	        echo "Message has been sent";
	        // session_unset();
	        // session_destroy();
	     }

	   
	} else {
		header("location: company_register_step_two.php");
	}
}
 ?>
 <?php

 

    
?>
