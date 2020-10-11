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
        <h2>User accounts</h2>
        <hr>
        <table>
            <thead>
            <tr>
                <th>Username</th>
                <th>Password</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>
            <?php
                foreach ($result as $row)
                {
                    echo '
                        <tr>
                            <td> ' . $row['username'] . ' </td>
                            <td> ' . $row['password'] . ' </td>';
                    if ($row['active'] == 1)
                    {
                        echo ' <td> Active <a href="administration.php?deactivate=true&id='.$row['id'].'" class="btn" style="float: right;">Deactivate</a></td>';
                    } else
                    {
                        echo ' <td> Inactive <a href="administration.php?activate=true&id='.$row['id'].'" class="btn" style="float: right;">Activate</a> </td>';
                    }

                    echo '</tr>';

                }
            ?>
            </tbody>
        </table>
    </div>

</div>

<!-- footer goes here -->
<?php
    include('fragments/footer.php');
?>