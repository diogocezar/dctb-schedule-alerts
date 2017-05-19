<?php
	/**
	* 	ScheduleAlerts
	* 	Class to integrate all componentes of composer and give to literal-object all server-side informations required.
	* 	Author: Diogo Cezar Teixeira Batista
	*	Year: 2014
	*/

class ScheduleAlerts{

	/**
	*	Constructor
	*/
	public function __construct(){
		date_default_timezone_set("America/Sao_paulo");
	}

	/**
	*	Internal Controls
	*/

	/**
	* 	Check if have some information at $_POST
	*/
	private function __check_posts(){
		return (!$_POST) ? true : false;
	}

	/**
	*	Method to trnasforma all posts in rawurldecode
	*/
	private function __to_raw_url(){
		foreach ($_POST as $key => $value) {
			$_POST[$key] = rawurldecode($value);
		}
	}

	/**
	*	Invoke all methods to prepare the main method
	*/
	private function __method_controls(){
		$this->__to_raw_url();
	}

	/**
	* 	Public Controls
	*/

	public function SendAlerts(){
		$alerts = Data::$alerts;
		foreach ($alerts as $key => $value) {
			$today = date('d');
			if($today == $key){
				$this->SendMail($value);
			}
		}
	}

	/**
	* Send an email with Mandrill API
	*/
	public function SendMail($array_alerts){
		$optional_mail_subject      = !empty($_POST['optional_mail_subject'])      ? $_POST['optional_mail_subject']      : Config::$config['MAIL']['MAIL_SUBJECT'];
		$optional_mail_title        = !empty($_POST['optional_mail_title'])        ? $_POST['optional_mail_title']        : Config::$config['MAIL']['MAIL_TITLE'];
		$optional_mail_to           = !empty($_POST['optional_mail_to'])           ? $_POST['optional_mail_to']           : Config::$config['MAIL']['MAIL_TO'];
		$optional_mail_from         = !empty($_POST['optional_mail_from'])         ? $_POST['optional_mail_from']         : Config::$config['MAIL']['MAIL_FROM'];
		$optional_mail_to_name      = !empty($_POST['optional_mail_to_name'])      ? $_POST['optional_mail_to_name']      : Config::$config['MAIL']['MAIL_TO_NAME'];
		$optional_mail_mandrill_key = !empty($_POST['optional_mail_mandrill_key']) ? $_POST['optional_mail_mandrill_key'] : Config::$config['MAIL']['MAIL_MANDRILL_KEY'];
		$optional_mail_sendgrid_key = !empty($_POST['optional_mail_sendgrid_key']) ? $_POST['optional_mail_sendgrid_key'] : Config::$config['MAIL']['MAIL_SENDGRID_KEY'];

		$optional_mail_title = $optional_mail_subject = "🕒 ALERTA DIÁRIO 🕒 [" . date('d/m/Y') . "] ▪ diogocezar.com";

		$content = '<!DOCTYPE html><html lang="pt-br"><head><meta charset="utf-8"/></head><body><table cellspacing="0" cellpadding="0" width="700" align="center" bgcolor="#fff" border="0"><tr><td bgcolor="#000" align="center"><img style="margin-top:20px;margin-bottom:15px;width:200px;height:200px" src="http://www.diogocezar.com/images/logo.jpg"/></td></tr><tr><td align="center" style="padding: 10px 30px"><h3 style="margin-top:40px;font-size:16px;font-family: Verdana, Geneva, sans-serif;color:#000;font-weight:normal;">Olá, este email é um <strong>Lembrete Diário</strong></h3><h4 style="margin-top:20px;font-size:14px;font-family: Verdana, Geneva, sans-serif;color:#000;font-weight:normal;">Lembretes para: <strong>{date}</strong></h4></td></tr><tr><td align="center"><table width="100%" style="padding: 10px 30px; margin-bottom: 40px" cellspacing="0" cellpadding="0"><tr><td width="35%" style="padding: 10px; border-bottom:1px solid #e6e9ea; border-top:1px solid #e6e9ea; border-right:1px solid #e6e9ea; text-align: center; font-size:12px;font-family: Verdana, Geneva, sans-serif;color:#000;font-weight:bold; text-transform: uppercase;">Nome</td><td width="65%" style="padding: 10px; border-bottom:1px solid #e6e9ea; border-top:1px solid #e6e9ea; text-align: center; font-size:12px;font-family: Verdana, Geneva, sans-serif;color:#000;font-weight:bold; text-transform: uppercase;">Instrução</td></tr>{replaces}</table></td></tr><tr><td align="center" bgcolor="#000"><h3 style="font-family: Verdana, Geneva, sans-serif;color:#fff;font-weight:normal; font-size:12px;margin-top:10px;margin-bottom:10px">Esta é uma mensagem automática, por favor não responda.</h3></td></tr></table></body></html>';

		$replaces = "";

		foreach ($array_alerts as $key => $value){
			$replaces .= '<tr>';
			$replaces .= '<td style="padding: 10px; border-right:1px solid #e6e9ea; border-bottom:1px solid #e6e9ea; text-align: center; font-size:12px;font-family: Verdana, Geneva, sans-serif;color:#000;font-weight:normal; text-transform: uppercase;">'.$key.'</td>';
			$replaces .= '<td style="padding: 10px; border-bottom:1px solid #e6e9ea; text-align: center; font-size:12px;font-family: Verdana, Geneva, sans-serif;color:#000;font-weight:normal;">'.$value.'</td>';
			$replaces .= '</tr>';
		}

		$content = str_replace('{title}', $optional_mail_title, $content);
		$content = str_replace('{date}', date('d/m/Y'), $content);
		$content = str_replace('{replaces}', $replaces, $content);

		$emails = $optional_mail_to;
		$type   = Config::$config['MAIL']['MAIL_TYPE'];
		switch($type){
			case 'mandrill' :
				try {
					$mandrill = new Mandrill($optional_mail_mandrill_key);
					foreach ($emails as $key => $value) {
						$list_to_send[] = array('email' => $value, 'type' => 'to');
					}
					$message  = array(
								'html' 		 => $content,
								'subject' 	 => $optional_mail_subject,
								'from_email' => $optional_mail_from,
								'from_name'  => $optional_mail_to_name,
								'headers' 	 => array('Reply-To' => $optional_mail_to),
								'to' 		 => $list_to_send
								);
					$async 	= false;
					$result = $mandrill->messages->send($message, $async);
					if($result[0]['status'] == 'sent'){
						echo Config::$messages['MAIL']['MAIL_SUCCESS'];
					}
				}
				catch(Mandrill_Error $e) {
					echo Config::$messages['MAIL']['MAIL_FAIL'];
				}
			break;
			case 'sendgrid' :
				$sendgrid = new SendGrid($optional_mail_sendgrid_key);
				$mail     = new SendGrid\Email();
				foreach ($emails as $email => $name) {
					$mail->addTo($email);
				}
				$mail->setFrom($optional_mail_from)
					 ->setSubject($optional_mail_subject)
					 ->setHtml($content);
				try {
					$sendgrid->send($mail);
					echo Config::$messages['MAIL']['MAIL_SUCCESS'];
				}
				catch(\SendGrid\Exception $e) {
					echo Config::$messages['MAIL']['MAIL_FAIL'];
				}
			break;
		}
	}//sendMail
}//ScheduleAlert
?>