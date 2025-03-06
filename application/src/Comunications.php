<?php 
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

	class Comunications{


		public function sendEmail($destination, $subject, $body){

			$mail = new PHPMailer();

			try {
			    //Server settings
			    // $mail->SMTPDebug = false;                      //Enable verbose debug output
			    $mail->isSMTP();                                            //Send using SMTP
			    $mail->Host       = 'smtp.hostinger.com';                     //Set the SMTP server to send through
			    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
			    $mail->Username   = 'naoresponda@canalsaltoalto.com';                     //SMTP username
			    $mail->Password   = 'MYP5E/Bp1';                               //SMTP password
			    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
			    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
			    $mail->CharSet = "UTF-8";


			    //Recipients
			    $mail->setFrom('naoresponda@canalsaltoalto.com', 'Canal Salto Alto');
			    $mail->addAddress($destination);     //Add a recipient
				$mail->addBcc("gabriel@hatoria.com");
			    

			    //Content
			    $mail->isHTML(true);
			    $mail->Subject = $subject;
			    $mail->Body    = $body;
			    $mail->AltBody = strip_tags($body);

			    $mail->send();

				error_log("Recovery message sent to {$destination}");
			    return true;
			} catch (Exception $e) {
			    return false;
				error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
			}
		}
	}