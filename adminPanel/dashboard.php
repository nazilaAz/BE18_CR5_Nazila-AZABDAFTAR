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


$sql = "SELECT * FROM user";
$result = mysqli_query($connect, $sql);
$rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

$countUser = mysqli_num_rows($result);

$tbody = '';
if (mysqli_num_rows($result) > 0) {
    foreach ($rows as $row) {
        $tbody .= "
    <tr> 
         <td>{$row['id']}</td>
         <td><img class='img-thumbnail userImage' src='../pictures/{$row['picture']}'></td>
        <td>{$row['first_name']}</td>
        <td>{$row['last_name']}</td>
        <td>{$row['email']}</td>
        <td>{$row['phone_number']}</td>
        <td>{$row['address']}</td>
        <td>{$row['status']}</td>
    </tr>";
    }
} else {
    $tbody =  "<tr><td colspan='5'><center>No Data Available </center></td></tr>";
}

//************************************************************** */
$sqlAnimal = "SELECT * FROM animal";
$resultAnimal = mysqli_query($connect, $sqlAnimal);
$rowsAnimal = mysqli_fetch_all($resultAnimal, MYSQLI_ASSOC);

$countAnimals = mysqli_num_rows($resultAnimal);

$tbodyAnimal = '';
if (mysqli_num_rows($resultAnimal) > 0) {
    foreach ($rowsAnimal as $rowAnimal) {
        if($rowAnimal['vaccinated']==1){
            $rowAnimal['vaccinated']='YES';
        }else{
            $rowAnimal['vaccinated']='NO';
        }
        if($rowAnimal['status']==1){
            $rowAnimal['status']='Available';
        }else{
            $rowAnimal['status']='Adopted';
        }


        $tbodyAnimal .= "
    <tr> 
         <td>{$rowAnimal['id']}</td>
         <td><img class='img-thumbnail userImage' src='../pictures/{$rowAnimal['picture']}'></td>
        <td>{$rowAnimal['name']}</td>
        <td>{$rowAnimal['breed']}</td>
        <td>{$rowAnimal['live']}</td>
        <td>{$rowAnimal['description']}</td>
        <td>{$rowAnimal['size']}</td>
        <td>{$rowAnimal['age']}</td>
        <td>{$rowAnimal['vaccinated']}</td>
        <td>{$rowAnimal['status']}</td>
         
         <td><a href='updatePet.php?id={$rowAnimal['id']}' role='button' class='btn btn-warning'>Update</a></td>
         <td><a href='deletePet.php?id={$rowAnimal['id']}' role='button' class='btn btn-danger'>Delete</a></td>
    </tr>";
    }
} else {
    $tbodyAnimal =  "<tr><td colspan='5'><center>No Data Available </center></td></tr>";
}
mysqli_close($connect);
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
    <link rel="stylesheet" href="../components/Css/admin.css">
    <?php include "../components/boot.php"; ?>

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
                        <img class="img-thumbnail userImage" src="../pictures/<?= $rowUser['picture']; ?>">
                    </li>
                    <li class="nav-item">
                        <a class="nav-link rightLogin" href="../logout.php?logout"><i class="bi bi-box-arrow-left"></i> Logout</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>
    <!--header-->
    <div class="page-header">
        <div class="container">
            <div class="row">
                <div class="col-md-10 ">
                    <h2 class="text-center lh-lg"><i class="bi bi-gear-fill"></i> Dashboard</h2>
                </div>
            </div>
        </div>
    </div>

    <!--main section-->
    <section id="main">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="list-group animated zoomIn">
                        <a class="list-group-item active  main-color-bg">
                            <span class="glyphicon glyphicon-cog"></span> Dashboard
                        </a>
                        <a href="pages.html" class="list-group-item"><span class="badge"><?= $countUser; ?></span><i class="bi bi-people-fill"></i> Users</a>
                    </div>

                </div>
                <div class="col-md-9">
                    <div class="panel panel-default">
                        <div class="panel-heading main-color-bg">
                            <h3 class="panel-title">Users Overview</h3>
                        </div>
                        <div class="panel-body">
                            <div class="col-md-3">
                                <div class="well dash-box">
                                    <h2><i class="bi bi-people-fill"></i> <?= $countUser; ?></h2>
                                    <h4>Users</h4>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <table class="table table-striped text-center">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Picture</th>
                                <th scope="col">Firstname</th>
                                <th scope="col">Lastname</th>
                                <th scope="col">Email</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Address</th>
                                <th scope="col">Status</th>

                                <!-- <th scope="col">Update</th>
                                <th scope="col">Delete</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <?= $tbody; ?>
                        </tbody>
                    </table>
                </div>
            </div>
    </section>
    <section id="main">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="list-group animated zoomIn">
                        <a class="list-group-item active  main-color-bg">
                            <span class="glyphicon glyphicon-cog"></span> Dashboard
                        </a>
                        <!-- <a href="pages.html" class="list-group-item"><span class="badge"><?= $countUser; ?></span><i class="bi bi-people-fill"></i> Users</a> -->
                        <a href="posts.html" class="list-group-item"><span class="badge"><?=$countAnimals?></span><i class="fa-sharp fa-solid fa-dog"></i> Pets</a>
                    </div>

                </div>
                <div class="col-md-9">
                    <div class="panel panel-default">
                        <div class="panel-heading main-color-bg">
                            <h3 class="panel-title">Pets Overview</h3>
                            <a href='createPet.php' role='button' class='btn btn-warning'>Add new</a>
                        </div>
                        <div class="panel-body">
                            <div class="col-md-3">
                                <div class="well">
                                    <h2><i class="fa-sharp fa-solid fa-dog"></i> <?=$countAnimals?></h2>
                                    <h4>Pets</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="table table-striped text-center">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Picture</th>
                                <th scope="col">name</th>
                                <th scope="col">breed</th>
                                <th scope="col">live</th>
                                <th scope="col">description</th>
                                <th scope="col">size</th>
                                <th scope="col">age</th>
                                <th scope="col">vaccinated</th>
                                <th scope="col">status</th>

                                <th scope="col">Update</th>
                                <th scope="col">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?= $tbodyAnimal; ?>
                        </tbody>
                    </table>
                </div>
            </div>
    </section>

    <!-- footer -->

    <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-auto border-top">
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


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script>
        CKEDITOR.replace('editor1');
        $(document).ready(function() {
            $(document).on('mousemove', function(e) {
                $("#cords").html("Cords: Y: " + e.clientY);
            })
        });
    </script>

    <?php include_once "../components/bootjs.php"; ?>
</body>

</html>