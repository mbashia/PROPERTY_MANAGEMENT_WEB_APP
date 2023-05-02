<?php
session_start();

require("db_connect.php");

$property_owner_id = $_SESSION['ownerID'];

$owner_name = $property_name = $location = "";
if (isset($_POST['submit'])) {
    $owner_name = $_POST['property_owner'];
    $property_name = $_POST['property_name'];
    $location = $_POST['location'];

    $ownerName_error = "";
    $property_nameError = '';
    $locationError = "";

    // echo $owner_name, $location, $property_name;
    function validate_data($input)
    {
        $input = trim($input);
        $input = htmlspecialchars($input);
        return $input;
    }
    function  validate_input($owner_name, $property_name, $location)
    {
        $owner_name = validate_data($owner_name);
        $property_name = validate_data($property_name);
        $location = validate_data($location);

        // Check if fields are empty
        if (empty($owner_name)) {
            global $ownerName_error;
            $ownerName_error = "Name is required";
        }
        if (empty($property_name || is_numeric($property_name))) {
            global $property_nameError;
            $property_nameError = "property name is required use characters from A-Z";
        }
        if (empty($location) || is_numeric($location)) {
            global $locationError;
            $locationError = "location is required and in right format";
        }

        // If all validations pass, return true
        // return true;
    }
    validate_input($owner_name, $property_name, $location);
    if (empty($ownerName_error) && empty($property_nameError) && empty($locationError)) {

        // echo "all inputs are valid";
        $sql = "INSERT INTO houseorproperty(propertyName,locationandstreet,propertyOwnerID)
                            VALUES('$property_name','$location','$property_owner_id')";
        if ($database_connect->query($sql) === true) {
            // $success = "<p style = 'color:green;' > successfully saved.<a href = 'login_form.php'>Login</a></p>";
            //  echo "$property_name','$location";
            $sql = "SELECT * FROM houseorproperty WHERE propertyOwnerID = '$property_owner_id' ";
            $result = mysqli_query($database_connect, $sql);
            //fetch the results
            if (mysqli_num_rows($result) > 0) {
                $user = mysqli_fetch_assoc($result);
                // print_r($user);
                
                $_SESSION['property_name'] = $user['propertyName'];
                $_SESSION['location'] = $user['locationandstreet'];
                $_SESSION['property_id'] = $user['propertyID'];
            }
            $house_sql = "SELECT * FROM houseorproperty WHERE propertyName = '$property_name'";
            $house_sql_result =  mysqli_query($database_connect,$house_sql);
            if (mysqli_num_rows($house_sql_result) > 0) {
                $house = mysqli_fetch_assoc($house_sql_result);
                $house_id = $house['propertyID'];
            }
                // print_r($user);

            // $update_sql = "UPDATE propertyowner SET houseID = '$property_id ' WHERE id = $property_owner_id";
            $update_sql = "INSERT INTO house_and_propertyowner(owner_id,house_id)
            VALUES('$property_owner_id','$house_id')";

            $run_query = mysqli_query($database_connect, $update_sql);

            header("location:my_property.php");
            exit();
        } else {
            echo "error" . $database_connect->error;
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
    <link rel="stylesheet" href="add_property.css" type="text/css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600&family=Roboto:wght@500;700&display=swap" rel="stylesheet">
    <title>login</title>
</head>

<body>
    <div class="form_div">
        <form action="add_property.php " method="post">
            <h3>ADD PROPERTY</h3>

            <label for="propert_owner">Owner:</label>
            <input type="text" id="property_owner" name="property_owner" required value="<?php if (isset($owner_name)) {
                                                                                                echo $owner_name;
                                                                                            } ?>"><br>
            <?php if (isset($ownerName_error)) {
                echo " <p style = 'color:red;'>$ownerName_error</p>";
            }; ?>

            <label for="name">property_name:</label>
            <input type="text" id="name" name="property_name" required value="<?php if (isset($property_name)) {
                                                                                    echo $property_name;
                                                                                } ?>"><br>
            <?php if (isset($property_nameError)) {
                echo " <p style = 'color:red;'>$property_nameError</p>";
            }; ?>

            <label for="street">location :</label>
            <input type="text" id="location" name="location" required placeholder="location and street" value="<?php if (isset($location)) {
                                                                                                                    echo $location;
                                                                                                                } ?>"><br>
            <?php if (isset($locationError)) {
                echo " <p style = 'color:red;'>$locationError</p>";
            }; ?>



            <input class="add" type="submit" value="add" name="submit">

        </form>
        <!-- <div class = "sign_up_here"><p>don't have an account <a href="resident_sign_up.html">sign up here!!</a>.</p></div> -->

    </div>
</body>

</html>