<?php
session_start();

define('DS', DIRECTORY_SEPARATOR);

if(!function_exists('password_hash'))
{
	require_once('include/password_hash_compat.php');
}

require_once('include/Config.php');
require_once('include/Authenticator.php');
require_once('include/File.php');
require_once('include/FileInfo.php');
require_once('include/Dir.php');
require_once('include/Dispatcher.php');
require_once('include/SendFile/SendFile.php');
require_once('include/SendFile/NginxSendFile.php');
if(file_exists('config.php'))
{
	DEFINE('CONFIG_EXISTS', 1);
	require_once('config.php');
}
require_once('Util.php');

?>