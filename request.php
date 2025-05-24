<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Select Cities</title>
<style>
  body {
    font-family: Arial, sans-serif;
    padding: 20px;
    max-width: 600px;
    margin: auto;
    background: linear-gradient(135deg, #11616b, #4c53af);
    color: white; /* Make text readable on dark background */
  }
  h1 {
    text-align: center;
    margin-bottom: 20px;
  }
  form {
    display: flex;
    flex-direction: column;
  }
  .cities-container {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px 40px;
    max-height: 400px;
    overflow-y: auto;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 6px;
    margin-bottom: 20px;
    background-color: rgba(33, 6, 83, 0.15);
  }
  label {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 16px;
    cursor: pointer;
    user-select: none;
    color: white;
  }
  button, .back-button {
    width: 120px;
    padding: 12px 0;
    font-size: 16px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    color: white;
    transition: background-color 0.3s ease;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    user-select: none;
  }
  button {
    background-color: #4CAF50; /* Green */
  }
  button:hover {
    background-color: #3e8e41;
  }
  .back-button {
    background-color: #f44336; /* Red */
    line-height: 1.2;
    padding-top: 12px;
    padding-bottom: 12px;
  }
  .back-button:hover {
    background-color: #d7372d;
  }
  .buttons-wrapper {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 10px;
  }
</style>

</head>
<body>
  <h1>Please Select Exactly 10 Cities</h1>
  <form id="cityForm" action="show.php" method="post" onsubmit="return validateSelection()">
    <div class="cities-container">
      <label><input type="checkbox" name="cities[]" value="Dhaka"> Dhaka</label>
      <label><input type="checkbox" name="cities[]" value="Beijing"> Beijing</label>
      <label><input type="checkbox" name="cities[]" value="Delhi"> Delhi</label>
      <label><input type="checkbox" name="cities[]" value="New York"> New York</label>
      <label><input type="checkbox" name="cities[]" value="London"> London</label>
      <label><input type="checkbox" name="cities[]" value="Berlin"> Berlin</label>
      <label><input type="checkbox" name="cities[]" value="Paris"> Paris</label>
      <label><input type="checkbox" name="cities[]" value="Tokyo"> Tokyo</label>
      <label><input type="checkbox" name="cities[]" value="Sydney"> Sydney</label>
      <label><input type="checkbox" name="cities[]" value="Toronto"> Toronto</label>
      <label><input type="checkbox" name="cities[]" value="São Paulo"> São Paulo</label>
      <label><input type="checkbox" name="cities[]" value="Moscow"> Moscow</label>
      <label><input type="checkbox" name="cities[]" value="Johannesburg"> Johannesburg</label>
      <label><input type="checkbox" name="cities[]" value="Mexico City"> Mexico City</label>
      <label><input type="checkbox" name="cities[]" value="Rome"> Rome</label>
      <label><input type="checkbox" name="cities[]" value="Riyadh"> Riyadh</label>
      <label><input type="checkbox" name="cities[]" value="Seoul"> Seoul</label>
      <label><input type="checkbox" name="cities[]" value="Cairo"> Cairo</label>
      <label><input type="checkbox" name="cities[]" value="Istanbul"> Istanbul</label>
      <label><input type="checkbox" name="cities[]" value="Buenos Aires"> Buenos Aires</label>
    </div>

    <div class="buttons-wrapper">
      <a href="index.php" class="back-button" role="button">Back</a>
      <button type="submit">Submit</button>
    </div>
  </form>

  <script>
    function validateSelection() {
      const checked = document.querySelectorAll('input[name="cities[]"]:checked').length;
      if (checked !== 10) {
        alert("You must select exactly 10 cities.");
        return false;
      }
      return true;
    }
  </script>
</body>
</html>
