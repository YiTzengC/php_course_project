
<?php require_once('auth.php'); ?>
<!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8">
        <title>Course Project</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <!-- <link rel="stylesheet" href="css/add.css"> -->
        <link rel="stylesheet" href="css/header.css">
        <link rel="stylesheet" href="css/footer.css">
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    </head>
    <body>
        <?php
            require_once('header.php');
            require_once('get_network.php');
            // $account_id = $_SESSION['account_id'];
            // $name = null;
            // $email = null;
            // $location = null;
            // $skills = null;
            // $image = null;
            // $social_media = null;
            // if(!empty($account_id)){
            //     try {
            //         require_once('db/connect.php');
            //         $sql = "SELECT * FROM users WHERE user_id = :user_id;";
            //         $statement = $db->prepare($sql);
            //         $statement->bindParam(':user_id', $account_id);
            //         $statement->execute();
            //         $users = $statement->fetchAll();
            //         $statement ->closeCursor(); 
            //         if(!empty($users)){
            //             foreach($users as $user){
            //                 $name = $user['name'];
            //                 $email = $user['email'];
            //                 $location = $user['location'];
            //                 $image = $user['image'];
            //                 $social_media = $user['social_media'];
            //             }
            //             foreach($users as $user){
            //                 $sql = "SELECT skill_name FROM skills WHERE user = :user;";
            //                 $statement = $db->prepare($sql); 
            //                 $statement->bindParam(':user', $account_id);
            //                 $statement->execute(); 
            //                 $skills = $statement->fetchAll();
            //                 $statement ->closeCursor();
            //             }
            //         }
                
            //     } catch (PDOException $e) {
            //         $error_message = $e->getMessage();
            //         echo $error_message;
            //     }
            // }
        ?>
        <main>
            <div class="container">
                <div class="row">
                    <div class="col" style="text-align: center;">
                        <?php
                            if(empty($_SESSION['name'])){
                                echo "<img src='imgs/user.png' class='rounded-circle' style='width:15em;height:15em;'>";
                            }
                            else{
                                echo "<img src='imgs/".$_SESSION['image']."' class='rounded-circle' style='width:15em;height:15em;'>";
                            }
                        ?>
                    </div>
                </div>
                <?php
                    if (empty($_SESSION['name'])) {
                        echo "<a href='add.php' class='btn btn-outline-secondary'>Share Connection</a>";
                    }
                    else{
                        require_once('profile_network.php');
                    }
                ?>
            </div>
        </main>
        <?php
            require_once('footer.php');
        ?>
    </body>
</html>