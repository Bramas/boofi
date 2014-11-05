<?php

namespace Boofi;

class Util
{
	public static function debug($a)
	{
		if(Config::debug)
		{
			if($a instanceof Dir)
			{
				Util::debug(array(
					'name'=>$a->name,
					'path' => $a->path,
					'url' => $a->url));
				return;
			}
			print_r($a);
			echo '<br/>';
		}
	}
}