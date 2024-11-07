<?php
include("connect.php");

// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//     $firstName = $_POST['firstName'];
//     $lastName = $_POST['lastName'];
//     $birthday = $_POST['birthday'];

//     $query = "INSERT INTO userinfo (firstName, lastName, birthDay) 
//               VALUES ('$firstName', '$lastName', '$birthday')";

//     $result = mysqli_query($conn, $query);

//     mysqli_close($conn);
// } else {
//     header("Location: ../index.php");
// }
?>


<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>M01</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
            <form method="post">
              <input type="text" class="form-control" placeholder="First Name" name="firstName" required>
              <input type="text" class="form-control mt-3" placeholder="Last Name" name="lastName" required>
              <input type="date" class="form-control mt-3" placeholder="Birthday" name="birthday" required>
              <div>
                <button type="submit" class="btn btn-primary mt-3">Submit</button>
                <button type="reset" class="btn btn-secondary mt-3">Clear</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>






  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>