<?php
session_start();

require('logged_in_dbconnect.php');
$property_owner_id = $_SESSION['ownerID'];
$property_names = "";
$locations = "";

$query =  "SELECT * FROM houseorproperty WHERE propertyOwnerID = '$property_owner_id' ";
$query_result = mysqli_query($database_connect, $query);
if (mysqli_num_rows($query_result) > 0) {
    $properties = mysqli_fetch_all($query_result, MYSQLI_ASSOC);
    // $property_names= $user['propertyName'];
    // $locations = $user['locationandstreet'];


}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="my_property.css" type="text/css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600&family=Roboto:wght@500;700&display=swap" rel="stylesheet">
    <title>my property</title>
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
        <h2>My property</h2>

        <?php
        if (!isset($properties)) {
            $properties = "";

            echo "<div class='property'></div>";


            


            

        }

        else{

            foreach ($properties as $property) { ?>

                <div class="property">
                    <div class="property_name">
                        <P>
                        <h3><?php echo $property['propertyName']; ?></h3>
                        </P>
                        <P><?php echo $property['locationandstreet']; ?></P>
                    </div>
                    <div class="units_class">
                        <div>
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
                    <div class="edit_delete">
                        <button class="edit">edit</button>
                        <button class="delete">delete</button>
                    </div>
                </div>
            <?php }} ?>





        <div class=add_property>
            <a href="add_property.php" class="add_property_button"> add property</a>
        </div>
    </div>


</body>

</html>