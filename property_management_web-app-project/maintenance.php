<?php
session_start();
require("logged_in_dbconnect.php");

$owner_id =  $_SESSION['ownerID'];
$request_error = "";
$sql = "SELECT  house_id FROM house_and_propertyowner WHERE owner_id = '$owner_id' ";
$result = mysqli_query($database_connect, $sql);
if (mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
    // print_r($user);
    $houseID = $user['house_id'];
    $maintenance_sql = "SELECT  * FROM maintenancerequests WHERE propertyID = '$houseID' ";
    $maintenance_result = mysqli_query($database_connect, $maintenance_sql);

    if (mysqli_num_rows($maintenance_result) > 0) {
        $requests = mysqli_fetch_all($maintenance_result, MYSQLI_ASSOC);
        $no_of_requests = mysqli_num_rows($maintenance_result);
         $_SESSION['no_of_requests'] = $no_of_requests;
    }else{
        $no_of_requests = 0;
    }
}
else{
    
    $request= array(
        'date' => '',
        'requestID' => '',
        'createdBY' => '',
        'request' => ''
    );
}



// print_r($requests);



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="maintenance.css" type="text/css">
    <link rel="stylesheet" href="dashboard.css" type="text/css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600&family=Roboto:wght@500;700&display=swap" rel="stylesheet">
    <title>maintenance</title>
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
    <div class="content">
        <h2>maintenance requests </h2>
        <p>You have <?php echo $no_of_requests ?> maintenance request
        <p>
        <table style="width:80%;">
            <tr>
                <th>date/time</th>
                <th>Request no</th>
                <th>created by</th>
                <th> request</th>


            </tr>
            <?php
            if (!isset($requests)) {
                $request_error = "no requests";
            } else {
                foreach ($requests as $request) {
            ?>
                    <tr>
                        <td><?php echo $request['date']; ?></td>
                        <td><?php echo $request['requestID']; ?></td>
                        <td><?php echo $request['createdBY']; ?></td>
                        <td><?php echo $request['request']; ?></td>
                    </tr>
            <?php
                }
            }
            ?>


        </table>
    </div>

</body>

</html>