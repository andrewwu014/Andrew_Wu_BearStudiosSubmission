<?php
ini_set("session.cookie_httponly", 1);
session_start();
require 'database2.php';
?>
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
    <title>Edit Page</title>
</head>

<body>
    <a class="button black margin-bottom" href="http://ec2-18-218-144-7.us-east-2.compute.amazonaws.com/~andrew.wu/ACBHomepage.php">Back</a>

    <!-- Member Bios -->
    <div class="container content center padding-64" style="max-width:800px" id="members">
        <h2 class="wide">A CAPELLA BOYS</h2>
        <div class="row padding-32">
            <?php
                $stmt = $mysqli->prepare("select id, bio from members");
                if (!$stmt) {
                    printf("Query Prep Failed: %s\n", $mysqli->error);
                    exit;
                }
                $stmt->execute();
                $stmt->bind_result($name, $bio);
                while ($stmt->fetch()) {
                    echo "
                    <div class='fifth'>
                        <p>$name</p>
                        <img src='$name.jpg' class='round margin-bottom' alt='$name' style='width:95%'>
                        <p>$bio</p>
                        <form method='POST' action='ACBEditBio.php'>
                            <input type='hidden' name='name' value=$name>
                            <p>Edit Bio:</p>
                            <textarea name='bio' rows='4' cols='13' placeholder='Enter new bio:'></textarea><br><br>
                            <button id='editMem_btn' class='button black margin-bottom'>EDIT</button>
                        </form>
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
                    $stmt = $mysqli->prepare("select sid, name, year(datetime), month(datetime), day(datetime), ticketprice, cast(datetime as time) from shows");
                    if (!$stmt) {
                        printf("Query Prep Failed: %s\n", $mysqli->error);
                        exit;
                    }
                    $stmt->execute();
                    $stmt->bind_result($sid, $name, $year, $month, $day, $ticketPrice, $time);
                    while ($stmt->fetch()) {
                        $date = date('h:i: a', strtotime($time));
                        $id = $sid;
                        echo "
                        <div class='third margin-bottom'>
                            <div class='container white'>
                                <p><b>$name</b></p>
                                <p><b>Tickets: $$ticketPrice</b></p>
                                <input type='hidden' id=$sid></input>
                                <p class='opacity'>$month/$day/$year</p>
                                <p class='opacity'>$date</p>
                                <form method='POST' action='ACBEditShow.php'>
                                    <p>Edit Location:</p>
                                    <input class='input border' type='text' name='name' placeholder='Enter name'>
                                    <p>Edit date and time:</p>
                                    <input class='input border' type='datetime-local' name='datetime'>
                                    <p>Edit Ticket Price:</p>
                                    <input class='input border' type='number' name='ticketPrice' placeholder='Enter price'>
                                    <input type='hidden' name='showID' value=$sid><br>
                                    <button type='submit' id='editShow_btn' class='button black margin-bottom'>MAKE CHANGES</button>
                                </form>
                            </div>
                        </div>
                        ";
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
                        ?> <br><br><button class='button black margin-bottom' onclick="document.getElementById('editVideoModal').style.display = 'block'">Edit</button> <?php
                        echo "
                        <div id='editVideoModal' class='modal'>
                            <div class='modal-content animate-top card-4'>
                                <header class='container teal center padding-32'>
                                    " ?> <span onclick="document.getElementById('editVideoModal').style.display='none'" class='button teal xlarge display-topright'>×</span> <?php echo "
                                    <h2 class='wide'><i class='margin-right'></i>Edit Embedded Link</h2>
                                </header>
                                <div class='container'>
                                    <form method='POST' action='ACBEditVideo.php'>
                                        <p style='float:left'>New Link:</p>
                                        <input class='input border' type='text' name='newLink' placeholder='Enter new embed link'>
                                        <button id='editVid_btn' class='button block teal padding-16 section right'>MAKE CHANGES</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        ";
                    }
                ?>
            </div>
        </div>

    <script src=ACBEditScript.js></script>

</body>

</html>