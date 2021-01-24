<!-- header goes here -->
<?php
    // including the header.php file allows this file to open a connection to the database
    include('fragments/header.php');

    // here we retrieve the messages sent to the user logged in
    $sth = $db->prepare('SELECT s.username, m.recipientID, m.senderID, m.messageDate, m.object, m.messageID
                         FROM message AS m
                         INNER JOIN users AS s on s.id = m.senderID
                         INNER JOIN users as u on u.id = m.recipientID
                         WHERE u.username = ?
                         ORDER BY messageDate DESC;');
    $sth->execute(array($loginName));
    $ret = $sth->fetchAll();
    $isInMailbox = false;
    foreach ($ret as $row)
    {
        if ($row['messageID'] == $_GET['messageID'])
        {
            $isInMailbox = true;
            break;
        }
    }

    if ($isInMailbox == false)
    {
        utils::redirect("mailbox.php");
    }


    // finds the message to delete with its id, deletes it and redirects on the mailbox
    $sql = 'DELETE FROM message WHERE messageID = "' . $_GET['messageID'] . '";';
    $ret = $db->query($sql);
    utils::redirect("mailbox.php");
?>

