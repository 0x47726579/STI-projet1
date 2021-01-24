<!-- header goes here -->
<?php
    // including the header.php file allows this file to open a connection to the database
    include('fragments/header.php');
    include('fragments/left_side_bar.php');
?>

<!-- Displaying a page allowing the user to change his password -->
<div class="right_section">
    <div style="height: 200px">
        <h2>
            Change your password
        </h2>
        <hr>
        <form method="post">
            <div class="column_one" style="width: 80%">
                <input type="hidden" name="username" value="<?= $loginName; ?>"/>
                <label for="cur_pwd"> Enter current password :
                    <input type="password"
                           name="cur_pwd"
                           value="<?= $_POST['cur_pwd'] ?>"
                           style="margin-left: 17px"
                           required/>
                </label>
                <br>
                <label for="new_pwd"> Enter new password :
                    <input type="password"
                           name="new_pwd"
                           value="<?= $_POST['new_pwd'] ?>"
                           style="margin-left: 37px"
                           required/>
                </label>
                <br>
                <label for="confirm_pwd"> Confirm new password :
                    <input type="password"
                           name="confirm_pwd"
                           value="<?= $_POST['confirm_pwd'] ?>"
                           style="margin-left: 22px"
                           required/>
                </label>
            </div>
            <div class="column_two" style="width: 19%">
            </div>
            <div class="column_one" style="float: left">
                <input type="submit" name="confirm" value="CONFIRM"/>
            </div>
        </form>
    </div>


    <?php
        // if the user entered passwords in the three boxes
        if (isset($_POST['cur_pwd']) && isset($_POST['new_pwd']) && isset($_POST['confirm_pwd']))
        {
            ?>
            <hr>
            <p style="float: end">
                <?php
                    // we retrieve the current password from the database
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
                        elseif (!preg_match('#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).{8,}$#', $_POST['new_pwd']))
                        {
                            echo "Password not strong enough. It must have a minimum length of 8, contain at least one lowercase letter, one uppercase letter and one number.";
                        }
                        else
                        {
                            // we update the database with the new password
                            $sth = $db->prepare('UPDATE users SET password = ? WHERE username = ?;');
                            $res = $sth->execute(array($_POST['confirm_pwd'], $loginName));

                            if (!$res)
                            {
                                print_r("Something went wrong, the password could not be changed");
                            }
                        }
                    }
                    else // if the new passwords do not match and/or the current password is wrong
                    {
                        print_r("The passwords you entered do not match and/or your password is incorrect");
                    }
                ?>
            </p>
            <?php
        } // END if (isset($_POST['cur_pwd']) && isset($_POST['new_pwd']) && isset($_POST['confirm_pwd']))
    ?>

</div>

<!-- footer goes here -->
<?php
    include('fragments/footer.php');
?>



