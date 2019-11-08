<!-- Citation: https://www.w3schools.com/w3css/tryit.asp?filename=tryw3css_templates_band&stacked=h -->
<?php
ini_set("session.cookie_httponly", 1);
session_start();
require 'database2.php'
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/themes/start/jquery-ui.css" type="text/css" rel="Stylesheet" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.5/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="ACBStyle.css" />
    <title>A Capella Boys</title>
</head>

<body>
    <!--- Header --->
    <div class="navbar">
        <a href="#home">Home</a>
        <div class="dropdown">
            <button class="dropbtn" onclick="showDrop()">Menu
                <i class="fa fa-caret-down"></i>
            </button>
            <div class="dropdown-content" id="myDropdown">
                <a href="#members">Members</a>
                <a href="#comingShows">Shows</a>
                <a href="#comingShows">Tickets</a>
                <a href="#prevShows">Past Performances</a>
            </div>
        </div>

        <!--- Login button -->
        <a id="loginBlock" style="float:right" onclick="document.getElementById('loginModal').style.display='block'">Login</a>
        <div id="loginModal" class="modal">
            <div class="modal-content animate-top card-4">
                <header class="container teal center padding-32"> 
                    <span onclick="document.getElementById('loginModal').style.display='none'" class="button teal xlarge display-topright">×</span>
                    <h2 class="wide"><i class="margin-right"></i>Login</h2>
                </header>
                <div class="container">
                    <p><label>Username</label></p>
                    <input class="input border" type="text" placeholder="Enter Username" id="username">
                    <p><label>Password</label></p>
                    <input class="input border" type="password" placeholder="Enter Password" id="password">
                    <button id="login_btn" class="button block teal padding-16 section right">Login</button>
                </div>
            </div>
        </div>
        <script src=ACBloginScript.js></script>

        <!--- Register button -->
        <a id="regBlock" style="float:right" onclick="document.getElementById('regModal').style.display='block'">Join the Fanclub!</a>
        <div id="regModal" class="modal">
            <div class="modal-content animate-top card-4">
                <header class="container teal center padding-32"> 
                    <span onclick="document.getElementById('regModal').style.display='none'" class="button teal xlarge display-topright">×</span>
                    <h2 class="wide"><i class="margin-right"></i>Register</h2>
                </header>
                <div class="container">
                    <p><label>Email</label></p>
                    <input class="input border" type="text" placeholder="Enter Email" id="userEmail">
                    <p><label>Username</label></p>
                    <input class="input border" type="text" placeholder="Enter Username" id="user">
                    <p><label>Password</label></p>
                    <input class="input border" type="password" placeholder="Enter Password" id="pass">
                    <button id="reg_btn" class="button block teal padding-16 section right">Register</button>
                </div>
            </div>
        </div>
        <script src=ACBregisterScript.js></script>

        <!-- Logout button -->
        <div class="logout" id="logoutBlock" style="display: none;">
            <a style="float:right" id="logout_btn">Logout</button>
        </div>

        <!-- Edit Button -->
        <a href="http://ec2-18-218-144-7.us-east-2.compute.amazonaws.com/~andrew.wu/ACBEdit.php" style="display: none;" id="edit">Edit</a>
    </div>

    <!-- Twitter Feed -->
    <div class="sidebar">
        <a class="twitter-timeline" href="https://twitter.com/elonmusk?ref_src=twsrc%5Etfw">Tweets by elonmusk</a> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
    </div>

    <div class="main" id="home">
        <!-- Showing who's logged in -->
        <div class="userHeader" id="userHead" style="float:right"></div>

        <!-- Member Bios -->
        <div class="container content center padding-64" style="max-width:800px" id="members">
            <h2 class="wide">A CAPELLA BOYS</h2>
            <div class="row padding-32">
                <?php 
                    $stmt = $mysqli->prepare("select id, bio from members");
                    if(!$stmt){
                        printf("Query Prep Failed: %s\n", $mysqli->error);
                        exit;
                    }
                    $stmt->execute();
                    $stmt->bind_result($name, $bio);
                    while($stmt->fetch()){
                    echo "
                    <div class='fifth'>
                    <p>$name</p>
                    <img src='$name.jpg' class='round margin-bottom' alt='$name' style='width:95%'>
                    <p>$bio</p>
                    </div>";
                    }
                    $stmt->close();
                ?>
            </div>
        </div>
        
        <!-- Upcoming Shows -->
        <div class="black" id="comingShows">
            <div class="container content padding-64" style="max-width:800px">
                <h2 class="wide center">UPCOMING SHOWS</h2>
                <div class="row-padding padding-32" style="margin:0 -16px">
                    <?php
                        $stmt = $mysqli->prepare("select name, year(datetime), month(datetime), day(datetime), ticketprice, cast(datetime as time) from shows");
                        if(!$stmt){
                            printf("Query Prep Failed: %s\n", $mysqli->error);
                            exit;
                        }
                        $stmt->execute();
                        $stmt->bind_result($name, $year, $month, $day, $ticketPrice, $time);
                        while($stmt->fetch()){
                            $date = date('h:i: a', strtotime($time));
                            echo "
                            <div class='third margin-bottom'>
                            <div class='container white'>
                                <p><b>$name</b></p>
                                <p><b>Tickets: $$ticketPrice</b></p>
                                <p class='opacity'>$month/$day/$year</p>
                                <p class='opacity'>$date</p>
                                "?> <button class='button black margin-bottom' onclick="document.getElementById('ticketModal').style.display = 'block'">Buy Tickets</button> <?php echo "
                            </div>
                            </div>";
                        }
                        $stmt->close();
                    ?>
                </div>
            </div>
        </div>

        <!-- Previous Shows -->
        <div class="container content center padding-64" style="max-width:800px" id="prevShows">
            <h2 class="wide">PREVIOUS SHOWS</h2>
            <div class="row padding-32">
                <?php 
                    $stmt = $mysqli->prepare("select link from video");
                    if(!$stmt){
                        printf("Query Prep Failed: %s\n", $mysqli->error);
                        exit;
                    }
                    $stmt->execute();
                    $stmt->bind_result($link);
                    while($stmt->fetch()){
                        echo $link;
                    }
                    $stmt->close();
                ?>
            </div>
        </div>

        <!-- Send Feedback -->
        <div class="black" id="comingShows">
            <div class="container content padding-64" style="max-width:800px">
                <h2 class="wide center">SEND US FEEDBACK</h2>
                <div class="row-padding padding-32" style="margin:0 -16px">
                    <div class="container white">
                        <br><br>
                        <form method="POST" action='ACBmail.php'>
                            <input class="input border" type="text" name= "feedbackName" placeholder="Name" required><br>
                            <input class="input border" type="text" name="feedbackContent" placeholder="Message" required><br>
                            <button type="submit" class="button black margin-bottom" id="email_btn">SEND</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
    
    <!-- Ticket Popup -->
    <div id="ticketModal" class="modal">
        <div class="modal-content animate-top card-4">
            <header class="container teal center padding-32"> 
                <span onclick="document.getElementById('ticketModal').style.display='none'" class="button teal xlarge display-topright">×</span>
                <h2 class="wide"><i class="margin-right"></i>Tickets</h2>
            </header>
            <div class="container">
                <form method="POST" action="ACBTicket.php">
                    <p>Email Address (Make sure to check spam!) :</p>
                    <input class="input border" type="text" name="email" placeholder="Enter email">
                    <button type="submit" id="pay_btn" class="button block teal padding-16 section right">PAY <i class="fa fa-check"></i></button>
                </form>
            </div>
        </div>
    </div>
    <script src=ACBhomeScript.js></script>
</body>

</html>