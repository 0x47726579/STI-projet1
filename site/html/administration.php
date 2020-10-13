<!-- header goes here -->
<?php
    include('fragments/header.php');
    $db = connectDB();
    function redirect()
    {
//        echo 'Success, you will now be redirected...';
//        sleep(2);
        $host = $_SERVER['HTTP_HOST'];
        $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        header("Location: http://$host$uri/administration.php");
        exit;
    }

?>


<!-- left side bar goes here -->
<?php
    include('fragments/left_side_bar.php');
?>

<div class="right_section">
    <div class="common_content">
        <?php
            if (isset($_GET) and $_GET != null)
            {
                // we clicked on "Modify" for the user's role
                if ($_GET['modifyRole'])
                {
                    $userInfo = $db->query('SELECT * FROM users WHERE id = '
                        . $_GET['id']
                        . ';')
                        ->fetchAll()[0];

                    echo '<h2>Modifying role for ' . $userInfo["username"]
                        . ' </h2><hr>';

                    $result = $db->query("SELECT * FROM role");
                    echo '<form style="float: left" action="administration.php?setRole=true" method="POST">';
                    foreach ($result as $row)
                    {
                        if ($row["roleID"] == $userInfo["roleID"])
                        {
                            echo '<label for="role"> '
                                . $row["roleName"]
                                . '<input type="radio" name="role"  value=\'{"roleID":"'
                                . $row["roleID"]
                                . '","userID":"'
                                . $userInfo["id"]
                                . '"}\' checked="checked" />
                                  </label>';
                        } else
                        {
                            echo '<label for="role"> ' . $row["roleName"]
                                . '<input type="radio" name="role" value=\'{"roleID":"'
                                . $row["roleID"]
                                . '","userID":"'
                                . $userInfo["id"]
                                . '"}\' />
                                  </label>';
                        }
                        echo '<br>';
                    }
                    echo '<input type="submit" name="submitForm" value="CONFIRM"/></form>';
                }
                // we clicked on "Change password" for the user
                if ($_GET['modifyPassword'])
                {
                    $userInfo = $db->query('SELECT * FROM users WHERE id = '
                        . $_GET['id']
                        . ';')
                        ->fetchAll()[0];

                    echo '<h2>Modifying password for ' . $userInfo["username"]
                        . ' </h2><hr>';

                    $result = $db->query("SELECT * FROM role");
                    echo '<form style="float: left" action="administration.php?setPassword=true&id='
                        . $_GET['id']
                        . '" method="POST">';

                    echo '<label for="password"> Enter new password : <input type="password" name="password" required/>
                          </label>';
                    echo '<br>';

                    echo '<input type="submit" name="submitForm" value="CONFIRM"/></form>';
                }
                // we clicked on "Activate/Deactivate" for the user's role
                if ($_GET['toggle'])
                {
                    $state = ($db->query('SELECT active FROM users WHERE id = '
                                . $_GET['id']
                                . ';')
                                ->fetch()[0] + 1) % 2;
                    $db->query('UPDATE users SET active = '
                        . $state
                        . ' WHERE id = '
                        . $_GET['id']
                        . ';');

                    redirect();
                }
                // here we set the new role
                if ($_GET['setRole'])
                {
                    $obj = json_decode($_POST["role"]);
                    $db->query('UPDATE users SET roleID = '
                        . $obj->roleID
                        . ' WHERE id = '
                        . $obj->userID
                        . ';');
                    redirect();
                }
                // here we set the new password
                if ($_GET['setPassword'])
                {
                    var_dump($_POST);
                    $db->query('UPDATE users SET password = "'
                        . $_POST['password']
                        . '" WHERE id = '
                        . $_GET['id']
                        . ';');
                    redirect();
                }
                // HERE WE ADD THE USER
                if ($_GET['addUser'])
                {

                    $db->query("INSERT INTO \"users\" (\"id\",\"username\",\"password\",\"active\",\"roleID\") VALUES (NULL,'"
                        . $_POST['username']
                        . "','"
                        . $_POST['password']
                        . "','"
                        . (int)$_POST['activate']
                        . "','"
                        . $_POST['roles']
                        . "')");
                    redirect();
                }

            } else
            {
                echo '<h2>Add a user</h2><hr>';

                echo '<div class="box" style="width: 540px">
                <form action="administration.php?addUser=true" method="POST" id="form">
                <div class="column_one">
                <label for="username">Username :</label>
                    <input type="text" class="form-control" name="username" id="username" 
                           placeholder="Enter username" required>
                <label for="password">Password :</label>
                    <input type="password" class="form-control" name="password" id="password"
                           placeholder="Enter password" required>
                <br></div>
                <div class="column_two" style="margin-right: 285px">
                <label for="activate">Activate :</label>
                    <input type="checkbox" class="form-control" name="activate" id="activate" value="1"
                           checked="checked">
                <label for="role">Set a role :</label>
                <select id="role" name="roles" >';
                $result = $db->query("SELECT * FROM role");
                foreach ($result as $row)
                {
                    // awfull html but it selects the last element by default this way.
                    echo '<option value="' . $row["roleID"] . '" selected>' . $row["roleName"] . '</option>';

                }
                echo '</select> <br>   </div>     
                <div class="column_one">   
                <input type="submit" name="submitForm" value="ADD USER"/>
                <input type="reset">
                </div>
            ';

                echo '
                    </form>
                </div>';

                $result = $db->query('SELECT * FROM users ORDER BY   roleID , active DESC , username COLLATE NOCASE ');
                echo '<div class="box"><hr><h2>User accounts</h2>
        <hr>
        <table>
            <thead>
            <tr>
                <th>Username</th>
                <th>Status</th>
                <th>Role</th>
                <th style="border-style: hidden hidden ridge ridge;border-width: 3px;"></th>
            </tr>
            </thead>
            <tbody>';

                foreach ($result as $row)
                {
                    echo '
                    <tr>
                        <td> ' . $row['username'] . ' </td>';
                    if ($row['active'] == 1)
                    {
                        echo ' <td> Active <a href="administration.php?toggle=true&id='
                            . $row['id']
                            . '" class="btn" style="float: right;">Deactivate</a></td>';
                    } else
                    {
                        echo ' <td> Inactive <a href="administration.php?toggle=true&id='
                            . $row['id']
                            . '" class="btn" style="float: right;">Activate</a> </td>';
                    }


                    //only works if the query is meant to return one row, otherwise you won't get the following rows.
                    echo '<td> '
                        . $db->query('SELECT roleName FROM role WHERE roleID = ' . $row['roleID'] . ';')->fetch()[0]
                        . ' <a href="administration.php?modifyRole=true&id='
                        . $row['id']
                        . '" class="btn" style="float: right;">Modify</a> </td>';
                    echo '<td style="border-style: solid ridge solid hidden;"> '
                        . ' &nbsp;&nbsp;<a href="administration.php?modifyPassword=true&id='
                        . $row['id']
                        . '">Change password</a> </td>';
                    echo '</tr>';

                }
                echo '</tbody>
                </table></div>';

            }

        ?>

    </div>

</div>

<!-- footer goes here -->
<?php
    include('fragments/footer.php');
?>