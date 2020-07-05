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
    $id = null;
    $id = filter_input(INPUT_POST, 'user_id');
    $name = filter_input(INPUT_POST, 'name');
    $location = filter_input(INPUT_POST, 'location');
    $user_password = filter_input(INPUT_POST, 'password');
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $skills = filter_input(INPUT_POST, 'skills', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

    $ok = true;
    if (empty($name)) {
        echo "<p>Please provide name! </p>";
        $ok = false;

    }
    else if (empty($location)){
        echo "<p>Please provide location! </p>";
        $ok = false;
    }
    else if (empty($user_password) && empty($id)){
        echo "<p>Please provide password! </p>";
        $ok = false;
    }
    else {
        $user_password = md5($user_password);
    }
    if(!empty($skills)){
        foreach($skills as $skill){
            if(empty($skill)){
                $ok = false;
            }
        }
    };
    if($ok){
        try{
            require_once("db/connect.php");
            if(!empty($id)){
                $sql = "UPDATE users SET name = :name, location = :location, email = :email WHERE user_id = :user_id;";
                $statement = $db->prepare($sql);
                $statement->bindParam(':name', $name);
                $statement->bindParam(':location', $location);
                $statement->bindParam(':email', $email);
                $statement->bindParam(':user_id', $id );
                $statement->execute(); 
                $statement ->closeCursor();

                $sql = "DELETE FROM skills WHERE owner = :user_id;"; 
                $statement = $db->prepare($sql);
                $statement->bindParam(':user_id', $id );
                $statement->execute();
                $statement->closeCursor(); 
            }
            else{
                $sql = "INSERT INTO users (name, location, email, password) VALUES (:name, :location, :email, :password)";
                $statement = $db->prepare($sql);
                $statement->bindParam(':name', $name);
                $statement->bindParam(':location', $location);
                $statement->bindParam(':email', $email);
                $statement->bindParam(':password', $user_password);
                $statement->execute(); 
                $id = $db->lastInsertId();
                $statement ->closeCursor();
    
            }
            if(!empty($skills)){
                $skills = array_unique($skills);
                foreach($skills as $skill){
                    $sql = "INSERT INTO skills (skill_name, owner) VALUES (:skill_name, :owner)";
                    $statement = $db->prepare($sql);
                    $statement->bindParam(':skill_name', $skill);
                    $statement->bindParam(':owner', $id);
                    $statement->execute(); 
                    $statement ->closeCursor();
                }
            }
            echo "
            <div class='modal fade' id='exampleModal' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
            <div class='modal-dialog'>
              <div class='modal-content'>
                <div class='modal-header'>
                  <h5 class='modal-title' id='exampleModalLabel'>You Are Connecred</h5>
                </div>
                <div class='modal-body'>
                    Thank you for sharing.
                </div>
                <div class='modal-footer'>
                  <a href='view.php' class='btn btn-primary'>Got It</a>
                </div>
              </div>
            </div>
          </div>
          <script>
              $('#exampleModal').modal('show');
          </script>
            ";
        } catch (PDOException $e) {
            $error_message = $e->getMessage();
            //show error message to user
            echo "<p> Sorry! We weren't able to process your submission at this time. We've alerted our admins and will let you know when things are fixed! </p> ";
            echo $error_message;
            //email app admin with error
            mail('200437546@student.georgianc.on.ca', 'App Error ', 'Error :'. $error_message);
        }
    }
    
    
?>
    </body>
</html>