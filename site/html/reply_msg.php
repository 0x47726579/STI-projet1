
<!-- header goes here -->
<?php
include('fragments/header.php');
?>

<?php
$db = new PDO('sqlite:/usr/share/nginx/databases/database.sqlite');

// finds the message to reply to with its id
$sql = 'SELECT * FROM message WHERE messageID = "' . $_GET['messageID'] . '";';

$ret = $db->query($sql);

?>

<div id="page_content">

    <!-- left side bar goes here -->
    <?php
    include('fragments/left_side_bar.php');
    ?>

    <div class="right_section">
        <div class="common_content">
            <h1>
                Your mailbox
            </h1>
            <!-- print the message we want to reply to -->
            <div class = row>
                <div class = col>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Sender</th>
                                <th>Date</th>
                                <th>Subject</th>
                                <th>Message</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            foreach($ret as $row):
                            $sender = $row['sender'];
                            $object = $row['object'];
                            ?>
                            <tr>
                                <td> <?php echo $row['sender']?> </td>
                                <td> <?php echo $row['date']?> </td>
                                <td> <?php echo $row['object']?> </td>
                                <td> <?php echo $row['text']?> </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>

                    <!-- TODO: create window to enter the reply -->
                    <form>
                        <label for="reply">Reply:</label><br>
                        <textarea cols="35" rows="10" name="reply">Type your reply here ...</textarea>
                        <br><br>
                        <input type="submit" value="Send">
                    </form>

                    <?php

                    $db = new PDO('sqlite:/usr/share/nginx/databases/database.sqlite');
                    // inserts the reply message in the database
                    // TODO : je ne sais pas comment utiliser le texte écrit en réponse ...
                    $sql = 'INSERT INTO message VALUES( "' . $_GET['messageID'] . '" + 1, datetime(), "' . $_SESSION["login"] . '", "' . $sender . '", "RE: " || "' . $object . '", "' . reply . '" ;';
                    $ret = $db->query($sql);

                    ?>

                </div>
            </div>
        </div>
    </div>
</div>

    <!-- footer goes here -->
    <?php
    include('fragments/footer.php');
    ?>


