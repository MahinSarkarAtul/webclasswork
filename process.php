<?php
session_start();

// Step 1: Store form values in session after the first form submission (in request.php)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['confirm'])) {
    // Store form data in the session
    $_SESSION['fullname'] = $_POST['fullname'];
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['password'] = $_POST['password'];
    $_SESSION['location'] = $_POST['location'];
    $_SESSION['zipcode'] = $_POST['zipcode'];
    $_SESSION['country'] = $_POST['country'];
    $_SESSION['favcolor'] = $_POST['favcolor'];

    // Redirect to the same page to show the confirmation table
    header("Location: process.php");
    exit();
}

// Initialize success and error variables
$success = false;
$error = "";

// Step 2: If the "Confirm" button is pressed, insert data into the database
if (isset($_POST['confirm'])) {
    // Retrieve values from session
    $fullname = $_SESSION['fullname'];
    $email = $_SESSION['email'];
    $password = $_SESSION['password']; // Plain text password
    $location = $_SESSION['location'];
    $zipcode = $_SESSION['zipcode'];
    $country = $_SESSION['country'];
    $favcolor = $_SESSION['favcolor']; // Favorite color to be saved in the cookie

    // Database connection
    $con = mysqli_connect("localhost", "root", "", "aqi"); // Replace with your DB credentials
    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Escape input values for safety
    $fullname = mysqli_real_escape_string($con, $fullname);
    $email = mysqli_real_escape_string($con, $email);
    $password = mysqli_real_escape_string($con, $password);
    $location = mysqli_real_escape_string($con, $location);
    $zipcode = mysqli_real_escape_string($con, $zipcode);
    $country = mysqli_real_escape_string($con, $country);

    // Check if email already exists
    $checkEmailQuery = "SELECT * FROM usertable WHERE email = '$email'";
    $result = mysqli_query($con, $checkEmailQuery);

    if (mysqli_num_rows($result) > 0) {
        // Email already registered
        $error = "This email is already registered. Please use another email.";
    } else {
        // Insert new user
        $sql = "INSERT INTO usertable (username, email, password, location, zipcode, country) 
                VALUES ('$fullname', '$email', '$password', '$location', '$zipcode', '$country')";
        if (mysqli_query($con, $sql)) {
            // Set cookie for favorite color
            setcookie("favcolor", $favcolor, time() + (30 * 24 * 60 * 60), "/"); // 30 days expiry
            $_SESSION['registration_success'] = "Your registration is done, please login.";
            $success = true;
        } else {
            $error = "Database error: " . mysqli_error($con);
        }
    }

    mysqli_close($con);
}

// Step 3: Display the confirmation page (if not confirmed yet)
if (!isset($_POST['confirm'])) {
    $fullname = $_SESSION['fullname'];
    $email = $_SESSION['email'];
    $password = $_SESSION['password'];
    $location = $_SESSION['location'];
    $zipcode = $_SESSION['zipcode'];
    $country = $_SESSION['country'];
    $favcolor = $_SESSION['favcolor'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>User Details</title>
<style>
    body, html {
        height: 100%;
        margin: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        font-family: Arial, sans-serif;
        background-color: #f9f9f9;
    }
    .container {
        background: white;
        padding: 20px 30px;
        border-radius: 6px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        min-width: 350px;
    }
    table {
        border-collapse: collapse;
        border: 1px solid #333;
        width: 100%;
        margin-bottom: 20px;
    }
    th, td {
        border: 1px solid #333;
        padding: 10px 15px;
        text-align: left;
    }
    th {
        background-color: #4CAF50;
        color: white;
    }
    .buttons {
        display: flex;
        justify-content: space-between;
    }
    .btn {
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
        text-align: center;
        text-decoration: none; /* for <a> */
        display: inline-block;
        min-width: 120px; /* equal width */
        color: white;
        background-color: #4C53AF; /* same color for both */
        border: 1px solid #333;
        transition: background-color 0.3s ease;
    }
    .btn:hover {
        background-color: #3b4296;
    }
    .success-message {
        padding: 10px;
        background-color: #4CAF50;
        color: white;
        text-align: center;
        margin-bottom: 20px;
        font-size: 18px;
        border-radius: 5px;
    }
    .error-message {
        padding: 10px;
        background-color: #f44336;
        color: white;
        text-align: center;
        margin-bottom: 20px;
        font-size: 18px;
        border-radius: 5px;
    }
</style>
</head>
<body>
    <div class="container">

        <?php if ($success): ?>
            <div class="success-message">
                <?php echo $_SESSION['registration_success']; ?>
            </div>
        <?php elseif ($error): ?>
            <div class="error-message">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <h2>Confirm Your Details:</h2>
        <table>
            <tr><th>Field</th><th>Value</th></tr>
            <tr><td>Full Name</td><td><?php echo htmlspecialchars($fullname); ?></td></tr>
            <tr><td>Email</td><td><?php echo htmlspecialchars($email); ?></td></tr>
            <tr><td>Password</td><td><?php echo htmlspecialchars($password); ?></td></tr>
            <tr><td>Location</td><td><?php echo htmlspecialchars($location); ?></td></tr>
            <tr><td>Zip Code</td><td><?php echo htmlspecialchars($zipcode); ?></td></tr>
            <tr><td>Country</td><td><?php echo htmlspecialchars($country); ?></td></tr>
            <tr><td>Favorite Color</td><td><?php echo htmlspecialchars($favcolor); ?></td></tr>
        </table>

        <div class="buttons">
            <a href="index.php" class="btn cancel-btn">Cancel</a>

            <form method="post" action="process.php" style="margin:0;">
                <input type="submit" name="confirm" class="btn confirm-btn" value="Confirm" <?php if ($success) echo 'disabled'; ?>>
            </form>
        </div>
    </div>
</body>
</html>
