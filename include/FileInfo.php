<?php
namespace Boofi;

class FileInfo
{
	private static $_mime;
	private static $_mimeType;
	public static function init()
	{
		FileInfo::$_mime = new \finfo(FILEINFO_MIME);
		FileInfo::$_mimeType = new \finfo(FILEINFO_MIME_TYPE);
	}
	public static function mime($file)
	{
		return FileInfo::$_mime->file($file->path);
	}

	public static function mimeType($file)
	{
		return FileInfo::$_mimeType->file($file->path);
	}
}
FileInfo::init();