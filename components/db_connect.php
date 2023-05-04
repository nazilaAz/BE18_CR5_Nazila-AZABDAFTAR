<?php

$localhost = "173.212.235.205";
$username = "nazilacodefactor_adminuser";
$password = "Ham19219414@Adminuser";
$dbname = "nazilacodefactor_be18_cr5_animal_adoption_nazila-azabdaftar";
// $localhost = "127.0.0.1";
// $username = "root";
// $password = "";
// $dbname = "be18_cr5_animal_adoption_nazila-azabdaftar";

// create connection
$connect = new  mysqli($localhost, $username, $password, $dbname);

// check connection
if ($connect->connect_error) {
    die("Connection failed: " . $connect->connect_error);
// } else {
//     echo "Successfully Connected";
}