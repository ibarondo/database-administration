<?php
include("connect.php");

// Fetch province and city data
$provinceQuery = "SELECT * FROM provinces";
$cityQuery = "SELECT * FROM cities";
$provinceResult = executeQuery($provinceQuery);
$cityResult = executeQuery($cityQuery);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $firstName = $_POST['firstName'];
  $lastName = $_POST['lastName'];
  $birthday = $_POST['birthday'];
  $provinceID = $_POST['provinceID'];
  $cityID = $_POST['cityID'];

  // Insert into `addresses` and get `addressID`
  $addressQuery = "INSERT INTO addresses (provinceID, cityID) VALUES ('$provinceID', '$cityID')";
  $addressResult = executeQuery($addressQuery);

  if ($addressResult) {
    $addressID = mysqli_insert_id($conn); // Get the last inserted addressID

    // Insert into `userinfo` with `addressID`
    $userInfoQuery = "INSERT INTO userinfo (firstName, lastName, birthday, addressID) 
                          VALUES ('$firstName', '$lastName', '$birthday', '$addressID')";
    $userInfoResult = executeQuery($userInfoQuery);

    if ($userInfoResult) {
      // Redirect to the list page after successful insertion
      header("Location: list.php"); // Redirect to the 'list.php' page
      exit; // Ensure the rest of the script doesn't run
    } else {
      echo "Error in userinfo insertion: " . mysqli_error($conn);
    }
  } else {
    echo "Error in addresses insertion: " . mysqli_error($conn);
  }

  mysqli_close($conn);
}
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>M01</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="icon" href="user.ico">
</head>

<body>
  <div class="container-fluid my-5">
    <div class="row justify-content-center">
      <div class="col-md-6 col-12 p-3">
        <div class="card">
          <div class="card-header">
            <h3>User Information</h3>
          </div>
          <div class="card-body">
            <form method="POST">
              <input type="text" class="form-control" placeholder="First Name" name="firstName" required>
              <input type="text" class="form-control mt-3" placeholder="Last Name" name="lastName" required>
              <input type="date" class="form-control mt-3" placeholder="Birthday" name="birthday" required>

              <div class="mt-3">
                <select class="form-select form-select-sm" name="provinceID" aria-label="Province Select" required>
                  <option value="">Select Province</option>
                  <?php
                  while ($province = mysqli_fetch_assoc($provinceResult)) {
                    echo "<option value='{$province['provinceID']}'>{$province['provinceName']}</option>";
                  }
                  ?>
                </select>
              </div>

              <div class="mt-3">
                <select class="form-select form-select-sm" name="cityID" aria-label="City Select" required>
                  <option value="">Select City</option>
                  <?php
                  while ($city = mysqli_fetch_assoc($cityResult)) {
                    echo "<option value='{$city['cityID']}'>{$city['cityName']}</option>";
                  }
                  ?>
                </select>
              </div>

              <div class="mt-3">
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="reset" class="btn btn-secondary">Clear</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
</body>

</html>