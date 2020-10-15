<!-- header goes here -->
<?php
    // including the header.php file allows this file to open a connection to the database
    include('fragments/header.php');
    include('fragments/left_side_bar.php');
?>

<?php
    // finds the message to delete with its id, deletes it and redirects on the mailbox
    $sql = 'DELETE FROM message WHERE messageID = "' . $_GET['messageID'] . '";';
    $ret = $db->query($sql);
    utils::redirect("mailbox.php");
?>

<div class="right_section">
    <div class="common_content">
        <h1>
            Your mailbox
        </h1>
        <hr>
        <h2>
            Message deleted
        </h2>
    </div>
</div>

<!-- footer goes here -->
<?php
    include('fragments/footer.php');
?>

