<?php
    session_start();
    require_once "library_db_conn.php";
    if(!isset($_SESSION["account"]))
    {
        header("location: login.php");
    }
    
    #get id from url
    $id = $_GET['id'];
    
    #get username from session variable
    $user = $_SESSION["account"];
 

    $sql = "SELECT Reserved FROM books WHERE ISBN='$id'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    $R = htmlentities($row['Reserved']);

    #Start if - executes if book is not already reserved
    if( $R == 'N')
    {
        $sql1 = "INSERT INTO reservations VALUES ('$id', '$user', CURDATE())";

        $sql2 = "UPDATE books SET Reserved = 'Y' WHERE ISBN = '$id' ";
        
        #start if - new values inserted into reservations and book is set to reserved
        if( ($conn->query($sql2) == TRUE) && ($conn->query($sql2) == TRUE) )
        {
            $conn->query($sql1);
            $conn->query($sql2);
            $_SESSION['success'] = "Reservation successful";
        }# end if

        #start else - values are not set and book is not reserved
        else
        {
            $_SESSION['error'] = "Reservation unsuccessful";
        }#end else

        header("Location: searchbook.php");
        return;
    }#end if

    #start else - selected book is already reserved
    else
    {
        $_SESSION['error'] = "You selected a book that is already reserved.";
        header("Location: searchbook.php");
        return;
    }#end else

    
?>
