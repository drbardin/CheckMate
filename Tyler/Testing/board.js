$(document).ready(function() {

    var canvas = $("canvas#gameCanvas")[0];
    var ctx = canvas.getContext("2d");
    var w = $("canvas#gameCanvas").width();
    var h = $("canvas#gameCanvas").height();
    
    var PAWN = 0;
    var KNIGHT = 1;
    var BISHOP = 2;
    var ROOK = 3;
    var QUEEN = 4;
    var KING = 5;
    var UNCAPTURED;
    var CAPTURED;
    var WHITE_TURN = false; 
    var NUM_ROWS;
    var SQR_SIZE = h / 8;
    var IGNORE_CLICKS = false; 

    // var pieceIDs = { bRook, bKnight, bBishop, bKing, bQueen, bPawn,
    //                  wRook, wKnight, wBishop, wKing, wQueen, wPawn }; 
    var pieces = null; 
    var json = null; 
    
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

    
// Listen for button click
$("canvas#gameCanvas").click(function(e) {
        
        // Get (x,y) of mouse click ( pageX works best in this situation. )
        // NOTE: (0,0) is top-left corner of canvas. 
        var x = e.pageX-$("canvas#gameCanvas").offset().left;
        var y = e.pageY-$("canvas#gameCanvas").offset().top;
        
        // Find out which square on the canvas was clicked.
        //  row = Y val / 100 (size of a square) and then rounded down. This will give a num 0-7
        //  col = X val / 100 and then rounded down. This will also give a num 0-7
        var row_clicked = Math.floor(y / SQR_SIZE);
        var col_clicked = Math.floor(x / SQR_SIZE);
        // Debug statements - ensure xy -> row/col conversion is correct & accurate
        console.log("screen X: " + x);
        console.log("screen Y: " + y);
        console.log("row: " + row_clicked);
        console.log("col: " + col_clicked);
        
        //draw box around user selection
        ctx.lineWidth = 5;
        ctx.strokeStyle = "#66FF00";
        ctx.strokeRect((col_clicked * SQR_SIZE) + 3,
                       (row_clicked * SQR_SIZE) + 3,
                        SQR_SIZE - (3 * 2),
                        SQR_SIZE - (3 * 2));
    
        // JSON for outgoing click
        JSONObj = { "row": row_clicked, "col": col_clicked };
        // Turns JSONObj into a JSONStr. 
        var JSONStr = JSON.stringify(JSONObj);
        console.log(JSONStr);
    
        // As of now, loader.php just decodes the JSON recieved, and then encodes and             
        // echoes back the same JSON. 
        $.ajax({
            type: 'POST',
            url: 'loader.php',
            // If I try to pass the JSON to 'data' in a different way, I get null json         
            //properties echoed back.
            data: {'data' : JSONStr},
            // If ContentType is lower-case, causes null json properties to be echoed                 
            // back.
            ContentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function(data, textStatus, jqXHR) {
                console.log(textStatus);
                console.log(data);
                console.log(JSON.stringify(data));
                console.log("Heard reply from loader.php");
            },
             error:function(xhr, desc, err) 
             {
                console.log("No reply from loader.php");
             }
        });
    });
});