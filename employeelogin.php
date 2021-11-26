<?php

session_start();
if (isset($_SESSION["username"]) && isset($_SESSION["privilege"])) {
    if($_SESSION["privilege"] == 1){
        header("Location: adminview.php");
    }else{
        header("Location: staffview.php");
    }
}

$dbhost = "localhost";
$dbuser = "root";
$dbpassword = "";
$dbname = "nailstore";
$table_name = "nail_technician";
$conn = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname);

$login = filter_input(INPUT_POST, "login");
$username="";
$errmsg="";

if (!$conn) {
    die('Could not connect: ' . mysqli_connect_error());
}

if($login){
    $username = filter_input(INPUT_POST, "username");
    $search_username = "SELECT * FROM $table_name WHERE username='$username'";
    $result = mysqli_query($conn, $search_username);
    $line = mysqli_fetch_assoc($result);
    
    if($result && $line != null){
        $password = filter_input(INPUT_POST, "password");
        $actual_password = $line["password"];
        if ($password == $actual_password) {
            $_SESSION["firstname"] = $line["fname"];
            $_SESSION["username"] = $line["username"];
            $_SESSION["privilege"] = $line["privilege"];
            if($_SESSION["privilege"] == 1){
                header("Location: adminview.php");
            }else{
                header("Location: staffview.php");
            }
        } else {
            $errmsg = "Password is not correct. Please try again!";
        }
    }else{
        $errmsg = "This username doesn't exist. Please try again!";
    } 
    
}

?>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" 
              integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" href="./style/loginview.css" type="text/css"/>
        <title>LogIn</title>
    </head>
    <body>
        <div class="head">
            <h1>NAILSTORE</h1>
        </div>
        <div class="body-box">
            <div class="log-box">
                <p class="errmsg"><?php print $errmsg ?></p>
                <form action="employeelogin.php" method="post">
                    <input type="hidden" name="login" value="true" />
                    <label>Username: </label>
                    <input type="text" name="username" value="<?php print $username ?>" required/><br />

                    <label>Password: </label>
                    <input type="password" name="password" required/><br />

                    <label>&nbsp;</label>
                    <input type ="submit" class="btn btn-default" value ="Sign In" />
                </form>
            </div>
        </div>
    </body>
</html>
