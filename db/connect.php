<?php

    // $dbname = 'Network_Connection';
    // $tbl_name = 'user_information';

    // function connect_2_SQL($dbname = null){

        $dsn = 'mysql:host=localhost;dbname=Network_Connection';
        $username = 'root';
        $password = 'root';
        $db = new PDO($dsn, $username, $password);
        //set error mode to exception
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // return $db;

    // }

    // function createDB(){

    //     global $dbname;

    //     $db = connect_2_SQL();

    //     try{
    //         $query = "CREATE DATABASE IF NOT EXISTS $dbname;";
    
    //         $statement = $db->prepare($query);
    //         $statement->execute();
    //         $statement->closeCursor();
    //     }
    //     catch(PDOException $e){
    //         echo "ERR in createDR: ".$e->getMessage();
    //     }

    // }
    
    // function createTable(){

    //     global $dbname, $tbl_name;
    //     $db = connect_2_SQL($dbname);

    //     try{
    //         $query = "CREATE TABLE IF NOT EXISTS $tbl_name;";
    
    //         $statement = $db->prepare($query);
    //         $statement->execute();
    //         $statement->closeCursor();
    //     }
    //     catch(PDOException $e){
    //         echo "ERR in createTable: ".$e->getMessage();
    //     }

    // }

    function insert($data){

        global $dbname, $tbl_name;
        $db = connect_2_SQL($dbname);

        try{
            $query = "INSERT INTO $dbname\.$tbl_name (name, email, location, skills) VALUES (:name, :email, :location, :skills);";
    
            $statement = $db->prepare($query);
            foreach($data as $field => $field_val){
                $statement->bindParam(':'.$field, $field_val);
            }
            $statement->execute();
            $statement->closeCursor();
        }
        catch(PDOException $e){
            echo "ERR in insert: ".$e->getMessage();
        }

    }

?>