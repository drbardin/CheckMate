$(document).ready(function () {

    var canvas = $("canvas#gameCanvas")[0];
    var ctx = canvas.getContext("2d");
    var w = $("canvas#gameCanvas").width();
    var h = $("canvas#gameCanvas").height();

    // value id for piece location in pieces.png. 
    // used for cropping method. 
    var PAWN = 0;
    var KNIGHT = 1;
    var BISHOP = 2;
    var ROOK = 3;
    var QUEEN = 4;
    var KING = 5;

    var NUM_ROWS;
    var CAPTURED;
    var UNCAPTURED;
    var SQR_SIZE = h / 8;
    var WHITE_TURN;

    var click_counter = 0; 
    var prev_click = {row: null, col: null};
    var sqrs_with_highlight = new Array();   // array of (r,c) objects currently highlighted. 
    var before_highlight_imgs = new Array(); // array of image object before highlighting. 

    // object declarations
    var pieces = null;
    var json = null;
    var JSONObj = null;

    // This acts as main method
    function draw() {
        // white always makes first move.
        WHITE_TURN = true;
        // load chess piece images, draw them.
        pieces = new Image();
        pieces.src = 'pieces.png';
        pieces.onload = drawPieces;

        // call method to set up fresh chessboard
        setNewBoard();
    }
    draw();

    // JSON wrapped in function so can be used as a new game initializer.
   function setNewBoard() {
        // two arrays, one black, one white. Their positions are 0-15. 
        json = {
            "black": [ { 'piece': ROOK,  'row': 0, 'col': 0, 'status': UNCAPTURED },
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
            "white": [ { 'piece': ROOK,  'row': 7, 'col': 0, 'status': UNCAPTURED },
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
    function drawPieces() {
        //Send white team to be drawn, then black team. 
        drawAllPieces(json.white, false);
        drawAllPieces(json.black, true);
    }
    // This send all pieces to be drawn in their base position.
    function drawAllPieces(fullColorSet, isBlackTeam) {
        var piece_index;
        // go through black or white team one-by-one, send to drawImage function 
        for (piece_index = 0; piece_index < fullColorSet.length; piece_index++) {
            var curImage = fullColorSet[piece_index];
            drawThisPiece(curImage, isBlackTeam);
        }
    }
    // Draws the specified piece. 
    function drawThisPiece(pieceToDraw, isBlackTeam) {
        var thisXY = getCoordinates(pieceToDraw.piece, isBlackTeam);
        ctx.drawImage(pieces, thisXY.x, thisXY.y, SQR_SIZE, SQR_SIZE, pieceToDraw.col * SQR_SIZE, pieceToDraw.row * SQR_SIZE, SQR_SIZE, SQR_SIZE);
    }
    // this chops out a 100x100 square from the pieces.png. Hopefully it'll be the right color and rank. 
    function getCoordinates(thisPiece, isBlackTeam) {
        // x is the column, so send the number of the current piece (e.g., ROOK = 3), multiply by size of piece images.
        // y is row, or white/black team. 
        var im_coordinates = {
            "x": thisPiece * SQR_SIZE,
            "y": (isBlackTeam ? SQR_SIZE : 0)
        };
        return im_coordinates;
    }

    function highlight_squares(sqrs_to_highlight) {
        for (var i = 0; i < sqrs_to_highlight.length; i++) {
            var r = sqrs_to_highlight[i].row;
            var c = sqrs_to_highlight[i].col;

            // add a row and col to array holding highlight coords.
            sqrs_with_highlight.push(new Object());
            sqrs_with_highlight[i].row = r;
            sqrs_with_highlight[i].col = c;

            // add un-highlighted image to array. 
            before_highlight_imgs[i] = ctx.getImageData(c * 100, r * 100, 100, 100);

            // draw highlight box around clicked square in red, potential moves in green
            ctx.outlineWidth = 5;
            if (i === 0) // clicked box
                ctx.strokeStyle = "#FF0000"; // red
            else
                ctx.strokeStyle = "#66FF00"; // green
            ctx.strokeRect((c * 100) + 3, (r * 100) + 3, 100 - (3 * 2), 100 - (3 * 2));
        }
    }

    function remove_highlights() {
        for (var i = 0; i < sqrs_with_highlight.length; i++) {
            var r = sqrs_with_highlight[i].row;
            var c = sqrs_with_highlight[i].col;

            ctx.putImageData(before_highlight_imgs[i], c * 100, r * 100);
        }
    }

    function update_json(move_to_click) {
        var cur_color;
        var r = move_to_click.row;
        var c = move_to_click.col;
        if (WHITE_TURN ? cur_color = json.white : cur_color = json.black);

        for (var i = 0; i < cur_color.length; i++) {
            if (cur_color[i].row === prev_click.row && cur_color[i].col === prev_click.col) {
                // update the json to reflect new position.
                cur_color[i].row = r;
                cur_color[i].col = c;
            }
        }
    }

    // Click handler 
    // Listen for button click
    $("canvas#gameCanvas").click(function (e) {

        // increment click counter
        click_counter++;

        // Get (x,y) of mouse click ( pageX works best in this situation. )
        // NOTE: (0,0) is top-left corner of canvas. 
        var x = e.pageX - $("canvas#gameCanvas").offset().left;
        var y = e.pageY - $("canvas#gameCanvas").offset().top;

        //  Find out which square on the canvas was clicked.
        //  row = Y val / 100 (size of a square) and then rounded down. This will give a num 0-7
        //  col = X val / 100 and then rounded down. This will also give a num 0-7
        var row_clicked = Math.floor(y / SQR_SIZE);
        var col_clicked = Math.floor(x / SQR_SIZE);


        // JSON for outgoing click
        var JSONObj = {
            "row": row_clicked,
            "col": col_clicked,
            "black": json.black,
            "white": json.white,
        };

        // Turns JSONObj into a JSONStr. 
        var JSONStr = JSON.stringify(JSONObj);
        console.log(JSONStr);

        // FROM_CLICK condition
        if (click_counter % 2 !== 0) {

            $.ajax({
                type: 'POST',
                url: 'from_click.php',
                // If I try to pass the JSON to 'data' in a different way, I get null json               
                //properties echoed back.
                data: {
                    'data': JSONStr
                },

                // If ContentType is lower-case, causes null json properties to be echoed back.
                ContentType: "application/json; charset=utf-8",
                dataType: "json",
                success: function (data, textStatus, jqXHR) {
                    console.log(textStatus);
                    console.log(data);
                    console.log(JSON.stringify(data));
                    console.log("Heard reply from from_click.php");

                    // call process return data function

                    highlight_squares(data);
                    prev_click.col = col_clicked;
                    prev_click.row = row_clicked;
                },
                error: function (xhr, desc, err) {
                    console.log("No reply from from_click.php");
                }
            });
        } else {
            $.ajax({
                type: 'POST',
                url: 'to_click.php',
                // If I try to pass the JSON to 'data' in a different way, I get null json               
                //properties echoed back.
                data: {
                    'data': JSONStr
                },

                // If ContentType is lower-case, causes null json properties to be echoed back.
                ContentType: "application/json; charset=utf-8",
                dataType: "json",
                success: function (data, textStatus, jqXHR) {
                    console.log(textStatus);
                    console.log(data);
                    console.log(JSON.stringify(data));
                    console.log("Heard reply from to_click.php");

                    // undo highlighted squares
                    remove_highlights();

                    // move piece
                    ctx.clearRect(prev_click.col * 100, prev_click.row * 100, 100, 100);
                    ctx.putImageData(before_highlight_imgs[0], col_clicked * 100, row_clicked * 100);

                    sqrs_with_highlight = new Array(); // clear this turns array
                    before_highlight_imgs = new Array(); // clear 
                    prev_click = {
                        "row": null,
                        "col": null
                    };

                    if (WHITE_TURN ? WHITE_TURN = false : WHITE_TURN = true);
                },
                error: function (xhr, desc, err) {
                    console.log("No reply from to_click.php");
                }
            });
        }
    });
    // getUpdate();
    //    function getUpdate() {
    //        var update_ping = $.ajax( {
    //           url: "loader.php",
    //           type: 'GET',
    //           dataType: "json"
    //        });
    //        
    //        update_ping.done(function(data, textStatus, jqXHR) {
    //            $.parseJSON(data);
    //            
    //            var lrow = data[0].row;
    //            var lcol = data[0].col;
    //            console.log("update jquery row: " + lrow);
    //            console.log("update jquery col: " + lcol);
    //            // send object to draw function
    //        });
    //        
    //        update_ping.fail(function(jqXHR, textStatus) {
    //           alert("Ping failed: " + textStatus);
    //        });
    //    }

 });
    
                                