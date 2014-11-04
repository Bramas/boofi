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
		$key = current(array_keys(Config::folders()));
		$path = Config::folders()[$key];
		if($url === "")
		{
			$url = $key;
		}
		if(substr($url.'/', 0, strlen($key)+1) !== $key.'/')
		{
			Util::debug('Dispatcher::run - '.$url.' does not start with '.$key.DS);
			exit();
		}
		$path = $path.substr($url, strlen($key));
		if(!file_exists($path) || substr($path,-3) === "php")
		{
			Util::debug('Dispatcher::run - Wrong path: '.$path);
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
		$currentDir = new \Boofi\Dir($path, $url);
		$urlParent = explode('/', $url);
		array_pop($urlParent);
		$urlParent = implode('/', $urlParent);
		ob_start();	
		echo '<a href="?'.$urlParent.'">Dossier Parent</a><br/>';
		$currentDir->files();	
		return ob_get_clean();
	}
}