<?php


    class utils
    {

        public static function redirect($destination = "login.php")
        {
            $host = $_SERVER['HTTP_HOST'];
            $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
            header("Location: http://$host$uri/$destination");
            exit;
        }
    }