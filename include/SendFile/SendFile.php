<?php

namespace Boofi;

class SendFile 
{
	public static function send($absolutePath)
	{
		if (!file_exists($absolutePath)) trigger_error("File '$file' doesn't exist.", E_USER_ERROR);
 
		header("Content-type: application/octet-stream");
		header('Content-Disposition: attachment; filename="' . basename($absolutePath) . '"');
		header("Content-Length: ". filesize($absolutePath));
		readfile($absolutePath);
	} 
}