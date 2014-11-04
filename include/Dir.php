<?php

namespace Boofi;

class Dir
{
	private $path;
	private $url;

	public function __construct($path, $url)
	{
		if(substr($path, -1) !== '/')
		{
			$path .= '/';
		}
		$this->path = $path;
		$this->url = $url;
	}

	public function files()
	{
		if ($handle = opendir($this->path)) {
			$id = 1;
			while (false !== ($entry = readdir($handle))) {
				if ($entry != "." && $entry != "..") {
					$file = new File($this->path, $entry, $this->url);
					if(!$file->isHidden)
					{
						include('include/Views/file.ctp');
					}
				}
			}
			closedir($handle);
		}
	}
}