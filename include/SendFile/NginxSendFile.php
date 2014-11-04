<?php

namespace Boofi;

class NginxSendFile
{
	public static function send($absolutePath)
	{
		echo $absolutePath;
		exit();
		if (!file_exists($absolutePath)) trigger_error("File '$file' doesn't exist.", E_USER_ERROR);

 		header('X-Accel-Redirect: '.$absolutePath);
		header("Content-type: application/octet-stream");
		header('Content-Disposition: attachment; filename="' . basename($absolutePath) . '"');
	} 
}