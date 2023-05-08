<?php
session_start();
if (isset($_SESSION['user']) != "") {
    header("Location: home.php");
    exit;
}
if (isset($_SESSION['admin']) != "") {
    header("Location: adminPanel/dashboard.php"); // redirects to dashboard.php
}

require_once "components/db_connect.php";
require_once "components/file_upload.php";



function cleanInput($param)
{
    $clean = trim($param); //take spaces out!
    $clean = strip_tags($clean); //take tags out!
    $clean = htmlspecialchars($clean);

    return $clean;
}
$fnameError = $lnameError = $dataError = $emailError = $passError = $emailloginError = $passLoginError = '';
$first_name = $last_name = $phone_number = $email = $address = $username = $pwd = '';
$display = 'none';
$logindislay = 'none';

if (isset($_POST['register'])) {
    $error = false;


    $first_name = cleanInput($_POST['firstname']);
    $last_name = cleanInput($_POST['lastname']);
    $phone_number = cleanInput($_POST['phone_number']);
    $email = cleanInput($_POST['email']);
    $password = cleanInput($_POST['password']);
    $address = cleanInput($_POST['address']);

    //Firstname validation
    if (empty($first_name)) {
        $error = true;
        $display = 'block';
        $fnameError = "Please Enter your Firstname.";
    } elseif (strlen($first_name < 2)) {
        $error = true;
        $display = 'block';
        $fnameError = "Firstname must have at least 2 char.";
    } elseif (!preg_match("/^[a-zA-Z]+$/", $first_name)) {
        $error = true;
        $display = 'block';
        $fnameError = "Firstname must contain only letters.";
    }
    //Lastname Validation
    if (empty($last_name)) {
        $error = true;
        $display = 'block';
        $lnameError = "Please Enter your Lastname.";
    } elseif (strlen($last_name < 2)) {
        $error = true;
        $display = 'block';
        $lnameError = "Lastname must have at least 2 char.";
    } elseif (!preg_match("/^[a-zA-Z]+$/", $last_name)) {
        $error = true;
        $display = 'block';
        $lnameError = "Lastname must contain only letters.";
    }
    //Email Validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = true;
        $display = 'block';
        $emailError = "Please Enter Valid Email Address!";
    } else {
        $sqlStr = "SELECT * FROM user WHERE email='$email'";
        $res = mysqli_query($connect, $sqlStr);
        // var_dump($res);
        // die();
        if (mysqli_num_rows($res) != 0) {
            $error = true;
            $display = 'block';
            $emailError = "This Email already exist!";
        }
    }
    //Phone-Number
    if (empty($phone_number)) {
        $error = true;
        $display = 'block';
        $dataError = "Please enter your Phone.";
    }
    //Password Validation
    if (empty($password)) {
        $error = true;
        $display = 'block';
        $passError = "Please enter password.";
    } elseif (strlen($password) < 6) {
        $error = true;
        $display = 'block';
        $passError = "Password must have to at least 6 charachters.";
    }
    $password = hash("sha256", $password);

    //create user to database
    $picture = file_upload($_FILES['picture'], "user");
    if (!$error) {
        $strSql = "INSERT INTO `user`(`first_name`, `last_name`, `email`, `password`, `phone_number`, `address`, `picture`) 
        VALUES ('$first_name','$last_name','$email','$password','$phone_number','$address','$picture->fileName')";
       
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
    }
}elseif (isset($_POST['login'])) {
 
    $display = 'none';
    $logindislay = 'none';
    $loginError = false;
    $username = cleanInput($_POST['username']);
    $pwd = cleanInput($_POST['pwd']);

    //Email Validation
    if (!filter_var($username, FILTER_VALIDATE_EMAIL)) {
        $loginError = true;
        $logindislay = 'block';
        $emailloginError = "Please Enter Valid Email Address!";
    } else {
        $sqlStr = "SELECT email FROM user WHERE email='$email'";
        $res = mysqli_query($connect, $sqlStr);

        if (mysqli_num_rows($res) != 0) {
            $loginError = true;
            $logindislay = 'block';
            $emailloginError = "This Email already exist!";
        }
    }
    //Password Validation
    if (empty($pwd)) {
        $loginError = true;
        $logindislay = 'block';
        $passLoginError = "Please enter password.";
    } elseif (strlen($pwd) < 6) {
        $loginError = true;
        $logindislay = 'block';
        $passLoginError = "Password must have to at least 6 charachters.";
    }
    if (!$loginError) {
        $pwd = hash("sha256", $pwd);
        $strSqlLogin = "SELECT * FROM user WHERE email='$username' AND password='$pwd'";
        $resultLogin = mysqli_query($connect, $strSqlLogin);
        $count = mysqli_num_rows($resultLogin);
        $rowLogin = mysqli_fetch_assoc($resultLogin);

        //define $_SESSION Variable
        if ($count == 1) {
            if ($rowLogin['status'] == 'admin') {
                $_SESSION['admin'] = $rowLogin['id'];
                header("Location:adminPanel/dashboard.php");
            } else {
                $_SESSION['user'] = $rowLogin['id'];
                header("Location:home.php");
            }
        }
    }
}elseif(isset($_POST['signin'])) {
        $display='none';
        $logindislay = 'none';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <title>LOGIN</title>

    <?php include "components/boot.php"; ?>
    <link rel="stylesheet" href="components/css/login.css">
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
                    <!-- <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="home.php">Home</a>
                    </li> -->
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="read.php">Our meals</a>
                    </li> -->
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <?php
        if (isset($msg)) {
        ?>
            <div class="alert alert-<?= $errType ?>" role="alert">
                <?= $msg ?>
                <?= $uploadError ?>
            </div>
        <?php
        }
        ?>
        <div class="welcome">
            <div class="pinkbox">
                <div class="signup nodisplay">
                    <h1>sign up</h1>
                    <form autocomplete="off" action="<?= htmlspecialchars($_SERVER['SCRIPT_NAME']) ?>" method="POST" enctype="multipart/form-data">
                        <input type="text" placeholder="Firstname" name="firstname" value="<?= $first_name ?>">
                        <input type="text" placeholder="Lastname" name="lastname" value="<?= $last_name ?>">
                        <input type="text" placeholder="Phone"  name="phone_number">
                        <input type="text" placeholder="Address"  name="address">
                        <input type="email" placeholder="email" name="email" value="<?= $email ?>">
                        <input type="password" placeholder="password" name="password">
                        <textarea rows="2" name="description" placeholder="Your Message"></textarea> 
                        <input type="file" name="picture">
                        <button type="submit" class="button submit" name="register">create account </button>
                    </form>

                </div>
                <div class="signin">
                    <h1>sign in</h1>
                    <p class="fs-6 text-light">azabdaftar@outlook.com <br> OR<br>test@test.com</p>
                    <p class="fs-6 text-light">123123</p>
                    <form class="more-padding" autocomplete="off" action="<?= htmlspecialchars($_SERVER['SCRIPT_NAME']) ?>" method="POST">
                        <input type="email" placeholder="Username" name="username">
                        <span class="text-danger danger" style="display: <?= $logindislay ?>;"><?= $emailloginError ?></span>
                        <input type="password" placeholder="password" name="pwd">
                        <span class="text-danger danger" style="display: <?= $logindislay ?>;"><?= $passLoginError ?></span>
                        <button type="submit" class="button submit"  name="login">login</button>
                    </form>
                </div>
            </div>
            <div class="leftbox">
                <h2 class="title"><span>Adop</span>a<br>PET</h2>
                <img class="flower smaller rounded-circle" src="https://cdn.pixabay.com/photo/2016/03/28/12/35/cat-1285634__340.png" alt="" border="0">
                <p class="account">have an account?</p>
                <form method="post">
                    <button type="submit" class="button" id="signin" name="signin">login</button>
                </form>
                
            </div>

            <div class="rightbox">
                <h2 class="title"><span>Adop</span>a<br>PET</h2>
                <img class="flower rounded-circle" src="https://cdn.pixabay.com/photo/2018/10/01/09/21/pets-3715733__340.jpg" />
                <p class="account">don't have an account?</p>
                <button type="submit" class="button" id="signup" name="signup">sign up</button>

            </div>


            <div class="rightbox error">

                <div class="text-danger danger" style="display: <?= $display ?>;"><?= $fnameError ?></div>
                <div class="text-danger danger" style="display: <?= $display ?>;"><?= $lnameError ?></div>
                <div class="text-danger danger" style="display: <?= $display ?>;"><?= $dataError ?></div>
                <div class="text-danger danger" style="display: <?= $display ?>;"><?= $emailError ?></div>
                <div class="text-danger danger" style="display: <?= $display ?>;"><?= $passError ?></div>

            </div>


        </div>
    </div>

    </div>

    <script>
        $('#signup').click(function() {
            $('.pinkbox').css('transform', 'translateX(80%)');
            $('.signin').addClass('nodisplay');
            $('.signup').removeClass('nodisplay');
        });

        $('#signin').click(function() {
            $('.pinkbox').css('transform', 'translateX(0%)');
            $('.signup').addClass('nodisplay');
            $('.signin').removeClass('nodisplay');

        });
    </script>
    <?php include_once "components/bootjs.php"; ?>
</body>

</html>