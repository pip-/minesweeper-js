<?php
if ($_SERVER['HTTPS'] !== 'on') {
    $redirectURL = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header("Location: $redirectURL");
    exit;
}

// http://us3.php.net/manual/en/function.session-start.php
if (!session_start()) {
    // If the session couldn't start, present an error
    header("Location: error.php");
    exit;
}


// Check to see if the user has already logged in
$loggedIn = empty($_SESSION['loggedin']) ? false : $_SESSION['loggedin'];

if ($loggedIn) {
    header("Location: login/page1.php");
    exit;
}

$action = empty($_POST['action']) ? '' : $_POST['action'];
//$action= $_POST['action'];

if($action == 'register') {
    handle_register();
} else {
    minesweeper();
    exit;
}

function handle_register(){
    $register_username = empty($_POST['signup-username']) ? '' : $_POST['signup-username'];
    $register_password = empty($_POST['signup-password']) ? '' : $_POST['signup-password'];

    // Require the credentials
    require_once 'db.conf';

    // Connect to the database
    $mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

    // Check for errors
    if ($mysqli->connect_error) {
        $error = 'Error: ' . $mysqli->connect_errno . ' ' . $mysqli->connect_error;
        print_r($error);
        require "error.php";
        exit;
    }

    // Build query
    $query = "INSERT INTO users(username, password) VALUES ('$register_username', '$register_password')";

    // Run the query
    $mysqliResult = $mysqli->query($query);
    if($mysqliResult == 1){
        echo "<b>Sign Up Success!</b><br><br><a href=\"https://babbage.cs.missouri.edu/~pg3f4/minesweeper/ms.php\">Return to Game</a>";
    } else{
        echo "Sign up failed. Try a different username";
    }
    // Close the results
    $mysqliResult->close();
    // Close the DB connection
    $mysqli->close();

    require "ms.php";
}


function minesweeper()
{
    $username = "";
    $error = "";
    require "error.php";
    exit;
}

?>