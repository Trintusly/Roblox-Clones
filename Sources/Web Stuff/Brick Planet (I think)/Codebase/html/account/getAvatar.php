<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../private/config.php");

	requireLogin();
	
	echo ''.$cdnName.''.$myU->AvatarURL.'';