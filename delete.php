<?php
    require_once('auth.php');
    try {
            
        // fetch all records from users
        $account_id = $_SESSION['account_id'];
        $user_name = $_SESSION['username'];
        require_once('db/connect.php');
        $sql = "DELETE FROM skills WHERE user = :user;";
        $statement = $db->prepare($sql);
        $statement->bindParam(':user', $_SESSION['account_id']); 
        $statement->execute();
        $statement ->closeCursor();

        $sql = "DELETE FROM users WHERE user_id = :user_id;";
        $statement = $db->prepare($sql);
        $statement->bindParam(':user_id', $_SESSION['account_id']); 
        $statement->execute(); 
        $statement ->closeCursor();
        unlink('imgs/'.$_SESSION['image']);
        session_unset();
        $_SESSION['account_id'] = $account_id;
        $_SESSION['username'] = $user_name;
        header("location:profile.php");
        exit();
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        echo $error_message;
    }
?>