<!-- header goes here -->
<?php
    // including the header.php file allows this file to open a connection to the database
    include('fragments/header.php');
    include('fragments/left_side_bar.php');
?>

<!-- Displays the boxes to write a new e-mail -->
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

            } // END if (isset($_POST['send']))
        ?>

    </div>
</div>

<!-- footer goes here -->
<?php
include('fragments/footer.php');
?>