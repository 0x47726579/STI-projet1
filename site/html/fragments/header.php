<!DOCTYPE html>


<?php
    include('functions/connectDB.php');
    include('functions/utils.php');
    session_start();

    if (!isset($_SESSION['login']))
    { //if login in session is not set
        if ($_SERVER['PHP_SELF'] != "/login.php")
        {  // important to check if we're not redirecting login.php onto itself
            utils::redirect();
        }
    } else
    {
        $loginName = $_SESSION['login'];

        $db = connectDB();
        $sth = $db->prepare('SELECT active FROM users WHERE username =  ?');
        $sth->execute(array($loginName));
        $result = $sth->fetchAll();
        if ($result == 0)
        {
            utils::redirect("logout.php");
        }
    }

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

        <div class="navigation">

            <?php if (!isset($_SESSION['login'])) { ?>
                <ul>
                    <li><a href="/">Home</a></li>
                    <li style="float: right;"><a href="login.php"> Login </a></li>
                </ul>
            <?php } else { ?>
                <ul>
                    <li><a href="/">Home</a></li>
                    <li><a href="mailbox.php">Mailbox</a></li>
                    <?php
                        $sth = $db->prepare('SELECT r.roleName FROM role AS r INNER JOIN users AS u on u.roleID = r.roleID WHERE u.username =  ?');
                        $sth->execute(array($loginName));
                        $result = $sth->fetchAll();
                        if ($result[0][0] == "admin")
                        { ?>
                            <li><a href="administration.php"> Administration</a></li>
                        <?php } ?>

                    <li style="float: right; border-right:0;"><a href="logout.php"> Logout </a>
                    </li>
                    <li style="float: right;"> Welcome <?= $loginName ?></li>
                    <li style="float: right;"></li>
                </ul>
            <?php } ?>
        </div>

    </div>
    <div id="page_content">