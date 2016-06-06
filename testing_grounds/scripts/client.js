/*jslint browser: true*/
/*global $, jQuery, alert*/
$(document).ready(function () {
    "use strict";
    //Getting the canvas from the DOM.
    var canvas = $("canvas")[0],
        ctx = canvas.getContext("2d"),
        boardWidth = $("canvas").width(),
        boardHeight = $("canvas").height(),
    // Value id for piece location in pieces.png. Used for cropping method. 
        PAWN = 0,
        KNIGHT = 1,
        BISHOP = 2,
        ROOK = 3,
        QUEEN = 4,
        KING = 5,
    // Data for drawing
        NUM_ROWS,
        SQR_SIZE = boardHeight / 8,
    // Object declarations
        pieces = null,
        FEN = null; //Forsythe-Edwards Notation (FEN) is a chess board description.

///////////////////////
// STARTUP FUNCTIONS //
///////////////////////
    
    // Return: void
    // Descr: sets the value of FEN
    function getBoardFromServer() {
        // send username to server at gameState.php.
        // if game exists, server returns an FEN string.
        // else, server returns -1. 
        
        //TODO
    }
    // Return: void
    // Descr: enables/disables certain clickEvents,
    //        based upon the data in FEN. 
    function configureClient() {
        //TODO
    }
    // Return: void
    // Descr: draws pieces onto the canvas,
    //        based upon the data in FEN. 
    function drawPieces() {
        //TODO
    }
    // This acts as the main method.
    function draw() {
        
        // get board data from server 
        getBoardFromServer();
        // initializes client settings
        configureClient();
                
        //load chess piece images, draw them.
        pieces = new Image();
        pieces.src = 'pieces.png';
        pieces.onload = drawPieces;
    }
    draw();
});