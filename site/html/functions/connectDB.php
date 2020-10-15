<?php

    function connectDB()
    {
        $myPDO = new PDO('sqlite:/usr/share/nginx/databases/database.sqlite');
        return $myPDO;
    }


?>

