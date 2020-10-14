<!-- header goes here -->
<?php
    include('fragments/header.php');
?>

<?php
    $username = $_SESSION["login"];
?>


<!-- left side bar goes here -->
<?php
    include('fragments/left_side_bar.php');
?>

<div class="right_section">
    <div class="common_content">
        <h1>
            Change your password
        </h1>
        <form style="float: left" method="post" action="?">
            <input type="hidden" name="username" value=<?php echo $username; ?>/>
            <!-- TODO : change CSS to have labels aligned -->
            <label for="cur_pwd"> Enter current password : <input type="cur_pwd" name="cur_pwd" required/>
            </label>
            <br>
            <label for="new_pwd"> Enter new password : <input type="new_pwd" name="new_pwd" required/>
            </label>
            <br>
            <label for="confirm_pwd"> Confirm new password : <input type="confirm_pwd" name="confirm_pwd" required/>
            </label>

            <input type="submit" name="confirm" value="CONFIRM"/>
        </form>

        <?php
            $db = new PDO('sqlite:/usr/share/nginx/databases/database.sqlite');

            if (isset($_POST['cur_pwd']) && isset($_POST['new_pwd']) && isset($_POST['confirm_pwd']))
            {
                $sql = 'SELECT password FROM users WHERE username = "' . $username . '";';
                $check_pwd = $db->query($sql);

                // if the user entered the correct current password and matching new passwords, we modify the password
                if ($check_pwd == $_POST['cur_pwd'] && $_POST['new_pwd'] == $_POST['confirm_pwd'])
                {
                    $req = 'UPDATE users SET password = "' . $_POST['confirm_pwd'] . '" WHERE username = "' . $username . '";';
                    $modif_pwd = $db->query($req);
                }
            }
        ?>
    </div>
</div>
</div>

<!-- footer goes here -->
<?php
    include('fragments/footer.php');
?>



