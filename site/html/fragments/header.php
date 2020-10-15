<!DOCTYPE html>

<?php
    // everytime another file includes this file, it gets a connection to the database
    include('functions/connectDB.php');
    include('functions/utils.php');
    session_start();

    if (!isset($_SESSION['login']))
    { //if login in session is not set
        if ($_SERVER['PHP_SELF'] != "/login.php")
        {  // important to check if we're not redirecting login.php onto itself
            utils::redirect();
        }
    } else { // if login in session is set
        $loginName = $_SESSION['login'];

        $db = connectDB();
        $sth = $db->prepare('SELECT active, roleID FROM users WHERE username =  ?');
        $sth->execute(array($loginName));
        $result = $sth->fetchAll();

        if ($result[0]["active"] == 0)  // booleans in SQLite are 0 or 1 integers
        {
            utils::redirect("logout.php");
        }

        // we don't want someone who isn't admin (roleID 1)
        if (substr($_SERVER['PHP_SELF'], 0, 15) == "/administration" && $result[0]["roleID"] != 1)
        {  // important to check if we're not redirecting login.php onto itself
            utils::redirect("");
        }
    } // END if(isset($_SESSION['login']))

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>STI - Project 1</title>
    <meta name="description" content="A simple chatting platform">
    <meta name="keywords" content="chat, STI, security">
    <link rel="stylesheet" href="css/style.css" type="text/css">
</head>
<body>

<div id="wrapper">

    <div id="header">

        <div class="top_banner">
            <h1>STI - Project 1</h1>
            <p>This is a secure communication platform!</p>
        </div>
        <!-- if the login in session is not set, we display only the login page -->
        <?php if (!isset($_SESSION['login'])) { ?>
            <div class="navigation">
                <ul>
                    <li><a href="/">Home</a></li>
                    <li><a href="login.php">Login</a></li>
                </ul>
            </div>
        <?php } else { ?>
            <!-- if the login in session is set, we allow access to the website's features -->
            <h6 style="float: right; margin-top: 20px;margin-right: 10px">Welcome <?= $loginName ?>[<a
                        href="../settings.php">Settings</a>|<a href="logout.php">Logout</a>]</h6>
            <div class="navigation">
                <ul>
                    <li><a href="/">Home</a></li>
                    <li><a href="mailbox.php">Mailbox</a></li>
                    <?php
                        $sth = $db->prepare('SELECT r.roleID FROM role AS r INNER JOIN users AS u on u.roleID = r.roleID WHERE u.username =  ?');
                        $sth->execute(array($loginName));
                        $result = $sth->fetchAll();
                        if ($result[0][0] == 1) // if we are admin
                        { ?>
                            <li><a href="administration.php"> Administration</a></li>
                        <?php } ?>
                </ul>
            </div>
        <?php } ?>

    </div>
    <div id="page_content">