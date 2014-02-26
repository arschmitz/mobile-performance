var socket = io.connect("<?php echo SOCKETPATH; ?>"),
	currentSlide;

socket.on( "connected", function( data ){
	if( data.page !== undefined ) {
		currentSlide = "#" + data.page;
	}
});
socket.on( 'changeslide', function( data ){
	currentSlide = "#" + data.page;
	if( $( "#follow" ).is(":checked") ){
		$.mobile.changePage( currentSlide );
	}
});
$.mobile.document.on( "change", "#follow", function(){
	if( $( this ).is( ":checked" ) && currentSlide !== undefined ){
		$.mobile.changePage( currentSlide, {} );
	}
});