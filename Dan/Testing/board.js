$(document).ready(function() {

    var canvas = $("canvas#gameCanvas")[0];
    var ctx = canvas.getContext("2d");
    var w = $("canvas#gameCanvas").width();
    var h = $("canvas#gameCanvas").height();
    
    // Image value for clipping
    var PAWN = 0;
    var KNIGHT = 1;
    var BISHOP = 2;
    var ROOK = 3;
    var QUEEN = 4;
    var KING = 5;
    
    var UNCAPTURED;
    var CAPTURED;
    var WHITE_TURN; 
    var NUM_ROWS;
    var SQR_SIZE = h / 8;
    var IGNORE_CLICKS; 
    var PIECE_HAS_HIGHLIGHT; 
    var LAST_IMAGE_CLICKED = {}; 
    var player_piece_selection = {row: null, col: null, arr_pos: null, im_type: null};
    var prev_piece_selection = {row: null, col: null, arr_pos: null, im_type: null};

    // var pieceIDs = { bRook, bKnight, bBishop, bKing, bQueen, bPawn,
    //                  wRook, wKnight, wBishop, wKing, wQueen, wPawn }; 
    var click_count = 0; 
    var pieces = null; 
    var json = null; 
    var sqr_clicked = { 'row': null, 'col': null, 'arr_pos': null };
    
    // This acts as main method
    function draw() {
        
        // white always makes first move.
        WHITE_TURN = true;

        pieces = new Image();
        pieces.src = 'pieces.png';
        pieces.onload = drawPieces;

        // call method to set up fresh chessboard
        setNewBoard();

        //canvas.addEventListener('click', heard_click, false);
    }
    draw();
    
    // JSON wrapped in function so can be used as a new game initializer.
    function setNewBoard() {
        // two arrays, one black, one white. Their positions are 0-15. 
        json = {
            'black': [ { 'piece': ROOK,  'row': 0, 'col': 0, 'status': UNCAPTURED },
                       { 'piece': KNIGHT,'row': 0, 'col': 1, 'status': UNCAPTURED },
                       { 'piece': BISHOP,'row': 0, 'col': 2, 'status': UNCAPTURED },
                       { 'piece': KING,  'row': 0, 'col': 3, 'status': UNCAPTURED },
                       { 'piece': QUEEN, 'row': 0, 'col': 4, 'status': UNCAPTURED },
                       { 'piece': BISHOP,'row': 0, 'col': 5, 'status': UNCAPTURED },
                       { 'piece': KNIGHT,'row': 0, 'col': 6, 'status': UNCAPTURED },
                       { 'piece': ROOK,  'row': 0, 'col': 7, 'status': UNCAPTURED },
                       { 'piece': PAWN,  'row': 1, 'col': 0, 'status': UNCAPTURED },
                       { 'piece': PAWN,  'row': 1, 'col': 1, 'status': UNCAPTURED },
                       { 'piece': PAWN,  'row': 1, 'col': 2, 'status': UNCAPTURED },
                       { 'piece': PAWN,  'row': 1, 'col': 3, 'status': UNCAPTURED },
                       { 'piece': PAWN,  'row': 1, 'col': 4, 'status': UNCAPTURED },
                       { 'piece': PAWN,  'row': 1, 'col': 5, 'status': UNCAPTURED },
                       { 'piece': PAWN,  'row': 1, 'col': 6, 'status': UNCAPTURED },
                       { 'piece': PAWN,  'row': 1, 'col': 7, 'status': UNCAPTURED },
                     ],
            'white': [ { 'piece': ROOK,  'row': 7, 'col': 0, 'status': UNCAPTURED },
                       { 'piece': KNIGHT,'row': 7, 'col': 1, 'status': UNCAPTURED },
                       { 'piece': BISHOP,'row': 7, 'col': 2, 'status': UNCAPTURED },
                       { 'piece': KING,  'row': 7, 'col': 3, 'status': UNCAPTURED },
                       { 'piece': QUEEN, 'row': 7, 'col': 4, 'status': UNCAPTURED },
                       { 'piece': BISHOP,'row': 7, 'col': 5, 'status': UNCAPTURED },
                       { 'piece': KNIGHT,'row': 7, 'col': 6, 'status': UNCAPTURED },
                       { 'piece': ROOK,  'row': 7, 'col': 7, 'status': UNCAPTURED },
                       { 'piece': PAWN,  'row': 6, 'col': 0, 'status': UNCAPTURED },
                       { 'piece': PAWN,  'row': 6, 'col': 1, 'status': UNCAPTURED },
                       { 'piece': PAWN,  'row': 6, 'col': 2, 'status': UNCAPTURED },
                       { 'piece': PAWN,  'row': 6, 'col': 3, 'status': UNCAPTURED },
                       { 'piece': PAWN,  'row': 6, 'col': 4, 'status': UNCAPTURED },
                       { 'piece': PAWN,  'row': 6, 'col': 5, 'status': UNCAPTURED },
                       { 'piece': PAWN,  'row': 6, 'col': 6, 'status': UNCAPTURED },
                       { 'piece': PAWN,  'row': 6, 'col': 7, 'status': UNCAPTURED },
                      ]
        };
    }
    ///////////////////////////////
    //   DRAW PIECES FUNCTIONS   //
    ///////////////////////////////
    function drawPieces() 
    {
        //Send white team to be drawn, then black team. 
        drawAllPieces(json.white, false);
        drawAllPieces(json.black, true);
    }

    // This send all pieces to be drawn in their base position.
    function drawAllPieces(fullColorSet, isBlackTeam) 
    { 
        var piece_index;
        // go through black or white team one-by-one, send to drawImage function 
        for (piece_index = 0; piece_index < fullColorSet.length; piece_index++) {
            var curImage = fullColorSet[piece_index]; 
            drawThisPiece(curImage, isBlackTeam);
        }
    }
    // Draws the specified piece. 
    function drawThisPiece(pieceToDraw, isBlackTeam)
    {
        var thisXY = getCoordinates(pieceToDraw.piece, isBlackTeam);
        ctx.drawImage(pieces, thisXY.x, thisXY.y, SQR_SIZE, SQR_SIZE, pieceToDraw.col * SQR_SIZE, pieceToDraw.row * SQR_SIZE, SQR_SIZE, SQR_SIZE);
    }
    // this chops out a 100x100 square from the pieces.png. Hopefully it'll be the right color and rank. 
    function getCoordinates(thisPiece, isBlackTeam)
    {
        // x is the column, so send the number of the current piece (e.g., ROOK = 3), multiply by size of piece images.
        // y is row, or white/black team. 
        var im_coordinates = { "x": thisPiece * SQR_SIZE, "y": (isBlackTeam ? SQR_SIZE : 0)};
        return im_coordinates;
    }
    
    // run through piece array, check for match. 
    function getPieceClicked(sqr_clicked) {
        
        var cur_color_array = {};
        var arr_pos, im_type, row, col; 
        
        // which color array should be looped?
        if(WHITE_TURN? cur_color_array = json.white: cur_color_array = json.black);
        
        // loop the array, if we have a match, build the data. 
        for(var i = 0; i < cur_color_array.length; i++)
        {
            if(cur_color_array[i].row === sqr_clicked.row && cur_color_array[i].col === sqr_clicked.col)
            {
                arr_pos = i;
                im_type = cur_color_array[i].piece;
                row = cur_color_array[i].row;
                col = cur_color_array[i].col;
            }
        }
                
        return {
            arr_pos: arr_pos,
            im_type: im_type,
            row: row,
            col: col
        };
    }
        
// Listen for button click
$("canvas#gameCanvas").click(function(e) {
    
    console.log("hello click");
    
    // Get (x,y) of mouse click ( pageX works best in this situation. )
    // NOTE: (0,0) is top-left corner of canvas. 
    var x = e.pageX-$("canvas#gameCanvas").offset().left;
    var y = e.pageY-$("canvas#gameCanvas").offset().top;

    //Find out which square on the canvas was clicked.
    //   row = Y val / 100 (size of a square) and then rounded down. This will give a num 0-7
    //   col = X val / 100 and then rounded down. This will also give a num 0-7
    var row_clicked = Math.floor(y / SQR_SIZE);
    var col_clicked = Math.floor(x / SQR_SIZE);
    
    var cur_click = {row: row_clicked, col: col_clicked};
    click_count++;
    
    console.log("clk count: " + click_count);
    console.log("cur click - row:" + cur_click.row);
    console.log("cur click - col:" + cur_click.col);

    if(PIECE_HAS_HIGHLIGHT !== true)
    {
        // grab un-highlighted image
        LAST_IMAGE_CLICKED = ctx.getImageData(col_clicked*100, row_clicked*100, 100, 100);

        //draw highlight box around user selection
        ctx.lineWidth = 5;
        ctx.strokeStyle = "#66FF00";
        ctx.strokeRect((col_clicked * SQR_SIZE) + 3, (row_clicked * SQR_SIZE) + 3, SQR_SIZE - (3 * 2), SQR_SIZE - (3 * 2));
        PIECE_HAS_HIGHLIGHT = true;

        player_piece_selection = getPieceClicked(cur_click);
        console.log("after setting player piece selection r/c: " + player_piece_selection.row + " " + player_piece_selection.col);
    }
    else
    {
        //prev_piece_selection.col = player_piece_selection.col;
        //prev_piece_selection.row = player_piece_selection.row; 
        prev_piece_selection = player_piece_selection;
        console.log("prev.row: " + prev_piece_selection.row + "prev.col: " + prev_piece_selection.col);
        
        player_piece_selection = getPieceClicked(cur_click);
        console.log("pps.row: " + player_piece_selection.row + "pps.col: " + player_piece_selection.col);
        
        ctx.clearRect(prev_piece_selection.col*100 , prev_piece_selection.row*100 , 100 , 100 );
        console.log("last image clicked: " + LAST_IMAGE_CLICKED);
        ctx.putImageData(LAST_IMAGE_CLICKED, prev_piece_selection.col*100, prev_piece_selection.row*100);
        PIECE_HAS_HIGHLIGHT = false;
        
        // move the piece
        ctx.clearRect(prev_piece_selection.col*100 , prev_piece_selection.row*100 , 100 , 100 );
        ctx.putImageData(LAST_IMAGE_CLICKED, col_clicked*100, row_clicked*100);
        
    }
    
    console.log("goodbye click");
    });
});


//    function highlightSquare(player_piece_selection)
//    {
//        var row_clicked = player_piece_selection.row;
//        var col_clicked = player_piece_selection.col;
//        
//        //Take a snapshot of clicked piece before highlighting.
//        var cur_click_image = ctx.getImageData(col_clicked*100, row_clicked*100, 100, 100);
//
//        //draw highlight box around user selection
//        ctx.lineWidth = 5;
//        ctx.strokeStyle = "#66FF00";
//        ctx.strokeRect((col_clicked * SQR_SIZE) + 3, (row_clicked * SQR_SIZE) + 3, SQR_SIZE - (3 * 2), SQR_SIZE - (3 * 2));        
//
//    }
//        function undoHighlight(player_piece_selection)
//    {
//        ctx.clearRect(player_piece_selection.col*100, player_piece_selection.row*100, 100, 100 );
//        ctx.putImageData(player_piece_selection.col, player_piece_selection.row);
//    }
