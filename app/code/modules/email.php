<?php
/**
* Project: SimplePHP Framework
*
* @copyright Alphacode  www.alphacode.com.br
* @author Rafael Franco <simplephp@alphacode.com.br>
*/

/**
* email module
*
* @package email
* @author Rafael Franco
**/
include_once("class.smtp.php");
include_once("class.phpmailer.php");

class email{

	public $smtp_host;
	public $smtp_username;
	public $smtp_password;

	public function __construct() {
		$this->smtp_host = 'smtp.mandrillapp.com';
		$this->smtp_username = 'rafaelfranco@me.com';
		$this->smtp_password = '-Q38_6lflM4oKcwMrXh3fg';
		$this->smtp_port = 587;
	}
	/**
	* send emails email
	* @param <string> $contents
	* @param <int> $get_attributes
	* @return <array >
	*/
	public function send( $email, $fromEmail, $subject, $html, $keys = array(), $fromName = '', $debug = false, $attachments = array() ){

		$enableDebug = ($debug === false) ? 0 : 1;

		$mail = new PHPMailer();
		$mail->IsSMTP(); // telling the class to use SMTP
		$mail->CharSet = 'UTF-8';
		$mail->Host = $this->smtp_host; // SMTP server
		$mail->SMTPDebug = $enableDebug; // enables SMTP debug information (for testing)
		$mail->SMTPAuth = true; // enable SMTP authentication
		$mail->Port = $this->smtp_port; // set the SMTP port for the service server
		$mail->Username = $this->smtp_username; // account username
		$mail->Password = $this->smtp_password; // account password

		if(isset($attachments)){
			if(!empty($attachments)){
				if(is_array($attachments)){
					foreach ($attachments as $attachment) {
						$mail->addAttachment($attachment, $attachment['name']);
					}
				} else {
					$mail->addAttachment($attachments, $attachments['name']);
				}
			}
		}

		if($fromName == '') {
			$fromName = $fromEmail;
		}

		$mail->SetFrom($fromEmail, $fromName);

		$mail->Subject = utf8_decode($subject);

		$html = $this->applyKeys($html, $keys);

		$mail->MsgHTML($html);
		$mail->AddAddress($email);
		return ( $mail->Send() ) ? true : false;
	}

	/**
	* applyKeys function
	* Apply keys to template
	* @param <string> $html
	* @param  <array> $keys
	* @return <string> $html
	*/
	private function applyKeys($html, $keys) {
		for ($x = 1; $x < 6; $x++) {
			foreach ($keys as $key => $value) {
				$html = str_replace("[#$key#]", $value, $html);
			}
		}
		return $html;
	}
}
?>
