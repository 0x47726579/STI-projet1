<!DOCTYPE html>


<?php
include('functions/connectDB.php');
session_start();
//var_dump($_SESSION);


//echo $_SERVER['PHP_SELF'];
if (!isset($_SESSION['login'])) { //if login in session is not set
    if ($_SERVER['PHP_SELF'] != "/login.php") {  // important to check if we're not redirecting login.php onto itself
        $host = $_SERVER['HTTP_HOST'];
        $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        header("Location: http://$host$uri/login.php");
        exit;
    }
}

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>STI - Projet 1</title>
    <meta name="description" content="A simple chatting platform">
    <meta name="keywords" content="chat, STI, security">
    <link rel="stylesheet" href="css/style.css" type="text/css">
</head>
<body>

<div id="wrapper">

    <div id="header">

        <div class="top_banner">
            <h1>STI - Projet 1</h1>
            <p>Application de communication sécurisée</p>
        </div>

        <div class="navigation">

            <?php
            if (!isset($_SESSION['login'])) {
                echo '<ul>
                        <li><a href="/">Home</a></li>
                        <li style="float: right;"><a href="login.php">  Login </a></li>
                      </ul> ';
            } else {
                echo '<ul>
                        <li><a href="/">Home</a></li>
                        <li><a href="mailbox.php">Mailbox</a></li>
                        <li style="float: right; border-right:#91969a dotted 0px;"><a href="logout.php">  Logout </a></li>
                        <li style="float: right;"> Welcome ' . $_SESSION['login'] . '</li>
                        <li style="float: right;"></li>
                      </ul> ';
            }
            ?>
        </div>

    </div>
    <div id="page_content">