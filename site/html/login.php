<!-- header goes here -->
<?php
    // including the header.php file allows this file to open a connection to the database
    include('fragments/header.php');
?>

<?php
    $error = false;
    if (isset($_GET["login"]))
    {
        sleep(rand(1,100) / 100);
        // here we retrieve the user info linked to the username entered
        $db = new PDO('sqlite:/usr/share/nginx/databases/database.sqlite');
        $sth = $db->prepare('SELECT id, username, password, active FROM users WHERE username = ?');
        $username = $_POST["username"];
        $sth->execute(array($username));
        $result = $sth->fetchAll()[0];

        $id = $result['id'];
        $username = $result['username'];
        $password = $result['password'];
        $active = $result['active'];

        // we check if the user exists in our database, if he's active and if the password is correct
        if ($id != "" and $active and $password == $_POST["password"])
        {
            $_SESSION["login"] = $username;
            header('Location: index.php');
            exit;
        }
        else
        {
            $error = true;
        }

    } // END if (isset($_GET["login"]))

?>

<!-- left side bar goes here -->
<?php
    include('fragments/left_side_bar.php');
?>

<!-- Displaying the login page -->
<div class="right_section">
    <div style="height: 200px">

        <h2>Please login</h2>
        <hr>
        <form style=" float: left
        " action="login.php?login=true" method="POST" id="form">
            <div class="column_one">
                <label for="username">
                    Username :
                    <input type="text"
                           name="username"
                           id="username"
                           placeholder="Enter username"
                           style="margin-left: 30px"
                           required>
                </label>
                <label for="password">
                    Password :
                    <input type="password"
                           name="password"
                           id="password"
                           placeholder="Enter password"
                           style="margin-left: 33px"
                           required>
                </label>
            </div>
            <div class="column_two">
            </div>
            <div class="column_one">
                <input type="submit" name="submitForm" value="LOGIN"/>
            </div>
        </form>

        <?php if ($error) { ?>
            <p style="text-align: left; line-height: 32px; margin-left: 310px">Check the credentials you entered, if
                it still doesn't work your account
                might be disabled...</p>
        <?php } ?>
    </div>
</div>

<!-- footer goes here -->
<?php
    include('fragments/footer.php');
?>