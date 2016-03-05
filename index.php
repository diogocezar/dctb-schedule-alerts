<?php
	require_once './api/vendor/autoload.php';
	require_once './api/ScheduleAlerts.php';
	require_once './config/config.php';
	require_once './data/data.php';
	$sa = new ScheduleAlerts();
	$sa->SendAlerts();
?>