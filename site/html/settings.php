<!-- header goes here -->
<?php
    include('fragments/header.php');

    //    $username = $_SESSION["login"];

    include('fragments/left_side_bar.php');
?>

<div class="right_section">
    <div style="height: 200px">
        <h1>
            Change your password
        </h1>
        <hr>
        <form style="float: left" method="post">
            <input type="hidden" name="username" value="<?= $loginName; ?>"/>
            <!-- TODO : change CSS to have labels aligned -->
            <label for="cur_pwd" style="width: 390px"> Enter current password :
                <input style="float: right" type="password" name="cur_pwd" value="<?= $_POST['cur_pwd'] ?>" required/>
            </label>
            <br>
            <label for="new_pwd" style="width: 390px"> Enter new password :
                <input style="float: right" type="password" name="new_pwd" value="<?= $_POST['new_pwd'] ?>" required/>
            </label>
            <br>
            <label for="confirm_pwd" style="width: 390px"> Confirm new password :
                <input style="float: right" type="password" name="confirm_pwd" value="<?= $_POST['confirm_pwd'] ?>" required/>
            </label>

            <input type="submit" name="confirm" value="CONFIRM"/>
        </form>
    </div>


    <?php

        if (isset($_POST['cur_pwd']) && isset($_POST['new_pwd']) && isset($_POST['confirm_pwd']))
        {
            ?>
            <hr>
            <p style="float: end">
                <?php
                    $sth = $db->prepare('SELECT password FROM users WHERE username = ?');
                    $sth->execute(array($loginName));
                    $check_pwd = $sth->fetch()[0];

                    // if the user entered the correct current password and matching new passwords, we modify the password
                    if (($check_pwd == $_POST['cur_pwd']) && ($_POST['new_pwd'] == $_POST['confirm_pwd']))
                    {
                        if ($check_pwd == $_POST['new_pwd'])
                        {
                            print_r("You can't reuse the same password!");
                        }
                        else
                        {
                            $sth = $db->prepare('UPDATE users SET password = ? WHERE username = ?;');
                            $res = $sth->execute(array($_POST['confirm_pwd'], $loginName));

                            if (!$res)
                            {
                                print_r("Something went wrong, the password could not be changed");
                            }
                        }
                    } else
                    {
                        print_r("The passwords you entered do not match and/or your password is incorrect");
                    }
                ?>
            </p>
            <?php

        }
    ?>

</div>

<!-- footer goes here -->
<?php
    include('fragments/footer.php');
?>



