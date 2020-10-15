<!-- header goes here -->
<?php
    include('fragments/header.php');


    include('fragments/left_side_bar.php');

    $sth = $db->prepare('SELECT s.username, m.recipientID, m.senderID, m.messageDate, m.object, m.messageID 
        FROM message AS m 
        INNER JOIN users AS s on s.id = m.senderID 
        INNER JOIN users as u on u.id = m.recipientID 
        WHERE u.username = ? 
        ORDER BY messageDate DESC;');
    $sth->execute(array($loginName));
    $ret = $sth->fetchAll();
    //    var_dump($ret);
?>
<?php if (isset($_GET) && $_GET['read'])
{
    include_once('print_msg.php');
} else
{ ?>
    <div class="right_section">
        <div class="common_content">
            <h1>
                Your mailbox
            </h1>
            <div class=row>
                <div class=col>
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
                        <?php foreach ($ret as $row): ?>
                            <tr>
                                <td> <?= $row['username'] ?> </td>
                                <td> <?= $row['messageDate'] ?> </td>
                                <td> <?= $row['object'] ?> </td>
                                <td><a href="mailbox.php?read=true&amp;messageID=<?= $row['messageID'] ?>"> Read </a>
                                </td>
                                <td><a href="reply_msg.php?messageID=<?= $row['messageID'] ?>"> Reply </a></td>
                                <td><a href="delete_msg.php?messageID=<?= $row['messageID'] ?>"> Delete </a></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<!-- footer goes here -->
<?php
    include('fragments/footer.php');
?>