<body>
	<?php
		require( "min/htmlmin.php" );
		echo Minify_HTML::minify( file_get_contents(  "header.html" ) );
		if( $master ) {
			echo Minify_HTML::minify( file_get_contents(  "popup.html" ) );
		}
		$files = scandir('./slides');
		foreach( $files as $file ){
			if( $file !== "." && $file !== ".." ) {
				$index = intVal( substr( $file, 0, 2 ) );
				$filesSorted[ $index ] = $file;
			}
		}
		ksort($filesSorted);
		$panel =  "<div class='preso-panel' id='slide-list'>";
		$panel .= "<ol class='preso-panel-list ui-mini ui-listview'>";
		$panel .= "<li class='ui-li-divider ui-bar-inherit ui-first-child'>Table of Contents</li>";

		$length = count( $filesSorted );
		$count = 0;
		$slides = "";
		foreach($filesSorted as $file){
			if( $file !== "." && $file !== ".." ) {
				$slides .= file_get_contents( "./slides/".$file );
				$count++;
				if( $count !== $length ){
					$panel .= "<li>";
				} else {
					$panel .= "<li class='ui-last-child'>";
				}
				$panel .= "<a class='ui-btn ui-btn-icon-right ui-icon-carat-r' href='#".preg_replace( "/\.html/", "", $file )."'>".ucwords( preg_replace( "/-/", " ", preg_replace('/\.html|^([0-9])*/', '', $file ) ) )."</a>";
				$panel .= "</li>";
			}
		}
		echo Minify_HTML::minify( $slides );
		$panel .= "</ol>";
		$panel .= "</div>";
		echo Minify_HTML::minify( $panel );
		echo Minify_HTML::minify( file_get_contents( "footer.php" ) );
	?>
</body>
</html>