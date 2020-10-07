
<!-- header goes here -->
<?php
include('fragments/header.php');
?>

<?php
$db = new PDO('sqlite:/usr/share/nginx/databases/database.sqlite');

// finds every message sent to this user
$sql = 'SELECT sender, messageDate, object from messages where recipient = "' . $_SESSION['login'] . '";';

$ret = $db->query($sql);

?>

<div id="page_content">

    <!-- left side bar goes here -->
    <?php
    include('fragments/left_side_bar.php');
    ?>

    <div class="right_section">
        <div class="common_content">
            <h1>
                Your mailbox
            </h1>
            <div class = row>
                <div class = col>
                    <table class="table-bordered">
                        <tr>
                            <th>Sender</th>
                            <th>Date</th>
                            <th>Subject</th>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- footer goes here -->
<?php
include('fragments/footer.php');
?>