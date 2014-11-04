<?php

namespace Boofi;

class Dir
{
	private $path;

	public function __construct($path)
	{
		$this->path = $path;
	}

	public function files()
	{
		if ($handle = opendir($this->path)) {
			$id = 1;
			while (false !== ($entry = readdir($handle))) {
				if ($entry != "." && $entry != "..") {
					$file = new File($this->path, $entry);
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