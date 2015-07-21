<?php

namespace Boofi;

class Dispatcher
{
	public function run($url)
	{
		if(!defined('CONFIG_EXISTS'))
		{
			ob_start();
			include('include/install.php');	
			return ob_get_clean();
		}
		$originalUrl = $url;
		if(substr($url, -1) === '/')
		{
			$url = substr($url, 0, strlen($url) - 1);
		}
		$alias = false;
		foreach(Config::folders() as $key => $aliasPath)
		{
			if(substr($url.'/', 0, strlen($key)+1) === $key.'/')
			{
				$alias = $key;
				$path = $aliasPath;
				break;
			}
		}
		$path = $path.substr($url, strlen($alias));

		Authenticator::setFolder($alias);
		Authenticator::setPath($path);
		$path = Authenticator::getAuthorizedPath($path);
		if($path === false)
		{
			ob_start();
			include('include/Views/login.ctp');	
			return ob_get_clean();
		}
		if($url === "")
		{
			ob_start();
			echo '<ul>';
			foreach(Config::folders() as $key => $aliasPath)
			{
				echo '<li><a href="?'.$key.'">'.$key.'</a></li>';
			}
			echo '</ul>';
			return ob_get_clean();
		}
		if($alias === false)
		{
			Util::debug('Dispatcher::run - '.$url.' does not start with '.$key);
			exit();
		}

		if(!file_exists($path) || substr($path,-3) === "php")
		{
			Util::debug('Dispatcher::run - Wrong path: '.$path);
			exit('not found');
		}
		if(!empty($_POST['share']))
		{
			if($_SESSION['token'] !== $_POST['token'])
			{
				Util::debug('Dispatcher::run - Wrong token');
				exit();
			}
			$time = (time()+3600*24*2);
			echo "http://".$_SERVER['HTTP_HOST'].str_replace("index.php","",$_SERVER['PHP_SELF']).'?'.$originalUrl.'/'.$time.'$'.substr(password_hash($time."/".$path, PASSWORD_DEFAULT, ['salt' => PRIVATE_KEY, 'cost' => 12]), 7).'.boofi';
			exit();
		}
		if(!empty($_POST['logout']))
		{
			if($_SESSION['token'] !== $_POST['token'])
			{
				Util::debug('Dispatcher::run - Wrong token');
				exit();
			}
			$_SESSION['login'] = '';
			$_SESSION['token'] = '';
			$_SESSION['code'] = '';
			header('Location: index.php');
			exit();
		}

		if(!is_dir($path))
		{
			if(strstr($_SERVER["SERVER_SOFTWARE"], 'nginx'))
			{
				NginxSendFile::send($path);
			}
			else
			{
				SendFile::send($path);
			}
			exit();
		}
		Dir::setCurrent($path, $url);
	
		ob_start();
		Dir::current()->files();	
		return ob_get_clean();
	}
}