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
  <div class="container my-5">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">
            <h3>User Information</h3>
          </div>
          <div class="card-body">
            <!-- PHP BLOCK -->
            <?php
            if (mysqli_num_rows($result)) {
            ?>
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th scope="col">User ID</th>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Birth Date</th>
                  </tr>
                </thead>
                <tbody>
                  <?php

                  while ($user = mysqli_fetch_assoc($result)) {
                  ?>
                    <tr>
                      <td><?php echo $user["userID"]; ?></td>
                      <td><?php echo $user["firstName"]; ?></td>
                      <td><?php echo $user["lastName"]; ?></td>
                      <td><?php echo $user["birthDay"]; ?></td>
                    </tr>
                  <?php
                  }
                  ?>
                </tbody>
              </table>
            <?php
            } else {
              echo "<div class='col-12'><p>No users found.</p></div>";
            }
            ?>
          </div>
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
