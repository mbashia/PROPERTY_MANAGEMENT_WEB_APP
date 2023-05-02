<?php
session_start();

require("logged_in_dbconnect.php");

$property_owner_id = $_SESSION['ownerID'];


// collect data
function validate_data($input)
{
    $input = trim($input);
    $input = htmlspecialchars($input);
    return $input;
}


$house_name = $house_nameError = "";
if (isset($_POST['submit'])) {

    if (empty($house_name)) {
        $house_nameError = "Name is required";
    }

    $house_name = $_POST['hname'];
    // sanitize the data
    $house_name = validate_data($house_name);
    $house_name = mysqli_real_escape_string($database_connect, $house_name);

    // check if the house is in the database and it is registered to that user
    $sql = "SELECT * FROM houseorproperty WHERE propertyName = '$house_name' ";

    $result = mysqli_query($database_connect, $sql);
    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        // print_r($user);
        // check if the property they have given is theirs 
        if ($user['propertyOwnerID'] == $property_owner_id) {
            // if its theirs we retrieve the residents data from the database 
            $residents_sql = "SELECT * FROM residents WHERE houseName = '$house_name' ";
            $residents_result = mysqli_query($database_connect, $residents_sql);
            if (mysqli_num_rows($residents_result) > 0) {
                $residents = mysqli_fetch_all($residents_result, MYSQLI_ASSOC);
            }
        } else {
            $house_nameError = "no such house registered under you name!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="mytenants.css" type="text/css">
    <link rel="stylesheet" href="dashboard.css" type="text/css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600&family=Roboto:wght@500;700&display=swap" rel="stylesheet">
    <title>myTenants</title>
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
        <h2>myTenants</h2>
        <form action="mytenants.php " method="post">
            <label for="name">house name:</label>
            <input type="text" id="hname" name="hname" required><br>
            <?php if (isset($house_nameError)) {
                echo " <p style = 'color:red;'>$house_nameError</p>";
            }; ?>
            <!-- <label for="number">house ID:</label>
        <input type="text" id="house_id" name="house_id" required><br> -->
            <input class="submit" type="submit" value="Submit" name="submit">
        </form>

        <div class="table_content">
            <table style="width:80%;">
                <tr>
                    <th>tenant</th>
                    <th>house</th>
                    <th>contact</th>
                    <th> date in</th>


                </tr>
                <?php
                if (!isset($residents)) {
                    $house_nameError = "no such house registered under your name!!";
                } else {
                    foreach ($residents as $resident) {
                ?>
                        <tr>
                            <td><?php echo $resident['residentName'] ?></td>
                            <td><?php echo $resident['houseName'] ?></td>
                            <td><?php echo $resident['contact'] ?></td>
                            <td><?php echo $resident['date'] ?></td>
                        </tr>
                <?php
                    }
                }
                ?>









            </table>
        </div>

    </div>



</body>

</html>