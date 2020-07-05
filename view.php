<?php
    $correct_password = true;
    try {
        //run script of connect.php
        require_once('db/connect.php');
        // instantiate a variable called sql to hold query to be executed for mysql
        $sql = "SELECT * FROM users;";
        //papare the query and return a PDO statement object
        $statement = $db->prepare($sql); 
        // execute the query
        $statement->execute(); 
        // disconnect from database
        $users = $statement->fetchAll();
        
        $statement ->closeCursor(); 

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
        //show error message to user
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
    <link href="https://fonts.googleapis.com/css2?family=Piedra&family=Quicksand&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  </head>
    <body>
        <div class="container">
            <header>
                <h1>PROFILES</h1>
                <nav>
                <ul class="nav justify-content-center">
                    <li class="nav-item">
                      <a class="nav-link active" href="index.php">Register</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link active" href="#">View</a>
                    </li>
                </ul>
            </nav>
            </header>
            <main>
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
                            echo "<tr><th scope='row'>".($index+1)."</th><td>" . $user['name'] . "</td><td>" . $user['email'] . "</td><td>".$user['location']. "</td><td><button class='btn btn-primary' type='button' data-toggle='collapse' data-target='#skill_".$index."' aria-expanded='false' aria-controls='skill_".$index."'>Show</button></td><td><a href='db/remove.php?id=" . $user['user_id'] . "'> Delete</a></td><td><button class='btn btn-primary' type='button' data-toggle='modal' data-target='#passwordModal' id='user_".$user['user_id']."' onclick='getId(event)'>Edit</button></td></tr>";
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
                            //papare the query and return a PDO statement object
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
                                header('location: index.php?id='.$user_id);
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
                <script> 
                    function getId($event){
                        const user_id = $event.target.id.substring($event.target.id.length-1, $event.target.id.length);
                        document.getElementById("user_id").value = user_id;
                        document.getElementById("password").value = "";
                    }
                    function closeAlertMSG(){
                        document.getElementById("wrongPW").hidden = true;
                    }
                </script>
                <!-- Modal -->
                
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
                                <div class="form-group">
                                    <label for="password">Password:</label>
                                    <input name="password" id="password" type="password" class="form-control" value="" required>
                                </div>
                                <?php
                                    if(!$correct_password){
                                        echo "<p id='wrongPW' style='color:red;' hidden>Incorrect Password</p>";
                                    }
                                ?>
                                <input class="btn btn-secondary" name="submit" type="submit"/>
                            </form>
                            </div>
                            <!-- <div class="modal-footer"> -->
                            <!-- </div> -->
                        </div>
                    </div>
                </div>
                <?php
                    if(!$correct_password){
                        echo "
                                    <script>
                                        document.getElementById('wrongPW').hidden = false;
                                        $('#passwordModal').modal('show');
                                    </script>
                                      ";
                    }
                ?>
            </main>
            <footer>
              <p> &copy; 2020 COMP1006 - Course Project Phase One</p>
            </footer>
        </div><!--end container-->
    </body>
</html>