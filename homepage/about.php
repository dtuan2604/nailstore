
<?php
session_start();
$logout = filter_input(INPUT_GET, "logout");
if ($logout) {
    session_destroy();
    header("Location: homepage.php");
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>
            About
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
                        <li><a href="service.php">Services</a></li>
                        <li><a href="">About</a></li>
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
       
        </div>
        </div>
     
<!----------- About--------------->
    
     <div class="about">
        <div class="small-container">
            <div class="row">
                <div class="col-2">
                    <img src="images/about.png" class ="offer-img">
                </div>
                <div class="col-2">
                    <h1>The Nail Shop</h1>
                    <h4>Located conveniently in St. Louis, Missouri The NAil SHop is committed to bringing you the best moment than ever.<br>

At THe nail Shop, your waxing and nail salon in St. Louis, we offer a warm, welcoming atmosphere where you can escape the stresses of everyday life and enjoy our transformative spa and salon services. We provide everything you need to renew your nails, skin, and mood in one location. Whether it’s time for a girls’ day or you just need to do something for yourself, we’re your go-to oasis. Visit us for waxing services, manicures, and more.<br>

Our nail salon understands that Safety and Sanitation are key to your peace of mind. Our implements are medically sterilized and disinfected after each use. Buffers and files are used only once then discarded. All pedicure procedures are done with liner protection. And above all, staffs are trained to follow a proper sanitization protocol that puts clients hygiene as the number one priority.<br>
Come pamper yourself and experience the ultimate service. Call Us to set an appointment, or just walk in any time.<br>

</h4>
                    <br>
                    
                </div>
            </div>
        </div>
    </div>
       

<!--------Offer---->
    <div class="offer">
        <div class="small-container">
            <div class="row">
                <div class="col-2">
                    <h1>The Nail Shop</h1>
                    <h4></h4>
                </div>
                <div class="col-2">
                	<br>
                    <h2>BUSINESS HOURS</h2>
                    <h3>Mon - Fri: 9:30 am - 7:30 pm </h3>
                    <h3>Saturday:  9:00 am - 6:00 pm </h3>
                    <h3>Sunday:   11:00 am - 5:00 pm </h3>
                    <br>
                   
                </div>
            </div>
        </div>
    </div>

<!-----Review------>
    

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