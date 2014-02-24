(function( $, undefined ) {
	var slides =
	<?php
		echo json_encode( array_splice( scandir('./slides'), 0, 2 ) ).";";
	?>

	$.mobile.document.on( "swipeleft swiperight", function( event ){
			var direction = ( event.type === "swiperight" ) ? "prev": "next",
				reverse = ( event.type === "swiperight" ),
				next = $( "body" ).find( ".ui-page-active" )[ direction ]( "[data-role='page']" );
			if( next.length > 0 ) {
				$( "body" ).pagecontainer( "change", next, {
					reverse: reverse
				});
			}
	});
	$.mobile.document.on( "pagecreate", function(){
		$.mobile.document.one( "pagebeforeshow", function( event, toPage ){
			window.setTimeout( function(){
				var contentHeight = window.innerHeight - 88;

				$( ".ui-content", event.target ).height( contentHeight - 32 );
				$( event.target ).find( ".preso-image-auto" ).each( function(){
					var limiter, bigger, clone, ratio, height,
						otherHeight = 0,
						parent = $( this ).parent();

					$( $( this ).parents( ".preso-image-wedge" ).get().reverse() ).each(function(){
						$( this ).height( $( this ).parent().height() );
					});

					limiter = ( parent.width() < parent.innerHeight() )? "width": "innerHeight";
					bigger = ( parent.width() > parent.innerHeight() )? "width": "innerHeight";
					clone = $( this ).clone();
					clone.removeAttr( "class" ).addClass( "preso-image-clone" );
					$( "body" ).append( clone );
					ratio = 1 - Math.round( ( clone[limiter]() / clone[bigger]() ) * 100 ) / 100;
					otherHeight = 0;

					$( this ).closest( ".ui-content" ).children().not( this ).not( $( this ).parents() ).each(function(){
						otherHeight = $( this ).outerHeight( true ) + otherHeight;
					});
					otherHeight = otherHeight + 20;
					if( parent.hasClass( "ui-content" ) ) {
						otherHeight = otherHeight + 32;
					}

					if( $( this ).hasClass( "preso-image-auto-ignoreother" ) ) {
						height = $( this ).closest( ".ui-content" ).height() - otherHeight;
					} else {
						height = ( parent[limiter]() - otherHeight );
					}

					$( this )[limiter]( height );
					$( this )[bigger]( height + height * ratio );
					clone.remove();
					$( this ).parents( ".preso-image-wedge" ).each(function(){
						$( this ).removeAttr( "style" );
					});
				});
			}, 0);
		});
	});
	$.mobile.document.on( "pageshow", function( event ){
		var id = $( event.target ).attr( "id" );

		$( "a" ).removeClass( "ui-btn-active" );
		$( "body" ).find( "a[href='#" + id + "']").addClass( "ui-btn-active" );
		$( ".syntaxhighlighter" ).addClass( "ui-corner-all" ).parent().css("margin-bottom","44px");
	});
	$.mobile.document.on( "pagecreate", function(){
		$( ".preso-inset-list" ).listview({
			"inset": true
		});
	});
	$.mobile.document.on( "panelbeforeopen", function(){
		$( ".ui-panel, .ui-panel-inner" ).height( window.innerHeight - 32 );
	});
	$.mobile.document.on( "panelopen", function(){
		var index = $( ".ui-panel-inner" ).find( ".ui-btn-active" ).parent().index(),
			top = ( index / $( ".ui-panel-inner" ).find( ".ui-btn" ).length > .5 )? true: false,
			direction = ( !top )? "next": "prev";

			console.log( top );
		$( ".ui-panel-inner" ).find( ".ui-btn-active" ).parent()[direction]()[direction]()[ 0 ].scrollIntoView( top );
	});
})( jQuery );