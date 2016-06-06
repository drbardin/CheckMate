/*jslint devel: true*/

////////////////////////
// HELPER FUNCTIONS   //
////////////////////////
var checkType = function (expected_type, val) {
    "use strict";
    if (typeof (val) !== expected_type) {
        return false;
    } else {
        return true;
    }
};
/////////////////////////////////////////////////////////////////////////////
//                            FEN DESCRIPTION                              //
/////////////////////////////////////////////////////////////////////////////
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
/////////////////////////////////////////////////////////////////////////////

                            
//////////////////////////////////////////
//~~~~~~~~~~~~ FEN OBJECT ~~~~~~~~~~~~~~//
//////////////////////////////////////////
var FEN_position = function (fen_string) {
    "use strict";
    
////////////////
// EXCEPTIONS //
////////////////
    // improper input passed to this object's constructor, expecting a string primitive.
    function inputTypeException() {
        throw new Error("InputTypeException: FEN_position input must be in the form of a string primitive.");
    }
    function improperNotationException(error_message) {
        throw new Error("ImproperNotationException: " + error_message);
    }
    function improperFieldException(error_message) {
        improperNotationException("ImproperFieldException: " + error_message);
    }
    
////////////////////////
// PRIVATE VARIABLES  //
////////////////////////
    var piece_placement,
        active_color,
        castling_availability,
        en_passante_target,
        halfmove_clock,
        fullmove_number;
    
///////////////////
// FIELD-PARSERS //
///////////////////
    // Return: string primitive
    // Descr: Parse a string primitive and return the Piece Placement field (1)
    function parsePiecePlacement(field_string) {
        // This is the most complex field to parse. 
        
        // Here is an example of what the initial board configuration would look like in proper FEN notation:
        //      "rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR"
        //           ^      ^      ^ ^ ^ ^      ^       ^
        //           |      |      | | | |      |       |
        // (rank#):  1      2      3 4 5 6      7       8
        //
        // So how to parse this...
        //      i.) Required # of ranks: 8
        //     ii.) Required # of files per rank: 8
        //    iii.) Legal characters and their corresponding # of files:
        //          a.) r,n,b,q,k,p,R,N,B,Q,K,P,1     :     1
        //          b.) 2                             :     2
        //          c.) 3                             :     3
        //          .
        //          . 
        //          h.) 8                             :     8
        //
        //    iv.) Character and max # of occurances in total:
        //              k, K                          :     1
        //              p, P                          :     8
        
        // piece placement string 
        var field_str = field_string,
        // array of rank strings
            field_arr = field_str.split("/");
            // verify length of field_field array is 8 (i.e. verify # of ranks is 8)
        if (field_arr.length() !== 8) {
            improperFieldException("Piece Placement field contained a string of improper format. Exactly 8 rank subfields were expected.");
        } else {
            //  set count for occurences of k, K, p, P to 0. 
            var k_count = 0,
                K_count = 0,
                p_count = 0,
                P_count = 0,
            // set legal characters that may be encountered (DO NOT EDIT THIS LIST WITHOUT EDITING num_files)
                legal_chars = ['r', 'n', 'b', 'q', 'k', 'p', 'R', 'N', 'B', 'Q', 'K', 'P', '1', '2', '3', '4', '5', '6', '7', '8'],
            // set # of files that each legal character takes up (DO NOT EDIT THIS LIST WITHOUT EDITING legal_chars)
                num_files = {r: 1, n: 1, b: 1, q: 1, k: 1, p: 1, R: 1, N: 1, B: 1, Q: 1, K: 1, P: 1, 1: 1, 2: 2, 3: 3, 4: 4, 5: 5, 6: 6, 7: 7, 8: 8},
            // index denoting current rank
                i = 0;
            for (i; i < 8; i = i + 1) {
                // a single rank string
                var rank_str = field_arr[i];
                if (rank_str.length() < 1 || rank_str.length() > 8) {
                    improperFieldException("Piece Placement field contained a string of improper format. Each rank subfield should have at least 1 character, and at most 8 characters.");
                }
                // index denoting current character within rank_string. 
                var j = 0;
                for (j; j < rank_str.length(); j = j + 1) {
                    var curr_char = rank_str.charAt(j),
                        file_count = 0;
                    if (legal_chars.indexOf(curr_char) === -1) {
                        improperFieldException("Piece Placement field contained a string of improper format. An invalid character was found inside a rank subfield.");
                    } else {
                        if (curr_char === 'k') {
                            if (k_count >= 1) {
                                improperFieldException("Piece Placement field contained a string of improper format. Black may not have more than 1 king.");
                            } else {
                                k_count = k_count + 1;
                            }
                        } else if (curr_char === 'K') {
                            if (K_count >= 1) {
                                improperFieldException("Piece Placement field contained a string of improper format. White may not have more than 1 king.");
                            } else {
                                K_count = K_count + 1;
                            }
                        } else if (curr_char === 'p') {
                            if (p_count >= 8) {
                                improperFieldException("Piece Placement field contained a string of improper format. Black may not have more than 8 pawns.");
                            } else {
                                p_count = p_count + 1;
                            }
                        } else if (curr_char === 'P') {
                            if (P_count >= 8) {
                                improperFieldException("Piece Placement field contained a string of improper format. White may not have more than 8 pawns.");
                            } else {
                                P_count = P_count + 1;
                            }
                        }
                        // increment the count of files represented thus far in the rank
                        file_count = file_count + num_files[curr_char];
                    }
                    // each rank should have a file_count of 8
                    if (file_count !== 8) {
                        improperFieldException("Piece Placement field contained a string of improper format. Each rank subfield should have representation equivalent to 8 files.");
                    }
                }
            }
            return field_str;
        }
    }
    // Return: string primitive
    // Descr: Parse an FEN string primitive and return the Active Color field (2)
    function parseActiveColor(field_string) {
            //TODO
    }
    // Return: string primitive
    // Descr: Parse an FEN string primitive and return the Castling Availability field (3)
    function parseCastlingAvailablity(field_string) {
            //TODO
    }
    // Return: string primitive
    // Descr: Parse an FEN string primitive and return the En Passante Target field (4)
    function parseEnPassanteTarget(field_string) {
            //TODO
    }
    // Return: string primitive
    // Descr: Parse an FEN string primitive and return the Halfmove Clock field (5)
    function parseHalfmoveClock(field_string) {
            //TODO
    }
    // Return: string primitive
    // Descr: Parse an FEN string primitive and return the Fullmove Number field (6)
    function parseFullmoveNumber(field_string) {
            //TODO
    }
    
    // Return: boolean
    // Descr: Check that fen_string primitive is in proper FEN notation.         
    function formatCheckFEN(input) {
        // verify that the input is a string.
        if (checkType("string", input) !== true) {
            inputTypeException();
        } else {
            var fen_str = input,
                fen_arr = fen_str.split(" ");
            // verify that all fields are present.
            if (fen_arr.length() !== 6) {
                // THROW EXCEPTION: There should always be 6 fields.
                improperNotationException("FEN standards dictate 6 fields, separated by whitespace.");
            } else {
                var field_1 = fen_arr[0],
                    field_2 = fen_arr[1],
                    field_3 = fen_arr[2],
                    field_4 = fen_arr[3],
                    field_5 = fen_arr[4],
                    field_6 = fen_arr[5];
                piece_placement = parsePiecePlacement(field_1);
                active_color = parseActiveColor(field_2);
                castling_availability = parseCastlingAvailablity(field_3);
                en_passante_target = parseEnPassanteTarget(field_4);
                halfmove_clock = parseHalfmoveClock(field_5);
                fullmove_number = parseFullmoveNumber(field_6);
            }
        }
    }
    
    formatCheckFEN(fen_string);
    
///////////////////////
// FEN-FIELD GETTERS //
///////////////////////
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