<!-- header goes here -->
<?php
    include('fragments/header.php');
?>


<!-- left side bar goes here -->
<?php
    include('fragments/left_side_bar.php');

    $oldMsgID = $_GET['messageID'];
    $reObj = "";
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
                    include_once('functions/message.php');
                    $message = new message($_GET['messageID']);
                    $message->print_message();
                ?>
                <br>
                <form action="reply_msg.php?reply=true&amp;messageID=<?= $oldMsgID ?>" method="POST" id="form">
                    <input type="hidden" name="oldMsgID" value="<?= $oldMsgID ?>"/>
                    <label for="reply">Write a reply :</label>

                    <textarea cols="100%"
                              rows="8"
                              id="reply"
                              name="reply"
                              placeholder="Type your reply here ..."
                              required></textarea>

                    <input type="submit" name="send" value="Send">
                    <br>

                    <?php

                        $id = 'SELECT id FROM users WHERE username = "' . $_SESSION["login"] . '";';
                        $newSenderid = $db->query($id)->fetch()[0];
                        print $newSenderid;

                        var_dump($_POST);
                        $reObj = "RE: " . $object;
                        var_dump($reObj);
                        $reply = $_POST['reply'];
                        $newMsgID = $oldMsgID + 1;

                        $req = 'SELECT senderID FROM message WHERE messageID = ' . $oldMsgID . '; ';
                        $newRecipientID = $db->query($req)->fetch()[0];
                        print $newRecipientID;
                        $date = new DateTime();
                        $dt = $date->format('d.m.Y H:i');

                        // TODO : here it seems the "send" is set, but the insert statement is not executed for some reason.
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

                            if (!$insert)
                            {
                                print_r("Oops ... Something went wrong! The message has not been sent.");
                            }
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


