<?php
    session_start();
    require_once "library_db_conn.php";

    # code will not run unless user submits form
    if(isset($_POST['submit']))
    {
        #start if - check whether all fields in form are filled in by comparing the count of the filtered $_POST array with the count of the regular $_POST array
        if(count(array_filter($_POST)) != count($_POST))
        {
            $_SESSION['error'] = "Missing required fields.";
            header("Location: register.php");
            return;
        }# end if

        #start if - check if phone numbers entered are numeric
        if( is_numeric($_POST['Telephone']) && is_numeric($_POST['Mobile']) )
        {
            $U = $_POST['Username'];
            $N = $_POST['Firstname'];
            $S = $_POST['Surname'];
            $P = $_POST['Password'];
            $P2 = $_POST['PasswordCheck'];
            $A1 = $_POST['Address_line_1'];
            $A2 = $_POST['Address_line_2'];
            $C = $_POST['City'];
            $T = $_POST['Telephone'];
            $M = $_POST['Mobile'];

            
            if ( isset($_POST['Username']) && isset($_POST['Firstname']) && isset($_POST['Surname']) && isset($_POST['Password']) && isset($_POST['PasswordCheck']) && isset($_POST['Address_line_1']) && isset($_POST['Address_line_2']) && isset($_POST['City']) && isset($_POST['Telephone']) && isset($_POST['Mobile']) )
            {
                #start if - check if passwords are the same
                if($P == $P2)
                {
                    $sql= "INSERT INTO users ( Username, Password, FirstName, Surname, AddressLine1, AddressLine2, City, Telephone, Mobile) VALUE ( '$U', '$P', '$N', '$S', '$A1', '$A2', '$C', '$T', '$M')";

                    #start if - registration is successful
                    if ($conn->query($sql) === TRUE) 
                    {
                        $_SESSION['success'] = "Account creation successfull, please log in.";
                        header("Location: login.php");
                        return;

                    }#end if

                    #start else - username is already taken
                    else 
                    {
                        $_SESSION['error'] = "This username is taken";
                        header("Location: register.php");
                        return;
                    }#end else
                    $conn->close();
                }#end if
                else
                {
                    $_SESSION['errorPassword'] = "Passwords did not match.";
                    header("Location: register.php");
                    return;
                }#end else
            } #end if
        }#end if

        #start else - at least one of the phone numbers were not numeric
        else
        {
            $_SESSION['error'] = "Phone numbers must be numeric.";
            header("Location: register.php");
            return;
        }#end else
    }#end if
?>
    
<html>
    <head>
        <title>Register</title>
        <link rel="stylesheet" href="CSS/style.css?version=1"/>
    </head>
    <body>
        <header>
            <h1>Matthew's Library</h1>
        </header>
        
        <div id="main">
            <div id="content">
                <div class="input">
                    <h3>Register</h3>
                    <form method="post">
                        <?php           
                            if(isset($_SESSION["error"]))
                            {
                                echo ('<p style="color:red">'. $_SESSION["error"] . "</p>");
                                unset($_SESSION["error"]);
                            }
                        ?>

                        <input type="text" name="Username" placeholder="Username">

                        <br>
                        <br>

                        <input type="text" name="Firstname" placeholder="Firstname">
                        
                        <br>
                        <br>

                        <input type="text" name="Surname" placeholder="Surname">

                        <br>
                        <br>

                        <input type="text" name="Address_line_1" placeholder="Address Line 1"> 

                        <br>
                        <br>

                        <input type="text" name="Address_line_2" placeholder="Address Line 2"> 

                        <br>
                        <br>

                        <input type="text" name="City" placeholder="City">

                        <br>
                        <br>

                        <input type="text" name="Telephone" placeholder="Telephone">

                        <br>
                        <br>

                        <input type="text" name="Mobile" placeholder="Mobile">
                        
                        <br>
                        <br>
                        
                        <h6>Passwords must be 6 characters in length</h6>

                        <?php           
                            if( isset($_SESSION["errorPassword"]))
                            {
                                echo ('<p style="color:red">*'. $_SESSION["errorPassword"] . "</p>");
                                unset($_SESSION["errorPassword"]);
                            }
                        ?>

                        <input type="password" name="Password" placeholder="Enter Password">
                        
                        <br>
                        <br>

                        <input type="password" name="PasswordCheck" placeholder="Re-Enter Password">
                        
                        <br>
                        <br>

                        <input type="submit" name="submit" value="Create">
                    </form>
                </div>
            </div>
        </div>
        <footer>
            <h6>Created by: Matthew Jungmann 2021</h6>
        </footer>
    </body>
</html>
