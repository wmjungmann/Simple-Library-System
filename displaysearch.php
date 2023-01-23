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
        <link rel="stylesheet" href="CSS/style.css?=version1">
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
            <a href="searchbook.php"><- Back to search</a>
                <?php
                    require_once "library_db_conn.php";

                    if(!isset($_GET['page']))
                    {
                        $page = 1;
                    }
                    else
                    {
                        $page = $_GET['page'];
                    }
                    $results_per_page = 5;
                    $page_first_result = ($page - 1) * $results_per_page;

                    #start if - user searches by category and not book title
                    if($_SESSION['searchTitle'] == NULL)
                    {
                        $SEARCH = $_SESSION['category'];
                        $sql= "SELECT books.ISBN, books.BookTitle, books.Author, books.Edition, books.Year, books.Category,  books.Reserved, categories.CategoryName FROM books JOIN categories ON books.Category = categories.CategoryID WHERE categories.CategoryName = \"$SEARCH\" ";
                    }
                    #end if

                    #start else - user searches by book title
                    else
                    {
                        $SEARCH = $_SESSION['searchTitle'];
                        $sql= "SELECT ISBN, BookTitle, Author, Edition, Year, Category, Reserved FROM books WHERE BookTitle LIKE '%$SEARCH%' ";
                    }
                    #end else
                    
                    $result = mysqli_query($conn, $sql);
                    $number_of_result1 = mysqli_num_rows($result);
                    $number_of_page = ceil($number_of_result1/$results_per_page);

                    if ($result->num_rows> 0) 
                    {
                        #start if - user searches by category and not book title WITH limits
                        if($_SESSION['searchTitle'] == NULL)
                        {
                            $SEARCH = $_SESSION['category'];
                            $sql= "SELECT books.ISBN, books.BookTitle, books.Author, books.Edition, books.Year, books.Category,  books.Reserved, categories.CategoryName FROM books JOIN categories ON books.Category = categories.CategoryID WHERE categories.CategoryName = \"$SEARCH\" LIMIT $page_first_result, $results_per_page";
                        }
                        #end if

                        #start else - user searches by book title WITH limits
                        else
                        {
                            $SEARCH = $_SESSION['searchTitle'];
                            $sql= "SELECT ISBN, BookTitle, Author, Edition, Year, Category, Reserved FROM books WHERE BookTitle LIKE '%$SEARCH%' LIMIT $page_first_result, $results_per_page" ;
                        }
                        #end else

                        $result = mysqli_query($conn, $sql);
                        $number_of_result = mysqli_num_rows($result);

                        echo "<h3>" .  $number_of_result1 . " Results Found for '" . $SEARCH . "' | Displaying  results " . $page_first_result + 1 . "-". $page_first_result + 5 . "</h3>" ;
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
                        echo("</td><td>");
                        echo "Reserved";
                        echo("</td>");
                        echo("</tr>\n");
                        # output data of each row
                        //$result->fetch_assoc()
                        while($row = mysqli_fetch_array($result)) 
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
                            echo(htmlentities($row["Reserved"]));
                            echo("</td><td>");
                            echo('<a href="reserve.php?id=' .htmlentities($row["ISBN"]).'">Reserve</a>');
                            echo("</tr>\n");
                        } 
                        echo "</table>\n";

                        if($page > 1)
                        {
                            echo "<a href='displaysearch.php?page=" . ($page - 1) . "'> Next </a>";
                        }
                        
                        if($page < $number_of_page)
                        {
                            echo "<a href='displaysearch.php?page=" . ($page + 1) . "'> Next </a>";
                        }
                        echo "</center>";
                    
                    }

                    #start else - no results are found
                    else 
                    {
                    echo "0 results";
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
