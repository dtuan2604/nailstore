
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

  
     
<!----------- About--------------->
<div class="wrapper">
    <div class ="overside">
        <h1 class="title1">Booking Side</h1>
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
        </div>
        <div class="rightside">
            <h2>Choose nail technician you want to book with</h2>
            <br>
            <div class="row">

                 <?php 
                while($row = mysqli_fetch_assoc($result1)){
                         print
                     "<div class='col-3'>
                     <i class='fa fa-user-circle-o' aria-hidden='true'></i>"
                     .$row['fname']." ".$row['lname'].
                     "<br><a href='make.php?techId=".$row['userid']."&techfname=".$row['fname']."&techlname=".$row['lname']."'>
                      
                    <input type='submit'  value='Book With ".$row['fname']."' class='button button1'></a>
                    </div>";
                }

                ?>




            

        </div>
        </div>
    </div>
</div>
    
           
     

    

<!--------Offer---->
  
<!-----Review------>
    

<!------------footer----->
  


    </body>
</html>