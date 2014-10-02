// constants are caps. because this is my world. 
var NUM_ROWS = 8;
var NUM_COLS = 8; 
var SQR_SIZE = 100; // want 800x800 board? sooo....8 * 100? 
var SQR_COLOR_W = '#ffffff'; // white 
var SQR_COLOR_B = '#000000'; // black
var row = 0;
var col = 0; 
var num_squares = 0;

function draw()
{
	// link with html5 canvas thingy (function? member?) 
	canvas = document.getElementById('chessb');

	// check if canvas is supported?
	if(canvas.getContext)
	{
		ctx = canvas.getContext('2d');
		
		// compute square size
		SQR_SIZE = canvas.height / NUM_ROWS;
		
		// call method to draw the board
		drawBoard();
		
		// TODO - call method to draw pieces? Use what type of file? 
		
		// TODO - EventListener -> Java == js? 
	}
	else
	{
		alert("Canvas not found.");
	}
}

function drawBoard()
{

	for(row = 0; row < NUM_ROWS; row++)
	{
		drawRow(row);
	}
	
	// Found this is W3 school. How to outline a drawing...
	ctx.lineWidth = 3;
	ctx.strokeRect(0, 0, NUM_ROWS * SQR_SIZE, NUM_COL * SQR_SIZE);

}

function drawRow(row)
{
	// Drawing goes left to right. I hope. 
	for( row = 0; row < NUM_ROWS; row++)
	{
		drawSquare(row, num_squares);
	}
}

function drawBlocks(row, num_squares)
{
	// make squares.... squares.o: squares.c 
	//  fillRect( start x-coord, start y-coord, width in px, height in px) 
	ctx.fillRect(row * SQR_SIZE, num_squares * SQR_SIZE, SQR_SIZE, SQR_SIZE );
	
	// color for blocks
	ctx.fillStyle = getSquareColor(row, blocks_made);
	
	// ctx.stroke(); -> calls the "line drawing" method to draw whatever you defined. Neat.  
	ctx.stroke();
}

function getSquareColor(row, col)
{

	var clr_counter;
	
	// modulo 2, so blocks alternate. Make sure to use cryptic if statement.
	if(clr_counter % 2)
	{
		// terniary operator, also need to know if even or odd row. odd = black, even = white. 
		clr_counter = (num_squares % 2 ? SQR_COLOR_B : SQR_COLOR_W);
	}
	else
	{
		clr_counter = (num_squares % 2 ? SQR_COLOR_W : SQR_COLOR_B);
	}
	return clr_counter; 
}