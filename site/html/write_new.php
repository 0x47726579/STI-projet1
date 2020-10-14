<!-- header goes here -->
<?php
include('fragments/header.php');
?>

<?php
$db = new PDO('sqlite:/usr/share/nginx/databases/database.sqlite');
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

        <form style="float: left" method="POST" action="?">
            <label for="recipient" style="width: 300px">To :
                <input style="float: right" type="text" id="recipient" name="recipient">
            </label>
            <label for="object" style="width: 300px">Object :
                <input style="float: right" type="text" id="object" name="object">
            </label>
            <label for="message" style="width: 300px">Message :
                <input style="float: right; height: 150px;" type="text" id="message" name="message">
            </label>
            <!-- TODO : put this button on the right ... -->
            <input style="float: right" type="submit" name="send" value="Send">
        </form>

        <?php
            $recipient = $_POST['recipient'];
            $object = $_POST['object'];
            $message = $_POST['message'];

            if(isset($_POST['send'])){
                // first, a sql request to find the user id of the recipient
                $sth = $db->prepare("SELECT id FROM users WHERE username = ? ;");
                $sth->execute(array($recipient));
                $recipientID = $sth->fetch()[0];

                // then a sql request to find the id of the sender
                $sth = $db->prepare("SELECT id FROM users WHERE username = ? ;");
                $sth->execute(array($_SESSION["login"]));
                $senderID = $sth->fetch()[0];

                // set the current date with format
                $dt = new DateTime();
                $date = $dt->format('d.m.Y H:i');

                // then a sql request to insert the message in the db
                $sth = $db->prepare("INSERT INTO message (messageDate, senderID, recipientID, object, message) 
                        VALUES (?, ?, ?, ?, ?);");
                $insert = $sth->execute(array($date, $senderID, $recipientID, $object, $message));

                if(!$insert) {
                    print_r("Oops ... Something went wrong! The message has not been sent.");
                } elseif(!$recipientID) {
                    print_r("This user does not use this website. Please enter another user.");
                }

            }
        ?>

    </div>
</div>

<!-- footer goes here -->
<?php
include('fragments/footer.php');
?>