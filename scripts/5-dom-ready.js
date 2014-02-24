$.mobile.document.one( "pagecreate", function(){
	$( ".preso-header, .preso-footer" ).toolbar({
		position: "fixed",
		tapToggle: false,
		theme: "a",
		role: "header"
	});
	$( ".preso-panel" ).panel({
		display: "overlay",
		//position: "fixed",
		theme: "b"
	});
	$( ".preso-panel-list" ).listview();
	$( ".preso-header-group" ).controlgroup({
		enhanced: true,
		type: "horizontal"
	});
	$( ".preso-back-button" ).on( "click", function(){
		var prev = $( "body" ).find( ".ui-page-active" ).prev( "[data-role='page']" );
		if( prev.length > 0 ) {
			$( "body" ).pagecontainer( "change", prev, {
				reverse: true
			});
		}
	});
	$( ".preso-forward-button" ).on( "click", function(){
		var next = $( "body" ).find( ".ui-page-active" ).next( "[data-role='page']" );
		if( next.length > 0 ) {
			$( "body" ).pagecontainer( "change", next );
		}
	});
	$( "#checkbox-enhanced" ).checkboxradio({
		enhanced: true
	});
	$( ".preso-master-popup").popup({ theme: "a"});
	$( ".preso-master-popup-header" ).toolbar({ theme: "b" });
});
$(function(){
	SyntaxHighlighter.all();
});