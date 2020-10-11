<!DOCTYPE html>


<?php
    include('functions/connectDB.php');
    session_start();
    //var_dump($_SESSION);


    //echo $_SERVER['PHP_SELF'];
    if (!isset($_SESSION['login']))
    { //if login in session is not set
        if ($_SERVER['PHP_SELF'] != "/login.php")
        {  // important to check if we're not redirecting login.php onto itself
            $host = $_SERVER['HTTP_HOST'];
            $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
            header("Location: http://$host$uri/login.php");
            exit;
        }
    } else {
        $db = connectDB();
        $statement = 'SELECT active FROM users WHERE username = "' . $_SESSION['login'] . '";';
        $result = $db->query($statement)->fetch()[0];
        if ( $result== 0) {
            $host = $_SERVER['HTTP_HOST'];
            $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
            header("Location: http://$host$uri/logout.php");
            exit;
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
            <h1>STI - Projet 1</h1>
            <p>This is a secure communication platform!</p>
        </div>

        <div class="navigation">

            <?php
                if (!isset($_SESSION['login']))
                {
                    echo '<ul>
                        <li><a href="/">Home</a></li>
                        <li style="float: right;"><a href="login.php">  Login </a></li>
                      </ul> ';
                } else
                {
                    echo '<ul>
                        <li><a href="/">Home</a></li>
                        <li><a href="mailbox.php">Mailbox</a></li>';
                    $db = connectDB();
                    $statement = 'SELECT r.roleName FROM role AS r INNER JOIN users AS u on u.roleID = r.roleID WHERE u.username = "' . $_SESSION['login'] . '";';
                    $result = $db->query($statement)->fetch()[0];
                    if ($result == "admin")
                    {
                        echo '<li ><a href = "administration.php" > Administration</a ></li >';
                    }
                    echo '<li style="float: right; border-right:#91969a dotted 0px;"><a href="logout.php">  Logout </a></li>
                        <li style="float: right;"> Welcome ' . $_SESSION['login'] . '</li>
                        <li style="float: right;"></li>
                      </ul> ';
                }
            ?>
        </div>

    </div>
    <div id="page_content">