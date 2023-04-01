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
require_once "../components/db_connect.php";
require_once "../components/file_upload.php";

$res = mysqli_query($connect, "SELECT * FROM user WHERE id=" . $_SESSION['admin']);
$rowUser = mysqli_fetch_array($res, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdn.ckeditor.com/4.7.3/standard/ckeditor.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../components/Css/admin.css">
    <?php include "../components/boot.php"; ?>

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
                        <img class="img-thumbnail userImage" src="../pictures/<?= $rowUser['picture']; ?>">
                    </li>
                    <li class="nav-item">
                        <a class="nav-link rightLogin" href="../logout.php?logout"><i class="bi bi-box-arrow-left"></i> Logout</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <fieldset>
            <legend class='h2'>Create New</legend>

            <form action="actions/a_creatPet.php" method="post" enctype="multipart/form-data">
                <table class='table table-striped table-light'>
                    <tr>
                        <th>Name</th>
                        <td><input type="text" class="form-control form-control-lg" placeholder="Name" name="name"></td>
                    </tr>
                    <tr>
                        <th>Breed</th>
                        <td><input type="text" class="form-control form-control-lg" placeholder="Breed" name="breed"></td>
                    </tr>
                    <tr>
                        <th>Live</th>
                        <td><input type="text" class="form-control form-control-lg" placeholder="Where?" name="live"></td>
                    </tr>
                    <tr>
                        <th>Age</th>
                        <td><input type="number" class="form-control form-control-lg" placeholder="Age" name="age"></td>
                    </tr>
                    <tr>
                        <th>Description</th>
                        <td><textarea class="form-control" rows="3" placeholder="Description" name="description"></textarea></td>
                    </tr>

                    <tr>
                        <th>Size</th>
                        <td><select class="form-select form-control-lg" aria-label="Default select example" name="size">
                                <option selected>Size</option>
                                <option value="Small">Small</option>
                                <option value="Larg">Larg</option>
                            </select></td>
                    </tr>
                    <tr>
                        <th>Vaccinated?</th>
                        <td><select class="form-select form-control-lg" aria-label="Default select example" name="vaccinated">
                                <option selected>Vaccinated</option>
                                <option value="1">YES</option>
                                <option value="0">NO</option>
                            </select></td>
                    </tr>
                    <tr>
                        <th>Available?</th>
                        <td><select class="form-select form-control-lg" aria-label="Default select example" name="status">
                                <option selected>Status</option>
                                <option value="1">Available</option>
                                <option value="0">Adopted</option>
                            </select></td>
                    </tr>

                    <tr>
                        <th>Picture</th>
                        <td> <input class="form-control form-control-lg" type="file" placeholder="Image" name="picture"></td>
                    </tr>
                   <tr>
                        <td><button type="submit" class="btn btn-info" name="submit">Add</button></td>
                        <td></td>
                    </tr>
                </table>
            </form>

        </fieldset>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
</body>

</html>