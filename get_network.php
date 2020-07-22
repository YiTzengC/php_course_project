<?php
    try {
        require_once('db/connect.php');

        $sql = "SELECT * FROM users WHERE user_id = :user_id;";
        $statement = $db->prepare($sql); 
        $statement->bindParam(':user_id', $_SESSION['account_id']);
        $statement->execute(); 
        if ($statement->rowCount() == 1) {
            $infos = $statement->fetch();
            $statement ->closeCursor();
            $_SESSION['name'] = $infos['name'];
            $_SESSION['location'] = $infos['location'];
            $_SESSION['email'] = $infos['email'];
            $_SESSION['image'] = $infos['image'];
            $_SESSION['link'] = $infos['social_media'];
            $sql = "SELECT skill_name FROM skills WHERE user = :user;";
            $statement = $db->prepare($sql); 
            $statement->bindParam(':user', $_SESSION['account_id']);
            $statement->execute();
            $_SESSION['skills'] = $statement->fetchAll();
            $statement ->closeCursor();
        }

    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        //show error message to user
        $alert_msg = "Sorry! We weren't able to process your submission at this time. We've alerted our admins and will let you know when things are fixed!";
        // echo $error_message;
        //email app admin with error
        mail('200437546@student.georgianc.on.ca', 'App Error ', 'Error :'. $error_message);
    }
?>