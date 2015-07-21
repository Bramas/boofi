<?php

namespace Boofi;

class File
{
	public $isDir = false;
	public $size = 0;
	public $name = "test";
	public $path = ".";
	public $url = "";
	public $isHidden = false;

	public $filemtime = '';

	public function __construct($path, $name, $url)
	{
		$this->url = urlencode($url.'/'.$name);
		$this->path = $path;
		$this->name = $name;
		$this->isDir = is_dir($path.$name);
		$this->filemtime = date("Y-m-d H:i:s",filemtime($path.$name));
		if(!$this->isDir)
		{
			$this->size = File::human_filesize(intval(filesize($path.$name)), 0);
		}
		else
		{
			$this->size = "";
		}

		$this->isHidden = (substr($name,0,1) == '.');
	}

	static function human_filesize($bytes, $decimals = 2) {
		$sz = array('o', 'Ko', 'Mo', 'Go', 'To', 'Po');
		$factor = floor((strlen($bytes) - 1) / 3);
		return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
	}
}