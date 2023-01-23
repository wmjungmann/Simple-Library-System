<?php
    session_start();
    require_once "library_db_conn.php";
    if(!isset($_SESSION["account"]))
    {
        header("location: login.php");
    }
?>

<html>
    <head>
        <title>Search</title>
        <link rel="stylesheet" href="CSS/style.css?version=2">
    </head>
    <body>
        <header>
            <div class="headerDiv">
                <h1>Matthew's Library</h1>
            </div>
            <div class="headerDiv" id="headerRight">
                <a href="logout.php"><button>Log Out</button></a>
            </div>
        </header>
        <div id="main">
            <a href="lib_index.php"><-Back to menu</a>
            <div id="resText">
                <h2>My reservations</h2> 
            </div>
            <div id="content">
                <?php
                    $USER = $_SESSION["account"];
                    $sql = "SELECT books.ISBN, books.BookTitle, books.Author, books.Edition, books.Year, books.Category, books.Reserved FROM books JOIN reservations ON books.ISBN = reservations.ISBN WHERE reservations.Username = \"$USER\" ";
                    $result = $conn->query($sql);

                    #start if - query returned with at least one result
                    if ($result->num_rows> 0) 
                    {
                        echo "<center>";
                        echo "<table border ='1'>";
                        echo "<tr><td>";
                        echo "ISBN";
                        echo("</td><td>");
                        echo "Title";
                        echo("</td><td>");
                        echo "Author";
                        echo("</td><td>");
                        echo "Edition";
                        echo("</td><td>");
                        echo "Published";
                        echo("</td><td>");
                        echo "Category ID";
                        echo("</td>");
                        echo("</tr>\n");

                        #start while - output each row of data selected from database into a table
                        while($row = $result->fetch_assoc()) 
                        {
                            echo "<tr><td>";
                            echo(htmlentities($row["ISBN"]));
                            echo("</td><td>");
                            echo(htmlentities($row["BookTitle"]));
                            echo("</td><td>");
                            echo(htmlentities($row["Author"]));
                            echo("</td><td>");
                            echo(htmlentities($row["Edition"]));
                            echo("</td><td>");
                            echo(htmlentities($row["Year"]));
                            echo("</td><td>");
                            echo(htmlentities($row["Category"]));
                            echo("</td><td>");
                            echo('<a href="unreservebook.php?id='.htmlentities($row["ISBN"]).'">Cancel</a>');
                            echo("</tr>\n");
                        }#end while

                        echo "</table>\n";
                        echo "</center>";
                    }#end if

                    #start else - no results returned from query
                    else 
                    {
                    echo "You have no reservations.";
                    }#end else
            
                    $conn->close();
                ?>    
            </div>  
        </div>
    <footer>
        <h6>Created by: Matthew Jungmann 2021</h6>
    </footer>  
    </body>
</html>
