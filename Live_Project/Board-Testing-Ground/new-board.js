$( document ).ready( function() {

	var rank = new Array("a","b","c","d","e","f","g","h");
	var file = new Array(1, 2, 3, 4, 5, 6, 7, 8);
    
    var defaultFEN = "rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w KQkq - 0 1";
    
	
    /* 
        Decided to move to ASCII characters instead of images. 
        Images are just too costly to work with for this situation.
	*/
    var pieces = new Array();
	pieces["P"] = "&#9817";
	pieces["R"] = "&#9814";
	pieces["N"] = "&#9816";
	pieces["B"] = "&#9815";
	pieces["K"] = "&#9812";
	pieces["Q"] = "&#9813";
	pieces["p"] = "&#9823";
	pieces["r"] = "&#9820";
	pieces["n"] = "&#9822";
	pieces["b"] = "&#9821";
	pieces["k"] = "&#9818";
	pieces["q"] = "&#9819";
	pieces[" "] = "";

    
    // Reads in a FEN string, parses.
	function readFEN( fen ) {

		fen = fen.replace( /\//g , "" );
		fen = fen.replace( /1/g , " " );
		fen = fen.replace( /2/g , "  " );
		fen = fen.replace( /3/g , "   " );
		fen = fen.replace( /4/g , "    " );
		fen = fen.replace( /5/g , "     " );
		fen = fen.replace( /6/g , "      " );
		fen = fen.replace( /7/g , "       " );
		fen = fen.replace( /8/g , "        " 	);

		var key;
		for( var i = 7 ; i >= 0 ; i-- ) {
			for( var j = 0 ; j <= 7 ; j++){
				key = fen[ (7-i)*8+j ];
				$( "#" + rank[ j ] + file[ i ] ).html( pieces[ key ] );
			}
		}
	}

	
    /* 
        Now we draw our board using a little odd/even math.
    */
	for( var i = 7 ; i >= 0 ; i-- ) {
		for( var j=0 ; j <= 7 ; j++ ) {
		 	bgcolor = ( ( i + j ) % 2 == 0 ) ? "darksquare" : "lightsquare";
		$( "#board" ).append( "<div class=\"square piece target " + bgcolor + "\" id=\"" + rank[ j ] + file[ i ] + "\"></div>" );
		}
	}
    
	/* 
        Now we want to read in our FEN string and display it.
        
        This is the next step, making moves, checking legality, turns, etc....
    */ 
	readFEN( defaultFEN );


	/*
        JQUERY UI THINGS
    
        This code will allow for pieces to be draggable and droppable using jQui's functions  
    */
    var dragging = false;	
	var draggingsource = false;

    
    /*
        This creates our dropper object
    */
	$( "#board" ).after( "<div id=\"dropper\" class=\"piece\"></div>" );
	$( "#dropper" ).offset( { top: $( "#a8" ).offset().top, left: $( "#a8" ).offset().left } );

    
	$( "#dropper" ).draggable( {

		start: function( event , ui ) {
			dragging = $( "#" + draggingsource ).attr( "id" );
			$( "#" + draggingsource ).text( "" );
		},
		stop: function( event , ui ) {
			if( dragging ) {
				$( "#dropper" ).offset( { top: $( "#" + draggingsource ).offset().top, left: $( "#" + draggingsource ).offset().left } );
				$( "#" + draggingsource ).text( $( "#dropper" ).text() );
				dragging = false;
			}
		}
	} );

    /*
        This drop will need to be changed to allow move take-backs. Once a piece is dropped on another, 
        The "bottom" piece is over-written by the moved piece and is off into the ether.
    */
	$( ".target" ).droppable( {
		drop: function( event , ui ) {
			
            if( dragging != $( this ).attr( "id" ) ) {
			
                $( "#dropper" ).offset( { top: $( this ).offset().top, left: $( this ).offset().left } );
				$( this ).text( $( "#dropper" ).text() );
				
                draggingsource = $( this ).attr( "id" );
				
                dragging = false;
			}
		}
	} );

	$( ".square" ).mouseenter( function() {
		if( !dragging && $( this ).text() != "" ) {
			draggingsource = $( this ).attr( "id" );
			$( "#dropper" ).text( $( this ).text() );
			$( "#dropper" ).offset( { top: $( this ).offset().top, left: $( this ).offset().left } );
			$( "#dropper" ).css( "z-index" , "1" );
		}
	} );

	$( "#dropper" ).mousedown( function() {
		$( this ).css( "cursor", "move" );
	} ).mouseup( function() {
		$( this ).css( "cursor" , "pointer" );
	} );

} );