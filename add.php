
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
        <?php
            require_once('header.php');
        ?>
        <main>
            <form method="post" action="process.php" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input name="name" id="name" type="text" class="form-control" value="<?php echo empty($_SESSION['name'])?"":$_SESSION['name']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input name="email" id="email" type="email" class="form-control" value="<?php echo empty($_SESSION['email'])?"":$_SESSION['email']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="location">Location:</label>
                    <input name="location" id="location" type="text" class="form-control" value="<?php echo empty($_SESSION['location'])?"":$_SESSION['location']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="photo" >Profile Photo:</label>
                    <input id="profile_photo" type="file" name="photo" required>
                </div>
                <div class="form-group">
                    <label for="social_media">Social Media URL:</label>
                    <input name="social_media" id="social_media" type="url" class="form-control" value="<?php echo empty($_SESSION['link'])?"":$_SESSION['link']; ?>" required>
                </div>
                <div class="form-group" id="skill_list">
                    <label for="skills">Skills:</label>
                    <button class="btn btn-outline-light" type="button" onclick="addBlank()">Add</button>
                </div>
                <?php
                    if(!empty($_SESSION['skills'])){
                        foreach($_SESSION['skills'] as $skill){
                            echo "<div class='input-group mb-3'><input name='skills[]' class='form-control skill' type='text' value='".$skill['skill_name']."'><div class='input-group-append'><button class='btn btn-outline-info' type='button' onclick='dropItem(event)'>Drop</button></div></div>";
                        }
                    }
                ?>
                <div class='btn-align'>
                    <input type='submit' class='btn btn-secondary' value= 'Save'>
                    <a href='profile.php' class='btn btn-danger'> Cancel </a>
                </div>
            <form>
            <script>
                function dropItem($event) {
                    $event.target.parentElement.parentElement.remove();
                }
                function addBlank(){
                    var div_btn = document.createElement("div");
                    div_btn.className = "input-group-append";
                    div_btn.innerHTML = '<button class="btn btn-outline-info" type="button" onclick="dropItem(event)">Drop</button>';
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
        <?php
            require_once('footer.php');
        ?>
    </body>
</html>