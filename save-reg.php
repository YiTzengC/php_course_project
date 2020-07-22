<?php
    $anchor = "register.php";
    $user = trim(filter_input(INPUT_POST, 'username'));
    $user_password = trim(filter_input(INPUT_POST, 'password'));
    $password_confirmation = trim(filter_input(INPUT_POST, 'password_confirmation'));
    
    $alert_msg = "";
    if (empty($user)) {
        $alert_msg = "Please provide username!";
    }
    else if (empty($user_password) || empty($password_confirmation)) {
        $alert_msg = "Please provide password!";
    }
    else if ($user_password != $password_confirmation) {
        $alert_msg = "Password and Password Confirmation are not identical!";
    }
    else {
        try {
            require_once('db/connect.php');
            $sql = "INSERT INTO accounts (username, password) VALUES (:username, :password)";
            $statement = $db->prepare($sql);
            $statement->bindParam(':username', $user);
            $hashed_password = password_hash($user_password, PASSWORD_DEFAULT);
            $statement->bindParam(':password', $hashed_password);
            $statement->execute(); 

            $alert_msg="Registered Successfully!";

            $statement ->closeCursor();
            $anchor = "login.php";
            
        } catch (PDOException $e) {
            $error_message = $e->getMessage();
            if(strpos($error_message, "Duplicate entry") != false){
                $alert_msg="Username exists! Please provide a new one.";
            }
            else{
                $alert_msg="Sorry! We weren't able to process your submission at this time. We've alerted our admins and will let you know when things are fixed!".$error_message;
            }
            mail('200437546@student.georgianc.on.ca', 'App Error ', 'Error :'. $error_message);
        }
    }
?>
<!DOCTYPE html>
    <html>
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
                          <a <?php echo "href='".$anchor."'"; ?> class='btn btn-secondary'>OK</a>
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