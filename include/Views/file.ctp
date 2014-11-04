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
<td><span class="file-name"><?php echo $file->name; ?></span>
<span class="file-size"><?php echo $file->size; ?></span></td>
</tr>