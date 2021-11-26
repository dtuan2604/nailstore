<?php
$dbhost = "localhost";
$dbuser = "root";
$dbpassword = "";
$dbname = "nailstore";
$conn = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname);
$mn = intval(filter_input(INPUT_POST,"mn"));
$tblArr = array("nail_technician","customer","marchandise","service","meeting");
$table_name = $tblArr[$mn];

if($mn == 0 || $mn == 1){
    $username = filter_input(INPUT_POST,"username");
    $email = filter_input(INPUT_POST,"email");

    $fname=filter_input(INPUT_POST,"fname");
    $lname=filter_input(INPUT_POST,"lname");

    $phone=filter_input(INPUT_POST,"phone");
    $dob=filter_input(INPUT_POST,"dob");
    $privilege=intval(filter_input(INPUT_POST,"privilege"));

    $checkusername = ($mn == 0 ) ? "select username from $table_name where " : "select email from $table_name where ";
    $checkusername .= ($mn == 0) ? "username='$username'" : "email='$email'";

    $result1 = mysqli_query($conn, $checkusername);
    $line = mysqli_fetch_assoc($result1);

    if($line == null){
        if($mn == 0){
            $password = filter_input(INPUT_POST,"password");
            $insert = "insert into $table_name (username,password,fname,lname,phone,dob,privilege) values('$username','$password','$fname','$lname','$phone','$dob',$privilege)";
            $result2 = mysqli_query($conn, $insert);

            if(!$result2){
                $codeerr = "02"; //something happens with database
                header("Location:adminview.php?mn=$mn&fname=$fname&lname=$lname&phone=$phone&dob=$dob&addtechnician=true&codeerr=$codeerr");
            }else{
                $success = "true";
                header("Location:adminview.php?mn=$mn&addtechnician=true&success=$success");
            }
        }else{
            $password = filter_input(INPUT_POST,"password");
            $insert = "insert into $table_name (email,password,fname,lname,phone,dob) values('$email','$password','$fname','$lname','$phone','$dob')";
            $result2 = mysqli_query($conn, $insert);
            if(!$result2){
                $codeerr = "12"; //something happens with database
                header("Location:adminview.php?mn=$mn&fname=$fname&lname=$lname&phone=$phone&dob=$dob&addcustomer=true&codeerr=$codeerr");
            }else{
                $success = "true";
                header("Location:adminview.php?mn=$mn&addcustomer=true&success=$success");
            }
        }

    }else{
        $codeerr = ($mn == 0) ? "01" : "11"; //existed username
        $add = ($mn == 0) ? "addtechnician" : "addcustomer";
        header("Location:adminview.php?mn=$mn&fname=$fname&lname=$lname&phone=$phone&dob=$dob&$add=true&codeerr=$codeerr");
    }
}
?>
