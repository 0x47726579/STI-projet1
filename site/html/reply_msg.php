
<!-- header goes here -->
<?php
include('fragments/header.php');
?>

<?php
$db = new PDO('sqlite:/usr/share/nginx/databases/database.sqlite');
$oldMsgID = (int) $_REQUEST['messageID'];
// finds the message to reply to with its id
$sql = 'SELECT s.username, m.recipientID, m.senderID, m.messageDate, m.object, m.messageID, m.message 
        FROM message AS m 
        INNER JOIN users AS s on s.id = m.senderID 
        INNER JOIN users as u on u.id = m.recipientID 
        WHERE m.messageID = ' . $oldMsgID . ' 
        ORDER BY messageDate DESC;';

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
            <!-- print the message we want to reply to -->
            <div class = row>
                <div class = col>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Sender</th>
                                <th>Date</th>
                                <th>Subject</th>
                                <th>Message</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            foreach($ret as $row):
                            $sender = $row['recipientID'];
                            $object = $row['object'];
                            ?>
                            <tr>
                                <td> <?php echo $row['username']?> </td>
                                <td> <?php echo $row['messageDate']?> </td>
                                <td> <?php echo $row['object']?> </td>
                                <td> <?php echo $row['message']?> </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>

                    <br>

                    <form method="post" action="?">
                        <input type="hidden" name="oldMsgID" value=<?php echo $oldMsgID; ?> />
                        <label for="reply">Reply :</label>
                        <textarea cols="35" rows="10" id="reply" name="reply">Type your reply here ...</textarea>
                        <br><br>
                        <input type="submit" name="send" value="Send">

                        <?php
                            $db = new PDO('sqlite:/usr/share/nginx/databases/database.sqlite');

                            $id = 'SELECT id FROM users WHERE username = "' . $_SESSION["login"] . '";';
                            $newSenderid = $db->query($id);

                            $reObj = "RE: " . $object;
                            $reply = $_POST['reply'];
                            $newMsgID = $oldMsgID + 1;

                            $req = 'SELECT senderID FROM message WHERE messageID = ' . $oldMsgID . '; ';
                            $newRecipientID = $db->query($req);

                            $date = new DateTime();
                            $dt = $date->format('d.m.Y H:i');

                            // TODO : here it seems the "send" is set, but the insert statement is not executed for some reason.
                            if(isset($_POST['send'])) {
                                // inserts the reply message in the database
                                // increments the message id, gets the current timestamp, gives the sender id, sets the msg object as a reply and sends the message itself
                                $sql = 'INSERT INTO message (messageID, messageDate, senderID, recipientID, object, message)
                                        VALUES( "' . $newMsgID . '", "' . $dt . '", "' . $newSenderid . '", "' . $newRecipientID . '", "' . $reObj . '", "' . $reply . '");';

                                $ret = $db->query($sql);
                                // this var_dump doesn't show anything
                                var_dump($sql);
                            }
                        ?>
                    </form>




                </div>
            </div>
        </div>
    </div>
</div>

    <!-- footer goes here -->
    <?php
    include('fragments/footer.php');
    ?>


