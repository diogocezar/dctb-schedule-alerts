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
													   'MAIL_TO'		    => array('email@server.com' => 'Name'),
													   'MAIL_TO_NAME'       => '',
													   'MAIL_TITLE'		    => '',
													   'MAIL_SUBJECT'	    => '',
													   'MAIL_FROM'          => ''
												 )
									    );
	}
?>
