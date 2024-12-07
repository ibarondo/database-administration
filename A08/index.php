<?php
include("connect.php");

// Filters
$airlineNameFilter = $_GET['airlineName'];
$aircraftTypeFilter = $_GET['aircraftType'];
$sort = $_GET['sort'];
$order = $_GET['order'];

// Query to get all flight logs
$flightLogsQuery = "SELECT * FROM flightlogs";

if ($aircraftTypeFilter != '' || $airlineNameFilter != '') {
    $flightLogsQuery = $flightLogsQuery . " WHERE";

    if ($aircraftTypeFilter != '') {
        $flightLogsQuery = $flightLogsQuery . " aircraftType = '$aircraftTypeFilter'";
    }

    if ($aircraftTypeFilter != '' && $airlineNameFilter != '') {
        $flightLogsQuery = $flightLogsQuery . " AND";
    }

    if ($airlineNameFilter != '') {
        $flightLogsQuery = $flightLogsQuery . " airlineName = '$airlineNameFilter'";
    }
}

// Sorting
if ($sort != '') {
    $flightLogsQuery = $flightLogsQuery . " ORDER BY $sort";

    if ($order != '') {
        $flightLogsQuery = $flightLogsQuery . " $order";
    }
}

// Query Execution and Results
$flightLogsResults = executeQuery($flightLogsQuery);

$aircraftTypeQuery = "SELECT DISTINCT aircraftType FROM flightlogs";
$aircraftTypeResults = executeQuery($aircraftTypeQuery);

$airlineNamQuery = "SELECT DISTINCT airlineName FROM flightlogs";
$airlineNameResults = executeQuery($airlineNamQuery);
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Flight Logs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="icon" href="assets/plane.png">
</head>

<body>
    <div class="container">
        <div class="row my-5">
            <div class="col">
                <form>
                    <div class="card p-4" style="border: transparent">
                        <div class="h2 mb-5">Flight Logs</div>
                        <div class="row d-flex flex-row align-items-center" style="font-weight: 500">

                            <!-- Aircraft Type Filter -->
                            <div class="col-3">
                                <label for="aircraftType" class="ms-2 mb-2">Aircraft Type</label>
                                <select id="aircraftType" name="aircraftType" class="ms-2 form-control"
                                    style="border: 1px solid black">

                                    <option value="">Any</option>

                                    <?php
                                    if (mysqli_num_rows($aircraftTypeResults) > 0) {
                                        while ($aircraftRow = mysqli_fetch_assoc($aircraftTypeResults)) {
                                            ?>

                                            <option <?php if ($aircraftTypeFilter == $aircraftRow['aircraftType']) {
                                                echo 'selected';
                                            } ?> value="<?php echo $aircraftRow['aircraftType']; ?>">
                                                <?php echo $aircraftRow['aircraftType']; ?>
                                            </option>

                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>

                            <!-- Airline Name Filter -->
                            <div class="col-3">
                                <label for="airlineName" class="ms-2 mb-2">Airlines</label>
                                <select id="airlineName" name="airlineName" class="ms-2 form-control"
                                    style="border: 1px solid black">

                                    <option value="">Any</option>

                                    <?php
                                    if (mysqli_num_rows($airlineNameResults) > 0) {
                                        while ($airlineNameRow = mysqli_fetch_assoc($airlineNameResults)) {
                                            ?>

                                            <option <?php if ($airlineNameFilter == $airlineNameRow['airlineName']) {
                                                echo 'selected';
                                            } ?> value="<?php echo $airlineNameRow['airlineName']; ?>">
                                                <?php echo $airlineNameRow['airlineName']; ?>
                                            </option>

                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>

                            <!-- Sorting and Order -->
                            <div class="col-3">
                                <label for="sort" class="ms-2 mb-2">Sort By</label>
                                <select id="sort" name="sort" class="ms-2 form-control" style="border: 1px solid black">

                                    <option value="">None</option>

                                    <option <?php if ($sort == "airlineName") {
                                        echo "selected";
                                    } ?> value="airlineName">
                                        Airlines</option>

                                    <option <?php if ($sort == "flightNumber") {
                                        echo "selected";
                                    } ?>   value="flightNumber">
                                        Flight No.</option>

                                    <option <?php if ($sort == "passengerCount") {
                                        echo "selected";
                                    } ?>
                                        value="passengerCount">Passenger Count</option>

                                    <option <?php if ($sort == "pilotName") {
                                        echo "selected";
                                    } ?> value="pilotName">
                                        Pilot</option>
                                </select>
                            </div>

                            <div class="col-3">
                                <label for="order" class="ms-2 mb-2">Order By</label>
                                <select id="order" name="order" class="ms-2 form-control"
                                    style="border: 1px solid black">

                                    <option value="">Default</option>

                                    <option <?php if ($order == "ASC") {
                                        echo "selected";
                                    } ?> value="ASC">Ascending
                                    </option>
                                    <option <?php if ($order == "DESC") {
                                        echo "selected";
                                    } ?> value="DESC">Descending
                                    </option>
                                </select>
                            </div>
                        </div>

                        <!-- Button -->
                        <div class="text-end">
                            <button class="btn btn-dark ms-2 mt-4 rounded-3"
                                style="width: fit-content; font-weight: 400;">Apply</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Table to Display Data -->
        <div class="row my-5">
            <div class="col">
                <div class="card p-4 rounded-4" style="border: 1px solid black">
                    <div class="table-responsive">
                        <table class="table text-center">
                            <thead>
                                <tr>
                                    <th scope="col" style="font-weight: 500">Flight No.</th>
                                    <th scope="col" style="font-weight: 500">Aircraft Type</th>
                                    <th scope="col" style="font-weight: 500">Airlines</th>
                                    <th scope="col" style="font-weight: 500">Pilot</th>
                                    <th scope="col" style="font-weight: 500">Departure Time</th>
                                    <th scope="col" style="font-weight: 500">Arrival Time</th>
                                    <th scope="col" style="font-weight: 500">Passenger Count</th>
                                </tr>
                            </thead>

                            <tbody class="text-center">
                                <?php
                                if (mysqli_num_rows($flightLogsResults) > 0) {
                                    while ($flightLogrow = mysqli_fetch_assoc($flightLogsResults)) {
                                        ?>
                                        <tr>
                                            <td> <?php echo $flightLogrow['flightNumber'] ?></td>
                                            <td> <?php echo $flightLogrow['aircraftType'] ?> </td>
                                            <td> <?php echo $flightLogrow['airlineName'] ?> </td>
                                            <td> <?php echo $flightLogrow['pilotName'] ?> </td>
                                            <td> <?php echo $flightLogrow['departureDatetime'] ?></td>
                                            <td> <?php echo $flightLogrow['arrivalDatetime'] ?> </td>
                                            <td> <?php echo $flightLogrow['passengerCount'] ?> </td>
                                        </tr>
                                        <?php
                                    }
                                } ?>
                            </tbody>
                        </table>
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