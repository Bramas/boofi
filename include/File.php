<?php

namespace Boofi;

class File
{
	public $isDir = false;
	public $size = 0;
	public $name = "test";
	public $path = ".";
	public $isHidden = false;


	public function __construct($path, $name)
	{
		$this->path = $path;
		$this->name = $name;
		$this->isDir = is_dir($path.$name);
		if(!$this->isDir)
		{
			$this->size = File::human_filesize(intval(filesize($path.$name)/8), 0);
		}
		else
		{
			$this->size = "";
		}

		$this->isHidden = (substr($name,0,1) == '.');
	}

	static function human_filesize($bytes, $decimals = 2) {
		$sz = 'BKMGTP';
		$factor = floor((strlen($bytes) - 1) / 3);
		return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
	}
}