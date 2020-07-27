<?php 
    if(session_status() != PHP_SESSION_ACTIVE){
        session_start();
    }
?>
<!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8">
        <title>Project Phase One</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    </head>
    <body>
    <?php
    $alert_msg = "";
    $user_id = null;
    $account_id = $_SESSION['account_id'];
    $name = filter_input(INPUT_POST, 'name');
    $location = filter_input(INPUT_POST, 'location');
    $social_media = filter_input(INPUT_POST, 'social_media');
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $skills = filter_input(INPUT_POST, 'skills', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
    $photo = $account_id.'_'.$_FILES['photo']['name'];
    $photo_type = $_FILES['photo']['type'];
    $photo_size = $_FILES['photo']['size'];

    define('UPLOADPATH', 'imgs/');
    define('MAXFILESIZE', 32786); //32 KB
    if($_SERVER['CONTENT_LENGTH'] > 8388608){
        $alert_msg = "Please upload image size less than 8MB";
    }
    else if (empty($name)) {
        $alert_msg = "Please provide name!";
    }
    else if (empty($location)){
        $alert_msg = "Please provide location!";
    }
    else if (empty($email)){
        $alert_msg = "Please provide email!";
    }
    else if (empty($social_media)){
        $alert_msg = "Please provide url to your social media!";
    }
    else if ((($photo_type !== 'image/gif') || ($photo_type !== 'image/jpeg') || ($photo_type !== 'image/jpg') || ($photo_type !== 'image/png')) && ($photo_size < 0)){
        if ($_FILES['photo']['error'] !== 0) {
            $alert_msg = "Please submit a photo that is a jpg, png or gif and less than 32kb";
        }
    }
    else {
        try{
            require_once("db/connect.php");
            if(!empty($_SESSION['name'])){
                if($photo != $_SESSION['image'] && $_SESSION['image'] != 'user.png'){
                    $target = UPLOADPATH . $photo;
                    unlink(UPLOADPATH.$_SESSION['image']);
                    move_uploaded_file($_FILES['photo']['tmp_name'], $target);
                }
                $sql = "UPDATE users SET name = :name, location = :location, email = :email, image = :image, social_media = :social_media WHERE user_id = :user_id;";
                $statement = $db->prepare($sql);
                $statement->bindParam(':name', $name);
                $statement->bindParam(':location', $location);
                $statement->bindParam(':email', $email);
                $statement->bindValue(':image', $photo);
                $statement->bindParam(':user_id', $account_id );
                $statement->bindValue(':social_media', $social_media);
                $statement->execute(); 
                $statement ->closeCursor();
                
                $sql = "DELETE FROM skills WHERE user = :user_id;"; 
                $statement = $db->prepare($sql);
                $statement->bindParam(':user_id', $account_id );
                $statement->execute();
                $statement->closeCursor(); 
            }
            else{
                $target = UPLOADPATH . $photo;
                move_uploaded_file($_FILES['photo']['tmp_name'], $target);

                $sql = "INSERT INTO users (user_id, name, location, email, image, social_media) VALUES (:user_id, :name, :location, :email, :image, :social_media)";
                $statement = $db->prepare($sql);
                $statement->bindParam(':user_id', $account_id);
                $statement->bindValue(':name', $name);
                $statement->bindValue(':location', $location);
                $statement->bindValue(':email', $email);
                $statement->bindValue(':image', $photo);
                $statement->bindValue(':social_media', $social_media);
                $statement->execute();
                $statement ->closeCursor();
            }
            if(!empty($skills)){
                $unhandled_skills = [];
                foreach($skills as $skill){
                    $exploded_by_comma = null;
                    if(strpos($skill, ",") !== false){
                        $exploded_by_comma = explode(',', $skill);
                        $exploded_by_comma = array_unique($exploded_by_comma);
                        foreach($exploded_by_comma as $explode_str){
                            array_push($unhandled_skills, $explode_str);
                        }
                    }
                    else{
                        array_push($unhandled_skills, $skill);
                    }
                }
                $unhandled_skills = array_unique($unhandled_skills);
                
                foreach($unhandled_skills as $skill){
                    $sql = "INSERT INTO skills (skill_name, user) VALUES (:skill_name, :user)";
                    $statement = $db->prepare($sql);
                    $statement->bindParam(':skill_name', $skill);
                    $statement->bindParam(':user', $account_id);
                    $statement->execute(); 
                    $statement ->closeCursor();
                }
            }
            header('location:profile.php');
        }catch (PDOException $e) {
            $error_message = $e->getMessage();
            // $alert_msg = "Sorry! We weren't able to process your submission at this time. We've alerted our admins and will let you know when things are fixed!";
            echo $error_message;
            mail('200437546@student.georgianc.on.ca', 'App Error ', 'Error :'. $error_message);
        }
    }
?>
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
                          <a href="add.php" class='btn btn-secondary'>OK</a>
                      </div>
                    </div>
                </div>
            </div>
            <script>
                $('#alertModal').modal('show');
            </script>
    </body>
</html>