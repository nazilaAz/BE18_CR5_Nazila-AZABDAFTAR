<?php
session_start();

if (!isset($_SESSION["user"]) && !isset($_SESSION["admin"])) {
    header("Location: ../../index.php");
}
if (isset($_SESSION["user"])) {
    header("Location: ../../home.php");
}

require_once '../../components/db_connect.php';
require_once '../../components/file_upload.php';


if ($_POST) {
    $error = false;

    $name = cleanInput($_POST['name']);
    $breed = cleanInput($_POST['breed']);
    $live = cleanInput($_POST['live']);
    $description = cleanInput($_POST['description']);
    $age = cleanInput($_POST['age']);
    $size = cleanInput($_POST['size']);
    $vaccinated = cleanInput($_POST['vaccinated']);
    $status = cleanInput($_POST['status']);
    

    //create Animal to database
    $picture = file_upload($_FILES['picture'], "pet");

    if (!$error) {
        $strSql = "INSERT INTO `animal`(`name`, `picture`, `breed`, `live`, `description`, `size`, `age`, `vaccinated`, `status`) 
        VALUES ('$name','$picture->fileName','$breed','$live','$description','$size','$age','$vaccinated','$status')";
       

        $resultsql = mysqli_query($connect, $strSql);
        if ($resultsql) {
            $errType = 'success';
            $msg = 'Successfully Registered!';
            $uploadError = ($picture->error != 0) ? $picture->ErrorMessage : "";
        } else {
            $errType = 'danger';
            $msg = 'Somethig wrong!';
            $uploadError = ($picture->error != 0) ? $picture->ErrorMessage : "";
        }
        mysqli_close($connect);
    } else {
        header("location: ../error.php");
    }
}
