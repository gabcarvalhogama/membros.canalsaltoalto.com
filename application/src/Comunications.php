<?php 
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

	class Comunications{


		public function sendEmail($destination, $subject, $body){

			//Create an instance; passing `true` enables exceptions
			$mail = new PHPMailer();

			try {
			    //Server settings
			    // $mail->SMTPDebug = fasle;                      //Enable verbose debug output
			    $mail->isSMTP();                                            //Send using SMTP
			    $mail->Host       = 'mail.gabcarvalhogama.com.br';                     //Set the SMTP server to send through
			    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
			    $mail->Username   = 'naoresponda@canalsaltoalto.com';                     //SMTP username
			    $mail->Password   = 'H)a0(f_+f41b';                               //SMTP password
			    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
			    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
			    $mail->CharSet = "UTF-8";


			    //Recipients
			    $mail->setFrom('naoresponda@canalsaltoalto.com', 'Canal Salto Alto');
			    $mail->addAddress($destination);     //Add a recipient
			    

			    //Content
			    $mail->isHTML(true);
			    $mail->Subject = $subject;
			    $mail->Body    = $body;
			    $mail->AltBody = strip_tags($body);

			    $mail->send();

			    return true;
			} catch (Exception $e) {
			    return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
			}
		}
	}