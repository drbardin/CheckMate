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
    
    // pristine black pieces
    var bP_img = new Image();
    var bN_img = new Image();
    var bB_img = new Image();
    var bR_img = new Image();
    var bQ_img = new Image();
    var bK_img = new Image();
    
    // pristine white pieces
    var wP_img = new Image();
    var wN_img = new Image();
    var wB_img = new Image();
    var wR_img = new Image();
    var wQ_img = new Image();
    var wK_img = new Image();

    var NUM_ROWS;
    var SQR_SIZE = h / 8;
    var WHITE_TURN;
    
    var CLIENT_UNAME=" ";  // this client's username
    var CLIENT_COLOR=" ";  // this client's color
    var OPPO_UNAME=" ";    // this client's opponent
    var MY_TURN=false;    // bool client's turn
    
    var CUR_TURN=1; // current turn #
    var CUR_BOARD;
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
        
        // call method to set up fresh chessboard
        setNewBoard();
        
        pieces.onload = putPiecesOnBoard;
        
        // pristine black pieces (col, row, width, height)
        var bP_img = ctx.getImageData(0, 100, 100, 100);
        var bN_img = ctx.getImageData(100, 0, 100, 100);
        var bB_img = ctx.getImageData(200, 0, 100, 100);
        var bR_img = ctx.getImageData(0, 0, 100, 100);
        var bQ_img = ctx.getImageData(400, 0, 100, 100);
        var bK_img = ctx.getImageData(300, 0, 100, 100);
    
        // pristine white pieces
        var wP_img = ctx.getImageData(0, 600, 100, 100);
        var wN_img = ctx.getImageData(100, 0, 100, 100);
        var wB_img = ctx.getImageData(200, 0, 100, 100);
        var wR_img = ctx.getImageData(700, 0, 100, 100);
        var wQ_img = ctx.getImageData(400, 0, 100, 100);
        var wK_img = ctx.getImageData(300, 0, 100, 100);
        
        // query server for player names, this.color
        // GET: client username, client color, opponent username, turn_number, board_rep
        $.ajax({
            type: 'GET',
            url: 'init_draw_ajax.php',
            ContentType: "application/json; charset=utf-8",
            //dataType: "json",
            success: function (data, textStatus, jqXHR) {
                console.log("Heard reply from init_draw_ajax.php");
                //console.log(data);

                var p_data = JSON.parse(data);

                // Set the globals
                CLIENT_UNAME = p_data[0];
                CLIENT_COLOR = p_data[1];
                OPPO_UNAME   = p_data[2];
                CUR_TURN = p_data[3];
                CUR_BOARD = p_data[4];
                console.log(CUR_BOARD);
                if (CLIENT_COLOR === 'w') {
                    if (CUR_TURN % 2 != 0) { 
                        MY_TURN = true;
                        $("canvas#gameCanvas").off("click", clickEvents);
                        $("canvas#gameCanvas").on("click", clickEvents);
                    }
                    else {
                        MY_TURN = false;
                        $("canvas#gameCanvas").off("click", clickEvents);
                    }
                }
                
                else if (CLIENT_COLOR === 'b') {
                    if (CUR_TURN % 2 === 0) {
                        MY_TURN = true;
                        $("canvas#gameCanvas").off("click", clickEvents);
                        $("canvas#gameCanvas").on("click", clickEvents);
                    }
                    else {
                        MY_TURN = false;
                        $("canvas#gameCanvas").off("click", clickEvents);
                    }
                }
                
                // call the add client username function.
                addClientUserName(CLIENT_UNAME, CLIENT_COLOR, OPPO_UNAME);
            },
            error: function (xhr, desc, err) {
                console.log("No reply from init_draw_ajax.php");
                console.log(desc);
                console.log(err);  
            }
        });
    }
    draw();
    
    (function waitForTurn() {
        setTimeout(function(){
            $.ajax({
                type: 'GET',
                url: 'check_turn_ajax.php',
                ContentType: "application/json; charset=utf-8",
                success: function (data, textStatus, jqXHR) {
                    console.log("Heard reply from check_turn_ajax.php");
                    //console.log(data);
                    var p_data = JSON.parse(data);
                    if (MY_TURN != p_data[0]) {
                        //update client
                        function updateClient() {
                            $.ajax( {
                                type: 'GET',
                                url: 'update_client_ajax.php',
                                ContentType: "application/json; charset=utf-8",
                                success: function (data, textStatus, jqXHR) {
                                    console.log("Heard reply from update_client_ajax.php");
                                    //console.log(data);
                                    var p_data = JSON.parse(data);
                                    CUR_TURN = p_data[0];
                                    //console.log(p_data);
                                    turnChange();
                                    console.log("The turn is now "+CUR_TURN);
                                },
                                error: function (xhr, desc, err) {
                                    console.log("No reply from update_client_ajax.php");
                                    console.log(desc);
                                    console.log(err);
                                }
                            });
                        }
                        updateClient();
                    }
                    if (MY_TURN)
                    {
                        $("canvas#gameCanvas").off("click", clickEvents);
                        $("canvas#gameCanvas").on("click", clickEvents);
                        console.log("It's your turn, "+CLIENT_UNAME+".");
                    }
                    else
                    {
                        $("canvas#gameCanvas").off("click", clickEvents);
                        console.log("It is my opponent "+OPPO_UNAME+"'s turn.");
                    }
                    waitForTurn();
                },
                error: function (xhr, desc, err) {
                    console.log("No reply from check_turn_ajax.php");
                    console.log(desc);
                    console.log(err);
                }
            });
        }, 8000);
    })();
    
    // JSON wrapped in function so can be used as a new game initializer.
   function setNewBoard() {
        // two arrays, one black, one white. Their positions are 0-15. 
        json = {
            "black": [ { 'piece': ROOK,  'row': 0, 'col': 0, 'status': true, 'id':110},
                       { 'piece': KNIGHT,'row': 0, 'col': 1, 'status': true, 'id':120},
                       { 'piece': BISHOP,'row': 0, 'col': 2, 'status': true, 'id':130},
                       { 'piece': QUEEN, 'row': 0, 'col': 3, 'status': true, 'id':140},
                       { 'piece': KING,  'row': 0, 'col': 4, 'status': true, 'id':150},
                       { 'piece': BISHOP,'row': 0, 'col': 5, 'status': true, 'id':131},
                       { 'piece': KNIGHT,'row': 0, 'col': 6, 'status': true, 'id':121},
                       { 'piece': ROOK,  'row': 0, 'col': 7, 'status': true, 'id':111},
                       { 'piece': PAWN,  'row': 1, 'col': 0, 'status': true, 'id':100},
                       { 'piece': PAWN,  'row': 1, 'col': 1, 'status': true, 'id':101},
                       { 'piece': PAWN,  'row': 1, 'col': 2, 'status': true, 'id':102},
                       { 'piece': PAWN,  'row': 1, 'col': 3, 'status': true, 'id':103},
                       { 'piece': PAWN,  'row': 1, 'col': 4, 'status': true, 'id':104},
                       { 'piece': PAWN,  'row': 1, 'col': 5, 'status': true, 'id':105},
                       { 'piece': PAWN,  'row': 1, 'col': 6, 'status': true, 'id':106},
                       { 'piece': PAWN,  'row': 1, 'col': 7, 'status': true, 'id':107},
                     ],
            "white": [ { 'piece': ROOK,  'row': 7, 'col': 0, 'status': true,'id':210},
                       { 'piece': KNIGHT,'row': 7, 'col': 1, 'status': true,'id':220},
                       { 'piece': BISHOP,'row': 7, 'col': 2, 'status': true,'id':230},
                       { 'piece': QUEEN, 'row': 7, 'col': 3, 'status': true,'id':240},
                       { 'piece': KING,  'row': 7, 'col': 4, 'status': true,'id':250},
                       { 'piece': BISHOP,'row': 7, 'col': 5, 'status': true,'id':231},
                       { 'piece': KNIGHT,'row': 7, 'col': 6, 'status': true,'id':221},
                       { 'piece': ROOK,  'row': 7, 'col': 7, 'status': true,'id':211},
                       { 'piece': PAWN,  'row': 6, 'col': 0, 'status': true,'id':200},
                       { 'piece': PAWN,  'row': 6, 'col': 1, 'status': true,'id':201},
                       { 'piece': PAWN,  'row': 6, 'col': 2, 'status': true,'id':202},
                       { 'piece': PAWN,  'row': 6, 'col': 3, 'status': true,'id':203},
                       { 'piece': PAWN,  'row': 6, 'col': 4, 'status': true,'id':204},
                       { 'piece': PAWN,  'row': 6, 'col': 5, 'status': true,'id':205},
                       { 'piece': PAWN,  'row': 6, 'col': 6, 'status': true,'id':206},
                       { 'piece': PAWN,  'row': 6, 'col': 7, 'status': true,'id':207},
                     ]
            };
    }
   
    function turnChange()
    {
        MY_TURN = !MY_TURN;
        if (MY_TURN) {
            $("canvas#gameCanvas").off("click", clickEvents);
            $("canvas#gameCanvas").on("click", clickEvents);
            console.log("Turn change: It is now your turn "+CLIENT_UNAME);
        }
        else {
            $("canvas#gameCanvas").off("click", clickEvents);
            console.log("Turn change: It is now your opponent "+OPPO_UNAME+"'s turn");
        }
    }
    /////////////////////////////////////////////
    //   DRAW / ERASE / COPY  PIECE FUNCTIONS  //
    /////////////////////////////////////////////
    function putPiecesOnBoard() 
    {
        var piece_index;
        var white_set = json.white;
        var black_set = json.black;
        
        // draw piece sets to board
        for(piece_index = 0; piece_index < white_set.length; piece_index++)
        {
            // params to clip white pieces from pieces.png.
            var w_clip_x = white_set[piece_index].piece * 100; 
            var w_clip_y = 0;
            var w_drawAt_col = white_set[piece_index].col * SQR_SIZE;
            var w_drawAt_row = white_set[piece_index].row * SQR_SIZE;
            
            // params to clip black pieces from pieces.png.
            var b_clip_x = black_set[piece_index].piece * 100; 
            var b_clip_y = 100;
            var b_drawAt_col = black_set[piece_index].col * SQR_SIZE;
            var b_drawAt_row = black_set[piece_index].row * SQR_SIZE;
            
            // draw the white image.
            ctx.drawImage(pieces, w_clip_x, w_clip_y, 100, 100, w_drawAt_col, w_drawAt_row, 100, 100);
            
            // draw the black image
            ctx.drawImage(pieces, b_clip_x, b_clip_y, 100, 100, b_drawAt_col, b_drawAt_row, 100, 100)
        }
    }
    
    function remove_PieceImage(row, col)
    {
        // remove image of piece at this row and column.    
        ctx.clearRect(col * 100, row * 100, 100, 100);
    }
    
    function draw_PieceImage_To_Board(piece_image, row, col)
    {
        ctx.putImageData(piece_image, col*100, row*100);
    }
    
    function move_Piece(source_coords, target_coords)
    {
        var source_row = source_coords.row * 100;
        var source_col = source_coords.col * 100;
        var target_row = target_coords.row * 100;
        var target_col = target_coords.col * 100;
        
        // get image data for source piece.
        var piece_moving = ctx.getImageData(source_col, source_row, 100, 100);
        
        // remove the image currently at this source
        ctx.clearRect(source_col, source_row, 100, 100);
        
        // "move" the piece by drawing the data on the new row and col.
        ctx.putImageData(piece_moving, target_col, target_row);    
        
    }
    /////////////////////////////////////////////////////
    //  END   DRAW / ERASE / COPY  PIECE FUNCTIONS     //
    /////////////////////////////////////////////////////

    
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
    function clickEvents(event) {
        // Get (x,y) of mouse click ( pageX works best in this situation. )
        // NOTE: (0,0) is top-left corner of canvas. 
        var x = event.pageX - $("canvas#gameCanvas").offset().left;
        var y = event.pageY - $("canvas#gameCanvas").offset().top;

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
            
            //$("canvas#gameCanvas").off("click", clickEvents);
            
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
                        
                      //  $("canvas#gameCanvas").on("click", clickEvents);
                    },
                    error: function (xhr, desc, err) {
                        console.log("No reply from from_click.php");
                        console.log(desc);
                        console.log(err);  
                    }
                });    
        } 
        else // TO_CLICK condition
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
                // Loop through highlighted squares, which signify legal moves, and check 
                // player is going to a valid destination. 
                // Start at i = 1 so the piece can't capture itself.  
                for(var i = 1; i < sqrs_to_highlight.length; i++) 
                {
                    if(sqrs_to_highlight[i].row === row_clicked && sqrs_to_highlight[i].col === col_clicked)
                    {
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
                }
            }
        } // end if(from || to)
    
    }// end click
    
}); // end canvas#gameCanvas
                              