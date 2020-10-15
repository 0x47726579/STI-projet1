<!-- header goes here -->
<?php
    include('fragments/header.php');
?>

<?php
    $error = false;
    if (isset($_GET["login"]))
    {
        sleep(1);
        $db = new PDO('sqlite:/usr/share/nginx/databases/database.sqlite');
        $sth = $db->prepare('SELECT id, username, password, active FROM users WHERE username = ?');
        $username = $_POST["username"];
        $sth->execute(array($username));
        $result = $sth->fetchAll()[0];
        $id = $result['id'];
        $username = $result['username'];
        $password = $result['password'];
        $active = $result['active'];

        if ($id != "" and $active and $password == $_POST["password"])
        {
            $_SESSION["login"] = $username;
            header('Location: index.php');
            exit;
        } else
        {
            $error = true;
        }

    }

?>

<!-- left side bar goes here -->
<?php
    include('fragments/left_side_bar.php');
?>


<div class="right_section">
    <div style="height: 200px">
        <h2>Please login</h2>
        <hr>
        <div class="column_one">
        <form style=" float: left
        " action="login.php?login=true" method="POST" id="form">
        <label for="username" style="width: 280px">
            Username :
            <input style="float: right" type="text" name="username" id="username"
                   placeholder="Enter username">
        </label>
        <label for="password" style="width: 280px">
            Password :
            <input style="float: right" type="password" name="password" id="password"
                   placeholder="Enter password">
        </label>
        <input type="submit" name="submitForm" value="LOGIN"/>
        </form>
    </div>
    <div class="column_two">
        <?php if ($error) { ?>
            <p style="text-align: left; line-height: 32px; margin-left: 310px">Check the credentials you entered, if it still doesn't work your account
                might be disabled...</p>
        <?php } ?>
    </div>
</div>
<!-- footer goes here -->
<?php
    include('fragments/footer.php');
?>