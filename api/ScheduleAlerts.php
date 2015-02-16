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
		$optional_mail_to_name      = !empty($_POST['optional_mail_to_name'])      ? $_POST['optional_mail_to_name']      : Config::$config['MAIL']['MAIL_TO_NAME'];
		$optional_mail_mandrill_key = !empty($_POST['optional_mail_mandrill_key']) ? $_POST['optional_mail_mandrill_key'] : Config::$config['MAIL']['MAIL_MANDRILL_KEY'];

		$content  = "";

		$content .= "<html>";
			$content .= "<head>";
				$content .= "<meta charset=\"UTF-8\">";
			$content .= "</head>";
			$content .= "<body>";
				$content .= "<h1>".$optional_mail_title."</h1>";
				$content .= "<h2>".date('d/m/Y - H:i:s')."</h2>";
				foreach ($array_alerts as $key => $value) {
					$content .= "<h3>".$key."</h3>";
					$content .= "<p>".$value."</p>";
					$content .= "<hr>";
				}
			$content .= "</body>";
		$content .= "</html>";

		try {

			$mandrill = new Mandrill($optional_mail_mandrill_key);
			$message  = array(
    					'html' 		 => $content,
    					'subject' 	 => $optional_mail_subject,
    					'from_email' => $optional_mail_to,
    					'from_name'  => $optional_mail_to_name,
    					'headers' 	 => array('Reply-To' => $optional_mail_to),
    					'to' 		 => array(
									 	   array(
									            'email' => $optional_mail_to,
									            'name' 	=> $optional_mail_to_name,
									            'type' 	=> 'to'
									            )
    										)
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
	}//sendMail

}//ScheduleAlert

?>