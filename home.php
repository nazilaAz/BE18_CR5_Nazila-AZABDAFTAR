<?php
session_start();
if (isset($_SESSION['admin'])) {
    header("Location: adminPanel/dashboard.php");
    exit;
}
// if session is not set this will redirect to login page
if (!isset($_SESSION['admin']) && !isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}
require_once "components/db_connect.php";
require_once "components/file_upload.php";

$res = mysqli_query($connect, "SELECT * FROM user WHERE id=" . $_SESSION['user']);
$rowUser = mysqli_fetch_array($res, MYSQLI_ASSOC);

$srtSql = "SELECT * FROM `animal`";
$result = mysqli_query($connect, $srtSql);


$card = '';


if (mysqli_num_rows($result)  > 0) {
    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $colortd = '';

    foreach ($rows as $row) {
        if ($row['status'] == 1) {
            $row['status'] = 'Available';
            $colortd = "green";
        } else {
            $row['status'] = 'Adopted';
            $colortd = "red";
        }

        $card .= "

                <div class='card mt-3 mx-3' style='width: 18rem;'>
                        <img src='pictures/{$row['picture']}' class='card-img-top imgTop' alt='...'>
                        <div class='card-body'>
                            <h5 class='card-title'>Name: {$row['name']}</h5>
                            <p class='card-text'>Breed: {$row['breed']} </p>
                            <p class='card-text'>Age: {$row['age']} </p>
                            
                        </div>
               
                    <div class='card-footer text-center'>
                    <p class='card-text' style='color:$colortd;'> {$row['status']} </p>                        
                        <a href='details.php?id={$row['id']}' role='button' class='btn btn-warning'>more...</a>         
                    </div>
                </div>
        ";
    };
} else {
    $card =  "<tr><td colspan='5'><center>No Data Available </center></td></tr>";
}
mysqli_close($connect);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adopt a Pet-Welcome - <?php echo $rowUser['first_name']; ?></title>
    <?php include_once "components/boot.php"; ?>
    <link rel="stylesheet" href="components/css/style.css">
    <style>
        .userImage {
            width: 3rem;
            height: 3rem;
        }

        .hero {
            background: rgb(2, 0, 36);
            background: linear-gradient(24deg, rgba(2, 0, 36, 1) 0%, rgba(0, 212, 255, 1) 100%);
        }
    </style>
</head>

<body id="home">
    <nav class="navbar navbar-expand-lg" style="background-color: #C1A3A3;">
        <div class="container-fluid">
            <a class="navbar-brand txtFont">Adopt a Pet</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="home.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="senior.php">Senior</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="login.php"></a>
                    </li> -->
                </ul>
            </div>
            <div class="collapse navbar-collapse justify-content-end ps-5" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link rightLogin">Hi, <?= $rowUser['first_name']; ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link rightLogin"><?= $rowUser['email']; ?></a>
                    </li>
                    <li class="nav-item">
                        <img class="img-thumbnail userImage" src="pictures/<?=$rowUser['picture'];?>" >
                    </li>
                    <li class="nav-item">
                        <a class="nav-link rightLogin" href="logout.php?logout"><i class="bi bi-box-arrow-left"></i> Logout</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <fieldset class="read">
            <legend class='h2 text-center mt-3'>Pet List</legend>

            <!-- <a href="create.php" type="button" role="button" class="btn btn-info">
                Add new
            </a> -->
            <div class="row row-cols-md-3">
                <?= $card ?>
            </div>

            <!--  -->
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
    <?php require_once "components/bootjs.php"; ?>
</body>

</html>