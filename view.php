<?php ob_start() ?>
<?php
    $correct_password = true;
    try {
        // fetch all records from users
        require_once('db/connect.php');
        $sql = "SELECT * FROM users;";
        $statement = $db->prepare($sql); 
        $statement->execute(); 
        $users = $statement->fetchAll();
        $statement ->closeCursor(); 
        // fetch all records from skills by primary key
        $skills = null;
        foreach($users as $user){
            $sql = "SELECT skill_name FROM skills WHERE owner = :owner;";
            $statement = $db->prepare($sql); 
            $statement->bindParam(':owner', $user['user_id']);
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
                            <th scope='col'>#</th>
                            <th scope='col'>Name</th>
                            <th scope='col'>Email</th>
                            <th scope='col'>Location</th>
                            <th scope='col'>Skills</th>
                            <th scope='col'> Delete</th>
                            <th scope='col'> Edit </th>
                        </thead>
                        <tbody>";
                        foreach($users as $index=>$user){
                            echo "<tr><th scope='row'>".($index+1)."</th><td>" . $user['name'] . "</td><td>" . $user['email'] . "</td><td>".$user['location']. "</td><td><button class='btn btn-light' type='button' data-toggle='collapse' data-target='#skill_".$index."' aria-expanded='false' aria-controls='skill_".$index."'>Show</button></td><td><a class='btn btn-outline-light' data-toggle='modal' data-target='#passwordModal' id='delete_".$user['user_id']."' onclick='deleteInfo(event)'> Delete</a></td><td><button class='btn btn-light' type='button' data-toggle='modal' data-target='#passwordModal' id='user_".$user['user_id']."' onclick='editInfo(event)'>Edit</button></td></tr>";
                            echo "<tr class='collapse' id='skill_".$index."'>
                            <td colspan='7'><div class='card card-body'><ul class='list-group list-group-horizontal'>";
                            if(!empty($skills[$user['user_id']])){
                                foreach($skills[$user['user_id']] as $skname){
                                    echo "<li class='list-group-item'>".$skname['skill_name']."</li>";
                                }
                            }
                            echo "</ul></div></td></tr>";
                        }
                        echo "</tbody>
                    </table>";
                ?>
                <?php
                    if (isset($_POST['submit'])) {
                        $user_password = md5($_POST['password']);
                        $user_id = $_POST['user_id'];
                        try {
                            $sql = "SELECT * FROM users WHERE user_id = :user_id AND password = :password;";
                            $statement = $db->prepare($sql);
                            $statement->bindParam(':user_id', $user_id);
                            $statement->bindParam(':password', $user_password);
                            $statement->execute();
                            $records = $statement->fetchAll();
                            $statement ->closeCursor();
                            if(empty($records)){
                                $correct_password = false;
                            }
                            else{
                                if($_POST['action'] == 'edit'){
                                    header('location: add.php?id='.$user_id);
                                }
                                else{
                                    header('location: db/remove.php?id='.$user_id);
                                }
                            }
                        }catch(PDOException $e){
                            echo "
                                <div class='modal fade' id='errorModal' tabindex='-1' role='dialog' aria-labelledby='errorModalLabel' aria-hidden='true'>
                                <div class='modal-dialog'>
                                  <div class='modal-content'>
                                    <div class='modal-header'>
                                      <h5 class='modal-title' id='errorModalLabel'>ERROR</h5>
                                    </div>
                                    <div class='modal-body'>
                                        Unexpected Error occurs:".$e->getMessage()."
                                    </div>
                                    <div class='modal-footer'>
                                        <button type='button' class='btn btn-secondary' data-dismiss='modal'>OK</button>
                                    </div>
                                  </div>
                                </div>
                                </div>
                                <script>
                                    $('#errorModal').modal('show');
                                </script>
                                  ";
                        }
                    }
                ?>
                </div>
                <script> 
                    function editInfo($event){
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
                
                <div class="modal fade" id="passwordModal" tabindex="-1" role="dialog" aria-labelledby="passwordModalLabel" aria-hidden="true" data-backdrop="static">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="passwordModalLabel">Password Required To Edit</h5>
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
                                <p id="wrongPW" style="color:red;" hidden>Incorrect Password</p>
                                <input class="btn btn-secondary" name="submit" type="submit"/>
                            </form>
                            </div>
                        </div>
                    </div>
                <?php
                    if(!$correct_password){
                        if($_POST['action'] == 'edit'){
                            echo "
                                <script>
                                    document.getElementById('user_id').value = ".$user_id.";
                                    document.getElementById('password').value = '';
                                    document.getElementById('action').value = 'edit';
                                </script>
                                  ";
                        }
                        else{
                            echo "
                            <script>
                                document.getElementById('user_id').value = ".$user_id.";
                                document.getElementById('password').value = '';
                                document.getElementById('action').value = 'delete';
                            </script>
                                  ";
                        }
                        echo "
                            <script>
                                document.getElementById('wrongPW').hidden = false;
                                $('#passwordModal').modal('show');
                            </script>
                              ";
                    }
                ?>
            </main>
            <?php
                require_once('footer.php');
            ?>
    </body>
</html>
<?php ob_flush() ?>