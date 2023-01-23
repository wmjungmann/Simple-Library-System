<?php
    session_start();
    require_once "library_db_conn.php";

    unset($_SESSION['searchTitle']);
    unset($_SESSION['category']);

    if(!isset($_SESSIOAN["account"]))
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
            <a href="lib_index.php"><- Back to menu</a>
            <div id="content">
                <div class="input">
                    <h3>What book are you looking for?</h3>
                        <?php
                            #start if - display error message if book can not be reserved
                            if(isset($_SESSION["error"]))
                            {
                                echo ('<p style="color:red">'. $_SESSION["error"] . "</p>");
                                unset($_SESSION["error"]);
                            }#end if

                            #start if - display success message if reservation is successful
                            if(isset($_SESSION["success"]))
                            {
                                echo ('<p style="color:green">'. $_SESSION["success"] . "</p>");
                                unset($_SESSION["success"]);
                            }#end if
                        ?>
                    <form method="post">
                        <label>Title: </label>
                        <input type="text" name="searchTitle">

                        <br><br>

                        <label>Category:</label>
                        <select id="categories" name="category">
                            <option>None</option>
                            <?php
                                $sql_cat = "SELECT CategoryName FROM categories";
                                $result_cat = $conn->query($sql_cat);
                                #start while - get categories from database so user can search by category
                                while($row_cat = $result_cat->fetch_assoc())
                                {
                                    echo "<option value=\"";
                                    echo(htmlentities($row_cat["CategoryName"]));
                                    echo "\">";
                                    echo(htmlentities($row_cat["CategoryName"]));
                                    echo "</option>";
                                }#end while
                            ?>
                        </select>

                        <br><br>

                        <input type="submit" name="submit_search" value="Go">

                    </form>
                </div>
                <?php
                    require_once "library_db_conn.php";
                    if(isset($_POST['submit_search']))
                    {
                        $_SESSION['searchTitle'] = $_POST['searchTitle'];
                        $_SESSION['category'] = $_POST['category'];
                        header("location: displaysearch.php");
                    }
                    
                    
                    $conn->close();
                ?>      
            </div>

        </div>
    <footer>
        <h6>Created by: Matthew Jungmann 2021</h6>
    </footer>  
    </body>
</html>
