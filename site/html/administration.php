<!-- header goes here -->
<?php
    include('fragments/header.php');
    $db = connectDB();

    $result = $db->query('SELECT * FROM users');


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
                    echo '<h2>Modifying role for ' . $db->query('SELECT username FROM users WHERE id = '
                            . $_GET['id']
                            . ';')
                            ->fetch()[0]
                        . ' </h2>
        <hr>';
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

                    $host = $_SERVER['HTTP_HOST'];
                    $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
                    header("Location: http://$host$uri/administration.php");
                    exit;
                }

            } else
            {
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