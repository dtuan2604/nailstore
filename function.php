<?php
$dbhost = "localhost";
$dbuser = "root";
$dbpassword = "";
$dbname = "nailstore";
$conn = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname);
$mn = intval(filter_input(INPUT_POST,"mn"));
$tblArr = array("nail_technician","customer","marchandise","service","meeting","marchant");
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
}else if($mn == 2){
    $merchandise = filter_input(INPUT_POST,"merchandise");
    $merchantid = intval(filter_input(INPUT_POST,"merchantid"));
    $query = "select * from marchant where marchantID=$merchantid";
    $result = mysqli_query($conn,$query);
    $merchant = mysqli_fetch_assoc($result);
    if($merchant == null){
        $codeerr = "21"; //the merchantID is not existed
        header("Location:adminview.php?mn=$mn&merchandise=$merchandise&codeerr=$codeerr&addmerchandise=true");
    }else{
        $quantity = intval(filter_input(INPUT_POST, "quantity"));
        if($quantity == 0){
            $codeerr="23";
            header("Location:adminview.php?mn=$mn&merchandise=$merchandise&addmerchandise=true&codeerr=$codeerr");
        }

        $insert="insert into $table_name (name,quantity,marchantID) values('$merchandise',$quantity,$merchantid)";
        $result2 = mysqli_query($conn, $insert);
        if(!$result2){
            $codeerr = "22"; //something happens with database
            header("Location:adminview.php?mn=$mn&merchandise=$merchandise&addmerchandise=true&codeerr=$codeerr");
        }else{
            $success = "true";
            header("Location:adminview.php?mn=$mn&addmerchandise=true&success=$success");
        }

    }
    
}else if($mn == 3){
    $name = filter_input(INPUT_POST,"name");
    $query = "select * from service where name='$name'";
    $result = mysqli_query($conn,$query);
    $line = mysqli_fetch_assoc($result);
    if($line == null){
        $type = filter_input(INPUT_POST,"type");
        $picture = filter_input(INPUT_POST,"picture");
        $duration = intval(filter_input(INPUT_POST,"duration"));
        $price = intval(filter_input(INPUT_POST,"price"));

        $insert = "insert into $table_name (name,type,picture,duration_min,price) values('$name','$type','$picture',$duration,$price)";
        $result2 = mysqli_query($conn, $insert);
        if(!$result2){
            $codeerr = "32"; //something happens with database
            header("Location:adminview.php?mn=$mn&addservice=true&codeerr=$codeerr");
        }else{
            $success = "true";
            header("Location:adminview.php?mn=$mn&addservice=true&success=$success");
        }
    }else{
        $codeerr = "31"; //the service name is already existed
        header("Location:adminview.php?mn=$mn&codeerr=$codeerr&addservice=true");
    }
}
?>
