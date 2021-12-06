<?php
session_start();
if(isset($_SESSION["cus_username"])){
    header("Location: homepage.php");
}
$customer = filter_input(INPUT_GET,"customer");
if(!$customer){
    $customer = filter_input(INPUT_POST,"customer");
}

$dbhost = "localhost";
$dbuser = "root";
$dbpassword = "";
$dbname = "nailstore";
$conn = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname);
$email="";
$errmsg="";
if (!$conn) {
    die('Could not connect: ' . mysqli_connect_error());
}
if($customer){
    $cus_login = filter_input(INPUT_POST,"cus_login");
    if($cus_login){
        $table_name = "customer";
        $email = filter_input(INPUT_POST, "email");
        $search_email = "SELECT * FROM $table_name WHERE email='$email'";
        $result = mysqli_query($conn, $search_email);
        $line = mysqli_fetch_assoc($result);

        if($result && $line != null){
            $password = filter_input(INPUT_POST, "password");
            $actual_password = $line["password"];
            if ($password == $actual_password) {
                $_SESSION["firstname"] = $line["fname"];
                $_SESSION["cus_username"] = $line["email"];
                $_SESSION["cus_id"] = $line["customerID"];
        
                header("Location: homepage.php");
                
            } else {
                $errmsg = "Password is not correct. Please try again!";
            }
        }else{
            $errmsg = "This email doesn't exist. Please try again!";
        } 
    }
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>
            Log In
        </title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" 
              integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" href="../style/loginview.css" type="text/css"/>
        <link rel="stylesheet" href="../style/directlogin.css" type="text/css"/>
    </head>
    <body>
        <div class="head">
            <h1>NAILSTORE</h1>
        </div>
        <div class="body-box">
            <?php if($customer){?>
            <div class="log-box">
                <p class="errmsg"><?php print $errmsg ?></p>
                <form action="directlogin.php" method="post">
                    <input type="hidden" name="cus_login" value="true" />
                    <input type="hidden" name="customer" value="true" />
                    <label>Email: </label>
                    <input type="email" name="email" value="<?php print $email ?>" required/><br />

                    <label>Password: </label>
                    <input type="password" name="password" required/><br />

                    <label>&nbsp;</label>
                    <input type ="submit" class="btn btn-default" value ="Sign In" />
                </form>
            </div>
            <?php }else{ ?>
                <div class="dialog">
                    <a href="./directlogin.php?customer=true">
                        Login as Customer
                    </a>
                </div>
                <div class="dialog">
                    <a href="../admin/employeelogin.php">
                        Login as Technician
                    </a>
                </div>
            <?php } ?>
        </div>
    </body>
</html>