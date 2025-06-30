<?php
session_start();


// Handle form submission before checking session
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['confirm'])) {
    $_SESSION['fullname'] = $_POST['fullname'];
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['password'] = $_POST['password'];
    $_SESSION['location'] = $_POST['location'];
    $_SESSION['zipcode'] = $_POST['zipcode'];
    $_SESSION['country'] = $_POST['country'];
    $_SESSION['favcolor'] = $_POST['favcolor'];

    header("Location: process.php");
    exit();
}

// Check if required session data is present
if (
    !isset($_SESSION['fullname']) ||
    !isset($_SESSION['email']) ||
    !isset($_SESSION['password']) ||
    !isset($_SESSION['location']) ||
    !isset($_SESSION['zipcode']) ||
    !isset($_SESSION['country']) ||
    !isset($_SESSION['favcolor'])
) {
    header("Location: index.php");
    exit();
}

$success = false;
$error = "";

// Confirm registration and insert into DB
if (isset($_POST['confirm'])) {
    $fullname = $_SESSION['fullname'];
    $email = $_SESSION['email'];
    $password = $_SESSION['password'];
    $location = $_SESSION['location'];
    $zipcode = $_SESSION['zipcode'];
    $country = $_SESSION['country'];
    $favcolor = $_SESSION['favcolor'];

    $con = mysqli_connect("localhost", "root", "", "aqi");
    if (!$con) {
        die("Database connection failed: " . mysqli_connect_error());
    }

    // Escape input
    $fullname = mysqli_real_escape_string($con, $fullname);
    $email = mysqli_real_escape_string($con, $email);
    $password = mysqli_real_escape_string($con, $password);
    $location = mysqli_real_escape_string($con, $location);
    $zipcode = mysqli_real_escape_string($con, $zipcode);
    $country = mysqli_real_escape_string($con, $country);

    // Check duplicate
    $checkEmail = "SELECT * FROM usertable WHERE email = '$email'";
    $result = mysqli_query($con, $checkEmail);

    if (mysqli_num_rows($result) > 0) {
        $error = "This email is already registered. Please use another.";
    } else {
        $insert = "INSERT INTO usertable (username, email, password, location, zipcode, country) 
                   VALUES ('$fullname', '$email', '$password', '$location', '$zipcode', '$country')";

        if (mysqli_query($con, $insert)) {
            setcookie("favcolor", $favcolor, time() + (30 * 24 * 60 * 60), "/");
            $_SESSION['registration_success'] = "Your registration is done, please login.";
            $success = true;
        } else {
            $error = "Database error: " . mysqli_error($con);
        }
    }

    mysqli_close($con);
}

// Assign values for display
$fullname = $_SESSION['fullname'];
$email = $_SESSION['email'];
$password = $_SESSION['password'];
$location = $_SESSION['location'];
$zipcode = $_SESSION['zipcode'];
$country = $_SESSION['country'];
$favcolor = $_SESSION['favcolor'];
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
 <script>
    window.addEventListener('pageshow', function(event) {
        if (event.persisted) {
            window.location.reload();
        }
    });
  </script>
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
<script>
    window.addEventListener("pageshow", function(event) {
        if (event.persisted || performance.getEntriesByType("navigation")[0].type === "back_forward") {
            window.location.reload();
        }
    });
</script>


</body>
</html>
