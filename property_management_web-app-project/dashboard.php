<?php
// require("db_connect.php");

session_start();
require("logged_in_dbconnect.php");

$owner = $_SESSION  ['user_name'];




?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="dashboard.css" type="text/css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600&family=Roboto:wght@500;700&display=swap"
        rel="stylesheet">
    <title>dashboard</title>
</head>

<body>
    <div class="dashboard">
        <h1>propsync</h1>

        <a href="dashboard.php">
            <div class="dashboard_content"><img class="dashboard_icons" src="icons/list.svg">
                <p class="icons_description">dashboard</p>
            </div>
        </a>
        <a href="my_property.php">
            <div class="dashboard_content"> <img class="dashboard_icons " src="icons/insurance.png">
                <p class="icons_description">my Property</p>
            </div>
        </a>
        <a href="rent_collection.php">
            <div class="dashboard_content"> <img class="dashboard_icons" src="icons/wallet.png">
                <p class="icons_description">payments</p>
            </div>
        </a>
        <a href="maintenance.php">
            <div class="dashboard_content"> <img class="dashboard_icons" src="icons/web-maintenance.png">
                <p class="icons_description">maintenance</p>
            </div>
        </a>
        <a href="mytenants.php">
            <div class="dashboard_content"> <img class="dashboard_icons" src="icons/people.png">
                <p class="icons_description">tenants</p>
            </div>
        </a>
        <a href="log_out.php">
            <div class="dashboard_content"> <img width="15px" src="icons/logout.png">
                <p class="icons_description">logout</p>
            </div>
        </a>
    </div>
    <div class="grid_div">
        <div class="m_request">
            <img class=" maintenance_image" src="icons/web-maintenance.png">
            <p></p>

            <p>maintenance requests</p>
            <a href="maintenance.php"><span>Click to view content!</span></a>
        </div>
        <div class="r_arrears">
            <img class="arrears_icon" src="icons/economic-crisis.png">
            <p>rent arrears</p>

            <p></p>
            <a href="rent_collection.php"><span>click to view!</span></a>
        </div>
        <div class="b_collected">
            <img class="payment_icon" src="icons/wallet.png">
            <p>bill collected</p>

            <p> </p>
            <a href="rent_collection.php"><span>click to view!</span></a>
        </div>
        <div class="portfolio">
            <div>
                <P>welcome back <?php echo $owner;?></P>
                <P>this is your property portfolio</P>
            </div>

            <div class="units_class">
                <div class="vacant">vacant</div>
                <div class="occupied ">occupied</div>
                <div class="unlisted">unlisted</div>
            </div>
            <div class="percentage">
                <div id="vacant_percentage">30%</div>
                <div id="occupied_percentage">40%</div>
                <div id="unlisted_percentage">30%</div>
            </div>


        </div>

        <div>calender</div>

    </div>






</body>

</html>