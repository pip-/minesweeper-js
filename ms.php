<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>Minesweeper</title>
    <script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
    <link rel="stylesheet" href="https://bootswatch.com/spacelab/bootstrap.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <link href="assets/stickyfooter.css" rel="stylesheet">
    <script src="assets/login-signup-modal-window/js/main.js"></script>
    <script src="assets/login-signup-modal-window/js/modernizr.js"></script>
    <script src="minesweeper.js"></script>
    <link rel="stylesheet" href="minesweeper.css">
    <link href="assets/login-signup-modal-window/css/reset.css" rel="stylesheet">
    <link href="assets/login-signup-modal-window/css/style.css" rel="stylesheet">
</head>
<body>
<?php session_destroy(); ?> <!--- No reason for user to remain logged in over multiple visits --->
<div id="wrap">
    <div id="page_container">
        <div id="main_container" class="">

            <div id="settings_container" class="well">
                <div class="row">
                    <div class="">
                        <p id="bombs" class="counter">99</p>
                    </div>
                    <div class="">
                        <p id="timer" class="counter">99</p>
                    </div>
                </div>
            </div>

            <div id="game_container"></div>
            <br>
        </div>
    </div>
    <footer class="footer navbar-fixed-bottom">
        <div class="row">
            <div class="col-sm-3">
                <h1><em>BombSweeper</em></h1>
            </div>
            <div class="col-sm-3">
                <div class="input-group">
                    <span class="input-group-addon"> Size </span>
                    <input type="number" id="size" class="form-control" value="20">
                </div>
            </div>
            <div class="col-sm-3">
                <div class="input-group">
                    <span class="input-group-addon">Bombs</span>
                    <input type="number" id="numBombs" class="form-control" value="40">
                </div>
            </div>
            <div class="col-sm-3">
                <button class="btn btn-primary btn-sm" id="ChangeP">Generate</button>
            </div>
        </div>
    </footer>
</body>
</html>