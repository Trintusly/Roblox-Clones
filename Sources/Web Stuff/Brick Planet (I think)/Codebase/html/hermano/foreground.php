<?php

	//echo 'Hello world!';
	exec("php /var/www/html/root/crons/sendBookmarkNotifications > /dev/null 2>&1 &");