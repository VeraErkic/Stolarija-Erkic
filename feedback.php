<?php

$name = $_POST['name'];
$email = $_POST['email'];
$subject = $_POST['subject'];
$message = $_POST['message'];

$error = null;

if(empty($name)|| empty($email) || empty($message)) 
{
    $error = "Ime, email i poruka su obavezna polja. Molimo Vas probajte ponovo!";
}
else if(IsInjected($email))
{
    $error = "Email adresa nije validna!";
}
else
{
	$message .= "<br><br>User IP : ".$_SERVER["REMOTE_ADDR"]."\r\n"; 
	
	$message = nl2br($message);
	
	require_once('./phpmailer/class.phpmailer.php');

	$mail = new PHPMailer();

	$mail->IsSMTP();
	$mail->CharSet="UTF-8";
	$mail->SMTPSecure = "tls";
	$mail->Host = "smtp.gmail.com";
	$mail->Port = 587;
	$mail->Username = "darko.erkic@gmail.com";
	$mail->Password = "darko9977";	
	$mail->SMTPAuth = true;

	
	//$mail->IsSMTP();
	//$mail->Host = "smtp1r.cp.blacknight.com";
	//$mail->SMTPAuth = true;
	//$mail->Port = 25;
	//$mail->Username = "darko@stolarijaerkic.com";
	//$mail->Password = "a#g7RbtKlt";

	$mail->SetFrom("darko@stolarijaerkic.com", "Kontakt sa sajta stolarijaerkic.com");
	$mail->AddReplyTo($email, $name);

	$mail->AddAddress("darko.erkic@gmail.com", "Darko Erkic");
	//$mail->AddAddress("rade.jaramaz@gmail.com", "Rade Jaramaz");

	$mail->Subject = $subject;
	$mail->MsgHTML($message);

	if(!$mail->Send()) {
		$error = "Uknown error, please email us directly to darko.erkic@gmail.com Thank you!";
	}		
}

echo '<html><head><meta http-equiv="refresh" content="0;url=http://www.stolarijaerkic.com/" /></head><body>';

if (isset($error))
{
	echo '<script>alert("'.$error.'");</script>';
}
else
{
	echo '<script>alert("Hvala Vam. Primili smo Vašu poruku i odgovoricemo Vam u najkracem mogucem roku.");</script>';
}

echo 'Bicete prosledjeni na pocetnu stranicu.</body></html>';


// Function to validate against any email injection attempts
function IsInjected($str)
{
  $injections = array('(\n+)',
              '(\r+)',
              '(\t+)',
              '(%0A+)',
              '(%0D+)',
              '(%08+)',
              '(%09+)'
              );
  $inject = join('|', $injections);
  $inject = "/$inject/i";
  if(preg_match($inject,$str))
    {
    return true;
  }
  else
    {
    return false;
  }
}

?>