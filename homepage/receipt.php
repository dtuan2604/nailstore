
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
$query1 = "SELECT * FROM nail_technician, ";
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
        <h1>Receipt</h1>
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
            <h2>Your Appointent was successful!</h2>
            <h4>We will send you a confirmation shorty</h4>
            <br>
            <br>
        	</h3>Appointment Detail</h3>
        	<h4>-------------------</h4>
        	<?php
	        	if(isset($_SESSION['meetingid']))
	        {
	        	$query2="SELECT date,s_time,nail_technician.fname as fname, nail_technician.lname as lname FROM meeting, nail_technician  WHERE meeting.meetingid =".$_SESSION['meetingid']." AND meeting.technicianID = nail_technician.userid";
	            $result2 = mysqli_query($conn, $query2);
	            $query3="SELECT service.name as name FROM service, has_service WHERE has_service.meetingid=".$_SESSION['meetingid']." AND  service.serviceID = has_service.serviceID";

	            $result3 = mysqli_query($conn, $query3);
	            $data = mysqli_fetch_assoc($result2);
	         
	            print"<h4>Nail Technician: ".$data['fname']." ".$data['lname']."</h4>";
	            print"<h4>Date: ".date("m-d-Y",strtotime($data['date']))."</h4>";
	            print"<h4>Time: ".$data['s_time']."</h4>";
	            print"<h4>Services: </h4>";
	
	             while($row = mysqli_fetch_assoc($result3)){
	             	print"<h4>&emsp;".$row['name']."</h4>";
	             }
	            
	            unset($_SESSION['meetingid']);
                print "<a href='./homepage.php'> 
                        <button class='btn'>Back to the Home Page </button>
                        </a>";
	        }

        	?>
        	
            

 

        </div>
    </div>
</div>
    
           
     

    

<!--------Offer---->
  
<!-----Review------>
    

<!------------footer----->
  


    </body>
</html>