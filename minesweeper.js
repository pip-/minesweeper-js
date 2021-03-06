var Space = function (xVal, yVal) {
    this.image = "assets/mineu.png";
    this.xVal = xVal;
    this.yVal = yVal;
    this.bomb = false;
    this.adjBomb = 0;
    this.pressed = false;
    this.flagged = false;
    this.findAdjBomb = function (board) {
        this.adjBomb = 0;
        for (var x = this.xVal - 1; x <= this.xVal + 1; x++) {
            for (var y = this.yVal - 1; y <= this.yVal + 1; y++) {
                if (x < board.length && y < board.length && x >= 0 && y >= 0) { //Make sure checked space is inbounds
                    var curCell = board[x][y];
                    if (curCell.bomb)
                        this.adjBomb++;
                }
            }
        }
        this.updateImage();
    };

    this.updateImage = function () {
        if (this.bomb == true) {
            this.image = "assets/minebomb.png";
            return;
        }
        else switch (this.adjBomb) {
            case 0:
                this.image = "assets/mine0.png";
                break;
            case 1:
                this.image = "assets/mine1.png";
                break;
            case 2:
                this.image = "assets/mine2.png";
                break;
            case 3:
                this.image = "assets/mine3.png";
                break;
            case 4:
                this.image = "assets/mine4.png";
                break;
            case 5:
                this.image = "assets/mine5.png";
                break;
            case 6:
                this.image = "assets/mine6.png";
                break;
            case 7:
                this.image = "assets/mine7.png";
                break;
            case 8:
                this.image = "assets/mine8.png";
                break;
            default:
                this.image = "assets/mine0.png"
                break;
        }
    }
};

//Found at http://stackoverflow.com/questions/210717/using-jquery-to-center-a-div-on-the-screen
jQuery.fn.center = function () {
    this.css("position", "absolute");

    this.css("left", Math.max(0, (($(window).width() - $(this).outerWidth()) / 2) +
    $(window).scrollLeft()) + "px");
    return this;
};


$(function () {
    var height = 20;
    var width = 30;
    var size = 15;
    var board = [];
    var cell_size = 3.5;
    var numBombs = 10;
    var remainingBombs;
    var correctBombs = 0;
    var time = 0;
    var sizeMode = true;

    var startTimer = function () {
        var timer = setTimeout(function () {
            time++;
            $("#timer").text(time);
            if (time < 999) {
                setTimeout(startTimer(), 1000);
            }
        }, 1000);
    };

    //Bind enter key to generate a new game
    $("html").keypress(function (e) {
        if (e.which == 13) {
            $("#ChangeP").click();
        }
    });


    //Generate a new game
    $("#ChangeP").click(function () {
        time = 998;
        setTimeout(function () {
            time = 0;
            startTimer();
            correctBombs = 0;
            $("#timer").html("00");
            board = [];
            size = $("#size").val();
            numBombs = $("#numBombs").val();

            if (size > 60)
                size = 60;
            if (size < 15)
                size = 15;

            if (sizeMode) {
                height = size;
                width = size;
            }

            if (numBombs > height * width - 1)
                numBombs = height * width - 1;
            if (numBombs < 1)
                numBombs = 1;

            cell_size = 80 / width;

            remainingBombs = numBombs;
            $("#bombs").text(numBombs);
            $("#size").val(size);
            $("#numBombs").val(numBombs);
            $("#game_container").html("");

            for (var i = 0; i < width; i++) {
                board[i] = [];
                for (var j = 0; j < height; j++) {
                    board[i][j] = new Space(i, j)
                }
            }

            $("#game_container").css("height", height * cell_size + "vh");
            $("#game_container").css("width", width * cell_size + "vh");
            $("#settings_container").css("width", width * cell_size + "vh");

            $("#couner_container").css("padding-bottom", (width * cell_size - 23) + "px");

            $("#main_container").center();

            for (var i = 0; i < numBombs; i++) {

                var xVal = Math.floor(Math.random() * width);
                var yVal = Math.floor(Math.random() * height);
                var randSpot = board[xVal][yVal];

                while (randSpot.bomb == true) {   //Pick a new spot if curSpot already has a bomb
                    xVal = Math.floor(Math.random() * width);
                    yVal = Math.floor(Math.random() * height);
                    randSpot = board[xVal][yVal];
                }
                randSpot.bomb = true;
                board[xVal][yVal] = randSpot;
                var test = board[xVal][yVal];
            }

            display();
        }, 1100);   //Note: longer we wait for timer here, the better it functions

    });

    var reveal = function () {
        for (var x = 0; x < board.length; x++) {
            for (var y = 0; y < board.length; y++) {
                var curCell = board[x][y]
                curCell.findAdjBomb(board);
                curCell.updateImage();
                board[x][y] = curCell;
            }
        }
        display();
    };

    $("#game_container").on('click', 'img', function (event) {
        var clickedCell = event.target.id;
        var xVal = clickedCell.replace(/^\D+|\D.*$/g, "");
        var yVal = clickedCell.replace(/.*\D/g, "");
        guess(+xVal, +yVal);
        var check = board[xVal][yVal];
    });

    var display = function () {
        var htmlToAppend = '';
        $("#game_container").empty();
        for (var i = 0; i < width; i++) {
            htmlToAppend += '<row>';
            for (var j = 0; j < height; j++) {
                var k = board[i][j];
                htmlToAppend += "<img class=\"cell\" style=\"height:" + cell_size + "vh; width:" + cell_size + "vh\" id=\"" + "b_" + k.xVal + "_" + k.yVal + "\" src=\"" + k.image + "\">";
            }
            htmlToAppend += "</row>";
        }

        $('#game_container').append(htmlToAppend);
    };

    $(window).resize(function () {
        $("#main_container").center();
    })


    var updateImage = function (xVal, yVal, newImage) {
        var id = "#b_" + xVal + "_" + yVal;
        $(id).attr("src", newImage);
    };

    var guess = function (xVal, yVal) {
        var s = board.length;
        var cell = board[xVal][yVal];
        if (cell == null) {
        }
        else {
            if (cell.bomb) {
                alert("Game Over");
                $("#game_container").html("Good job");
                reveal();
                return;
            }

            if (cell.pressed) {
                return;
            }

            cell.findAdjBomb(board);
            if (!cell.flagged) {
                cell.pressed = true;
                updateImage(xVal, yVal, cell.image);
                board[xVal][yVal] = cell;
            }


            if (cell.adjBomb != 0) {
                return;
            }
            else {
                if ((xVal + 1) < width) {
                    guess(xVal + 1, yVal);
                }


                if (yVal + 1 < height) {
                    guess(xVal, yVal + 1);
                }


                if (yVal - 1 >= 0) {
                    guess(xVal, yVal - 1);
                }

                if (xVal - 1 >= 0) {
                    guess(xVal - 1, yVal);
                }


            }
        }
    }

    $("#game_container").bind('contextmenu', function (e) {
        e.preventDefault();
        var clickedCell = e.target.id;
        var xVal = clickedCell.replace(/^\D+|\D.*$/g, "");
        var yVal = clickedCell.replace(/.*\D/g, "");
        var cell = board[xVal][yVal];
        if (!cell.pressed) {
            if (!cell.flagged) {
                cell.flagged = true;
                updateImage(xVal, yVal, "assets/mineflag.png");
                remainingBombs--;
                if (cell.bomb) {
                    correctBombs++;
                }
                if (correctBombs == numBombs) {
                    alert("You win");
                    var t = time;
                    time = 999;
                    setTimeout(function () {
                        var width = $("#game_container").width();
                        var height = $("#game_container").height();
                        $("#game_container").html("<img id=\"victory\" style=\"width: 100%; height: 100%;\" src=\"http://i.imgur.com/0PoqQMo.gif\">");
                        //clearTimeout(timer);
                        $("#timer").text(t);
                    }, 1100);
                }
            }

            else if (cell.flagged) {
                cell.flagged = false;
                remainingBombs++;
                if (cell.bomb) {
                    correctBombs--;
                }
                updateImage(xVal, yVal, "assets/mineu.png");
            }
        }

        if (remainingBombs <= 0) {
            remainingBombs = 0;
        }
        if (remainingBombs >= numBombs) {
            remainingBombs = numBombs;
        }

        $("#bombs").text(remainingBombs);
    });

    $("#ChangeP").click();
});

