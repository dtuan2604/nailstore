<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: employeelogin.php");
}
$logout = filter_input(INPUT_GET, "logout");
if ($logout) {
    session_destroy();
    header("Location: employeelogin.php");
}

?>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" 
              integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" href="./style/adminview.css" type="text/css"/>
        <title>Employee</title>
    </head>
    <body>
        <p>Hello from admin view</p>
        <a href="./adminview.php?logout=true" id="logout-button">
            <button class="btn btn-default">LOG OUT</button> 
        </a>
        </div>
    </body>
</html>
