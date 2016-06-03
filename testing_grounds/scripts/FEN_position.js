//  A chess game's position, in FEN, is defined the following way:
//      - A FEN record contains six fields.
//      - The separator between fields is a space.
//      - The fields are
//          1.) Piece Placement (from White's perspective).
//
//                      Each rank is described, starting with rank '8'
//                      and ending with rank '1'; within each rank,
//                      the contents of each square are described 
//                      from file 'a' through file 'h'.
//
//                      Following the Standard Algebraic Notation (SAN),
//                      each piece is identified by a single letter
//                      i.e.) pawn   = "P",
//                            knight = "N",
//                            bishop = "B",
//                            rook   = "R",
//                            queen  = "Q",
//                            king   = "K".
//                      White pieces are designated with upper-case 
//                      letters ("PNBRQK") while black peices use
//                      lower-case ("pnbrqk").
//                      
//                      Empty squares are noted using digits 1 through 8
//                      (the number of empty squares), and "/" separates
//                      ranks.
//
//          2.) Active Color
//                      
//                      White moves next = "w",
//                      Black moves next = "b".
//
//          3.) Castling Availability.
//
//                      If neither side can castle, this is "-".
//                      Otherwise, this has one or more letters, 
//                      i.e.) White can castle kingside  = "K",
//                            White can castle queenside = "Q",
//                            Black can castle kingside  = "k",
//                            Black can castle queenside = "q".
//
//          4.) En Passante Target (in SAN notation). 
//                      
//                      If there's no en passante target square,
//                      this is "-".
//                      If a pawn has just made a two square move, 
//                      this is the position 'behind' the pawn.
//                      This is recorded regardless of whether there
//                      is a pawn in position to make an en passant 
//                      capture.
//                
//          5.) Halfmove Clock
//
//                      This is the number of halfmoves since the last 
//                      capture or pawn advance. This is used to determine
//                      if a draw can be claimed under fifty-move rule.
//
//          6.) Fullmove Number
//
//                      This is the number of the full move. It starts at 1
//                      and is incremented after Black's move.
//
var FEN_position = function (fen_string) {
    "use strict";
    // Check that fen_string is in proper FEN notation.         
    function formatCheckFEN(input) {
            //TODO
    }
    // Parse an FEN string and return the Piece Placement field (1)
    function parsePiecePlacement(input) {
            //TODO    
    }
    // Parse an FEN string and return the Active Color field (2)
    function parseActiveColor(input) {
            //TODO
    }
    // Parse an FEN string and return the Castling Availability (3)
    function parseCastlingAvailablity(input) {
            //TODO
    }
    // Parse an FEN string and return the En Passante Target (4)
    function parseEnPassanteTarget(input) {
            //TODO
    }
    // Parse an FEN string and return the Halfmove Clock (5)
    function parseHalfmoveClock(input) {
            //TODO
    }
    // Parse an FEN string and return the Fullmove Number (6)
    function parseFullmoveNumber(input) {
            //TODO
    }
    var piece_placement = parsePiecePlacement(fen_string),
        active_color = parseActiveColor(fen_string),
        castling_availability = parseCastlingAvailablity(fen_string),
        en_passante_target = parseEnPassanteTarget(fen_string),
        halfmove_clock = parseHalfmoveClock(fen_string),
        fullmove_number = parseFullmoveNumber(fen_string);
        
    this.getPiecePlacement = function () {
        return piece_placement;
    };
    this.getActiveColor = function () {
        return active_color;
    };
    this.getCastlingAvailability = function () {
        return castling_availability;
    };
    this.getEnPassanteTarget = function () {
        return en_passante_target;
    };
    this.getHalfmoveClock = function () {
        return halfmove_clock;
    };
    this.getFullmoveNumber = function () {
        return fullmove_number;
    };
};