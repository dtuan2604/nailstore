

<?php

session_start();
if(!isset($_SESSION["cus_id"])){
    header("Location: directlogin.php?customer=true");
}
$dbhost = "localhost";
$dbuser = "root";
$dbpassword = "";
$dbname = "nailstore";
$conn = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname);
$query1 = "SELECT * FROM nail_technician";
$result1 = mysqli_query($conn, $query1);

?>
 
<html>
    <head>
        <meta charset="UTF-8">
        <title>
            Booking
        </title>
        <link rel="stylesheet"  href="homepage.css">
        <link rel="stylesheet"  href="slider.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet"  href="booking.css">
    </head>
    <body>

  
     
<!----------- Booking--------------->

<div class="wrapper">
    <div class ="overside">
        <h1>Time</h1>
        <?php
        if(isset($_SESSION['status']))
        {
            print "<h1>".$_SESSION['status']."</h1>";
            unset($_SESSION['status']);
        }
        ?>
    </div>
    <div class="container">
        <div class="leftside">
            <h1 class = "name">The Nail Shop</h1>
            <small class ="phonenumber">Phone number: 314-123-123</small>
            <h3 class="bookingtime">Booking Time</h3>
            <h4> Mon: 9:00 AM - 7:00 PM</h4>
            <h4> Tue: 9:00 AM - 7:00 PM</h4>
            <h4> Wed: 9:00 AM - 7:00 PM</h4>
            <h4> Thu: 9:00 AM - 7:00 PM</h4>
            <h4> Fri: 9:00 AM - 7:00 PM</h4>
            <h4> Sat: 9:00 AM - 7:00 PM</h4>
            <h4> Sun: 9:00 AM - 7:00 PM</h4>
            <h4> Booking available until 7:00 today</h4>
            <br>
            <h3  class="bookingtime" >Booking Details</h3>
            <h3>Nail Technician</h3>
            
                <?php
                    $id = $_GET['techId'];
                    $fname =$_GET['techfname'];
                    $lname =$_GET['techlname'];
                    print
                    "<h4>&emsp;{$fname} {$lname}</h4>";
                ?>

                <a class="comeback" href="booking.php">&emsp;Choose other Nail Tech</a>
                <br>
                <br>
                <h3>Services</h3>
                <?php
                $arrayService = array();
                    if(isset($_POST["submit"]))
                    {
                        if(!empty($_POST["serviceID"]))
                        {
                            
                            foreach ($_POST["serviceID"] as $service)
                            {
                                $arrayService[] = $service;
                                if($service==1){
                                     print "<h4>&emsp;Pedicure</h4>";
                                }
                                else if($service==2){
                                    print "<h4>&emsp;Manicure</h4>";
                                }
                                else{
                                    print "<h4>&emsp;Eyebrow</h4>";
                                }
                               
                            }
                            
                            print
                            "
                             <a class='comeback' href='make.php?techId={$id}&techfname={$fname}&techlname={$lname}'>&emsp;Choose other service</a>
                            ";
                        }
                        else
                        {
                            print "Please select at least one service";
                        }
                    }
                ?>
              
               
            
        </div>
 <!----------- Pick day and time--------------->
        <div class="rightside">
            <h2>Please pick the day for your appoiment</h2>
           <form action="calendar.php" method='post'>
            <?php
                foreach ($_POST["serviceID"] as $ID){
                    print "<input type='hidden' name='serviceID[]' value='".$ID."'/>";
                }
                print "<input type='hidden' name='techID' value='$id' />";
                foreach ($arrayService as $service) {
                    print "<input type='hidden' name='service[]' value='".$service."'/>";
                }
            
            $time = array('9:00:00','10:00:00', '11:00:00','12:00:00','1:00:00','2:00:00','3:00:00','4:00:00','5:00:00','6:00:00');
            print
                "<input type='date' name='dateofbooking'/>";
                foreach($time as $time){
                    print "<br/><input type='radio' name='time' value='$time'>$time</option>";
                }
            print "</select>
                <button type='submit' name='save_date' class='button button1'>Book Appointment</button>";
                ?>
           </form>

           
        </div>
    </div>
  
</div>
    
           

  


    </body>
</html>

<?php
if(isset($_POST['save_date']))
{
    $s_time= $_POST['time'];
    $techID = $_POST['techID'];
    $e_time = date('H:i:s',strtotime('+2 hour',strtotime($s_time)));
    $total_price = 100;
    $type=1;
    $date= date('Y-m-d', strtotime($_POST['dateofbooking']));
    $query2 ="INSERT INTO meeting (date,s_time,e_time,type,technicianID,customerID) VALUES ('$date','$s_time','$e_time',$type,".$techID.",".$_SESSION["cus_id"].")";
    print "<p>$query2</p>";  
    $query_run = mysqli_query($conn, $query2);
    $query3="SELECT meetingID FROM meeting WHERE date='$date' AND s_time='$s_time' AND technicianID=$techID AND customerID=".$_SESSION['cus_id']." ORDER BY meetingID DESC LIMIT 1";
    print "<p>$query3</p>";
    $query3_run = mysqli_query($conn, $query3);
    $meeting = mysqli_fetch_assoc($query3_run);
    // print "<p>$query3_run['meetingID']</p>"; 
    foreach ($_POST['serviceID'] as $service)
     {
          $query4="INSERT INTO has_service(meetingID,serviceID) VALUES (".$meeting['meetingID'].",$service)";
          print "<p>$query4</p>"; 
           $query4_run = mysqli_query($conn, $query4);
     }
   

    print "<p>$query3</p>"; 
    print "<p>".$meeting['meetingID']."</p>"; 


    if($query_run)
     {
         $_SESSION['meetingid'] = $meeting['meetingID'];
        header("Location: receipt.php");
     }
    else
    {
        $_SESSION['status'] = "Please try again";
        header("Location: receipt.php");
    }
    
}
?>