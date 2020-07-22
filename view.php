<?php ob_start() ?>
<?php
    require_once('auth.php');
    try {
        // fetch all records from users
        require_once('db/connect.php');
        $sql = "SELECT * FROM users WHERE user_id != :user_id;";
        $statement = $db->prepare($sql); 
        $statement->bindParam(':user_id', $_SESSION['account_id']);
        $statement->execute(); 
        $users = $statement->fetchAll();
        $statement ->closeCursor(); 
        // fetch all records from skills by primary key
        $skills = null;
        foreach($users as $user){
            $sql = "SELECT skill_name FROM skills WHERE user = :user;";
            $statement = $db->prepare($sql); 
            $statement->bindParam(':user', $user['user_id']);
            $statement->execute(); 
            $skills[$user['user_id']] = $statement->fetchAll();
            $statement ->closeCursor();
        }
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        echo $error_message;
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Course Project</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="css/view.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  </head>
    <body>
        <?php
            require_once('header.php');
        ?>
            <main>
                <div class="tbl">
                <?php 
                    echo "
                    <table class='table table-striped'>
                        <thead>
                            <th scope='col'>Profile</th>
                            <th scope='col'>Name</th>
                            <th scope='col'>Email</th>
                            <th scope='col'>Location</th>
                            <th scope='col'>Skills</th>
                            <th scope='col'>Social Media</th>
                        </thead>
                        <tbody>";
                        foreach($users as $index=>$user){
                            echo "<tr><th scope='row'><img src='imgs/".$user['image']."' class='rounded-circle' style='width:10em;height:10em;'></th><td>" . $user['name'] . "</td><td>" . $user['email'] . "</td><td>".$user['location']. "</td><td><button class='btn btn-outline-light' data-toggle='modal' data-target='#skillModal' id='skill_".$user['user_id']."' onclick='skillInfo(event)'>Show</button></td><td><a class='btn btn-light' href='".$user['social_media']."'>Check</a></td></tr>";
                        }
                        echo "</tbody>
                    </table>";
                ?>
                </div>
                <script> 
                    function skillInfo($event){
                        const user_id = $event.target.id.substring($event.target.id.length-1, $event.target.id.length);
                        document.getElementById("user_id").value = user_id;
                        document.getElementById("password").value = "";
                        document.getElementById("action").value = "edit";
                    }
                    function deleteInfo($event){
                        const user_id = $event.target.id.substring($event.target.id.length-1, $event.target.id.length);
                        document.getElementById("user_id").value = user_id;
                        document.getElementById("password").value = "";
                        document.getElementById("action").value = "delete";
                    }
                    function closeAlertMSG(){
                        document.getElementById("wrongPW").hidden = true;
                    }
                </script>
                
                <div class="modal fade" id="skillModal" tabindex="-1" role="dialog" aria-labelledby="skillModalLabel" aria-hidden="true" data-backdrop="static">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="skillModalLabel">Skill Set</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeAlertMSG()">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                            <form action="" method="post">
                                <input name="user_id" id="user_id" type="hidden" class="form-control" value="">
                                <input name="action" id="action" type="hidden" class="form-control" value="">
                                <div class="form-group">
                                    <label for="password">Password:</label>
                                    <input name="password" id="password" type="password" class="form-control" value="" required>
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>
            </main>
            <?php
                require_once('footer.php');
            ?>
    </body>
</html>
<?php ob_flush() ?>