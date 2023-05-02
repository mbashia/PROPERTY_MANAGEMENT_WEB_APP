<?php
session_start();
require("logged_in_dbconnect.php");
if (isset($_SESSION['property_name'])) {
    $property_name = $_SESSION['property_name'];
} else {
    $property_name = "";
}



if (isset($_SESSION['location'])) {
    $street_name = $_SESSION['location'];
} else {
    $street_name = "";
}



$property_owner_id = $_SESSION['ownerID'];


define('rent_amount', 1000000);
$query =  "SELECT * FROM houseorproperty WHERE propertyOwnerID = '$property_owner_id' ";
$query_result = mysqli_query($database_connect, $query);
if (mysqli_num_rows($query_result) > 0) {
    $user = mysqli_fetch_assoc($query_result);
    $property_name = $user['propertyName'];
}
$payment_sql = " SELECT SUM(paymentAmount) as total_payment_amount FROM payment WHERE house = '$property_name';
";
$result = mysqli_query($database_connect, $payment_sql);

// Check if the query was successful
if (!$result) {
    die("Query failed: " . mysqli_error($connection));
}
$row = mysqli_fetch_assoc($result);

// Get the total payment amount from the result row
$total_payment_amount = $row["total_payment_amount"];
$formatted_amount = number_format($total_payment_amount);

$rent_arrears = number_format(rent_amount - $total_payment_amount);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="rent_collection.css" type="text/css">
    <link rel="stylesheet" href="dashboard.css" type="text/css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600&family=Roboto:wght@500;700&display=swap" rel="stylesheet">
    <title>rent_collection</title>
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
        <h2>rent collection</h2>

        <div class="property_rent">
            <div class="rent_details">
                <P>
                <h3> <?php 
                            echo $property_name;
                         ?></h3>
                </P>
                <P><?php 
                        echo $street_name;
                    ?></P>
            </div>
            <div class="bill_collected">
                <div>
                    <P>
                    <h3>bill collected</h3>
                    </P>
                    <P><?php echo $formatted_amount; ?></P>
                </div>

            </div>
            <div class="rent_arrears">
                <div>
                    <P>
                    <h3>rent arrears</h3>
                    </P>
                    <P><?php echo $rent_arrears; ?></P>
                </div>

            </div>
        </div>






    </div>


</body>

</html>