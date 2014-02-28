<?php
$files = scandir('../scripts');
$scripts = "";
require( '../min/jsmin.php' );
foreach($files as $file){
	if( $file !== "." && $file !== ".." && $file != "master.js" && $file != "slave.js" && $file !== ".DS_Store" && $file != "index.php" ) {
		 $scripts .= file_get_contents($file);
		 $scripts .= "\n";
	}
}
echo JSMin::minify( $scripts );
?>
