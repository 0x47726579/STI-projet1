<?php

function connectDB()
{
    $myPDO = new PDO('sqlite:/usr/share/nginx/databases/database.sqlite');
    $result = $myPDO->query('SELECT * FROM users');
    foreach ($result as $row) {
        print $row['id'] . "\n";
    }
}


?>

