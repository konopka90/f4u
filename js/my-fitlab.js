$(document).ready(function() { 
	
	
	$(".my-diet-header-clickable").click(function() { 
		var glyph = $(this).children().first();
		glyph.toggleClass( "glyphicon-minus" );
		glyph.toggleClass( "glyphicon-plus" );
		
		var body = $(this).next();
		body.toggleClass( "hidden" );
		body.toggleClass( "show" );
	});

});
