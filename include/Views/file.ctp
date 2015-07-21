<tr>
<td class="file-icon"><?php 

if($file->isDir)
{
	echo '<span class="glyphicon glyphicon-folder-open"></span>';
}
else
{
	echo '<span class="glyphicon glyphicon-file"></span>';
}


?></td>
<td><span class="file-name"><a href="?<?php echo $file->url; ?>"><?php echo $file->name; ?></a></span></td>
<td><span class="file-size"><?php echo $file->size; ?></span></td>
<td><span class="file-size"><?php echo $file->filemtime; ?></span></td>
<td><?php
if(!$file->isDir)
{
	echo '<a data-url="'.$file->url.'" class="action-share">Share</a>';
}
?>
</td>
</tr>
