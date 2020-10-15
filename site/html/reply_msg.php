<!-- header goes here -->
<?php
    include('fragments/header.php');
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
                <?php
                    include('print_msg.php');
                ?>

                <br>

                <form method="post" action="?">
                    <input type="hidden" name="oldMsgID" value=<?php echo $oldMsgID; ?>/>
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
                        if (isset($_POST['send']))
                        {
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
<!-- footer goes here -->
<?php
    include('fragments/footer.php');
?>


