
<!-- header goes here -->
<?php
include('fragments/header.php');
?>

<?php
$db = new PDO('sqlite:/usr/share/nginx/databases/database.sqlite');

// finds every message sent to this user
$sql = 'SELECT s.username, m.recipientID, m.senderID, m.messageDate, m.object, m.messageID 
        FROM message AS m 
        INNER JOIN users AS s on s.id = m.senderID 
        INNER JOIN users as u on u.id = m.recipientID 
        WHERE u.username = "' . $_SESSION['login'] . '" 
        ORDER BY messageDate DESC;';

$ret = $db->query($sql);

//var_dump($ret->fetch());


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
                                <td> <?php echo $row['username']?> </td>
                                <td> <?php echo $row['messageDate']?> </td>
                                <td> <?php echo $row['object']?> </td>
                                <td> <a href = "print_msg.php?messageID=<?php echo $row['messageID']?>"> Read </a> </td>
                                <td> <a href = "reply_msg.php?messageID=<?php echo $row['messageID']?>"> Reply </a> </td>
                                <td> <a href = "delete_msg.php?messageID=<?php echo $row['messageID']?>"> Delete </a> </td>
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