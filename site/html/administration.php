<!-- header goes here -->
<?php
    include('fragments/header.php');
    $db = connectDB();
    function redirect()
    {
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
                // here we set the new role
                if ($_GET['setRole'])
                {
                    $obj = json_decode($_POST["role"]);
//                    var_dump($obj);
                    echo '<br>Role ID : <br>' . $obj->roleID . '<br>User ID : <br>' . $obj->userID;
                    $db->query('UPDATE users SET roleID = '
                        . $obj->roleID
                        . ' WHERE id = '
                        . $obj->userID
                        . ';');
                    redirect();
                }
                // we clicked on "Modify" for the user's role
                if ($_GET['modifyRole'])
                {
                    $userInfo = $db->query('SELECT * FROM users WHERE id = '
                        . $_GET['id']
                        . ';')
                        ->fetchAll()[0];
                    echo '<h2>Modifying role for ' . $userInfo["username"]
                        . ' </h2>
        <hr>';
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

            } else
            {
                $result = $db->query('SELECT * FROM users');
                echo '<h2>User accounts</h2>
        <hr>
        <table>
            <thead>
            <tr>
                <th>Username</th>
                <th>Status</th>
                <th>Role</th>
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

                    echo '</tr>';

                }
                echo '</tbody>
        </table>';

            }
        ?>

    </div>

</div>

<!-- footer goes here -->
<?php
    include('fragments/footer.php');
?>