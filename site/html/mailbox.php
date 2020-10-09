
<!-- header goes here -->
<?php
include('fragments/header.php');
?>

<?php
$db = new PDO('sqlite:/usr/share/nginx/databases/database.sqlite');

// finds every message sent to this user
$sql = 'SELECT * FROM message WHERE recipient = "' . $_SESSION['login'] . '" ORDER BY messageDate;';

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
                        <thead>
                            <tr>
                                <th>Sender</th>
                                <th>Date</th>
                                <th>Subject</th>
                                <th colspan="3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($ret as $row): ?>
                            <tr>
                                <td> <?php echo $row['sender']?> </td>
                                <td> <?php echo $row['date']?> </td>
                                <td> <?php echo $row['object']?> </td>
                                <td> <a href = "print_msg.php?messageID=<?php echo $row['messageID']?>"> See all </a> </td>
                                <td> <a href = "delete_msg.php?messageID=<?php echo $row['messageID']?>"> Delete </a> </td>
                                <td> <a href = "reply_msg.php?messageID=<?php echo $row['messageID']?>"> Reply </a> </td>
                            </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- footer goes here -->
<?php
include('fragments/footer.php');
?>