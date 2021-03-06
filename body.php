<body>
	<?php
		require( $_SERVER[ 'DOCUMENT_ROOT' ]."/min/htmlmin.php" );
		echo Minify_HTML::minify( file_get_contents(  $_SERVER[ 'DOCUMENT_ROOT' ]."/header.html" ) );
		if( isset( $master ) ) {
			echo Minify_HTML::minify( file_get_contents(  $_SERVER[ 'DOCUMENT_ROOT' ]."/popup.html" ) );
		}
		$files = scandir('./');
		$subfilesSorted;
		foreach( $files as $file ){
			if( $file !== "." && $file !== ".." && !is_dir( $file ) && preg_match("/\.html/", $file) ) {
				$index = intVal( substr( $file, 0, 2 ) );
				$filesSorted[ $index ] = $file;
			}
		}

		ksort( $filesSorted );
		$panel =  "<div class='preso-panel' id='slide-list'>";
		$panel .= "<ol class='preso-panel-list ui-mini ui-listview'>";
		$panel .= "<li class='ui-li-divider ui-bar-inherit ui-first-child'>Table of Contents</li>";

		$length = count( $filesSorted );
		$count = 0;
		$slides = "";
		$folder = "";
		$perf = false;
		foreach($filesSorted as $file){
			if( $file !== "." && $file !== ".." ) {
				$slides .= file_get_contents( $file );
				$count++;
				$match = preg_match( "`(.)*/`", $file, $matches );
				if( $match && $matches[0] !== $folder ){
					$folder = $matches[0];
					$panel .= "<li class='ui-li-divider ui-bar-a'><h1>".preg_replace( "/jquery/","jQuery", preg_replace( "`-|/`", " ",$folder) )."</h1></li>";
				} else if ( !$match && !$perf ) {
					$perf = true;
					$panel .= "<li class='ui-li-divider ui-bar-a'><h1>Mobile Performance</h1></li>";
				}
				if( $count !== $length ){
					$panel .= "<li>";
				} else {
					$panel .= "<li class='ui-last-child'>";
				}
				$panel .= "<a class='ui-btn ui-btn-icon-right ui-icon-carat-r' href='#".preg_replace( "`(.)*/`", "", preg_replace( "/\.html/", "", $file ) )."'>".ucwords( preg_replace( "/^([0-9])*/", "", preg_replace( "`^(.)*/`", " ", preg_replace("`/(.)*/`", "", preg_replace( "/-/", " ", preg_replace('/\.html|^([0-9])*/', '', $file ) ) ) ) ) )."</a>";
				$panel .= "</li>";
			}
		}
		echo Minify_HTML::minify( $slides );
		$panel .= "</ol>";
		$panel .= "</div>";
		echo Minify_HTML::minify( $panel );
		echo Minify_HTML::minify( file_get_contents( $_SERVER[ 'DOCUMENT_ROOT' ]."/footer.php" ) );
	?>
</body>
</html>