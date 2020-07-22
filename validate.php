<?php 
    if(session_status() != PHP_SESSION_ACTIVE){
        session_start();
    }
    if(!empty($_SESSION['account_id'])){
        header('location:profile.php');
        exit();
    }
    $alert_msg = "";
    // grab the information from the form and also validate 
    $user = trim(filter_input(INPUT_POST, 'username'));
    $user_password = trim(filter_input(INPUT_POST, 'password'));
    if(empty($user)) {
        $alert_msg = "Please provide username!";
    }
    else if(empty($user_password)) {
        $alert_msg = "Please provide your password!";
    }
    else {
        try {
            require_once('db/connect.php');
            $sql = "SELECT account_id, username, password FROM accounts WHERE username = :username";
            //prepare
            $statement = $db->prepare($sql);
            //bind
            $statement->bindParam(':username', $user);
            //execute
            $statement->execute();
            if ($statement->rowCount() == 1) {
                $row = $statement->fetch();
                $statement->closeCursor();
                $hashed_password = $row['password'];
                if (password_verify($user_password, $hashed_password)) {
                    //password matches
                    $_SESSION['account_id'] = $row['account_id'];
                    $_SESSION['username'] = $row['username'];
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
                    //direct user to restricted page
                    header('location:profile.php');
                }
                else {
                    $alert_msg = "Wrong password!";
                }
            } else{
                $alert_msg = "Username does not exist!";
            }

        } catch (PDOException $e) {
            $error_message = $e->getMessage();
            //show error message to user
            $alert_msg = "Sorry! We weren't able to process your submission at this time. We've alerted our admins and will let you know when things are fixed!";
            mail('200437546@student.georgianc.on.ca', 'App Error ', 'Error :'. $error_message);
        }
    }
?>
<!DOCTYPE html>
<html lang="en"> 
    <head>
        <meta charset="utf-8">
        <title>Course Project</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <link rel="stylesheet" href="css/add.css">
        <link rel="stylesheet" href="css/header.css">
        <link rel="stylesheet" href="css/footer.css">
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    </head>
    <body>
    <?php require_once('header.php');?>
    <main>
        <div class='modal fade' id='alertModal' tabindex='-1' role='dialog' aria-labelledby='alertModalLabel' aria-hidden='true'>
            <div class='modal-dialog'>
                <div class='modal-content'>
                  <div class='modal-header'>
                    <h5 class='modal-title' id='alertModalLabel'>Notification</h5>
                  </div>
                  <div class='modal-body'>
                      <?php
                          echo $alert_msg;
                      ?>
                  </div>
                  <div class='modal-footer'>
                      <a href="login.php" class='btn btn-secondary'>OK</a>
                  </div>
                </div>
            </div>
        </div>
        <script>
            $('#alertModal').modal('show');
        </script>
    </main>
    <?php require_once('footer.php');?>
  </body>
</html>