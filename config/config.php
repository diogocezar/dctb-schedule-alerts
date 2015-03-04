<?php

	/**
	* 	Config
	* 	Class to centralize all configurations of project
	* 	Author: Diogo Cezar Teixeira Batista
	*	Year: 2014 
	*/

	class Config{
		public static $messages = array(
									   'MAIL' => array(
													   'MAIL_SUCCESS' => 'Email has been sent successfully.',
													   'MAIL_FAIL'	  => 'Sorry, the email can not be sent.'
												 )
									   );
		public static $config   = array(
									   'MAIL' => array(
													   'MAIL_MANDRILL_KEY' 	=> '',
													   'MAIL_TO'			=> '',
													   'MAIL_TO_NAME'		=> '',
													   'MAIL_TITLE'			=> 'Daily Aelert',
													   'MAIL_SUBJECT'		=> 'Daily Aelert'
												 )
									    );
	}
?>