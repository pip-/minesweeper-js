
<?php
    if ($_SERVER['HTTPS'] !== 'on') {
        $redirectURL = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        header("Location: $redirectURL");
        exit;
    }

	if(!session_start()) {
        header("Location: error.php");
        exit;
    }

	$loggedIn = empty($_SESSION['loggedin']) ? false : $_SESSION['loggedin'];
	if (!$loggedIn) {
        header("Location: ms.php");
        exit;
    }
?>

<style>
    #wrap{
        margin-left: 30vw;
        margin-right: auto;
        margin-top: 25vh;
        display: block;
    }
    iframe{
        margin-left: auto;
        margin-right: auto;
    }
    body{
        overflow: hidden;
    }
</style>

<html>
<head>
    <title>Minesweeper Guide</title>
    <script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
    <link href="minesweeper.css" type="text/css">
    <link rel="stylesheet" href="https://bootswatch.com/spacelab/bootstrap.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <link href="assets/stickyfooter.css" rel="stylesheet">

</head>
<body>
<div id="wrap">
    <iframe width="560" height="315" src="https://www.youtube.com/embed/8aph-8bCRw4" frameborder="0" allowfullscreen></iframe>
    <h3><a href="logout.php">Return/Log Out</a></h3>
</div>

<footer class="footer navbar-fixed-bottom">
    <div class="row">
        <div class="col-sm-3">
            <h1><em>BombSweeper</em></h1>
    </div>
</footer>
</body>
</html>