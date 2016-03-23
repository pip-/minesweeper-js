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
    header("Location: video.php");
    exit;
}

$action = empty($_POST['action']) ? '' : $_POST['action'];
//$action= $_POST['action'];

if($action == 'login') {
    handle_login();
} else {
    //minesweeper();
    exit;
}

function handle_login()
{
    $login_username = empty($_POST['signin-username']) ? '' : $_POST['signin-username'];
    $login_password = empty($_POST['signin-password']) ? '' : $_POST['signin-password'];

    // Require the credentials
    require_once 'db.conf';

    // Connect to the database
    $mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

    // Check for errors
    if ($mysqli->connect_error) {
        $error = 'Error: ' . $mysqli->connect_errno . ' ' . $mysqli->connect_error;
        print $error;
        require "error.php";
        exit;
    }

    // http://php.net/manual/en/mysqli.real-escape-string.php
    $login_username = $mysqli->real_escape_string($login_username);
    $login_password = $mysqli->real_escape_string($login_password);

    // Build query
    $query = "SELECT id FROM users WHERE userName = '$login_username' AND password = '$login_password'";

    // Run the query
    $mysqliResult = $mysqli->query($query);

    // How many records were returned?
    $match = $mysqliResult->num_rows;

    // Close the results
    $mysqliResult->close();
    // Close the DB connection
    $mysqli->close();


    // We will check for matches instead
    if (!empty($match)) {
        $_SESSION['loggedin'] = $login_username;
        header("Location: video.php");
        exit;
    }

        echo 'Error: Incorrect username or password';

}


function minesweeper()
{
    $username = "";
    $error = "";
    require "error.php";
    exit;
}

?>