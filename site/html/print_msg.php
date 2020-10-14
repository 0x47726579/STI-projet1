<!-- header goes here -->
<?php
    include('fragments/header.php');
?>

<?php
    $db = new PDO('sqlite:/usr/share/nginx/databases/database.sqlite');

    // finds the message to print from the table
    $sql = 'SELECT u.username, m.messageDate, m.object, m.message, m.messageID 
        FROM message AS m
        INNER JOIN users as u on u.id = m.senderID
        WHERE messageID = "' . $_GET['messageID'] . '";';

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
        <div class=row>
            <div class=col>
                <table class="table-bordered">
                    <thead>
                    <tr>
                        <th>Sender</th>
                        <th>Date</th>
                        <th>Subject</th>
                        <th>Message</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($ret as $row): ?>
                        <tr>
                            <td> <?php echo $row['username'] ?> </td>
                            <td> <?php echo $row['messageDate'] ?> </td>
                            <td> <?php echo $row['object'] ?> </td>
                            <td> <?php echo $row['message'] ?> </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- footer goes here -->
<?php
    include('fragments/footer.php');
?>
