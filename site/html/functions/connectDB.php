<?php
    // This function establishes a new connection to the database
    function connectDB()
    {
        $myPDO = new PDO('sqlite:/usr/share/nginx/databases/database.sqlite');
        return $myPDO;
    }


?>

