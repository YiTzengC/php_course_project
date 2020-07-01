<?php ob_start();

try {
    $id = filter_input(INPUT_GET, 'id'); 
    require_once('connect.php'); 

    $sql = "DELETE FROM skills WHERE owner = :user_id;"; 
    $statement = $db->prepare($sql);
    $statement->bindParam(':user_id', $id );
    $statement->execute();
    $statement->closeCursor(); 

    $sql = "DELETE FROM users WHERE user_id = :user_id;";
    $statement = $db->prepare($sql);
    $statement->bindParam(':user_id', $id ); 
    $statement->execute();
    $statement->closeCursor(); 
    
    header('location:../view.php'); 
}
catch(PDOException $e) {
    $error_message = $e->getMessage(); 
    echo "<p> $errormessage </p>"; 
}
ob_flush(); 
?>