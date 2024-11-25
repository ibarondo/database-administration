<?php
include("connect.php");

if (isset($_POST['edit'])) {
  $userinfoID = $_POST['userinfoID'];
  $firstName = $_POST['firstName'];
  $lastName = $_POST['lastName'];
  $birthDay = $_POST['birthDay'];
  $cityID = $_POST['cityID'];
  $provinceID = $_POST['provinceID'];

  $updateQuery = "UPDATE userinfo 
                  JOIN addresses ON userinfo.addressID = addresses.addressID
                  SET firstName = '$firstName', lastName = '$lastName', birthDay = '$birthDay', 
                      addresses.cityID = '$cityID', addresses.provinceID = '$provinceID' 
                  WHERE userinfoID = '$userinfoID'";
  mysqli_query($conn, $updateQuery);

  header("Location: index.php");
}

$query = "SELECT userinfoID, firstName, lastName, birthDay, cities.cityName, provinces.provinceName, isDeleted 
          FROM userinfo 
          LEFT JOIN addresses on userinfo.addressID = addresses.addressID
          LEFT JOIN cities ON addresses.cityID = cities.cityID
          LEFT JOIN provinces ON addresses.provinceID = provinces.provinceID
          WHERE isDeleted = 'no'";
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
  <link rel="icon" href="user.ico">
</head>

<body>
  <div class="container my-5">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">
            <h3>User Information</h3>
            <!-- Button to insert new user -->
            <a href="insert.php" class="btn btn-primary btn-sm position-absolute" style="top: 10px; right: 10px;">
              Insert New User
            </a>
          </div>
          <div class="card-body">
            <?php if (mysqli_num_rows($result)) { ?>
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Birth Date</th>
                    <th scope="col">City</th>
                    <th scope="col">Province</th>
                    <th scope="col">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php while ($user = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                      <td><?php echo $user["firstName"]; ?></td>
                      <td><?php echo $user["lastName"]; ?></td>
                      <td><?php echo $user["birthDay"]; ?></td>
                      <td><?php echo $user["cityName"]; ?></td>
                      <td><?php echo $user["provinceName"]; ?></td>
                      <td>
                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                          data-bs-target="#deleteModal<?php echo $user['userinfoID']; ?>">Delete</button>
                        <button class="btn btn-secondary btn-sm" data-bs-toggle="modal"
                          data-bs-target="#editModal<?php echo $user['userinfoID']; ?>">Edit</button>
                      </td>
                    </tr>
                    <!-- Delete Modal -->
                    <div class="modal fade" id="deleteModal<?php echo $user['userinfoID']; ?>" tabindex="-1">
                      <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel">Delete User Info?</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <p>This action will permanently delete the user information.</p>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <form action="index.php" method="POST">
                              <input type="hidden" name="userinfoID" value="<?php echo $user['userinfoID']; ?>">
                              <input type="hidden" name="delete" value="1">
                              <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Edit Modal -->
                    <div class="modal fade" id="editModal<?php echo $user['userinfoID']; ?>" tabindex="-1">
                      <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title">Edit User Info</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <form action="index.php" method="POST">
                              <input type="hidden" name="userinfoID" value="<?php echo $user['userinfoID']; ?>">
                              <div class="mb-3">
                                <label for="firstName" class="form-label">First Name</label>
                                <input type="text" class="form-control" name="firstName"
                                  value="<?php echo $user['firstName']; ?>" required>
                              </div>
                              <div class="mb-3">
                                <label for="lastName" class="form-label">Last Name</label>
                                <input type="text" class="form-control" name="lastName"
                                  value="<?php echo $user['lastName']; ?>" required>
                              </div>
                              <div class="mb-3">
                                <label for="birthDay" class="form-label">Birth Date</label>
                                <input type="date" class="form-control" name="birthDay"
                                  value="<?php echo $user['birthDay']; ?>" required>
                              </div>
                              <div class="mb-3">
                                <label for="cityID" class="form-label">City</label>
                                <select class="form-control" name="cityID" required>
                                  <?php
                                  $citiesQuery = "SELECT * FROM cities";
                                  $citiesResult = executeQuery($citiesQuery);
                                  while ($city = mysqli_fetch_assoc($citiesResult)) {
                                    $selected = ($city['cityID'] == $user['cityID']) ? 'selected' : '';
                                    echo "<option value='{$city['cityID']}' $selected>{$city['cityName']}</option>";
                                  }
                                  ?>
                                </select>
                              </div>
                              <div class="mb-3">
                                <label for="provinceID" class="form-label">Province</label>
                                <select class="form-control" name="provinceID" required>
                                  <?php
                                  $provincesQuery = "SELECT * FROM provinces";
                                  $provincesResult = executeQuery($provincesQuery);
                                  while ($province = mysqli_fetch_assoc($provincesResult)) {
                                    $selected = ($province['provinceID'] == $user['provinceID']) ? 'selected' : '';
                                    echo "<option value='{$province['provinceID']}' $selected>{$province['provinceName']}</option>";
                                  }
                                  ?>
                                </select>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" name="edit" value="1" class="btn btn-primary">Save Changes</button>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>

                  <?php } ?>
                </tbody>
              </table>
            <?php } else {
              echo "<div class='col-12'><p>No users found.</p></div>";
            } ?>
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