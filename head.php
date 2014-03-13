<!DOCTYPE html>
<html lang="en" xml:lang="en" xmlns= "http://www.w3.org/1999/xhtml">
<head>
	<title>jQuery Mobile: Optimizing Performance</title>
	<meta charset="utf-8">
	<meta http-equiv="Content-Language" content="en" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="<?php echo SOCKETPATH; ?>/socket.io/socket.io.js"></script>

	<?php
		ini_set ( "short_open_tag" , false );
		echo "<style>";
		$files = scandir($_SERVER[ 'DOCUMENT_ROOT' ].'/css');
		$styles = "";
		require( $_SERVER[ 'DOCUMENT_ROOT' ].'/min/cssmin.php' );
		foreach($files as $file){
			if( $file !== "." && $file !== ".." && preg_match('/\./', $file ) && $file !== ".DS_Store" && $file !== "ajax-loader.gif" ) {
				$styles .= file_get_contents( $_SERVER[ 'DOCUMENT_ROOT' ]."/css/".$file );
			}
		}
		echo CssMin::minify( $styles );
		echo "</style>";
		echo "<script src='/scripts/'></script>";
		echo "<script>";
		if( isset( $master ) ){
			include( $_SERVER[ 'DOCUMENT_ROOT' ]."/scripts/master.js" );
		} else {
			include( $_SERVER[ 'DOCUMENT_ROOT' ]."/scripts/slave.js" );
		}
		echo "</script>";
	?>
</head>