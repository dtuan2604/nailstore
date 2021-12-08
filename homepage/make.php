
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
$query2 = "SELECT * FROM service";
$result2 = mysqli_query($conn, $query2);
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
            <h4> Booking available until 6:00 today</h4>
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
                <p id ="servicename" style="display: none">Pedicure</p>
              
        </div>
<!----------- Pick services--------------->
        <div class="rightside">
            <h2>Please pick all the serives that you want for your appoiment</h2>
             <form method ="post" action="calendar.php?techId=<?php
         
            print "{$id}&techfname={$fname}&techlname={$lname}";?>">
            <?php
             while($row = mysqli_fetch_assoc($result2)){
                print
                "<p><input id ='mycheck' type='checkbox' onclick='clickFunction()' name='serviceID[]' value='".$row['serviceID']."'/>".$row['name']."</p>";
                //print "<input type='hidden' name='serviceID[]' value='".$row['serviceID']."'/>";
               
               
            }
             ?>
              <p><input type="submit" name="submit" value="Next" /></p>
            </form>


        </div>
    </div>
  
</div>
    
           

  


    </body>
</html>
<script>
    function clickFunction(){
        for(i=0; i<3; i++){
            var checkbox = document.getElementById("mycheck");
        var text = document.getElementById("servicename");
        if(checkbox.checked == true){
            text.style.display ="block";
        }else{
            text.style.display="none";
         }
        }
        

    }
</script>