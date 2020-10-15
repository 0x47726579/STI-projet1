<!-- header goes here -->
<?php
    include('fragments/header.php');
?>

<?php
    $db = new PDO('sqlite:/usr/share/nginx/databases/database.sqlite');
    $oldMsgID = $_REQUEST['messageID'];
    // finds the message to reply to with its id
    $sql = 'SELECT s.username, m.recipientID, m.senderID, m.messageDate, m.object, m.messageID, m.message 
        FROM message AS m 
        INNER JOIN users AS s on s.id = m.senderID 
        INNER JOIN users as u on u.id = m.recipientID 
        WHERE m.messageID = ' . $oldMsgID . ' 
        ORDER BY messageDate DESC;';

    $ret = $db->query($sql);

    var_dump($oldMsgID); // this var_dump indicates the right id
?>


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
        <div class=row>
            <div class=col>
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
                        foreach ($ret as $row):
                        $sender = $row['recipientID'];
                        $object = $row['object'];
                    ?>
                        <tr>
                            <td> <?php echo $row['username'] ?> </td>
                            <td> <?php echo $row['messageDate'] ?> </td>
                            <td> <?php echo $row['object'] ?> </td>
                            <td> <?php echo $row['message'] ?> </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>

                <br>
                <!-- TODO : how to get the message id of the message being replied to, so it stays on the page ???? -->
                <form method="post" action="reply_msg.php?messageID="$oldMsgID>
                    <input type="hidden" name="oldMsgID" value="<?php echo $oldMsgID; ?>"/>
                    <input type="hidden" name="sender" value="<?php echo $sender; ?>"/>
                    <input type="hidden" name="object" value="<?php echo $object; ?>"/>
                    <label for="reply">Reply :</label>
                    <textarea cols="35" rows="10" id="reply" name="reply">Type your reply here ...</textarea>
                    <br><br>
                    <input type="submit" name="send" value="Send">

                    <?php
                        // gets the id of the sender
                        $sth = $db->prepare("SELECT id FROM users WHERE username = ? ;");
                        $sth->execute(array($_SESSION["login"]));
                        $newSenderID = $sth->fetch()[0];

                        // TODO : does not get the object
                        $reObj = "RE: " . $object;
                        $reply = $_POST['reply'];

                        // gets the id of the recipient
                        // TODO : does not work
                        $sth = $db->prepare("SELECT senderID FROM message WHERE messageID = ? ;");
                        $sth->execute(array($oldMsgID));
                        $newRecipientID = $sth->fetch()[0];

                        $dt = new DateTime();
                        $date = $dt->format('d.m.Y H:i');

                        if (isset($_POST['send']))
                        {
                            // inserts the reply message in the database
                            // increments the message id automatically, gets the current date and time, gives the sender id, sets the msg object as
                            // a reply and sends the message itself
                            $sth = $db->prepare("INSERT INTO message (messageDate, senderID, recipientID, object, message)
                                        VALUES(?, ?, ?, ?, ?);");
                            $insert = $sth->execute(array($date, $newSenderID, $newRecipientID, $reObj, $reply));

                            var_dump($date);
                            var_dump($newSenderID);
                            var_dump($newRecipientID);
                            var_dump($reObj);
                            var_dump($reply);
                            var_dump($sth);

                            if(!$insert) {
                                print_r("Oops ... Something went wrong! The message has not been sent.");
                            }
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


