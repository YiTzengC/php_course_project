<?php
      //authentication
      // check status of session 
      // start session if it is not active
      if(session_status() != PHP_SESSION_ACTIVE){
            session_start();
      }
      $extension = "";
      //obtain info from session
      if(empty($_SESSION['account_id']) && empty($_SESSION['name'])){
            $extension = "<li class='nav-item'>
                              <a class='nav-link' href='register.php'>Register</a>
                        </li>
                        <li class='nav-item'>
                              <a class='nav-link' href='login.php'>Login</a>
                        </li>
                        ";
      }else if(!empty($_SESSION['account_id']) && empty($_SESSION['name'])){
            $extension = "<li class='nav-item'>
                              <a class='nav-link' href='profile.php'>My Info</a>
                        </li>
                        <li class='nav-item'>
                              <a class='nav-link' href='view.php'>Network</a>
                        </li>
                        <li class='nav-item'>
                              <a class='nav-link' href='destroy.php'>Logout</a>
                        </li>
                        ";
      }else {
            $extension = "<li class='nav-item'>
                              <a class='nav-link' href='profile.php'>My Info</a>
                        </li>
                        <li class='nav-item'>
                              <a class='nav-link' href='view.php'>Network</a>
                        </li>
                        <li class='nav-item'>
                              <a class='nav-link' href='destroy.php'>Logout</a>
                        </li>
                        ";
      }
?>
<header>
    <nav class='navbar'>
        <h1 class='navbar-brand'>Connection&Network</h1>
        <ul class='nav justify-content-end'>
          <li class='nav-item'>
                <a class='nav-link' href='index.php'>Home</a>
          </li>
          <?php
            echo $extension;
          ?>
          <li class='nav-item'>
                <a class='nav-link' href='review.php'>Project Review</a>
          </li>
        </ul>
    </nav>
</header>