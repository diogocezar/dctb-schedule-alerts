#Schedule Alerts#

Schedule Alerts is a system to send alerts mails to remember you that you should do something.

##Technologies##

The system was developed based at:

* PHP 5.x

##Usage##

To use Schedule Alerts, just replace your configurations at _config/config.php_

You also will need to put your alerts in these format:

```
class Data{
	public static $alerts = array(
								   '01' => 	array(
												   	'Subject to Send' => 'Content to Send'
											),
								   '02' => 	array(
												   	'Subject to Send 01' => 'Content to Send',
													'Subject to Send 02' => 'Content to Send',
											)
								);
}
```

At the _data/data.php_  file.

*IMPORTANT*

If you want to run this correctly, please include a cron job that daily invokes the script like:

```
# m h dom mon dow user command
00 14	* * *	root	cd /var/www/dctb-schedule-alerts/ && php mail.php
```