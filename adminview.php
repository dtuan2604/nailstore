<?php
session_start();
if (!isset($_SESSION["username"]) && !isset($_SESSION["privilege"]) && $_SESSION["privilege"] != 1 ) {
    header("Location: employeelogin.php");
}
$logout = filter_input(INPUT_GET, "logout");
if ($logout) {
    session_destroy();
    header("Location: employeelogin.php");
}
$dbhost = "localhost";
$dbuser = "root";
$dbpassword = "";
$dbname = "nailstore";
$conn = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname);
$mn = intval(filter_input(INPUT_GET, "mn"));

$tblArr = array("nail_technician","customer","marchandise","service","meeting");
$optArr = array("Technician","Customer","Merchandise","Service","Meeting");
$table_name = $tblArr[$mn];

if($mn == 0){
    $fields[0] = "Technician ID"; $fields[1] = "Username"; $fields[2] = "Password";
    $fields[3] = "First Name"; $fields[4] = "Last Name";
    $fields[5] = "Phone Number"; $fields[6] = "Birthdate"; $fields[7] = "Privilege";
    $addtechnician = filter_input(INPUT_GET, "addtechnician");
}else if($mn == 1){
    $fields[0] = "Customer ID"; $fields[1] = "First Name"; $fields[2] = "Last Name";
    $fields[3] = "Email"; $fields[4] = "Password";
    $fields[5] = "Birthdate"; $fields[6] = "Point Reward"; $fields[7] = "Phone Number";
    $addcustomer = filter_input(INPUT_GET, "addcustomer");
}else if($mn == 2){
    $fields[0] = "Merchandise ID"; $fields[1] = "Merchandise Name"; $fields[2] = "Quantity";
    $fields[3] = "Merchant ID"; $fields[4]  = "Merchant Name"; 
    $addmerchandise = filter_input(INPUT_GET, "addmerchandise");
}else if($mn == 3){
    $fields[0] = "Service ID"; $fields[1] = "Service Name"; $fields[2] = "Service Type";
    $fields[3] = "Picture"; $fields[4] = "Duration"; $fields[5] = "Price"; 
    $addservice = filter_input(INPUT_GET, "addservice");
}else{
    $fields[] = "Meeting ID"; $fields[] = "Total Price"; $fields[] = "Start Time";
    $fields[] = "End Time"; $fields[] = "Date"; $fields[] = "Meeting Type";
    $fields[] = "Review"; $fields[] = "Technician ID"; $fields[] = "Customer ID";
    $fields[] = "Technician Name"; $fields[] = "Customer Name";
}
//Fetch the Current table and print it out
$data2dArr = array();

if($mn == 2){
    $query="select T.*, marchant.name as 'marchant name' from marchandise as T, marchant where T.marchantID = marchant.marchantID";
}else if($mn == 4){
    $query = "select T.*, nail_technician.fname, customer.fname as 'customer name' from meeting as T, nail_technician, customer where T.technicianID = nail_technician.userid and"
            ." T.customerID = customer.customerID order by meetingid asc";
}else{
    $query = "SELECT * FROM  $table_name";
}
$result2 = mysqli_query($conn, $query);
while ($line = mysqli_fetch_assoc($result2)) {
    $i = 0;
    foreach ($line as $col_value) {
        $data2dArr[$i][] = $col_value;
        $i++;
    }
}

?>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" 
              integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" href="./style/adminview.css" type="text/css"/>
        <script src="./javascript/validate.js"></script>
        <title>Employee</title>
    </head>
    <body>
        <div class="nav-bar">
            <?php
                for ($i = 0; $i < count($optArr); $i++) {
                    ?>
                    <p>
                        <?php
                        if ($mn == $i) {
                            ?>
                            <b><?php print $optArr[$i]; ?></b>
                            <?php
                        } else {
                            ?>
                            <a href="adminview.php?mn=<?php print $i; ?>">
                                <?php print $optArr[$i]; ?>
                            </a>
                            <?php
                        }
                        ?>
                    </p>
                    <?php
                }
                ?>
            <a href="./adminview.php?logout=true" id="logout-button">
                <button class="btn btn-default">LOG OUT</button> 
            </a>
        </div>
        <div class="main-view">
            <?php if($mn == 0 && $addtechnician == "true"){ ?>
            <form action="./function.php" method="post">
                <?php $coderr = filter_input(INPUT_GET,"codeerr");
                    $success = filter_input(INPUT_GET,"success");
                    $fname = filter_input(INPUT_GET,"fname");
                    $lname = filter_input(INPUT_GET,"lname");
                    $phone = filter_input(INPUT_GET,"phone");
                    $dob = filter_input(INPUT_GET,"dob");
                    if($coderr == "01"){
                        print "<p class='errmsg'>This username has already existed, please try another one!</p>";  
                    }else if($coderr == "02"){
                        print "<p class='errmsg'>Cannot add this username, please try again!</p>";  
                    }
                    if($success){
                        print "<p class='succmsg'>Successfully add this employee!</p>";
                    }
                ?>
                <input type="hidden" name="mn" value="<?php print $mn ?>" />
                <div style="margin: 2%">
                    <label>Role: </label>
                    <input type="radio" name="privilege" value="1" required/>
                    <span>Admin</span>
                    <input type="radio" name="privilege" value="2" required />
                    <span>Staff</span>
                </div>
                <div class="personal-info">
                    <label>First Name:</label><br />
                    <input type="text" name="fname" value="<?php print $fname ?>" required/>
                </div>
                <div class="personal-info">
                    <label>Last Name:</label><br />
                    <input type="text" name="lname" value="<?php print $lname ?>"required/>
                </div>
                <div class="personal-info">
                    <label>Birth Date (YYYY-MM-DD):</label><br />
                    <input type="text" name="dob" id="dob" value="<?php print $dob ?>" onchange="validate()" required/><br />
                    <p class="errmsg" style="display: none; font-size: small; position: absolute" id="bderror">
                        Please enter the date as specified format YYYY-MM-DD
                    </p>
                </div>
                <div class="personal-info">
                    <label>Phone Number (XXX-XXX-XXXX):</label><br />
                    <input type="text" name="phone" id="phone" value="<?php print $phone ?>" onchange="validate()" required/>
                    <p class="errmsg" style="display: none; font-size: small; position: absolute" id="phoneerror">
                        Please enter the phone number as specifies format XXX-XXX-XXXX
                    </p>
                </div>
                <div class="personal-info">
                    <label>Username:</label><br />
                    <input type="text" name="username" required/>
                </div>
                <div class="personal-info">
                    <label>Password:</label><br />
                    <input type="password" name="password" required/>
                </div>
                <input type="submit" id="tech-submit" class="btn btn-default" />
            </form>
            <a href="./adminview.php?mn=<?php print $mn ?>">
                <button class="btn btn-default" id="add-info-button">Cancel</button>   
            </a>
            <?php }else if($mn == 1 && $addcustomer == "true"){ ?>
                <?php $coderr = filter_input(INPUT_GET,"codeerr");
                    $success = filter_input(INPUT_GET,"success"); 
                    $fname = filter_input(INPUT_GET,"fname");
                    $lname = filter_input(INPUT_GET,"lname");
                    $phone = filter_input(INPUT_GET,"phone");
                    $dob = filter_input(INPUT_GET,"dob");
                    if($coderr == "11"){
                        print "<p class='errmsg'>This username has already existed, please try another one!</p>";  
                    }else if($coderr == "12"){
                        print "<p class='errmsg'>Cannot add this account, please try again!</p>";  
                    }
                    if($success){
                        print "<p class='succmsg'>Successfully add this customer!</p>";
                    }
                    ?>
                    <form action="function.php" method="post">
                        <input type="hidden" name="mn" value="<?php print $mn ?>" />
                        <div class="personal-info">
                            <label>First Name:</label><br />
                            <input type="text" name="fname" value="<?php print $fname ?>" required/>
                        </div>
                        <div class="personal-info">
                            <label>Last Name:</label><br />
                            <input type="text" name="lname" value="<?php print $lname ?>"required/>
                        </div>
                        <div class="personal-info">
                            <label>Birth Date (YYYY-MM-DD):</label><br />
                            <input type="text" name="dob" id="dob" value="<?php print $dob ?>" onchange="validate()" required/><br />
                            <p class="errmsg" style="display: none; font-size: small; position: absolute" id="bderror">
                                Please enter the date as specified format YYYY-MM-DD
                            </p>
                        </div>
                        <div class="personal-info">
                            <label>Phone Number (XXX-XXX-XXXX):</label><br />
                            <input type="text" name="phone" id="phone" value="<?php print $phone ?>" onchange="validate()" required/>
                            <p class="errmsg" style="display: none; font-size: small; position: absolute" id="phoneerror">
                                Please enter the phone number as specifies format XXX-XXX-XXXX
                            </p>
                        </div>
                        <div class="personal-info">
                            <label>Email:</label><br />
                            <input type="email" name="email" required/>
                        </div>
                        <div class="personal-info">
                            <label>Password:</label><br />
                            <input type="password" name="password" required/>
                        </div>
                        <input type="submit" id="tech-submit" class="btn btn-default" />
                    </form>
                    <a href="./adminview.php?mn=<?php print $mn ?>">
                        <button class="btn btn-default" id="add-info-button">Cancel</button>   
                    </a>
            <?php }else if($mn == 2 && $addmerchandise == "true"){ ?>
                
            <?php }else if($mn == 3 && $addservice == "true"){ ?>
                
            <?php }else{ ?>
            <table>
                <tr>
                <?php
                for ($i = 0; $i < count($fields); $i++) {
                    ?>
                    <th style="width: 8em"><?php print $fields[$i]; ?></th>
                    <?php
                }
                ?>
                </tr>
                <?php for ($j = 0; $j < count($data2dArr[0]); $j++) { ?>
                    <tr>
                    <?php for ($k = 0; $k < count($fields); $k++) { ?>
                        <td><?php print $data2dArr[$k][$j]; ?></td>
                        <?php }?>
                    </tr>
                    <?php } ?>
            </table>
            <?php if($mn != 4){ ?>
            <a id="add-info" href="./adminview.php?mn=<?php print $mn . "&"?><?php 
                if($mn == 0){print "addtechnician=true";}
                else if($mn == 1) {print "addcustomer=true";}
                else if($mn == 2) {print "addmerchandise=true";}
                else if($mn == 3) {print "addservice=true" ;}
            ?>">
                <button class="btn btn-default" id="add-info-button">
                    <?php
                        if($mn == 0){print "Add Technician";}
                        else if($mn == 1) {print "Add Customer";}
                        else if($mn == 2) {print "Add Item";}
                        else if($mn == 3) {print "Add Service" ;}
                    ?>
                </button>
            </a>
            <?php }
            }?>
        </div>
    </body>
</html>
