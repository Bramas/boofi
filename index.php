<?php

require_once('include/bootstrap.php');
$dispatcher = new \Boofi\Dispatcher();
$content = $dispatcher->run(urldecode($_SERVER['QUERY_STRING']));

?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="icon" href="favicon.ico">

	<title>Boofi Manager</title>

	<!-- Bootstrap core CSS -->
	<link href="assets/css/bootstrap.min.css" rel="stylesheet">

	<!-- Custom styles for this template
	<link href="assets/css/cover.css" rel="stylesheet"> -->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
	<div class="container">
		<div class="btn-group">
		 	<button type="button" class="btn btn-default" disabled="disabled">Dossier:</button>
			<?php
			$dir = \Boofi\Dir::current();
			$folderList = array();
			while($dir)
			{
				$folderList[] = '<a href="?'.$dir->url.'" '.($dir == \Boofi\Dir::current()?'disabled="disabled"':'').' type="button" class="btn btn-default">'.$dir->name.'</a>';
				$dir = $dir->parent();
			}
			$folderList = array_reverse($folderList);
			echo implode("\n", $folderList);
			?>
		</div>
		<table class="table table-striped">
			<tbody>
				<?php
				echo $content;
				?>
				</tbody>
			</table>
		</div>
	</div>
</body>
</html>