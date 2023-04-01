<?php
session_start();
if (!isset($_SESSION['admin']) && !isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}
if (isset($_SESSION['user'])) {
    header("Location: ../home.php");
    exit;
}
require_once "../../components/db_connect.php";
require_once "../../components/file_upload.php";

$res = mysqli_query($connect, "SELECT * FROM user WHERE id=" . $_SESSION['admin']);
$rowUser = mysqli_fetch_array($res, MYSQLI_ASSOC);

if ($_POST) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $breed = $_POST['breed'];
    $live = $_POST['live'];
    $description = $_POST['description'];
    $size = $_POST['size'];
    $age = $_POST['age'];
    // $picture = $_POST['picture'];
    $picture = file_upload($_FILES['picture'], "pet");

    if (isset($_POST['status'])) {
        $status = 1;
    } else {
        $status = 0;
    }
    if (isset($_POST['vaccinated'])) {
        $vaccinated = 1;
    } else {
        $vaccinated = 0;
    }

  

    $sql = "UPDATE `animal` SET `name`='$name',`picture`='$picture->fileName',`breed`='$breed',`live`='$live',`description`='$description',`size`='$size',`age`='$age',`vaccinated`='$vaccinated',`status`='$status' WHERE id = {$id}";
    // var_dump($sql);
    // die();

    if (mysqli_query($connect, $sql) === TRUE) {
        $class = "success";
        $message = "The record was successfully updated";
    } else {
        $class = "danger";
        $message = "Error while updating record : <br>" . mysqli_connect_error();
    }
    mysqli_close($connect);
} else {
    header("location: ../error.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdn.ckeditor.com/4.7.3/standard/ckeditor.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../../components/Css/admin.css">
    <?php include "../../components/boot.php"; ?>

    <style>
        .userImage {
            width: 4rem;
            height: 4rem;
        }

        .hero {
            background: rgb(2, 0, 36);
            background: linear-gradient(24deg, rgba(2, 0, 36, 1) 0%, rgba(0, 212, 255, 1) 100%);
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg" style="background-color: #C1A3A3;">
        <div class="container-fluid">
            <a class="navbar-brand txtFont" style="font-size: 1.8rem;line-height:2;">Welcome <?= $rowUser['first_name']; ?></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page"></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"></a>
                    </li>
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
                        <img class="img-thumbnail userImage" src="../../pictures/<?= $rowUser['picture']; ?>">
                    </li>
                    <li class="nav-item">
                        <a class="nav-link rightLogin" href="../../logout.php?logout"><i class="bi bi-box-arrow-left"></i> Logout</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="mt-3 mb-3">
            <h1>Update request response</h1>
        </div>
        <div class="alert alert-<?php echo $class; ?>" role="alert">
            <p><?php echo ($message) ?? ''; ?></p>

            <a href='../dashboard.php'><button class="btn btn-warning" type='button'>Back</button></a>
        </div>

    </div>

</body>

</html>