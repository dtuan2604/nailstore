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

$sql = "SHOW COLUMNS FROM $table_name";
$result1 = mysqli_query($conn, $sql);

while ($record = mysqli_fetch_array($result1)) {
    $fields[] = $record['0'];
}
//Fetch the Current table and print it out
$data2dArr = array();
$query = "SELECT * FROM  $table_name";
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
        <title>Employee</title>
    </head>
    <body>
        <div class="nav-bar">
            <?php
                for ($i = 0; $i < count($optArr); $i++) {
                    ?>
                    <ul style="width: 7em">
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
                    </ul>
                    <?php
                }
                ?>
            <a href="./adminview.php?logout=true" id="logout-button">
                <button class="btn btn-default">LOG OUT</button> 
            </a>
        </div>
        <div class="main-view">
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
        </div>
        
        
        </div>
    </body>
</html>
