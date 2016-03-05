<?php

	/**
	* 	Config
	* 	Class to centralize all configurations of project
	* 	Author: Diogo Cezar Teixeira Batista
	*	Year: 2016
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
									   				   'MAIL_TYPE'          => 'sendgrid',
									   				   'MAIL_SENDGRID_KEY'  => '',
													   'MAIL_MANDRILL_KEY' 	=> '',
													   'MAIL_TO'			=> array('email1@server.com' => 'name1', 'email2@server.com' => 'name2' ),
													   'MAIL_TO_NAME'       => 'name1',
													   'MAIL_TITLE'			=> 'Daily Aelert',
													   'MAIL_SUBJECT'		=> 'Daily Aelert',
													   'MAIL_FROM'          => 'email1@server.com'
												 )
									    );
	}
?>