// constants are caps. because this is my world. 
// NOTE -> color of board, and pieces are from wikipedia.org/Chess_piece
// chess board is 8x8 
var NUM_ROWS = 8;
var NUM_COLS = 8;
var SQR_SIZE;
// want 800x800 board? sooo....8 * 100?
var LIGHT_SQUARE = '#ffce9e';
var DARK_SQUARE = '#d18b47';
var WHITE_TURN = true; // false = black, true = white


// This is the order of the png file. Makes sure the pieces 
// are in the correct position on the board when clipping/drawing them.
var PAWN = 0;
var KNIGHT = 1;
var BISHOP = 2;
var ROOK = 3;
var QUEEN = 4;
var KING = 5;
var UNCAPTURED;
var CAPTURED;

// declare class callers & global variables. 
// var derp = null --> signifies an object definition
var ctx = null;
var canvas = null;
var json = null;
var clicked_piece = null;
var pieces = null;
var row = 0;
var col = 0;
var sqr_clicked = null;
var player_piece_selection = null;

var num_squares = 64;

// This acts as main method
function draw() {
    // link with html5 canvas thingy 
    canvas = document.getElementById('checkmate_board');
    // check if canvas is supported 
    if (canvas.getContext) {
        ctx = canvas.getContext('2d');
        // compute square size
        SQR_SIZE = canvas.height / NUM_ROWS;
        
        // white always makes first move.
        WHOSE_TURN = 1;
        
        pieces = new Image();
        pieces.src = 'pieces.png';
        pieces.onload = drawPieces;
        
        // call method to set up fresh chessboard
        setNewBoard();
        // call method to draw the board
        drawBoard();
        
        canvas.addEventListener('click', heard_click, false);

    } else {
        alert('Canvas not found.');
    }
}

///////////////////////////////
//    DRAW BOARD FUNCTIONS   //
///////////////////////////////
function drawBoard() {
    // draw each row
    for (row = 0; row < NUM_ROWS; row++) {
        // draw cols/squares left to right
        for (num_squares = 0; num_squares < NUM_ROWS; num_squares++) {
            drawSquare(row, num_squares);
        }
    }
    // Found this is W3 school. How to outline a drawing...
    ctx.lineWidth = 3;
    ctx.strokeRect(0, 0, NUM_ROWS * SQR_SIZE, NUM_COLS * SQR_SIZE);
}
function drawSquare(row, num_squares) {
    // color for blocks
    ctx.fillStyle = getSquareColor(row, num_squares);

    // make squares.... gcc squares.c -o C_joke.
    // fillRect( start x-coord, start y-coord, width in px, height in px) 
    ctx.fillRect(row * SQR_SIZE, num_squares * SQR_SIZE, 100, 100);
   
    // ctx.stroke(); -> calls the "line drawing" method to draw whatever you defined. Neat.  
    ctx.stroke();
}
function getSquareColor(row, num_squares) {
    var clr_counter;
    // modulo 2, so blocks alternate. Make sure to use cryptic if statement.
    if (row % 2) {
        // terniary operator, also need to know if even or odd row. odd = black, even = white. 
        clr_counter = (num_squares % 2 ? DARK_SQUARE : LIGHT_SQUARE);
    } else {
        clr_counter = (num_squares % 2 ? LIGHT_SQUARE : DARK_SQUARE);
    }
    return clr_counter;
}
// END DRAW BOARD FUNCTIONS 



///////////////////////////////
//    Pieces JSON function   //
///////////////////////////////
// JSON wrapped in function so can be used as a new game initializer.
function setNewBoard() {
    
    // !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!//
    //                                                                //
    //    DO NOT FORGET (0,0) IS TOP LEFT CORNER. NOT BOTTOM LEFT.    //
    //                                                                //
    // !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!//
    json = {
        'black': [
            {
                'piece': ROOK,
                'row': 0,
                'col': 0,
                'status': UNCAPTURED
            },
            {
                'piece': KNIGHT,
                'row': 0,
                'col': 1,
                'status': UNCAPTURED
            },
            {
                'piece': BISHOP,
                'row': 0,
                'col': 2,
                'status': UNCAPTURED
            },
            {
                'piece': KING,
                'row': 0,
                'col': 3,
                'status': UNCAPTURED
            },
            {
                'piece': QUEEN,
                'row': 0,
                'col': 4,
                'status': UNCAPTURED
            },
            {
                'piece': BISHOP,
                'row': 0,
                'col': 5,
                'status': UNCAPTURED
            },
            {
                'piece': KNIGHT,
                'row': 0,
                'col': 6,
                'status': UNCAPTURED
            },
            {
                'piece': ROOK,
                'row': 0,
                'col': 7,
                'status': UNCAPTURED
            },
            {
                'piece': PAWN,
                'row': 1,
                'col': 0,
                'status': UNCAPTURED
            },
            {
                'piece': PAWN,
                'row': 1,
                'col': 1,
                'status': UNCAPTURED
            },
            {
                'piece': PAWN,
                'row': 1,
                'col': 2,
                'status': UNCAPTURED
            },
            {
                'piece': PAWN,
                'row': 1,
                'col': 3,
                'status': UNCAPTURED
            },
            {
                'piece': PAWN,
                'row': 1,
                'col': 4,
                'status': UNCAPTURED
            },
            {
                'piece': PAWN,
                'row': 1,
                'col': 5,
                'status': UNCAPTURED
            },
            {
                'piece': PAWN,
                'row': 1,
                'col': 6,
                'status': UNCAPTURED
            },
            {
                'piece': PAWN,
                'row': 1,
                'col': 7,
                'status': UNCAPTURED
            },
        ],
        'white': [
            {
                'piece': ROOK,
                'row': 7,
                'col': 0,
                'status': UNCAPTURED
            },
            {
                'piece': KNIGHT,
                'row': 7,
                'col': 1,
                'status': UNCAPTURED
            },
            {
                'piece': BISHOP,
                'row': 7,
                'col': 2,
                'status': UNCAPTURED
            },
            {
                'piece': KING,
                'row': 7,
                'col': 3,
                'status': UNCAPTURED
            },
            {
                'piece': QUEEN,
                'row': 7,
                'col': 4,
                'status': UNCAPTURED
            },
            {
                'piece': BISHOP,
                'row': 7,
                'col': 5,
                'status': UNCAPTURED
            },
            {
                'piece': KNIGHT,
                'row': 7,
                'col': 6,
                'status': UNCAPTURED
            },
            {
                'piece': ROOK,
                'row': 7,
                'col': 7,
                'status': UNCAPTURED
            },
            {
                'piece': PAWN,
                'row': 6,
                'col': 0,
                'status': UNCAPTURED
            },
            {
                'piece': PAWN,
                'row': 6,
                'col': 1,
                'status': UNCAPTURED
            },
            {
                'piece': PAWN,
                'row': 6,
                'col': 2,
                'status': UNCAPTURED
            },
            {
                'piece': PAWN,
                'row': 6,
                'col': 3,
                'status': UNCAPTURED
            },
            {
                'piece': PAWN,
                'row': 6,
                'col': 4,
                'status': UNCAPTURED
            },
            {
                'piece': PAWN,
                'row': 6,
                'col': 5,
                'status': UNCAPTURED
            },
            {
                'piece': PAWN,
                'row': 6,
                'col': 6,
                'status': UNCAPTURED
            },
            {
                'piece': PAWN,
                'row': 6,
                'col': 7,
                'status': UNCAPTURED
            },
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
function drawAllPieces(fullColorSet, isBlackTeam) 
{
    
    var piece_index; // descriptive counters makes JS more readable.
  
    // go through black or white team one-by-one, send to drawImage function 
    for (piece_index = 0; piece_index < fullColorSet.length; piece_index++) {
        var curImage = fullColorSet[piece_index]; 
        var thisXY = getCoordinates(curImage.piece, isBlackTeam);
        ctx.drawImage(pieces, thisXY.x, thisXY.y, SQR_SIZE, SQR_SIZE, curImage.col * SQR_SIZE, curImage.row * SQR_SIZE, SQR_SIZE, SQR_SIZE);
    }
}

// this chops out a 100x100 square from the pieces.png. Hopefully it'll be the right color and rank. 
function getCoordinates(thisPiece, isBlackTeam)
{
    // x is the column, so send the number of the current piece (e.g., ROOK = 3), multiply by size of piece images.
    // y is row, or white/black team. 
    var im_coordinates = { "x": thisPiece * SQR_SIZE, "y": (isBlackTeam ? SQR_SIZE : 0)};
    return im_coordinates;
}


////////////////////////////////
//   CLICK ACTION FUNCTIONS   //
////////////////////////////////
function heard_click(e) {
    // standard get X/Y of click event. 
    var x = e.clientX - canvas.offsetLeft;
    var y = e.clientY - canvas.offsetTop;
    // round down and divide to get row and column of click
   
    sqr_clicked = { "row": Math.floor(y / SQR_SIZE),
                    "col": Math.floor(x / SQR_SIZE) };
    console.log(x);
    console.log(y);
    
    player_piece_selection = checkSquareContents(sqr_clicked);
}

function checkSquareContents(sqrClicked)
{
    var loop_piece; 
    var i; 
    var pieceToMove = null;
    var cur_color;
    if(WHITE_TURN) // eval true = white
        cur_color = json.white;
    else
        cur_color = json.black;
    
    for(i = 0; i < cur_color.length; i++)
    {
        //if(sqr_clicked.col == cur_color[i].col && sqr_clicked.row == cur_color[i].row && cur_color[i].status == UNCAPTURED)
            
    }
}
