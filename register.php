
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
            <form method="post" action="save-reg.php">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input name="username" id="username" type="text" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input name="password" id="password" type="password" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Password Confirmation:</label>
                    <input name="password_confirmation" id="password_confirmation" type="password" class="form-control" required>
                </div>
                <div class='btn-align'>
                    <input type='submit' class='btn btn-secondary' value= 'Submit'>
                </div>
            <form>
        </main>
        <?php
            require_once('footer.php');
        ?>
    </body>
</html>