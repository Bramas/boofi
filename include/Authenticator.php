<?php

namespace Boofi;

class Authenticator
{

	private static $_users = array();
	private static $_loggedUser = array();
	private static $_folder = "";
	private static $_path = "";



	public static function addUser($login, $password)
	{
		Authenticator::$_users[$login] = array('name' => $login, 'password' => $password);
	}

	public static function loggedUser()
	{
		if(empty(Authenticator::$_loggedUser) && !empty($_SESSION['login']) && !empty($_SESSION['code']))
		{
			$login = $_SESSION['login'];
			if(!empty(Authenticator::$_users[$login]))
			{
				$pass = Authenticator::$_users[$login]['password'];
				$code = $_SESSION['code'];
				if($code === md5($login.$pass))
				{
					Authenticator::$_loggedUser = htmlentities($login);
				}
			}
		}
		if(empty(Authenticator::$_loggedUser) && !empty($_POST['password']) && !empty($_POST['login']))
		{
			$login = $_POST['login'];
			$pass = password_hash($_POST['password'], PASSWORD_DEFAULT, ['salt' => PRIVATE_KEY, 'cost' => 12]);
			if(!empty(Authenticator::$_users[$login]) && Authenticator::$_users[$login]['password'] === $pass)
			{
				Authenticator::$_loggedUser = htmlentities($login);
				$_SESSION['login'] = $login;
				$_SESSION['code']  = md5($login.$pass);
				$_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(64));
			}
			else
			{
				echo $pass;
			}

		}
		return Authenticator::$_loggedUser;
	}

	private static function getBoofiSharedPath($path)
	{
		if(!preg_match('/^.*\/\d+\$[^\$]+\.boofi$/', $path))
		{
			return false;
		}
		$filePath = preg_replace ('/^(.*)\/\d+\$[^\$]+\.boofi$/', '$1', $path);
		$code = '$2y$12$'.preg_replace ('/.*\/\d+\$([^\$]+)\.boofi$/', '$1', $path);
		$time = preg_replace ('/.*\/(\d+)\$[^\$]+\.boofi$/', '$1', $path);
		if(intval($time) < time())
		{
			Util::debug('Authenticator - Your link is not available anymore');
			return false;
		}
		if($code === password_hash($time."/".($filePath), PASSWORD_DEFAULT, ['salt' => PRIVATE_KEY, 'cost' => 12]))
		{
			return $filePath;
		} 
		
		Util::debug('Authenticator - Wrong key');
		return false;

	}
	public static function getAuthorizedPath($path)
	{
		$user = Authenticator::loggedUser();
		if(empty($user))
		{
			return Authenticator::getBoofiSharedPath($path);
		}
		return $path;
	}
	public static function setFolder($folder)
	{
		Authenticator::$_folder = $folder;
	}
	public static function setPath($path)
	{
		Authenticator::$_path = $path;
	}
}