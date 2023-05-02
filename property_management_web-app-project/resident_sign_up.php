<?php
// connecting to required database
require("db_connect.php");

$fname = $user_email = $user_password = $housename = "";
$phone_number = 0;

if (isset($_POST['submit'])) {

    $fname = $_POST['name'];
    $phone_number = $_POST['number'];
    $user_email = $_POST['email'];
    $user_password = $_POST['password'];
    $housename = $_POST['hname'];

    // echo "<p>$fname $phone_number $user_email $user_password $confirm_pass </p>";
    $name_error = "";
    $phone_numberError = '';
    $emailError = "";
    $houseError = "";
    $password_error = "";

    function validate_data($input)
    {
        $input = trim($input);
        $input = htmlspecialchars($input);
        return $input;
    }

   
    function validate_input($name, $phone_number, $password, $housename, $email)
    {
        $name = validate_data($name);
        $phone_number = validate_data($phone_number);
        $password = validate_data($password);
        $housename = validate_data($housename);
        $email = validate_data($email);

        // Check if name is empty
        if (empty($name)) {
            global $name_error;
            $name_error = "Name is required";
        }

        // Check if phone number is empty and numeric
        if (empty($phone_number) || !is_numeric($phone_number)) {
            global $phone_numberError;
            $phone_numberError = "Phone number is required and must be numeric";
        }

        // Check if password is empty
        if (empty($password)) {
            global $password_error;
            $password_error = "Password is required";
        }
        if (empty($housename)) {
            global $houseError;
            $houseError = "Password is required";
        }

        // Check if email is empty and valid
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            global $emailError;

            $emailError = "Email is required and must be valid";
        }

        // Check if name contains only letters and spaces
        if (!preg_match("/^[a-zA-Z ]+$/", $name)) {
            global $name_error;
            $name_error = "Name can only contain letters and spaces";
        }

        // Check if password contains only letters, numbers, and symbols
        if (!preg_match("/^[a-zA-Z0-9!@#\$%\^&\*\(\)\-\_\+=]+$/", $password)) {
            $password_error = "Password can only contain letters, numbers, and symbols";
        }


        // Check if phone number is exactly 10 digits long
        if (strlen($phone_number) != 10) {
            $phone_numberError = "Phone number must be 10 digits long";
        }

        // If all validations pass, return true
        // return true;
    }

    validate_input($fname, $phone_number, $user_password, $housename, $user_email);
    $sql = "SELECT * FROM houseorproperty WHERE propertyName = '$housename' ";
    $result = mysqli_query($database_connect, $sql);
    //fetch the results
    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        $house_ID = $user['propertyID'];
    }
    // print_r($user);
    // echo $house_ID;
    $success = "";

    if (empty($name_error) && empty($emailError) && empty($phone_numberError) && empty($password_error) && empty($houseError)) {
        $sql = "INSERT INTO residents(residentName,email,contact,houseName,password,houseID)
                            VALUES('$fname','$user_email','$phone_number','$housename','$user_password','$house_ID')";
        if ($database_connect->query($sql) === true) {
            $success = "<p style = 'color:green;' > successfully signed up.<a href = 'login_form.php'>Login</a></p>";
            // echo "$success";
            header("location:resident_login.php");
            exit();
        } else {
            echo "error" . $database_connect->error;
        }
    }
    mysqli_close($database_connect);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>resident_sign_up_form</title>
    <link rel="stylesheet" href="resident_sign_up.css" type="text/css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600&family=Roboto:wght@500;700&display=swap" rel="stylesheet">
</head>

<body>
    <div class="grid_div">
        <div class="form_div">
            <form action="resident_sign_up.php" method="post">
                <h3>sign up</h3>
                <label for="name">Name:</label>
                <input type="text" id="name" maxlength="15" name="name" required value="<?php if (isset($fname)) {
                                                                                            echo $fname;
                                                                                        } ?>"><br>
                <?php if (isset($name_error)) {
                    echo " <p style = 'color:red;'>$name_error</p>";
                }; ?>
                <label for="number">Number:</label>
                <input type="number" id="number" name="number" required value="<?php if (isset($phone_number)) {
                                                                                    echo $phone_number;
                                                                                } ?>"><br>
                <?php if (isset($phone_numberError)) {
                    echo " <p style = 'color:red;'>$phone_numberError</p>";
                }; ?>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required value="<?php if (isset($user_email)) {
                                                                                echo $user_email;
                                                                            } ?>"><br>
                <?php if (isset($emailError)) {
                    echo " <p style = 'color:red;'>$emailError</p>";
                }; ?>
                <label for="house">HOUSE:</label>
                <input type="text" id="housename" name="hname" required value="<?php if (isset($housename)) {
                                                                                    echo $housename;
                                                                                } ?>"><br>
                <?php if (isset($houseError)) {
                    echo " <p style = 'color:red;'>$houseError</p>";
                }; ?>
                <label for="password">password:</label>
                <input type="password" id="password" name="password" required value="<?php if (isset($user_password)) {
                                                                                            echo $user_password;
                                                                                        } ?>"><br>
                <?php if (isset($password_error)) {
                    echo " <p style = 'color:red;'>$password_error</p>";
                }; ?>
                <?php if (isset($success)) {
                    echo "$success";
                }; ?>
                <input class="submit" type="submit" value="Submit" name="submit">
            </form>
            <p>If you already have an account, please <a href="resident_login.php">login here!!</a>.</p>
        </div>
        <div class="image_div"> <img src="sign_pictures/Capture.PNG">
        </div>
    </div>

</body>

</html>