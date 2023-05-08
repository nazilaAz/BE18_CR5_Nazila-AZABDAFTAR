<?php
session_start();
if (!isset($_SESSION['admin']) && !isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}
if (isset($_SESSION['admin'])) {
    header("Location: adminPanel/dashboard.php");
    exit;
}
include_once "components/db_connect.php";
include_once "components/file_upload.php";

if (isset($_GET['id'])) {
    $sql = "SELECT * FROM `animal` WHERE id = " . $_GET['id'];
    $result = mysqli_query($connect, $sql);
    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

    $img = '';
    $name = '';
    $breed = '';
    $live = '';
    $size = '';
    $age = '';
    $vaccinated = '';
    $status = '';
    $desc = '';

    if (mysqli_num_rows($result) > 0) {
        foreach ($rows as $row) {
            $img = "
                    <img class='img-thumbnail' src='pictures/" . $row['picture'] . "'>
                    ";
            if($row['vaccinated']==1){
                $row['vaccinated'] = 'Vaccinated';
            }else{
                $row['vaccinated'] = 'not Vaccinated';
            }
           

            if ($row['status'] == 1) {
                $row['status'] = 'Available';
                // $colortd = "green";
            } else {
                $row['status'] = 'Adopted';
                // $colortd = "red";
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>More</title>
    <?php include_once "components/boot.php"; ?>
    <link rel="stylesheet" href="components/css/style.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary" style="background-color: #C1A3A3;">
        <div class="container-fluid">
            <a class="navbar-brand txtFont" href="index.php">Adopt a Pet</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="home.php">Home</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="read.php">Our meals</a>
                    </li> -->
                </ul>
            </div>
        </div>
    </nav>
    <div class="container" id="details">

        <div class="card" style="width: 70%;">
            <?= $img ?>
            <div class="card-body">
                <p class="card-text"><?= $row['name'] ?></p>
                <p class="card-text">Breed: <?= $row['breed'] ?></p>
                <p class="card-text">Where: <?= $row['live'] ?></p>
                <p class="card-text">Size: <?= $row['size'] ?></p>
                <p class="card-text">Age: <?= $row['age'] ?></p>
                <p class="card-text"><?= $row['description'] ?></p>
                <!-- <a href="home.php" class="card-link"><img class="backImg" src="https://cdn-icons-png.flaticon.com/512/2099/2099166.png"></a> -->
            </div>
            <div class='card-footer text-center'>
                <p class="card-text text-uppercase fw-bold"><?= $row['vaccinated'] ?></p>
                <p class="card-text"><?= $row['status'] ?></p>
                <a href="home.php" role="button" class='btn btn-warning btn-sm' id='center' style='color:white'>Back</a>
            </div>
        </div>

        <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
                <div class="col-md-4 d-flex align-items-center">
                   
                    <span class="mb-3 mb-md-0 text-muted">&copy; PHP-Mysql Adop a Pet, CodeFactory</span>
                </div>

                <ul class="nav col-md-4 justify-content-end list-unstyled d-flex">
                    <li class="ms-3"><i class="bi bi-twitter"></i></li>
                    <li class="ms-3"><i class="bi bi-facebook"></i></li>
                    <li class="ms-3"><i class="bi bi-instagram"></i></li>
                    <li class="ms-3"><i class="bi bi-youtube"></i></li>
                </ul>
            </footer>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
</body>

</html>