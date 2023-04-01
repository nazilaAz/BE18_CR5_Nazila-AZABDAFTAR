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


if ($_GET['id']) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM animal WHERE id = {$id}";
    $result = mysqli_query($connect, $sql);
   
    
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $name = $row['name'];
        $breed = $row['breed'];
        $live = $row['live'];
        $description = $row['description'];
        $size = $row['size'];
        $age = $row['age'];
        $picture = $row['picture'];
        if ($row['status'] == 1) {

            $val = 1;
            $Ava = 'Available';
            $colorspan = 'green';
        } else {
            $val = '';
            $Ava = 'Adopted';
            $colorspan = 'red';
        }

        if ($row['vaccinated'] == 1) {

            $vacc = 1;
            $vaccinated = 'YES';
            $colorspan = 'green';
        } else {
            $vacc = '';
            $vaccinated = 'NO';
            $colorspan = 'red';
        }

    } else {
        header("location: error.php");
    }
    mysqli_close($connect);
} else {
    header("location: error.php");
}
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
                        <a class="nav-link rightLogin" href="logout.php?logout"><i class="bi bi-box-arrow-left"></i> Logout</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <fieldset>
            <legend class='h2'>Update request <img class='img-thumbnail rounded-circle userImage' src='../pictures/<?= $picture ?>'></legend>

            <form action="actions/a_updatePet.php" method="post" enctype="multipart/form-data">
                <table class='table table-striped table-light'>
                    <tr>
                        <th>Name</th>
                        <td><input class='form-control' type="text" name="name" placeholder="Name" value="<?= $name ?>" /></td>
                    </tr>
                    <tr>
                        <th>Breed</th>
                        <td><input class='form-control' type="text" name="breed" placeholder="Breed" value="<?= $breed ?>" /></td>
                    </tr>
                    <tr>
                        <th>Live</th>
                        <td><input class='form-control' type="text" name="live" placeholder="Live" value="<?= $live ?>" /></td>
                    </tr>
                    <tr>
                        <th>Age</th>
                        <td><input class='form-control' type="text" name="age" placeholder="Age" value="<?= $age ?>" /></td>
                    </tr>
                    <tr>
                        <th>Size</th>
                        <td><select class="form-select" aria-label="multiple select example" name="size">
                                <option selected value="<?= $size ?>"><?= $size ?></option>
                                <option value="small">Small</option>
                                <option value="larg">Larg</option>
                            </select></td>
                    </tr>
                    <tr>
                        <th>Description</th>
                        <td><textarea class="form-control" rows="3" name="description" placeholder="Description"><?= $description ?></textarea></td>
                    </tr>
                    <tr>
                        <th>Vaccinated? <span style='color:<?= $colorspan ?>'><?= $vaccinated ?></span></th>
                        <td><input type="checkbox" name="vaccinated" <?= ($vacc == 1) ? 'checked= checked' : ''; ?> /></td>
                    </tr>                   
                    <tr>
                        <th>Picture</th>
                        <td><input class='form-control' type="file" name="picture" value="<?= $picture ?>" /></td>
                    </tr>
                    <tr>
                        <th>Available? <span style='color:<?= $colorspan ?>'><?= $Ava ?></span></th>
                        <td><input type="checkbox" name="status" <?= ($val == 1) ? 'checked= checked' : ''; ?> /></td>
                    </tr>
                    <tr>
                        <input type="hidden" name="id" value="<?= $id ?>" />
                        <td><button class="btn btn-success" type="submit">Save Changes</button></td>
                        <td></td>
                    </tr>
                </table>
            </form>

        </fieldset>
    </body>
</html>