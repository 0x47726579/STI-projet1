<?php
// src : https://github.com/BestsoftCorporation/PHP-SQLITE-registration-login-form/blob/master/login.php
session_start();
if (isset($_GET["login"])){
    class MyDB extends SQLite3
    {
        function __construct()
        {
            $this->open('database.sqlite');
        }
    }
    $db = new MyDB();
    if(!$db){
        echo $db->lastErrorMsg();
    } else {
        //echo "Opened database successfully\n";
    }

    $sql ='SELECT * from USER where USERNAME="'.$_POST["username"].'";';


    $ret = $db->query($sql);
    while($row = $ret->fetchArray(SQLITE3_ASSOC) ){
        $id=$row['ID'];
        $username=$row["USERNAME"];
        $password=$row['PASSWORD'];
    }
    if ($id!=""){
        if ($password==$_POST["password"]){
            $_SESSION["login"]=$username;
            header('Location: index.php');
        }else{
            echo "Wrong Password";
        }
    }else{
        echo "User does not exist, please register to continue!";
    }
    //echo "Operation done successfully\n";
    $db->close();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Log in</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
    <h2>Login</h2>
    <form role="form" action="login.php?login=true">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" class="form-control" id="username" placeholder="Enter username">
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" placeholder="Enter password">
        </div>
        <button type="enter" class="btn btn-default">Enter</button>
    </form>
</div>

</body>
</html>
