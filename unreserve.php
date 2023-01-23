<?php
    session_start();
    require_once "library_db_conn.php";
    if(!isset($_SESSION["account"]))
    {
        header("location: login.php");
    }
    
    # start if - check that id and delete confirmation are set
    if(isset($_GET['id']))
    {
        #delet row from reservations table using ISBN
        $id = $conn -> real_escape_string($_GET['id']);
        $sql = "DELETE FROM reservations WHERE ISBN = \"$id\"";
        $conn->query($sql);
        header("Location: reservations.php");
        return;
    }# end if

?>
