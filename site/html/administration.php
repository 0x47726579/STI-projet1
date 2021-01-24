<?php
    // including the header.php file allows this file to open a connection to the database
    include('fragments/header.php');
    include('fragments/left_side_bar.php');
?>

    <div class="right_section">
        <div class="common_content">
            <?php
                if ($_GET['p'])
                {
                    echo "Password not strong enough. It must have a minimum length of 8, contain at least one lowercase letter, one uppercase letter and one number.";
                }
                if (isset($_GET) and $_GET != null)
                {
                    $sth = $db->prepare('SELECT * FROM users WHERE id =   ?');
                    $sth->execute(array($_GET['id']));
                    $userInfo = $sth->fetchAll()[0];
                    // we clicked on "Modify" for the user's role
                    if ($_GET['modifyRole'])
                    {
                        $roles = $db->query("SELECT roleID, roleName FROM role");
                        ?>

                        <h2>Modifying role for <?= $userInfo["username"] ?></h2>
                        <hr>

                        <form action="administration.php?setRole=true" method="POST">
                            <div class="column_one">
                                <?php foreach ($roles as $row): ?>

                                    <label for="role">
                                        <input type="radio"
                                               name="role"
                                               style="size: 20px"
                                               value='{"roleID":"<?= $row["roleID"] ?>","userID":"<?= $userInfo["id"] ?>"}'
                                            <?php if ($row["roleID"] == $userInfo["roleID"])
                                            {
                                                echo 'checked="checked"';
                                            } ?>
                                        /><?= $row["roleName"] ?>
                                    </label>
                                    <br>

                                <?php endforeach; ?>
                            </div>
                            <div class="column_two"></div>

                            <div class="column_one">
                                <p><input type="submit" name="submitForm" value="CONFIRM"/></p>
                            </div>

                        </form>
                        <?php
                    } // END if ($_GET['modifyRole'])
                    // we clicked on "Change password" for the user
                    if ($_GET['modifyPassword'])
                    { ?>

                        <h2>Modifying password for <?= $userInfo["username"] ?></h2>
                        <hr>
                        <form style="float: left"
                              action="administration.php?setPassword=true&amp;id=<?= $userInfo['id'] ?>" method=post>

                            <label for="password"> Enter new password :
                                <input type="password" name="password" required/>
                            </label>
                            <br>
                            <input type="submit" name="submitForm" value="CONFIRM"/>
                        </form>

                    <?php }
                    // we clicked on "Activate/Deactivate" for the user's role
                    if ($_GET['toggle'])
                    {
                        $state = ($userInfo['active'] + 1) % 2;  // if true : becomes false. And vice versa.
                        $sth = $db->prepare('UPDATE users SET active = ? WHERE id = ? ');
                        $sth->execute(array($state, $userInfo['id']));
                        utils::redirect("administration.php");
                    }
                    // here we set the new role
                    if ($_GET['setRole'])
                    {
                        $obj = json_decode($_POST["role"]);
                        $sth = $db->prepare('UPDATE users SET roleID = ? WHERE id = ? ');
                        $sth->execute(array($obj->roleID, $obj->userID));
                        utils::redirect("administration.php");
                    }
                    // here we set the new password
                    if ($_GET['setPassword'])
                    {
                        if (!preg_match('#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).{8,}$#', $_POST['password']))
                        {
                            utils::redirect("administration.php?p=true");
                        }
                        $sth = $db->prepare('UPDATE users SET password = ? WHERE id = ? ');
                        $sth->execute(array($_POST['password'], $userInfo['id']));
                        utils::redirect("administration.php");
                    }
                    // here we add the user
                    if ($_GET['addUser'])
                    {
                        if (!preg_match('#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).{8,}$#', $_POST['password']))
                        {
                            utils::redirect("administration.php?p=true");
                        }
                        $username = $_POST['username'];
                        $pwd = $_POST['password'];
                        $active = (int)$_POST['activate'];
                        $role = $_POST['role'];
                        $sth = $db->prepare('INSERT INTO users ("username","password","active","roleID") VALUES ( ?, ?, ?, ?)');
                        $sth->execute(array($username, $pwd, $active, $role));
                        utils::redirect("administration.php");
                    }

                }
                else // if !(isset($_GET) and $_GET != null)
                { ?>
                    <!-- Displaying the page with all the informations for the admin -->
                    <h2>Add a user</h2>
                    <hr>

                    <form action="administration.php?addUser=true" method="POST" id="form">
                        <div class="column_one">
                            <label for="username">Username :
                                <input type="text"
                                       name="username"
                                       id="username"
                                       placeholder="Enter username"
                                       style="margin-left: 30px"
                                       required>
                            </label>
                            <label for="password">Password :
                                <input type="password"
                                       name="password"
                                       id="password"
                                       placeholder="Enter password"
                                       style="margin-left: 33px"
                                       required>
                            </label>
                        </div>
                        <div class="column_two">
                            <input type="checkbox"
                                   name="activate"
                                   id="activate"
                                   value="1"
                                   class="css-checkbox"
                                   checked="checked">
                            <label for="activate" style="width: 280px" class="css-label">Enable account
                            </label>
                            <br>
                            <select id="role"
                                    name="role"
                                    style="margin-top: 7px">

                                <?php
                                    $roles = $db->query("SELECT * FROM role")->fetchAll();
                                    $last = count($roles) - 1;
                                    for ($i = 0; $i < count($roles); $i++) : ?>

                                        <option value="<?= $roles[$i]["roleID"] ?>" <?php if ($i == $last) { ?> selected<?php } ?>>
                                            <?= $roles[$i]["roleName"] ?>
                                        </option>

                                    <?php endfor; ?>

                            </select>
                            <label for="role">Account role</label>
                        </div>
                        <div class="column_one">
                            <input type="submit" name="submitForm" value="ADD USER"/>
                            <input type="reset">
                        </div>
                    </form>
                    <?php
                    //we get all the users in the DB, because why not, the admin needs to know who's here after all ;)
                    $users = $db->query('SELECT * FROM users ORDER BY roleID , active DESC , username COLLATE NOCASE ');
                    // a 2D array of the form [line][roleName]. one line per roleName.
                    $roleNames = $db->query('SELECT roleName FROM role')->fetchAll();
                    ?>
                    <div class="box">
                        <hr>
                        <details>
                            <summary>Click to reveal/hide existing users</summary>

                            <table>
                                <thead>
                                <tr>
                                    <th>Username</th>
                                    <th colspan="2">Status</th>
                                    <th colspan="2">Role</th>
                                    <th style="border-style: hidden hidden ridge ridge;border-width: 3px;"></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                    foreach ($users as $row):

                                        if ($row['active'])
                                        {
                                            $activeStatus = "Active";
                                            $activeAction = "Deactivate";
                                        }
                                        else
                                        {
                                            $activeStatus = "Inactive";
                                            $activeAction = "Activate";
                                        }
                                        $roleID = $row['roleID'] - 1; // Our DB's roleID start at 1, the array at 0
                                        $roleName = $roleNames[$roleID][0];
                                        ?>
                                        <tr>
                                            <td>
                                                <?= $row['username'] ?>
                                            </td>
                                            <td>
                                                <?= $activeStatus ?>
                                            </td>
                                            <td style="border-style: solid solid solid hidden; text-align: center;">
                                                <a href="administration.php?toggle=true&amp;id=<?= $row['id'] ?>"
                                                   class="btn">
                                                    <?= $activeAction ?>
                                                </a>
                                            </td>
                                            <td>
                                                <?= $roleName ?>
                                            </td>
                                            <td style="border-style: solid solid solid hidden; ">
                                                <a href="administration.php?modifyRole=true&amp;id=<?= $row['id'] ?>"
                                                   class="btn"
                                                   style="float: right;">
                                                    Modify
                                                </a>
                                            </td>
                                            <td style="border-style: solid hidden solid hidden;">&nbsp;&nbsp;
                                                <a href="administration.php?modifyPassword=true&amp;id=<?= $row['id'] ?>">
                                                    Change password
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </details>
                    </div>
                <?php } ?>

        </div>

    </div>

    <!-- footer goes here -->
<?php
    include('fragments/footer.php');
?>