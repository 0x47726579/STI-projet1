<!-- header goes here -->
<?php
    include('fragments/header.php');
?>

<?php
    $db = new PDO('sqlite:/usr/share/nginx/databases/database.sqlite');

    // finds the message to delete with its id
    $sql = 'DELETE FROM message WHERE messageID = "' . $_GET['messageID'] . '";';

    $ret = $db->query($sql);

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
        <h2>
            Message deleted
        </h2>
    </div>
</div>

<!-- footer goes here -->
<?php
    include('fragments/footer.php');
?>

