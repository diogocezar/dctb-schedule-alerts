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
									   				   'MAIL_SENDGRID_KEY'  => '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',
													   'MAIL_MANDRILL_KEY' 	=> 'RbFB5br4ZITKzG8E65pEPQ',
													   'MAIL_TO'			=> array('xgordo@gmail.com' => 'Diogo Cezar'),
													   'MAIL_TO_NAME'       => 'DCBuster Server',
													   'MAIL_TITLE'			=> 'DCBuster Server - Daily Aelert',
													   'MAIL_SUBJECT'		=> 'DCBuster Server - Daily Aelert',
													   'MAIL_FROM'          => 'xgordo@gmail.com'
												 )
									    );
	}
?>