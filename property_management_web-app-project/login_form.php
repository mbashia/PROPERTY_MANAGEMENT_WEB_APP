<?php
session_start();
require("db_connect.php");
function validate_data($input)
{
    $input = trim($input);
    $input = htmlspecialchars($input);
    return $input;
}


$user_email = $user_password = $pass_success = $pass_error = $invalid_email = "";
if (isset($_POST['submit'])) {


    $user_email = $_POST['email'];
    $user_password = $_POST['password'];
    // sanitize the data
    $user_email = validate_data($user_email);
    $user_email = mysqli_real_escape_string($database_connect, $user_email);
    $user_password = validate_data($user_password);
    $user_password = mysqli_real_escape_string($database_connect, $user_password);

    // echo"$user_email,$user_password";

    // retrieve data from the database
    $sql = "SELECT * FROM propertyOwner WHERE email = '$user_email' ";
    $result = mysqli_query($database_connect, $sql);
    //fetch the results
    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        // print_r($user);
        if ($user_password == $user['password']) {
            $pass_success = "<p style = 'color:green;' > successfully logged in</p>";
            // saving some user info
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['ownerID'] = $user['id'];
            sleep(0.5);
            // redirecting user to dashboard if login is successful
            header("Location: dashboard.php");
            exit();
        } else {
            $pass_error = "<p style = 'color:red;' >invalid password</p>";
        }
    } else {
        $invalid_email = "<p style = 'color:red;' > email does not exist</p>";
    }
    
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login_form.css" type="text/css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600&family=Roboto:wght@500;700&display=swap" rel="stylesheet">
    <title>login</title>
</head>

<body>
    <div class="form_div">
        <form action="login_form.php" method="post">
            <h3>login</h3>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br>
            <?php if (isset($invalid_email)) {
                echo $invalid_email;
            } ?>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br>
            <div  style ='color:green;' id = "success_login"></div>
            <?php if (isset($pass_error)) {
                echo $pass_error;
            } ?>
            <?php if (isset($pass_success)) {
                // echo $pass_success;
                // echo "<script>
                // document.querySelector('#success_login').innerText= 'login successful';
                
                // </script>";
            }
            ?>



            <input class="submit" type="submit" name="submit" value="login">

        </form>
        <div class="sign_up_here">
            <p>don't have an account <a href="sign_up.php">sign up here!!</a>.</p>
        </div>

    </div>
</body>

</html>