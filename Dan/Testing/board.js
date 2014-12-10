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
    var SQR_SIZE = h / 8;
    var WHITE_TURN;
    
    var CLIENT_UNAME;  // this client's username
    var CLIENT_COLOR;  // this client's color
    var OPPO_UNAME;    // this client's opponent
    
    var click_counter = 0;  
    var selected_valid_destination = false;   // to_click flag for selecting valid destination
   
    // object declarations
    var pieces = new Image();
    var json = null;
    var JSONObj = null;
    var prev_click = {row: null, col: null};  // hold the last click successfully handleded by ajax. 
    var before_highlight_imgs = new Array();  // array of image object before highlighting. 
    var sqrs_to_highlight = new Array();      // array to hold the (row, col) pairs to highlight. 
    var sqrs_to_hlgt_len = 0;                 // get count of keys returned from ajax query.
    var new_capture = {};                     // hold the array position of a captured piece
    

    // This acts as main method
    function draw() {
        // white always makes first move.
        WHITE_TURN = true;
        // load piece image resource.
        pieces.src = 'pieces.png';
        
        pieces.onload = drawPieces;
        
        // call method to set up fresh chessboard
        setNewBoard();
        
        // query server for player names, this.color
        // GET: client username, client color, opponent username
        $.ajax({
            type: 'GET',
            url: 'init_draw_ajax.php',
            ContentType: "application/json; charset=utf-8",
            //dataType: "json",
            success: function (data, textStatus, jqXHR) {
                console.log("Heard reply from init_draw_ajax.php");
                console.log(data);

                var p_data = JSON.parse(data);

                // Set the globals
                CLIENT_UNAME = p_data[0];
                CLIENT_COLOR = p_data[1];
                OPPO_UNAME   = p_data[2];
                
                // call the add client username function.
                addClientUserName(CLIENT_UNAME, CLIENT_COLOR, OPPO_UNAME);
                
                console.log(CLIENT_UNAME);
                console.log(CLIENT_COLOR);
                console.log(OPPO_UNAME);

            },
            error: function (xhr, desc, err) {
                console.log("No reply from init_draw_ajax.php");
                console.log(desc);
                console.log(err);  
            }
        });
    }
    
    draw();

    // JSON wrapped in function so can be used as a new game initializer.
   function setNewBoard() {
        // two arrays, one black, one white. Their positions are 0-15. 
        json = {
            "black": [ { 'piece': ROOK,  'row': 0, 'col': 0, 'status': true},
                       { 'piece': KNIGHT,'row': 0, 'col': 1, 'status': true},
                       { 'piece': BISHOP,'row': 0, 'col': 2, 'status': true},
                       { 'piece': KING,  'row': 0, 'col': 3, 'status': true},
                       { 'piece': QUEEN, 'row': 0, 'col': 4, 'status': true},
                       { 'piece': BISHOP,'row': 0, 'col': 5, 'status': true},
                       { 'piece': KNIGHT,'row': 0, 'col': 6, 'status': true},
                       { 'piece': ROOK,  'row': 0, 'col': 7, 'status': true},
                       { 'piece': PAWN,  'row': 1, 'col': 0, 'status': true},
                       { 'piece': PAWN,  'row': 1, 'col': 1, 'status': true},
                       { 'piece': PAWN,  'row': 1, 'col': 2, 'status': true},
                       { 'piece': PAWN,  'row': 1, 'col': 3, 'status': true},
                       { 'piece': PAWN,  'row': 1, 'col': 4, 'status': true},
                       { 'piece': PAWN,  'row': 1, 'col': 5, 'status': true},
                       { 'piece': PAWN,  'row': 1, 'col': 6, 'status': true},
                       { 'piece': PAWN,  'row': 1, 'col': 7, 'status': true},
                     ],
            "white": [ { 'piece': ROOK,  'row': 7, 'col': 0, 'status': true},
                       { 'piece': KNIGHT,'row': 7, 'col': 1, 'status': true},
                       { 'piece': BISHOP,'row': 7, 'col': 2, 'status': true},
                       { 'piece': KING,  'row': 7, 'col': 3, 'status': true},
                       { 'piece': QUEEN, 'row': 7, 'col': 4, 'status': true},
                       { 'piece': BISHOP,'row': 7, 'col': 5, 'status': true},
                       { 'piece': KNIGHT,'row': 7, 'col': 6, 'status': true},
                       { 'piece': ROOK,  'row': 7, 'col': 7, 'status': true},
                       { 'piece': PAWN,  'row': 6, 'col': 0, 'status': true},
                       { 'piece': PAWN,  'row': 6, 'col': 1, 'status': true},
                       { 'piece': PAWN,  'row': 6, 'col': 2, 'status': true},
                       { 'piece': PAWN,  'row': 6, 'col': 3, 'status': true},
                       { 'piece': PAWN,  'row': 6, 'col': 4, 'status': true},
                       { 'piece': PAWN,  'row': 6, 'col': 5, 'status': true},
                       { 'piece': PAWN,  'row': 6, 'col': 6, 'status': true},
                       { 'piece': PAWN,  'row': 6, 'col': 7, 'status': true},
                     ]
            };
    }
    //////////////////////////////////////
    //   INIT & DRAW PIECES FUNCTIONS   //
    //////////////////////////////////////
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
    //////////////////////////////////////////
    //  END  INIT/DRAW PIECES FUNCTIONS   //
    //////////////////////////////////////////
    
    
    // After successful source square click, game engine returns 
    // an array of (row, col) pairs representing the locations the clicked piece
    // can legally move to. 
    // Array contains the clicked piece at arr[0]. 
    function highlight_squares(sqrs_to_highlight) {
        
        for (var i = 0; i < sqrs_to_highlight.length; i++) 
        {
            var r = sqrs_to_highlight[i].row;
            var c = sqrs_to_highlight[i].col;
            
            // add un-highlighted image to array. 
            var temp = ctx.getImageData((c * 100), (r * 100), 100, 100);
            before_highlight_imgs.push(temp);

            // draw highlight box around clicked square in red, potential moves in green
            ctx.outlineWidth = 5;
            if (i === 0) // clicked piece
                ctx.strokeStyle = "#FF0000"; // red
            else
                ctx.strokeStyle = "#66FF00"; // green
            
            ctx.strokeRect((c * 100) + 3, (r * 100) + 3, 100 - (3 * 2), 100 - (3 * 2));
        }
    }

    
    // This will remove all highlights from the game board. 
    function remove_highlights() {
        
        for (var i = 0; i < sqrs_to_highlight.length; i++) {
        
            var r = sqrs_to_highlight[i].row;
            var c = sqrs_to_highlight[i].col;
            
            var temp = ctx.createImageData(before_highlight_imgs[i]);
            ctx.putImageData(temp, c * 100, r * 100);
        }
    }
    
    // After success FROM and TO clicks, update the local gamestate. 
    function update_json(to_click) {
        
        // container for black or white json. 
        var cur_color;
        
        // Which color is playing. 
        if (WHITE_TURN ? cur_color = json.white : cur_color = json.black);
        var i;
        // Find the piece and update it to its new location. 
        for(i = 0; i < cur_color.length; i++) {
            
            if(cur_color[i].col === to_click.col && cur_color[i].row === to_click.row){
            
                cur_color[i].col = to_click.col;
                cur_color[i].row = to_click.row;
            }
        }
        
        // Now we want the opposing set, see if a piece lives in the space.
        if(WHITE_TURN ? cur_color = json.black : cur_color = json.white)
        
        for(i = 0; i < cur_color.length; i++)
        {
            if(cur_color[i].col === to_click.col && cur_color[i].row === to_click.row){
                new_capture = true;
                cur_color[captured_arrpos].row = -1;
                cur_color[captured_arrpos].col = -1;
                cur_color[captured_arrpos].inPlay = false; 
            }
        }
    }
    
    function addClientUserName(CLIENT_UNAME, CLIENT_COLOR, OPPO_UNAME){
        
        if(CLIENT_COLOR === 'w')
        {
            $('#leftcapturedcontainer').append("<p>"+OPPO_UNAME+"</p>");
            $('#rightcapturedcontainer').append("<p>"+CLIENT_UNAME+"</p>");
        }
        else
        {
            $('#leftcapturedcontainer').append("<p>"+CLIENT_UNAME+"</p>");
            $('#rightcapturedcontainer').append("<p>"+OPPO_UNAME+"</p>");
        }
           
    }

    // Click handler 
    // Listen for button click
    $("canvas#gameCanvas").click(function (e) {

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
            "col": col_clicked
        };

        // Turns JSONObj into a JSONStr. 
        var JSONStr = JSON.stringify(JSONObj);
        
        // FROM_CLICK condition
        if (click_counter === parseFloat(click_counter) && !(click_counter % 2)) 
        {
            $.ajax({
                type: 'POST',
                url: 'from_click.php',
                data: {'data': JSONStr},
                // If ContentType is lower-case, causes null json properties to be echoed back.
                ContentType: "application/json; charset=utf-8",
                //dataType: "json",
                success: function (data, textStatus, jqXHR) {
                    console.log("Heard reply from from_click.php");
                    
                    //var updated_data = JSON.stringify(data);
                    sqrs_to_highlight = JSON.parse(data);
                    // get number of keys in new obj. 
                    // sqrs_to_hlgt_len = Object.keys(sqrs_to_highlight).length;
                    
                    // call process return data function
                    highlight_squares(sqrs_to_highlight);
                    
                    // store the user's click
                    prev_click.col = col_clicked;
                    prev_click.row = row_clicked;
                    
                    // increment click counter
                    click_counter++;
                },
                error: function (xhr, desc, err) {
                    console.log("No reply from from_click.php");
                    console.log(desc);
                    console.log(err);  
                }
            });
        } 
        else 
        {
            // UNDO CLICK condition, reset logic to FROM_CLICK game status.
            if(row_clicked === prev_click.row && col_clicked === prev_click.col)
            {
                remove_highlights(); // remove board highlights
                click_counter--;     // now listening for "from_click"
                prev_click.row = null;
                prev_click.col = null;
            }
            else 
            {
                
                // Loop through highlighted square, which signify legal moves, and check 
                // player is going to a valid destination. 
                for(var i = 0; i < sqrs_to_highlight.length; i++) 
                {
                    if(sqrs_to_highlight[i].row === row_clicked && sqrs_to_highlight[i].col === col_clicked){
                        selected_valid_destination = true;
                    }
                }
                // If it is valid, process the move, otherwise, do nothing and wait for a valid click. 
                if(selected_valid_destination) 
                {
                    $.ajax({
                        type: 'POST',
                        url: 'to_click.php',
                        data: {'data': JSONStr},

                        // If ContentType is lower-case, causes null json properties to be echoed back.
                        ContentType: "application/json; charset=utf-8",
                        dataType: "json",
                        success: function (data, textStatus, jqXHR) {
                            console.log("Heard reply from to_click.php");

                            // undo highlighted squares
                            remove_highlights();

                            // move piece
                            ctx.clearRect(prev_click.col * 100, prev_click.row * 100, 100, 100);
                            ctx.putImageData(before_highlight_imgs[0], col_clicked * 100, row_clicked * 100);

                            var toClick = {row: row_clicked, col: col_clicked};
                            // update local json
                            update_json(toClick);

                            // clear the highlight array. 
                            before_highlight_imgs = [];

                            // clear prev_click object.
                            prev_click = { "row": null, "col": null };

                            // Change turn ownership
                            if (WHITE_TURN ? WHITE_TURN = false : WHITE_TURN = true);

                            // increment click counter
                            click_counter++;

                            // $("canvas#gameCanvas").bind("click");

                        },
                        error: function (xhr, desc, err) {
                            console.log("No reply from to_click.php");
                        }
                    }); // end .ajaxTO

                 } // end if (selected_valid_destination)

                            //           else
                            //           {
                            //                // Show message for Invalid Destination
                            //           }
                
                
            } // end ajaxTO else undo move condition
            
        } // end if(from || to)
    
    }); // end click handler .ajax
    
}); // end canvas#gameCanvas


//function handleFromClick(){
//    
//}
//    
//function handleToClick(){
//    
//}
//function processSuccess_FromClick(){
//    
//}
//
//function processSuccess_ToClick(){
//    
//}



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