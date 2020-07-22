<?php ob_start() ?>
<?php
    require_once('auth.php');
    $search = filter_input(INPUT_POST, 'search');
    if(empty($search)){
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
    }else{
        $search_words = explode(' ', $search);
        try {
            
            // fetch all records from users
            require_once('db/connect.php');
            $sql = "SELECT * FROM users WHERE ";
            $where = "";
            foreach($search_words as $word){
                $word = trim($word);
                $where = $where."name LIKE '%$word%' OR ";
            }
            $where = substr($where, 0, strlen($where) - 4);
            $sql = $sql . $where.";";
            // echo $sql;
            $statement = $db->prepare($sql); 
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
            <div class="search">
            <form class="input-group mb-3" action="view.php" method="post">
                <input type="text" class="form-control" name="search" value="<?php echo empty($search)?"":$search; ?>" placeholder="Example: name name ..." aria-label="Recipient's username" aria-describedby="button-addon2">
                <div class="input-group-append">
                  <input type="submit" class="btn btn-outline-secondary" type="button"></input>
                </div>
                <div class="input-group-append">
                  <a href="view.php" class="btn btn-outline-danger" type="button">Clear</a>
                </div>
            </form>
</div>
                <div class="tbl">
                <?php 
                    echo "
                    <table class='table'>
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
                            echo "<tr>
                                    <th scope='row'>
                                        <img src='imgs/".$user['image']."' class='rounded-circle' style='width:5em;height:5em;'>
                                    </th>
                                    <td>".$user['name']. "</td>
                                    <td>".$user['email']. "</td>
                                    <td>".$user['location']. "</td>
                                    <td>
                                        <button class='btn btn-outline-light' data-toggle='modal' data-target='#skillModal".$user['user_id']."'>Show</button>
                                    </td>
                                    <td>
                                        <a class='btn btn-outline-light' href='".$user['social_media']."' target='_blank' rel='external'>Check</a>
                                    </td>
                                </tr>";
                        }
                        echo "</tbody>
                    </table>";
                ?>
                </div>
                <?php
                    if(!empty($skills)){
                        foreach($skills as $skill_index => $skill_set){
                            echo "<div class='modal fade' id='skillModal".$skill_index."' tabindex='-1' role='dialog' aria-labelledby='skillModalLabel' aria-hidden='true'>
                            <div class='modal-dialog'>
                                <div class='modal-content'>
                                  <div class='modal-header'>
                                    <h5 class='modal-title' id='skillModalLabel'>Skill Set</h5>
                                  </div>
                                  <div class='modal-body'>
                                      ";
                                      foreach($skill_set as $skill){
                                        echo "<span class='badge badge-secondary'>".$skill['skill_name']."</span>";
                                    }
                            echo"
                                  </div>
                                  <div class='modal-footer'>
                                      <button type='button' data-dismiss='modal' class='btn btn-secondary'>Close</button>
                                  </div>
                                </div>
                            </div>
                        </div>";
                        }
                    }
                ?>
            </main>
            <?php
                require_once('footer.php');
            ?>
    </body>
</html>
<?php ob_flush() ?>