<!DOCTYPE html>


<?php
//include('/usr/share/nginx/html/functions/connectDB.php');
include('functions/connectDB.php');

?>

<html>
<head>
    <meta charset="UTF-8">
    <title>STI - Projet 1</title>
    <meta name="description" content="A simple chatting platform">
    <meta name="keywords" content="chat, STI, security">
    <link href="css/style.css" rel="stylesheet" type="text/css">
</head>
<body>

<div id="wrapper">

    <div id="header">

        <div class="top_banner">
            <h1>STI - Projet 1</h1>
            <p>Application de communication sécurisée</p>
        </div>

        <div class="navigation" >
            <ul>
                <li><a href="/">Home</a></li>
                <li><a href="about.php">Contact</a></li>
                <li style="float: right"><a href="#"> Register<?php //connectDB();?> </a></li>
                <li style="float: right"><a href="#"> Login<?php //connectDB();?> </a></li>
                <li style="float: right"><a href="#"> <?php //connectDB();?> </a></li>
            </ul>
        </div>

    </div>