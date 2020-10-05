<?php
// src : https://github.com/BestsoftCorporation/PHP-SQLITE-registration-login-form/blob/master/login.php
session_start();
if (isset($_GET["login"])) {
    class MyDB extends SQLite3
    {
        function __construct()
        {
            $this->open('database.sqlite');
        }
    }

    $db = new MyDB();
    if (!$db) {
        echo $db->lastErrorMsg();
    } else {
        //echo "Opened database successfully\n";
    }

    $sql = 'SELECT * from USER where USERNAME="' . $_POST["username"] . '";';


    $ret = $db->query($sql);
    while ($row = $ret->fetchArray(SQLITE3_ASSOC)) {
        $id = $row['ID'];
        $username = $row["USERNAME"];
        $password = $row['PASSWORD'];
    }
    if ($id != "") {
        if ($password == $_POST["password"]) {
            $_SESSION["login"] = $username;
            header('Location: index.php');
        } else {
            echo "Wrong Password";
        }
    } else {
        echo "User does not exist, please register to continue!";
    }
    //echo "Operation done successfully\n";
    $db->close();
}

?>


    <!-- header goes here -->
<?php
include('fragments/header.php');
?>


    <!-- left side bar goes here -->
<?php
include('fragments/left_side_bar.php');
?>


    <div class="right_section" style="padding-left: 250px;">
        <h2>Please login</h2>
        <div class="box" style="margin-right: fill; padding-right: 390px;">
            <form role="form" action="login.php?login=true" class="form">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control" id="username" placeholder="Enter username">
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" id="password" placeholder="Enter password">
                </div>
                <input type="submit" value="LOGIN"/>
            </form>
        </div>
    </div>
    <!-- footer goes here -->
<?php
include('fragments/footer.php');
?>