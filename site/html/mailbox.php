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
            <h2>
                Your mailbox
                <?php if ($_GET['compose'] != true) { ?>
                    <a href="mailbox.php?compose=true" class="btn" style="float: right">
                        Compose message
                    </a>
                <?php } ?>
            </h2>

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
                            //we store everything we can about the message in a variable
                            include_once('functions/message.php');
                            $message = new message($_GET['messageID']);

                            if ($_GET['reply'])
                            {
                                // we got a POST request to send the reply, execute it then tell the user about the result
                                if (isset($_POST) && $_POST['send'] == "Send")
                                {
                                    $result = message::send_message($message->getSenderID(),
                                        $message->getRecipientID(),
                                        "RE: " . $message->getObject(),
                                        $_POST['reply']);
                                    if ($result)
                                    {
                                        echo "Reply Sent !";
                                    }
                                    else
                                    {
                                        echo "Oops ... Something went wrong! The message has not been sent.";
                                    }
                                } // END if (isset($_POST) && $_POST['send'] == "Send")

                                ?>
                                <!-- simple form to reply to a mail -->
                                <form action="mailbox.php?reply=true&amp;messageID=<?= $message->getMessageID() ?>"
                                      method="POST"
                                      id="form">
                                    <input type="hidden" name="oldMsgID"
                                           value="<?= $message->getMessageID() ?>"/>
                                    <label for="reply"> Write a reply :</label>
                                    <textarea cols="100%"
                                              rows="8"
                                              id="reply"
                                              name="reply"
                                              placeholder="Type your reply here ..."
                                              required>
                                    </textarea>
                                    <input type="submit" name="send" value="Send">
                                </form>

                                <?php
                            } // END if ($_GET['reply'])
                            // we show the message we're either replying to or wanting to read
                            $message->print_message();
                            if ($_GET['read'])
                            { ?>
                                <a href="mailbox.php?reply=true&amp;messageID=<?= $message->getMessageID() ?>"
                                   class="btn">
                                    Reply </a>
                                <a href="delete_msg.php?messageID=<?= $message->getMessageID() ?>" class="btn">
                                    Delete </a>

                            <?php } // END if ($_GET['read'])
                        }  // END if (isset($_GET) && $_GET['messageID'] && ($_GET['read'] || $_GET['reply']))
                        elseif ($_GET['compose'])
                        {
                            // $loginName comes from header.php, it's our logged username, it should be unique
                            // as specified in the DB Schema
                            $sth = $db->prepare("SELECT id, username FROM users WHERE username != ? ORDER BY username COLLATE NOCASE;");
                            $sth->execute(array($loginName));
                            $userNames = $sth->fetchAll();

                            // then a sql request to find the id of the sender (the user we're logged as)
                            $sth = $db->prepare("SELECT id FROM users WHERE username = ? ;");
                            $sth->execute(array($loginName));
                            $senderID = $sth->fetch()[0];
                            ?>
                            <form action="mailbox.php"
                                  method="POST"
                                  id="form">

                                <label for="recipient">To :
                                    <select id="recipient"
                                            name="recipient"
                                            style="margin-top: 7px">
                                        <?php foreach ($userNames as $userName) : ?>
                                            <option value="<?= $userName[0] ?>">
                                                <?= $userName[1] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </label>
                                <br>
                                <label for="object">Object :
                                    <input type="text" id="object" name="object" style="height: 20px;margin-top: 5px"
                                           required>
                                </label>

                                <textarea cols="100%"
                                          rows="8"
                                          id="content"
                                          name="content"
                                          placeholder="Type your message here ..."
                                          required></textarea>
                                <input type="hidden" name="sender"
                                       value="<?= $senderID ?>"/>
                                <input type="submit" name="submitMail" value="SUBMIT">
                            </form>

                        <?php } // END elseif ($_GET['compose'])
                        else // normal mode for the mailbox
                        {
                            // in case we just sent an email
                            if (isset($_POST) && $_POST['submitMail'] == "SUBMIT")
                            {
                                include_once('functions/message.php');

                                if (message::send_message($_POST['recipient'], $_POST['sender'], $_POST['object'], $_POST['content']))
                                {
                                    echo "Reply Sent !";
                                }
                                else
                                {
                                    echo "Oops ... Something went wrong! The message has not been sent.";
                                }
                            } // END if ($_GET['send'] && $_GET['from'])
                            ?>
                            <!-- displaying the mailbox on screen and showing what actions are available -->
                            <table class="table-bordered">
                                <thead>
                                <tr>
                                    <th>Sender</th>
                                    <th>Date</th>
                                    <th>Subject</th>
                                    <th colspan="3" style="border-style: solid solid solid solid ;">
                                        Actions
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($ret as $row): ?>
                                    <tr>
                                        <td rowspan="4"> <?= $row['username'] ?> </td>
                                        <td rowspan="4"> <?= $row['messageDate'] ?> </td>
                                        <td rowspan="4"> <?= $row['object'] ?> </td>
                                    </tr>
                                    <tr align="center" style="border-style: hidden solid hidden solid;">
                                        <td><a href="mailbox.php?read=true&amp;messageID=<?= $row['messageID'] ?>">
                                                Read </a>
                                        </td>
                                    </tr>
                                    <tr align="center" style="border-style: hidden solid hidden solid;">
                                        <td><a href="mailbox.php?reply=true&amp;messageID=<?= $row['messageID'] ?>">
                                                Reply </a>
                                        </td>
                                    </tr>
                                    <tr align="center">
                                        <td>
                                            <a href="delete_msg.php?messageID=<?= $row['messageID'] ?>">
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