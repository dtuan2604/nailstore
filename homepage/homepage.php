<?php
session_start();
$logout = filter_input(INPUT_GET, "logout");
if ($logout) {
    session_destroy();
    header("Location: homepage.php");
}
$dbhost = "localhost";
$dbuser = "root";
$dbpassword = "";
$dbname = "nailstore";
$conn = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname);
$query1 = "SELECT * FROM service";
$result1 = mysqli_query($conn, $query1);
$query2 ="SELECT fname,lname, review_text, picture FROM review_technician,customer WHERE customer.customerID = review_technician.customerID";
$result2 = mysqli_query($conn, $query2);
?>
 
<html>
    <head>
        <meta charset="UTF-8">
        <title>
            Nail Shop
        </title>
        <link rel="stylesheet"  href="homepage.css">
        <link rel="stylesheet"  href="slider.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
    <body>

        <div class="header">
             <div class="container">
             <div class ="navbar">
                <div class = "logo">
                <img src="images/logo1.png" width="225px">
            </div>
                <nav>
                    <ul>
                        <li><a href="homepage.php">Home</a></li>
                        <li><a href="">Services</a></li>
                        <li><a href="about.php">About</a></li>
                        <li><a href="">Contact</a></li>

                        <?php 
                        if(isset($_SESSION["cus_username"])){
                            print "<li><a href='./homepage.php?logout=true'>Log Out</a><li>";
                        }else{ 
                            print "<li><a href='./directlogin.php'>Account</a></li>";
                            }
                        ?>
                    </ul>
                </nav>

        </div>
        <div class="row">
            <div class="col-2">
                <?php 
                if(isset($_SESSION["cus_username"])){
                    print "<h1>Hello ".$_SESSION['firstname']."!</h1>";
                } 
                ?>               
                <h1>Welcome to<br> Nail Shop!</h1>
                <p> Where that you can live with your new style and <br>
                enjoy every minute of your life with beauty</p>
                <a href="./booking.php" class ="btn">Booking Our Service Now &#8594;</a>
            </div>



            <div  class="slider">
                <div class ="slides">
                <input type="radio" name="radio-btn" id="radio1"></input>
                <input type="radio" name="radio-btn" id="radio2"></input>
                <input type="radio" name="radio-btn" id="radio3"></input>
                <input type="radio" name="radio-btn" id="radio4"></input>
                <div class ="slide first">
                    <img src="images/banner7.jpg">
                </div>
                <div class ="slide">
                    <img src="images/banner3.png">
                </div>
                <div class ="slide">
                    <img src="images/banner5.jpg">
                </div>
                <div class ="slide">
                    <img src="images/banner1.webp">
                </div>

                <div class ="navigation-auto">
                    <div class = "auto-btn1"></div>
                    <div class = "auto-btn2"></div>
                    <div class = "auto-btn3"></div>
                    <div class = "auto-btn4"></div>
                </div>
            </div>
        
            <div class ="navigation-manual">
            <label for ="radio1" class ="manual-btn"></label>
            <label for ="radio2" class ="manual-btn"></label>
            <label for ="radio3" class ="manual-btn"></label>
            <label for ="radio4" class ="manual-btn"></label>
                
            </div>
        </div>
        </div>
        </div>
        </div>
<!----------- inside shop picture--------------->
    <div class ="gallery">
        <div class="small-container">
            <div class="row">
            <div class="col-3">
                <img src="images/gallery2.jpg" >
            </div>
            <div class="col-3">
                <img src="images/gallery3.jpg" >
            </div>
            <div class="col-3">
                <img src="images/gallery4.jpg" >
            </div>
        </div>
        </div>
        
    </div>
 <!-----------service------------->
    <div class ="small-container">
        <h2 class="title">Our Services</h2>
        <div class ="row">
            
                <?php 
                while($row = mysqli_fetch_assoc($result1)){
                         print
                     "<div class='col-4'>
                      <img src='".$row['picture']."''>
                     <h4>".$row['name']."</h4>
                     <div class ='rating'>
                        <i class='fa fa-star'></i>
                        <i class='fa fa-star'></i>
                        <i class='fa fa-star'></i>
                        <i class='fa fa-star'></i>
                        <i class='fa fa-star'></i>
                    </div>
                    <p>$".$row['price']. "</p>
                    </div>";
                }

                ?>
 
           
        </div>
    </div>


    <!----------Gallery--------->
        <h2 class="title">Our Gallery</h2>
        <div class ="row">
            
            <div class="col-4">
                <img src="images/g8.jpg">
            </div>
            <div class="col-4">
                <img src="images/g7.jpg">
                
            </div>
            <div class="col-4">
                <img src="images/g6.jpg">
                
            </div>
            <div class="col-4">
                <img src="images/g5.jpg">
                
            </div>
            <div class="col-4">
                <img src="images/g6.jpg">
                
            </div>
            <div class="col-4">
                <img src="images/g8.jpg">
                
            </div>
            <div class="col-4">
                <img src="images/g5.jpg">
                
            </div>
            <div class="col-4">
                <img src="images/g7.jpg">
                
            </div>


    </div>

<!--------Offer---->
    <div class="offer">
        <div class="small-container">
            <div class="row">
                <div class="col-2">
                    <img src="images/offer.png" class ="offer-img">
                </div>
                <div class="col-2">
                    <h1>Big Offer For Holiday</h1>
                    <small>5% off for all services on Christmas Day and New Year Day</small>
                    <br>
                    <a href="" class="btn">View Offer Detail &#8594;</a>
                </div>
            </div>
        </div>
    </div>

<!-----Review------>
    <div class="review">
        <div class="small-container">
            <div class="row">
                 <?php 
                 $i = 0;
                while($row = mysqli_fetch_assoc($result2)){
                    $i++;
                    if($i > 3){break;}

                    print
                    "<div class='col-3'>
                <i class='fa fa-quote-left'></i>
                <p>".$row['review_text']."</p>
                <div class ='rating'>
                <i class='fa fa-star'></i>
                <i class='fa fa-star'></i>
                <i class='fa fa-star'></i>
                <i class='fa fa-star'></i>
                <i class='fa fa-star'></i>
                    </div>
                    <img src='".$row['picture']."' >
                    <h3>".$row['fname']. " ".$row['lname']."</h3>
                    </div>
                    ";
                }
                     ?>
            </div>
        </div>
    </div>

<!------------footer----->
    <div class ="footer">
        <div class="container">
            <div class="row">
                <div class="footer-col-0">
                    <h3>Dowload Our App</h3>
                    <p>Dowload App for Android and IOS mobile phone.</p>
                    <div class ="app-logo">
                        <img src="images/google-play-store-button.png">
                        <img src="images/app-store.png">
                    </div>
                </div>
                <div class="footer-col-1">
                    <img src="images/logo.png" width="125px">
                </div>
                <div class="footer-col-2">
                    <h3>Nail Shop</h3>
                    <p><i class="fa fa-map-marker" aria-hidden="true"></i>&nbsp;123 UMSL, St. Louis, Missouri 63141
                        <br><i class="fa fa-phone" aria-hidden="true"></i>&nbsp;314-234-234
                        <br><i class="fa fa-envelope" aria-hidden="true"></i>&nbsp;anthonynguyen@gmail.com</p>
                </div>
                <div class="footer-col-3">
                  <h3>Follow us</h3>
                  <ul>
                    <li><i class="fa fa-facebook-square" aria-hidden="true"></i></li>
                    <li><i class="fa fa-twitter-square" aria-hidden="true"></i></li>
                    <li><i class="fa fa-instagram" aria-hidden="true"></i></li>
                    <li><i class="fa fa-youtube" aria-hidden="true"></i></li>
                  </ul>
                </div>
            </div>

            <hr>
            <p class="copyright">Copyright 2021 by Team 1 Project</p>
        </div>
    </div>


<script type = "text/javascript">
    var counter = 1;
    setInterval(function(){
        document.getElementById('radio' + counter).checked = true;
        counter++;
        if(counter > 4){
            counter = 1;
        }
    }, 5000);
 </script>
    </body>
</html>