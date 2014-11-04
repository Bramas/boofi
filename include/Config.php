<?php

namespace Boofi;

class Config
{
	const debug = 2;

	private static $_folders = array();

	public static function folders()
	{
		return Config::$_folders;
	}
	public static function addFolder($alias, $absolutePath)
	{
		str_replace('\\', '/', $absolutePath);
		str_replace('//', '/', $absolutePath);
		while(substr($absolutePath,-1,1) == '/')
		{
			$absolutePath = substr($absolutePath, 0, strlen($absolutePath));
		}
		Config::$_folders[$alias] = $absolutePath;
	}
	public static function addFolders($folders)
	{
		foreach($folders as $alias => $folder)
		{
			Config::addFolder($alias, $folder);
		}
	}
}