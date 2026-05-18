<?php

class myDB{
    
    function createConn(){
        $host = "localhost";
        $user = "root";
        $password = "";
        $database = "clothing_store";

        $conn = new mysqli($host, $user, $password, $database);
        return $conn;
    }

    function closeConn($conn){
        $conn->close();
    }

}

?>