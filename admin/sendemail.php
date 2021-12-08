<?php
    print "<p>It takes a lot of time and effort to set up a server to send an email to customer before appointment day</p>";
    print "<p>Therefore, I would print a list of customer who will receive a notification email.</p>";

    $dbhost = "localhost";
    $dbuser = "root";
    $dbpassword = "";
    $dbname = "nailstore";
    $conn = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname);

    $result = mysqli_query($conn,'SELECT * FROM meeting');
    $customers = array();
    while($row = mysqli_fetch_assoc($result)) {$customers[] = $row;}
    
    # loop through users and (if you didn't already check) see which ones have signed up (4 weeks)*n ago
    foreach ($customers as $customer) {
        # take the number of seconds and convert it to number of days
        $today = (int)(strtotime(date('c')) / 60 / 60 / 24);
        $meetingday = (int)(strtotime($customer['date']) / 60 / 60 / 24);
       
        if (($today - $meetingday) >= 0 && ($today - $meetingday) <= 1) {
            $id = $customer['customerID'];
            $subject = "Appointment Reminder";
            $query = "select * from customer where customerID = $id";
            $getemail = mysqli_query($conn,$query);
            $line = mysqli_fetch_assoc($getemail);
            $email = $line['email'];
            $fname = $line['fname'];
            $s_time = $customer['s_time'];

            $message="<html>
            <head>
            <title>NailStore</title>
            </head>
            <body>
            <p>Hello $fname!!!</p>
            <p>We would like to send you a reminder for your appointment at $s_time on ".$customer['date']."</p>
            <p>Thank you!</p>
            </body>
            </html>";
            print "<b>Customer email: $email</b><br />";
            print "<b>Subject: $subject</b>";
            print "$message";
            print "<br /><br />";

            // $headers = "MIME-Version: 1.0" . "\r\n";
            // $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            // $headers .= 'From: <tdhhxn@umsystem.edu>' . "\r\n";
            // mail($email,$subject,$message,$headers);
        }
    }

?>