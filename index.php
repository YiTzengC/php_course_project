<?php
    $id = null;
    $id = filter_input(INPUT_GET, 'id');
    $name = null;
    $email = null;
    $location = null;
    $skills = null;
    if(!empty($id)){
        try {
            //run script of connect.php
            require_once('db/connect.php');
            // instantiate a variable called sql to hold query to be executed for mysql
            $sql = "SELECT * FROM users WHERE user_id = :user_id;";
            //papare the query and return a PDO statement object
            $statement = $db->prepare($sql);
            $statement->bindParam(':user_id', $id);
            // execute the query
            $statement->execute(); 
            // disconnect from database
            $users = $statement->fetchAll();
            foreach($users as $user){
                $name = $user['name'];
                $email = $user['email'];
                $location = $user['location'];
            }
            
            $statement ->closeCursor(); 

            foreach($users as $user){
                $sql = "SELECT skill_name FROM skills WHERE owner = :owner;";
                $statement = $db->prepare($sql); 
                $statement->bindParam(':owner', $user['user_id']);
                $statement->execute(); 
                $skills = $statement->fetchAll();
                $statement ->closeCursor();
            }
    
    
        } catch (PDOException $e) {
            $error_message = $e->getMessage();
            //show error message to user
            echo $error_message;
        }
    }
?>

<!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8">
        <title>Project Phase One</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <link rel="stylesheet" href="css/main.css">
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    </head>
    <body>
        <header>
            <h1>Network & Connection</h1>
            <nav>
                <ul class="nav justify-content-center">
                    <li class="nav-item">
                      <a class="nav-link active" href="index.php">Register</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link active" href="view.php">View</a>
                    </li>
                </ul>
            </nav>
        </header>
        <main>
            <form method="post" action="process.php">
                <?php
                echo "<input type='hidden' name='user_id' value='".$id."'>";
                if(!empty($id)){
                    echo "<div class='form-group'><a href='view.php' class='btn btn-danger'> Cancel </a></div>";
                }
                ?>
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input name="name" id="name" type="text" class="form-control" value="<?php echo $name?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input name="email" id="email" type="email" class="form-control" value="<?php echo $email?>" required>
                </div>
                <div class="form-group">
                    <label for="location">City:</label>
                    <input name="location" id="location" type="text" class="form-control" value="<?php echo $location?>" required>
                </div>
                <?php
                    if(empty($id)){
                        echo "<div class='form-group'>
                    <label for='password'>Password:</label>
                    <input name='password' id='password' type='password' class='form-control' required>
                </div>";
                    }
                ?>
                <div class="form-group" id="skill_list">
                    <label for="skills">Skills:</label>
                    <button class="btn btn-outline-secondary" type="button" onclick="addBlank()">Add</button>
                </div>
                <?php
                    if(!empty($skills) && !empty($id)){
                        foreach($skills as $skill){
                            echo "<div class='input-group mb-3'><input name='skills[]' class='form-control skill' type='text' value='".$skill['skill_name']."'><div class='input-group-append'><button class='btn btn-outline-secondary' type='button' onclick='dropItem(event)'>Drop</button></div></div>";
                        }
                    }
                    
                    if(empty($id)){
                        echo "<input type='submit' value= 'Share' class='btn btn-secondary'>";
                    }else{
                        echo "<input type='submit' value= 'Save' class='btn btn-success'>";
                    }
                ?> 
            <form>
            <script>
                function dropItem($event) {
                    $event.target.parentElement.parentElement.remove();
                }
                function addBlank(){
                    var div_btn = document.createElement("div");
                    div_btn.className = "input-group-append";
                    div_btn.innerHTML = '<button class="btn btn-outline-secondary" type="button" onclick="dropItem(event)">Drop</button>';
                    var input = document.createElement("input");
                    input.name = "skills[]";
                    input.className = "form-control skill";
                    input.type = "text";
                    input.required = true;

                    var input_grp = document.createElement("div");
                    input_grp.className = "input-group mb-3";
                    input_grp.appendChild(input);
                    input_grp.appendChild(div_btn);

                    var element = document.getElementById("skill_list");
                    element.appendChild(input_grp);
                }
            </script>
        </main>
        <footer>
            <p> &copy; 2020 COMP1006 - Course Project Phase One</p>
        </footer>
    </body>
</html>