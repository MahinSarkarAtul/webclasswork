<?php
// Connect to DB
$con = mysqli_connect("localhost", "root", "", "aqi");
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

if (!isset($_POST['cities']) || !is_array($_POST['cities']) || count($_POST['cities']) !== 10) {
    die("Error: Please select exactly 10 cities.");
}

$selectedCities = $_POST['cities'];

$escapedCities = array_map(function($city) use ($con) {
    return "'" . mysqli_real_escape_string($con, $city) . "'";
}, $selectedCities);

$inClause = implode(",", $escapedCities);

$sql = "SELECT City, Country, AQI FROM infotable WHERE City IN ($inClause) ORDER BY City";

$result = mysqli_query($con, $sql);

if (!$result) {
    die("Query failed: " . mysqli_error($con));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Selected Cities AQI</title>
<style>
    body {
        font-family: Arial, sans-serif;
        padding: 20px;
        max-width: 700px;
        margin: auto;
        background-color: #f5f5f5;
        color: #333;
    }
    h1 {
        text-align: center;
        margin-bottom: 20px;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        background-color: white;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        margin-bottom: 20px;
    }
    th, td {
        padding: 12px;
        border: 1px solid #ccc;
        text-align: center;
    }
    th {
        background-color: #11616b;
        color: white;
    }
    .buttons-wrapper {
        display: flex;
        justify-content: space-between;
        max-width: 700px;
        margin: auto;
    }
    .btn, button {
        padding: 10px 20px;
        border-radius: 6px;
        border: none;
        font-size: 16px;
        cursor: pointer;
        text-decoration: none;
        text-align: center;
        color: white;
        min-width: 120px;
        user-select: none;
        display: inline-block;
    }
    .btn-back {
        background-color: #f44336; /* Red */
    }
    .btn-back:hover {
        background-color: #d7372d;
    }
    .btn-logout {
        background-color: #4CAF50; /* Green */
    }
    .btn-logout:hover {
        background-color: #3e8e41;
    }
</style>
</head>
<body>
  <h1>Air Quality Index for Selected Cities</h1>

  <?php if (mysqli_num_rows($result) === 0): ?>
    <p>No data found for the selected cities.</p>
  <?php else: ?>
    <table>
      <thead>
        <tr>
          <th>City</th>
          <th>Country</th>
          <th>AQI</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
          <tr>
            <td><?= htmlspecialchars($row['City']) ?></td>
            <td><?= htmlspecialchars($row['Country']) ?></td>
            <td><?= htmlspecialchars($row['AQI']) ?></td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  <?php endif; ?>

  <div class="buttons-wrapper">
    <a href="request.php" class="btn btn-back">Back</a>

    <?php /*
    <form action="logout.php" method="post" style="margin: 0;">
      <button type="submit" class="btn btn-logout" name="logout">Logout</button>
    </form>
    */ ?>
  </div>

<?php mysqli_close($con); ?>
</body>
</html>
