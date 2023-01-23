<?php
    session_start();
    if(!isset($_SESSION["account"]))
    {
        header("location: login.php");
    }
?>
<html>
    <head>
        <title>Home</title>
        <link rel="stylesheet" href="CSS/style.css?version="/>
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
            <div id="welcome">
                <h2>Welcome...</h2>
                <p>What are you looking for today?</p>
            </div>

            <nav>
                <div class="link">
                    <a href="searchbook.php">Search/Reserve Book</a>
                </div>
                <div class="link">
                    <a href="reservations.php">Your Reservations</a>
                </div>

            </nav> 
        </div>
        
        <footer>
            <h6>Created by: Matthew Jungmann 2021</h6>
        </footer>
    </body>
</html>
