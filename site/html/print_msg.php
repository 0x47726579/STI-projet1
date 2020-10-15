<?php

    // finds the message to print from the table
    $sth = $db->prepare('SELECT u.username, m.messageDate, m.object, m.message, m.messageID 
        FROM message AS m
        INNER JOIN users as u ON u.id = m.senderID
        WHERE messageID = ?;');
    $sth->execute(array($_GET['messageID']));
    $ret = $sth->fetchAll();

?>


            <table class="table-bordered">
                <?php foreach ($ret as $row): ?>

                    <thead>
                    <tr>
                        <th>Subject :</th>
                        <td colspan="3"> <?php echo $row['object'] ?> </td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th>From :</th>
                        <td> <?php echo $row['username'] ?> </td>
                        <th>Sent :</th>
                        <td> <?php echo $row['messageDate'] ?> </td>
                    </tr>
                    <tr>
                        <td colspan="4"> <?php echo $row['message'] ?> </td>
                    </tr>
                    </tbody>
                <?php endforeach; ?>
            </table>

