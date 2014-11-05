<?php

namespace Boofi;

class Dispatcher
{
	public function run($url)
	{
		if(substr($url, -1) === '/')
		{
			$url = substr($url, 0, strlen($url) - 1);
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
		$alias = false;
		foreach(Config::folders() as $key => $aliasPath)
		{
			if(substr($url.'/', 0, strlen($key)+1) === $key.'/')
			{
				$alias = $key;
				$path = $aliasPath;
			}
		}
		if($alias === false)
		{
			Util::debug('Dispatcher::run - '.$url.' does not start with '.$key);
			exit();
		}
		$path = $path.substr($url, strlen($alias));
		if(!file_exists($path) || substr($path,-3) === "php")
		{
			Util::debug('Dispatcher::run - Wrong path: '.$path);
			exit('not found');
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