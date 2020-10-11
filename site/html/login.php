<!-- header goes here -->
<?php
    include('fragments/header.php');
?>

<?php
    $error = false;
    if (isset($_GET["login"]))
    {
        $db = new PDO('sqlite:/usr/share/nginx/databases/database.sqlite');
        $sql = "SELECT * from users where username = \"" . $_POST["username"] . "\";";

        $result = $db->query($sql)->fetchAll()[0];
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
    <h2>Please login</h2>
    <hr>
    <div class="box" style="padding-right: 390px;">
        <form action="login.php?login=true" class="form" method="POST" id="form">
            <div class="form-group">
                <label for="username">
                    Username:
                    <input type="text" class="form-control" name="username" id="username" placeholder="Enter username">
                </label>
            </div>
            <div class="form-group">
                <label for="password">
                    Password :
                    <input type="password" class="form-control" name="password" id="password"
                           placeholder="Enter password">
                </label>
            </div>
            <input type="submit" name="submitForm" value="LOGIN"/>
        </form>
    </div>
    <?php
        if ($error) {
            echo '<hr><p style="text-align: center">Check the credentials you entered, if it still doesn\'t work your account might be disabled...</p>';
        }
    ?>
</div>
<!-- footer goes here -->
<?php
    include('fragments/footer.php');
?>