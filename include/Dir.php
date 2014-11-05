<?php

namespace Boofi;

class Dir
{

	private static $_current = false;
	public static function setCurrent($path, $url)
	{
		Dir::$_current = new Dir($path, $url);
	}

	private function __construct($path, $url)
	{
		if(substr($path, -1) !== '/')
		{
			$path .= '/';
		}
		$this->path = $path;
		$this->url = $url;
		$this->name = basename($path);
	}

	public static function current()
	{
		return Dir::$_current;
	}


	public $path;
	public $url;
	public $name;

	public function parent()
	{
		if(strpos($this->url, '/') === false)
		{
			return false;
		}
		$pathParent = explode('/', $this->path);
		array_pop($pathParent);
		array_pop($pathParent);
		$pathParent = implode('/', $pathParent);

		$urlParent = $this->url;
		if(substr($urlParent, -1) !== '/')
		{
			$urlParent = substr($urlParent, 0, strlen($urlParent) - 1) ;
		}
		$urlParent = explode('/', $urlParent);
		array_pop($urlParent);
		$urlParent = implode('/', $urlParent);
		return new Dir($pathParent, $urlParent);
	}

	public function files()
	{
		if ($handle = opendir($this->path)) {
			$id = 1;
			$dirs = array();
			$files = array();
			while (false !== ($entry = readdir($handle))) {
				if ($entry != "." && $entry != "..") {
					$file = new File($this->path, $entry, $this->url);

					if(!$file->isHidden)
					{
						if($file->isDir)
						{
							$dirs[] = $file;
						}
						else
						{
							$files[] = $file;
						}
					}
				}
			}
			foreach($dirs as $file)
			{
				include('include/Views/file.ctp');
			}
			foreach($files as $file)
			{
				include('include/Views/file.ctp');
			}
			closedir($handle);
		}
	}
}