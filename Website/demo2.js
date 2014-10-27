$(document).ready(function() {

    var canvas = $("canvas#gameCanvas")[0];
    var ctx = canvas.getContext("2d");
    var w = $("canvas#gameCanvas").width();
    var h = $("canvas#gameCanvas").height();

    var NUM_ROWS = $("64");
    var SQR_SIZE = h / 8;
    console.log(SQR_SIZE);
    
    // Listen for button click
    $("canvas#gameCanvas").click(function(e) {
        
        var x = e.pageX-$("canvas#gameCanvas").offset().left;
        var y = e.pageY-$("canvas#gameCanvas").offset().top;
        var row_clicked = Math.floor(y / SQR_SIZE);
        var col_clicked = Math.floor(x / SQR_SIZE);
        // Debug statements
        console.log("screen X: " + x);
        console.log("screen Y: " + y);
        console.log("row: " + row_clicked);
        console.log("col: " + col_clicked);
        
        //draw box around user selection
        ctx.lineWidth = 10;
        ctx.strokeStyle = "#66FF00";
        ctx.strokeRect((col_clicked * SQR_SIZE) + 5,
                       (row_clicked * SQR_SIZE) + 5,
                        SQR_SIZE - (5 * 2),
                        SQR_SIZE - (5 * 2));
        ctx.stroke;
        
        // json for outgoing click
        var data = { "row": row_clicked, "col":col_clicked};
        
        $.ajax({
            type: "POST",
            url: "proj-309-m13.cs.iastate.edu/var/www/html/loader.php",
            data: data,
            dataType: "json",
            
            success: function(data, textStatus, jqXHR) {
                if(data.success)
                    console.log("Heard reply from loader.php");
                 else
                    console.log("No reply from loader.php");
            }
        });
        
    });
});