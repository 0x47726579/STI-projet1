<!-- header goes here -->
<?php
    // including the header.php file allows this file to open a connection to the database
    include('fragments/header.php');
    // finds the message to delete with its id, deletes it and redirects on the mailbox
    $sql = 'DELETE FROM message WHERE messageID = "' . $_GET['messageID'] . '";';
    $ret = $db->query($sql);
    utils::redirect("mailbox.php");
?>

