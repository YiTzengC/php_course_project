<?php
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
                            echo "<tr><th scope='row'>".($index+1)."</th><td>" . $user['name'] . "</td><td>" . $user['email'] . "</td><td>".$user['location']. "</td><td><button class='btn btn-primary' type='button' data-toggle='collapse' data-target='#skill_".$index."' aria-expanded='false' aria-controls='skill_".$index."'>Show</button></td><td><a href='db/remove.php?id=" . $user['user_id'] . "'> Delete</a></td><td><a href='index.php?id=" . $user['user_id'] . "'>Edit</a></td></tr>";
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
            </main>
            <footer>
              <p> &copy; 2020 COMP1006 - Course Project Phase One</p>
            </footer>
        </div><!--end container-->
    </body>
</html>