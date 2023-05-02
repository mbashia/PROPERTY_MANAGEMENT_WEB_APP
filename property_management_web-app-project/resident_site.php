<?php
session_start();



require("resident_logged_in.php");
$resident_name = $_SESSION['resident_name'];
$residentID = $_SESSION['residentID'];
$success = "";
$housename = $_SESSION['residence_name'];

$_request_error = "";
function validate_data($input)
{
  $input = trim($input);
  $input = htmlspecialchars($input);
  return $input;
}
$user_request =   $request_success = $request_error  = "";

if (isset($_POST['submit'])) {
  $user_request = $_POST['request'];





  function  validate_input($request)
  {
    $request = validate_data($request);

    // Check if name is empty
    if (empty($request)) {
      global $_request_error;
      $_request_error = " you've not typed anything";
    }


    // If all validations pass, return true
    // return true;
  }
  validate_input($user_request);

  $sql = "SELECT * FROM houseorproperty WHERE propertyName = '$housename' ";
  $result = mysqli_query($database_connect, $sql);
  //fetch the results
  if (mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
    $house_ID = $user['propertyID'];
  }

  if (empty($_request_error)) {
    $sql = "INSERT INTO maintenancerequests(propertyID,createdBY,request)
                          VALUES('$house_ID','$resident_name','$user_request')";
    if ($database_connect->query($sql) === true) {
      $success = "<p style = 'color:green;' > successfully submitted</p>";
      // echo "$success";
    } else {
      echo "error" . $database_connect->error;
    }
  }
}
// code for payments
$amount = 0;
$message = $amount_error = $message_error = "";
$payor = $_SESSION['resident_name'];
$house_paid_for = $_SESSION['residence_name'];
$payorID =  $_SESSION['residentID'];

// collect data from the payment form
// function validate_data($input)
// {
//     $input = trim($input);
//     $input = htmlspecialchars($input);
//     return $input;
// }


if (isset($_POST['save'])) {
  $amount = $_POST['amount'];
  $message = $_POST['message'];







  function  validate_input($amount, $message)
  {
    $amount = validate_data($amount);
    $message = validate_data($message);

    // Check if name is empty and non-numeric
    if (empty($amount) || !is_numeric($amount)) {
      global $amount_error;
      $amount_error = " amount should be filled and in should be in figures";
    }
    if (empty($message)) {
      global $message_error;
      $message_error = " you have not entered anything";
    }
  }
  validate_input($amount, $message);

  if (empty($amount_error) && empty($message_error)) {
    $sql = "INSERT INTO payment(paymentAmount,confirmMessage,paidBY,paidbyID,house)
                            VALUES('$amount','$message','$payor','$payorID','$house_paid_for')";
    if ($database_connect->query($sql) === true) {
      $success = "<p style = 'color:green;' > successfully signed up.<a href = 'login_form.php'>Login</a></p>";
      echo "$success";
    } else {
      echo "error" . $database_connect->error;
    }
  }
}





?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="resident_site.css" type="text/css">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600&family=Roboto:wght@500;700&display=swap" rel="stylesheet">
  <title>Resident Side Page</title>
</head>

<body>
  <div class="container">
    <a href="resident_logout.php">
      <div id="logout-form">
        <button type="submit" name="logout">Logout</button>
      </div>
    </a>
    <h1>Welcome <?php echo $resident_name; ?>!</h1>
    <form id="payment-form" action="#" method="post">
      <label for="amount">Payment Amount:</label>
      <input type="text" id="amount" name="amount" required>
      <label for="date">Payment Date:</label>
      <input type="date" id="date" name="date" required>
      <h2>Post Payment Message</h2>
      <label for="message">copy your message here:</label>
      <textarea id="message" name="message" rows="2" cols="40"></textarea>
      <input type="submit" value="Submit" name="save">
    </form>
    <form id="request-form" action="resident_site.php" method="post">
      <h2>Make a Request</h2>
      <label for="date">Payment Date:</label>
      <input type="date" id="date" name="date" required>
      <label for="request">Type your request:</label>
      <textarea id="request" name="request" rows="4" cols="50"></textarea>
      <input type="submit" value="Submit" name="submit">
      <?php if (isset($success)) {
        echo $success;
      } ?>
    </form>
    <div id="message-success"></div>
    <div id="request-success"></div>
  </div>
  <script src="script.js"></script>
</body>

</html>