<?php

session_start();
if (!isset($_SESSION["username"])) {
    header("Location: employeelogin.php");
}
if(isset($_SESSION["privilege"]) && $_SESSION["privilege"] != 2 ){
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
$tblArr = array("meeting","payroll","review_technician");
$optArr = array("Meeting","Payroll","Review");
$table_name = $tblArr[$mn];
if($mn ==0){
    $fields = array("Date","Start Time","Type","Customer Name");
    $query = "select date as Date, s_time as 'Start Time', type as Type, customer.fname as 'Customer Name'".
            " from meeting,customer where meeting.technicianID=".$_SESSION['id']
            ." and meeting.customerID=customer.customerID";
}else if($mn == 1){
    $fields = array("Payroll ID","Cash Advance","Monthly Salary","Tax","Date Received","Net Income");
    $query="select payrollid, cash_advance, monthly_sal, tax, date, CONCAT('$', CAST((monthly_sal*(1-tax)) as varchar(15))) as 'Net Income' ".
            "from payroll where technicianID=" . $_SESSION['id'];
}else{
    $fields = array("Customer Name","Review");
    $query="select C.fname, T.review_text from review_technician as T, customer as C where C.customerID=T.customerID and T.technicianID=".$_SESSION['id'];
}
$data2dArr = array();
$result2 = mysqli_query($conn, $query);
$null = 1;
while ($line = mysqli_fetch_assoc($result2)) {
    $i = 0;
    $null = 0;
    foreach ($line as $col_value) {
        $data2dArr[$i][] = $col_value;
        $i++;
    }
}
if($null == 1){
    for($a = 0; $a < count($fields); $a++)
        $data2dArr[0][]="NULL";
}

?>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" 
              integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" href="../style/adminview.css" type="text/css"/>
        <title>Employee</title>
    </head>
    <body>
        <div class="head">
            <h1>NAILSTORE</h1>
        </div>
        <div class="website-body">
        <div class="nav-bar">
                <?php print "<h2>Welcome ". $_SESSION['firstname'] . "!</h2>" ?>
                <?php
                    for ($i = 0; $i < count($optArr); $i++) {
                        ?>
                        <p class="tag-link" style="<?php if($mn==$i) {print 'font-size: 20px; margin-left: 0px; margin-right: 0px; padding: 0px; background-color: rgb(72,133,217);';} ?>">
                            <?php
                            if ($mn == $i) {
                                ?>
                                <b style="height: 100%"><?php print $optArr[$i]; ?></b>
                                <?php
                            } else {
                                ?>
                                <a href="staffview.php?mn=<?php print $i; ?>">
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
                <?php if($mn == 0 || $mn == 1){?>
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
                <?php if($null == 0){ 
                    for ($j = 0; $j < count($data2dArr[0]); $j++) { ?>
                    <tr>
                    <?php for ($k = 0; $k < count($fields); $k++) { ?>
                        <td><?php print $data2dArr[$k][$j]; ?></td>
                        <?php }?>
                    </tr>
                    <?php }
                    }else{ 
                        for ($k = 0; $k < count($fields); $k++) { ?>
                        <td><?php print $data2dArr[0][$k]; ?></td>
                        <?php }
                    } ?>
                </table>
                <?php }else{ 
                    if($null==0){
                    for ($j = 0; $j < count($data2dArr[0]); $j++) {?>
                    <div class="review-card">
                    <?php for ($k = 0; $k < count($fields); $k++) { ?>
                        <p><?php print "<b>".$fields[$k]."</b>: ".$data2dArr[$k][$j]; ?></p>
                    <?php }?>
                    </div>
                    <?php } ?>
                <?php }else{ ?>
                    <p>There hasn't been any reviews for you.</p>
                <?php } 
                }?>
            </div>
        </div>
    </body>
</html>
