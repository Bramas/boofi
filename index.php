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
	<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
	<script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="assets/js/jquery.tablesorter.min.js"></script>
	

	<!-- Custom styles for this template -->
	<link href="assets/css/cover.css" rel="stylesheet"> 

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
	<div class="container">
		<div class="btn-group">
		 	<a href="?" class="btn btn-default" >Dossiers</a>
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
		<div style="float:right">
			<form method="POST">
				<input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
				<input type="hidden" name="logout" value="1">
				<input type="submit" value="logout" class="btn btn-default" />
			</form>
		</div>
		<table id="files-table" class="table table-striped tablesorter">
			<thead>
			<tr>
				<th></th>
				<th><span class="ascending glyphicon glyphicon-chevron-up"></span><span class="descending glyphicon glyphicon-chevron-down"></span> Name</th>
				<th><span class="ascending glyphicon glyphicon-chevron-up"></span><span class="descending glyphicon glyphicon-chevron-down"></span> Size</th>
				<th><span class="ascending glyphicon glyphicon-chevron-up"></span><span class="descending glyphicon glyphicon-chevron-down"></span> Date</th>
				<th><span class="ascending glyphicon glyphicon-chevron-up"></span><span class="descending glyphicon glyphicon-chevron-down"></span> Action</th>
			</tr>
			</thead>
			<tbody>
				<?php
				echo $content;
				?>
				</tbody>
			</table>
		</div>
	</div>
	<script type="text/javascript">
	$(document).ready(function(){
		$(function(){
			$("#files-table").tablesorter();
		});
	});
	jQuery(function($){

		$('a.action-share').click(function(){
			var url = $(this).attr('data-url');
			$.ajax({
			  method: "POST",
			  url: "index.php?"+url,
			  data: { share: 1, ajax: 1, token: '<?php echo $_SESSION['token']; ?>' }
			})
			  .done(function( msg ) {
			    alert( "Link: " + msg );
			});
		})

	})
</script>
</body>
</html>