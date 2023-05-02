<?php
// connecting to required database
require("db_connect.php");

$fname = $user_email = $user_password = $confirm_pass = "";
$phone_number = 0;
if (isset($_POST['submit'])) {

    $fname = $_POST['name'];
    $phone_number = $_POST['number'];
    $user_email = $_POST['email'];
    $user_password = $_POST['password'];
    $confirm_pass = $_POST['confirm_password'];

    // echo "<p>$fname $phone_number $user_email $user_password $confirm_pass </p>";
    $name_error = "";
    $phone_numberError = '';
    $emailError = "";
    $confirm_passwordError = "";
    $password_error = "";

    function validate_data($input)
    {
        $input = trim($input);
        $input = htmlspecialchars($input);
        return $input;
    }


    function  validate_input($name, $phone_number, $password, $confirm_password, $email)
    {
        $name = validate_data($name);
        $phone_number = validate_data($phone_number);
        $password = validate_data($password);
        $confirm_password = validate_data($confirm_password);
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
        if (empty($confirm_password)) {
            global $confirm_passwordError;
            $confirm_passwordError = "Password is required";
        }
        if ($password !== $confirm_password) {
            // passwords don't match
            global $confirm_passwordError;
            $confirm_passwordError = "Password is required";
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
        if (!preg_match("/^[a-zA-Z0-9!@#\$%\^&\*\(\)\-\_\+=]+$/", $confirm_password)) {
            $confirm_passwordError = "Password can only contain letters, numbers, and symbols";
        }

        // Check if phone number is exactly 10 digits long
        if (strlen($phone_number) != 10) {
            $phone_numberError = "Phone number must be 10 digits long";
        }

        // If all validations pass, return true
        // return true;
    }
    validate_input($fname, $phone_number, $user_password, $confirm_pass, $user_email);

    // if ($result === true) {
    //     // echo "All input is valid";
    // } else {
    //     echo "Error: " . $result;
    // }
    $success = "";

    if (empty($name_error) && empty($emailError) && empty($phone_numberError) && empty($password_error) && empty($confirm_passwordError)) {
        $sql = "INSERT INTO propertyOwner(name,contact,email,password)
                            VALUES('$fname','$phone_number','$user_email','$user_password')";
        if ($database_connect->query($sql) === true) {
            $success = "<p style = 'color:green;' > successfully signed up.<a href = 'login_form.php'>Login</a></p>";
            echo "$success";
        }
        else{
            echo "error" . $database_connect->error;
        }
    }

};
mysqli_close($database_connect);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>sign_up_form</title>
    <link rel="stylesheet" href="sign_up.css" type="text/css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600&family=Roboto:wght@500;700&display=swap" rel="stylesheet">
</head>

<body style="background-color: #10294E;">
    <div class="grid_div">
        <div class="form_div">
            <form action="sign_up.php" method="post">
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

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required value="<?php if (isset($user_password)) {
                                                                                            echo $user_password;
                                                                                        } ?>"><br>
                <?php if (isset($password_error)) {
                    echo " <p style = 'color:red;'>$password_error</p>";
                }; ?>

                <label for="confirm-password">confirm pass:</label>
                <input type="password" id="confirm_password" name="confirm_password" required value="<?php if (isset($confirm_pass)) {
                                                                                                            echo $confirm_pass;
                                                                                                        } ?>"><br>
                <?php if (isset($confirm_passwordError)) {
                    echo " <p style = 'color:red;'>$confirm_passwordError</p>";
                }; ?>
                <?php if (isset($success)) {
                    echo "$success";
                }; ?>
                <input class="submit" type="submit" value="Submit" name="submit">

            </form>
            <p>If you already have an account, please <a href="login_form.php">login here!!</a>.</p>
        </div>
        <div class="image_div"> <img src="sign_pictures/Capture.PNG">
        </div>
    </div>

</body>

</html>