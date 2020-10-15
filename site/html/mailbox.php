<?php
    // including the header.php file allows this file to open a connection to the database
    include('fragments/header.php');
    include('fragments/left_side_bar.php');

    // here we retrieve the messages sent to the user logged in
    $sth = $db->prepare('SELECT s.username, m.recipientID, m.senderID, m.messageDate, m.object, m.messageID 
        FROM message AS m 
        INNER JOIN users AS s on s.id = m.senderID 
        INNER JOIN users as u on u.id = m.recipientID 
        WHERE u.username = ? 
        ORDER BY messageDate DESC;');
    $sth->execute(array($loginName));
    $ret = $sth->fetchAll();
?>

<div class="right_section">
    <div class="common_content">
        <h1>
            Your mailbox
        </h1>
        <hr>
        <div class=row>
            <div class=col>
                <?php
                    // if we're not simply looking at the mailbox, we want to do an action :
                    // either read an e-mail or reply to one
                    // this is done through different GET variables set to true
                    if (isset($_GET) && $_GET['messageID']
                        && ($_GET['read'] || $_GET['reply']))
                    {
                        include_once('functions/message.php');
                        $message = new message($_GET['messageID']);

                        if ($_GET['reply'])
                        {
                            // we got a POST request to send the reply, execute it then tell the user about the result
                            if (isset($_POST) && $_POST['send'] == "Send")
                            {
                                $result = $message->send_message($message->getSenderID(),
                                    $message->getRecipientID(),
                                    "RE: " . $message->getObject(),
                                    $_POST['reply']);
                                if ($result)
                                {
                                    echo "Reply Sent !";
                                } else {
                                    print_r("Oops ... Something went wrong! The message has not been sent.");
                                }
                            }

                            ?>
                            <!-- simple form to reply to a mail -->
                            <form action="mailbox.php?reply=true&amp;messageID=<?= $message->getMessageID() ?>"
                                  method="POST" id="form">
                                <input type="hidden" name="oldMsgID" value="<?php echo $message->getMessageID() ?>"/>
                                <label for="reply"> Write a reply :</label>

                                <textarea cols="100%"
                                          rows="8"
                                          id="reply"
                                          name="reply"
                                          placeholder="Type your reply here ..."
                                          required></textarea>

                                <input type="submit" name="send" value="Send">
                            </form>

                            <?php
                        } // END if ($_GET['reply'])
                        // we show the message we're either replying to or wanting to read
                        $message->print_message();
                        if ($_GET['read'])
                        {
                            ?>
                            <a href="mailbox.php?reply=true&amp;messageID=<?= $message->getMessageID() ?>" class="btn">
                                Reply </a>
                            <a href="delete_msg.php?messageID=<?= $message->getMessageID() ?>" class="btn">
                                Delete </a>

                            <?php
                        }
                    } else // if no action is selected by the user
                    { ?>
                        <!-- displaying the mailbox on screen and showing what actions are available -->
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
                                    <td rowspan="4"> <?= $row['username'] ?> </td>
                                    <td rowspan="4"> <?= $row['messageDate'] ?> </td>
                                    <td rowspan="4"> <?= $row['object'] ?> </td>
                                </tr>
                                <tr align="center">
                                    <td><a href="mailbox.php?read=true&amp;messageID=<?= $row['messageID'] ?>">
                                            Read </a>
                                    </td>
                                </tr>
                                <tr align="center">
                                    <td><a href="mailbox.php?reply=true&amp;messageID=<?= $row['messageID'] ?>">
                                            Reply </a>
                                    </td>
                                </tr>
                                <tr align="center">
                                    <td><a href="delete_msg.php?messageID=<?= $row['messageID'] ?>">
                                            Delete </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php } ?>
            </div>
        </div>
    </div>

</div>

<!-- footer goes here -->
<?php
    include('fragments/footer.php');
?>