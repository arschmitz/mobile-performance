<!DOCTYPE html>
<html lang="en" xml:lang="en" xmlns= "http://www.w3.org/1999/xhtml">
<head>
	<title>jQuery Mobile: Optimizing Performance</title>
	<meta charset="utf-8">
	<meta http-equiv="Content-Language" content="en" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
		<script src="http://localhost:420/socket.io/socket.io.js"></script>

	<?php
		ini_set ( short_open_tag , false );
		echo "<style>";
		$files = scandir('./css');
		foreach($files as $file){
			if( $file !== "." && $file !== ".." && preg_match('/\./', $file ) && $file !== ".DS_Store" && $file !== "ajax-loader.gif" ) {
				include( "./css/".$file );
			}
		}
		echo "</style>";

		$files = scandir('./scripts');
		echo "<script>";
		foreach($files as $file){
			if( $file !== "." && $file !== ".." ) {
				include( "./scripts/".$file );
				echo "\n";
			}
		}
		echo "</script>";
	?>
	<script>
	var socket;
	$.mobile.document.one('pagechange', function ( event, data ) {
		socket = io.connect('http://localhost:420');
		socket.on('connected', function (data) {
			console.log( "connected ");
			$( ".preso-master-popup").popup( "open" );
		});
		$.mobile.document.on('pagechange', function ( event, data ) {
			socket.emit('changeslide', { page: data.toPage.attr( "id" ) });
		});
	});
	$.mobile.document.on( "click", ".preso-master-submit-button",function( event ){
		var data = {};
		console.log( "submitting" );
		data.masterKey = $( "#masterKey" ).val();
		socket.emit( "masterconnect", data );
		socket.on( "masterconnect", function( data ){
			console.log( data.status );
		});
	});
	</script>
</head>
<body>
	<?php
		include( "header.html" );
		include( "popup.html" );
		$files = scandir('./slides');
		foreach( $files as $file ){
			if( $file !== "." && $file !== ".." ) {
				$index = intVal( substr( $file, 0, 2 ) );
				$filesSorted[ $index ] = $file;
			}
		}
		ksort($filesSorted);
		$panel =  "<div class='preso-panel' id='slide-list'>";
		$panel .= "<ol class='preso-panel-list ui-mini'>";
		$panel .= "<li data-role='list-divider'>Table of Contents</li>";

		foreach($filesSorted as $file){
			if( $file !== "." && $file !== ".." ) {
				include( "./slides/".$file );
				$panel .= "<li>";
				$panel .= "<a href='#".preg_replace( "/\.html/", "", $file )."'>".ucwords( preg_replace( "/-/", " ", preg_replace('/\.html|^([0-9])*/', '', $file ) ) )."</a>";
				$panel .= "</li>";
			}
		}

		$panel .= "</ol>";
		$panel .= "</div>";
		echo $panel;
		require( "footer.php" );
	?>