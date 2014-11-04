<?php

namespace Boofi;

class Util
{
	public static function debug($a)
	{
		if(Config::debug)
		{
			echo $a;
		}
	}
}