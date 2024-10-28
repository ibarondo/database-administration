<?php
include("connect.php");

// Update the query to select data from the userinfo table
$query = "SELECT firstName, lastName, userID, birthDay FROM userinfo";

$result = executeQuery($query);
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>User Information</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
  <div class="container-fluid shadow mb-5 p-3">
    <h1>User Information</h1>
  </div>
  <div class="container">
    <div class="row">

      <!-- PHP BLOCK -->
      <?php
      if (mysqli_num_rows($result)) {
        while ($user = mysqli_fetch_assoc($result)) {
          ?>

          <div class="col-12">
            <div class="card rounded-4 shadow my-3 mx-2" style="background-color: beige">
              <div class="card-body">
                <h5 class="card-title">
                  <?php echo $user["firstName"] . " " . $user["lastName"]; ?>
                </h5>
                <h6 class="card-subtitle mb-2 text-body-secondary">
                  User ID: <?php echo $user["userID"]; ?>
                </h6>
                <p class="card-text">
                  Birth Date: <?php echo $user["birthDay"]; ?>
                </p>
              </div>
            </div>
          </div>

          <?php
        }
      } else {
        echo "<div class='col-12'><p>No users found.</p></div>";
      }
      ?>

    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
</body>

</html>
