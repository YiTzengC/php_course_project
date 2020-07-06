<?php
        $dsn = 'mysql:host=localhost;dbname=Yi200437546';
        if ($_SERVER['HTTP_HOST'] == 'localhost:8888'){
            $username = 'root';
            $password = 'root';
        }
        else {
            $username = 'Yi200437546';
            $password = 'zuStUwJqxz';
        }
        $db = new PDO($dsn, $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>