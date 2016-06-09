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
var Fen_Object  = function (fen_string) {
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
        //
        // (rank#):  8      7      6 5 4 3      2       1
        //                            |
        //                            Rank 6, 5, 4, and 3 are occupied by 8 empty squares each. 
        //                            Any # indicates that many empty squares, so for example 3pp3
        //                            would represent 3 whitespaces, two black pawns, and 3 whitespaces. 
        // So how to parse this...
        //      i.) Required # of ranks: 8
        //     ii.) Required # of files(squares) per rank: 8
        //    iii.) Legal characters and their corresponding # of files (squares) that they occupy:
        //          a.) r,n,b,q,k,p,R,N,B,Q,K,P,1     :     1
        //          b.) 2                             :     2
        //          c.) 3                             :     3
        //          .
        //          .
        //          .
        //          h.) 8                             :     8
        //
        //    iv.) Character and max # of occurances allowed (total):
        //              k, K                          :     1
        //              p, P                          :     8
        
        var field_str = field_string,         // field_str: piece placement string 
            field_arr = field_str.split("/"), // field_arr: array of rank strings
            k_count,        // k_count: current # of Black king pieces counted in this field
            K_count,        // K_count: current # of White king pieces counted in this field
            p_count,        // p_count: current # of Black pawn pieces counted in this field
            P_count,        // P_count: current # of White pawn pieces counted in this field
            legal_chars,    // legal_chars: array of legal characters that may be parsed in this field
            num_files,      // num_files: object that assigns each legal character a number of files (squares) that it represents having occupied.
            i,              // i: index denoting current rank #
            rank_str,       // rank_str: string denoting piece placement at this rank
            file_count,     // file_count: sum of file spaces described at this rank
            j,              // j: index of character to be parsed at this rank
            curr_char;      // curr_char: current character at this index of this rank
        
        // verify length of field_field array is 8 (i.e. verify # of ranks is 8)
        if (field_arr.length !== 8) {
            improperFieldException("Piece Placement field contained a string of improper format. Exactly 8 rank subfields were expected.");
        } else {
            //  set count for occurences of k, K, p, P to 0. 
            k_count = 0;
            K_count = 0;
            p_count = 0;
            P_count = 0;
            // set legal characters that may be encountered (DO NOT EDIT THIS LIST WITHOUT EDITING num_files)
            legal_chars = ['r', 'n', 'b', 'q', 'k', 'p', 'R', 'N', 'B', 'Q', 'K', 'P', '1', '2', '3', '4', '5', '6', '7', '8'];
            // set # of files that each legal character takes up (DO NOT EDIT THIS LIST WITHOUT EDITING legal_chars)
            num_files = {r: 1, n: 1, b: 1, q: 1, k: 1, p: 1, R: 1, N: 1, B: 1, Q: 1, K: 1, P: 1, 1: 1, 2: 2, 3: 3, 4: 4, 5: 5, 6: 6, 7: 7, 8: 8};
            // set index denoting current rank
            i = 8;
            for (i; i >= 1; i = i - 1) {
                // get string description of piece placement at this rank
                rank_str = field_arr[i - 1];
                file_count = 0;
                if (rank_str.length < 1 || rank_str.length > 8) {
                    improperFieldException("Piece Placement field contained a string of improper format. Each rank subfield should have at least 1 character, and at most 8 characters.");
                }
                // set index denoting current character parsed within rank_str to 0
                j = 0;
                for (j; j < rank_str.length; j = j + 1) {
                    // get character of rank_str at this index
                    curr_char = rank_str.charAt(j);
                    // verify that the character is legal
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
                    // then increment the count of files (squares) occuppied thus far in the rank
                        file_count = file_count + num_files[curr_char];
                    }
                }
                // each rank should have a file_count of 8
                if (file_count !== 8) {
                    improperFieldException("Piece Placement field contained a string of improper format. Each rank subfield should have representation such that 8 files (squares) are counted.");
                } else if (k_count === 0 && K_count === 0) {
                    improperFieldException("Piece Placement field contained a string of improper format. No kings were counted.");
                }
            }
            //successful piece placement parsing
            return field_str;
        }
    }
    // Return: string primitive
    // Descr: Parse a string primitive and return the Active Color field (2)
    function parseActiveColor(field_string) {
        // get active color field string
        var field_str = field_string;
        // verify that it is a valid string
        if (field_str !== "w" && field_str !== "b") {
            improperFieldException("Active Color field contained a string of improper format. The only permitted field contents are 'w' or 'b'. ");
        } else {
            //successful active color parsing
            return field_str;
        }
    }
    // Return: string primitive
    // Descr: Parse a string primitive and return the Castling Availability field (3)
    function parseCastlingAvailablity(field_string) {
        var field_str = field_string,
            k_count = 0,
            K_count = 0,
            q_count = 0,
            Q_count = 0,
            legal_chars = ["k", "K", "q", "Q"],
            i = 0,
            curr_char;
        if (field_str.length > 4 || field_str.length === 0) {
            improperFieldException("Castling Availability field contained a string of improper format. The field should be at least 1 character in length, and no longer than 4 characters.");
        } else if (field_str === "-") {
            // successful castling availability parsing (No Castling Availability)
            return field_str;
        } else {
            // parse through 
            for (i; i < field_str.length; i = i + 1) {
                // get current character in field string
                curr_char = field_str.charAt(i);
                // verify that the current character is a legal one
                if (legal_chars.indexOf(curr_char) === -1) {
                    improperFieldException("Castling Availability field contained a string of improper format. The field may only consist of a '-' or some combination of the following characters: 'k', 'K', 'q','Q'. ");
                } else {
                    // keep track of character counts so that duplicates can flag an error
                    if (curr_char === k_count) {
                        k_count = k_count + 1;
                    } else if (curr_char === K_count) {
                        K_count = K_count + 1;
                    } else if (curr_char === q_count) {
                        q_count = q_count + 1;
                    } else if (curr_char === Q_count) {
                        Q_count = Q_count + 1;
                    }
                }
            }
            // verify that there are no duplicate characters read
            if (k_count > 1 || K_count > 1 || q_count > 1 || Q_count > 1) {
                improperFieldException("Castling Availability field contained a string of improper format. The field may contain no duplicate characters.");
            } else {
                // successful castling availability parsing (Some Castling Availability)
                return field_str;
            }
        }
    }
    // Return: string primitive
    // Descr: Parse a string primitive and return the En Passante Target field (4)
    function parseEnPassanteTarget(field_string) {
            //TODO
        var field_str = field_string,
            legal_targets = ["a3", "b3", "c3", "d3", "e3", "f3", "g3", "h3", "a6", "b6", "c6", "d6", "e6", "f6", "g6", "h6"];
        if (field_str === "-") {
            // successful en passante target parsing (No Target)
            return field_str;
        } else if (legal_targets.indexOf(field_str) !== -1) {
            // NOTE: this is not checking to see if the piece placement field is consistent w/ the en passante target field
            // successful en passante target parsing (Legal Target Specified)
            return field_str;
        } else {
            // invalid string specified
            improperFieldException("En Passante Target field contained a string of improper format. The conceivable target squares for an en passant capture are: a3, b3, c3, ... , h3, a6, b6, c6, ... , h6.");
        }
    }
    // Return: string primitive
    // Descr: Parse a string primitive and return the Halfmove Clock field (5)
    function parseHalfmoveClock(field_string) {
        var field_str = field_string,
			num_val = +field_str;
        // verify that the field string literal is a #
		if (isNaN(field_str)) {
			improperFieldException("Halfmove Clock field contained a string of improper format. This string literal should be equivalent to a numeric value that is a natural #.");
		} else if (num_val < 0) {
			//verify that the # is not negative
            improperFieldException("Halfmove Clock field contained a string of improper format. This string literal should be a natural # (i.e. 0 or some positive integer).");
		} else {
            //// NOTE: this method is not checking for consistency w/ the piece placement field. 
			//successful halfmove clock parsing
			return field_str;
		}
    }
    // Return: string primitive
    // Descr: Parse a string primitive and return the Fullmove Number field (6)
    function parseFullmoveNumber(field_string) {
        var field_str = field_string,
			num_val = +field_str;
        // verify that the field string literal is a #
		if (isNaN(field_str)) {
			improperFieldException("Fullmove Clock field contained a string of improper format. This string literal should be equivalent to a numeric value that is a natural #.");
		} else if (num_val < 0) {
			//verify that the # is not negative
            improperFieldException("Fullmove Clock field contained a string of improper format. This string literal should be a natural # (i.e. 0 or some positive integer).");
		} else {
            // NOTE: this method is not checking for consistency w/ the piece placement field. 
			//successful fullmove clock parsing
			return field_str;
		}
    }
    
    // Return: boolean
    // Descr: Check that input string primitive is in proper FEN.         
    function formatCheckFEN(input) {
        var fen_str, // fen_str: input string that is expected to be in FEN.
            fen_arr, // fen_arr: array of six field strings that make up a proper FEN string.
            field_1, // field_1: string representation of piece placement
            field_2, // field_2: string reprsentation of active color
            field_3, // field_3: string representation of castling availaiblity
            field_4, // field_4: string representation of an en passante target
            field_5, // field_5: string representation of a halfmove clock
            field_6; // field_6: string representation of a fullmove number
        
        // verify that the input is a string.
        if (checkType("string", input) !== true) {
            inputTypeException();
        } else {
            fen_str = input;
            fen_arr = fen_str.split(" ");
            // verify that all fields are present.
            if (fen_arr.length !== 6) {
                improperNotationException("FEN standards dictate 6 fields, separated by whitespace.");
            } else {
                field_1 = fen_arr[0];
                field_2 = fen_arr[1];
                field_3 = fen_arr[2];
                field_4 = fen_arr[3];
                field_5 = fen_arr[4];
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
/////////////////////////
// PSEUDO -CONSTRUCTOR //
/////////////////////////
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

var fen = new Fen_Object("rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w KQkq - 0 1");
alert(fen.getPiecePlacement() + "\n"
      + fen.getActiveColor() + "\n"
      + fen.getCastlingAvailability() + "\n"
      + fen.getEnPassanteTarget() + "\n"
      + fen.getHalfmoveClock() + "\n"
      + fen.getFullmoveNumber());