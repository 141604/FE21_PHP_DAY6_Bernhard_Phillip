<?php
session_start();
require_once 'components/db_connect.php';
// if session is not set this will redirect to login page
if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}
//if session user exist it shouldn't access dashboard.php
if (isset($_SESSION["user"])) {
    header("Location: home.php");
    exit;
}

$id = $_SESSION['adm'];
$status = 'adm';
#$sql = "SELECT * FROM user WHERE status != '$status'";
$sql = "SELECT user.id, user.picture, user.first_name, user.last_name, user.email, user.date_of_birth, hotel.room as 'room', hotel.id
FROM user 
JOIN booking ON booking.fk_user_id = user.id
JOIN hotel ON hotel.id = booking.fk_hotel_id
WHERE user.status != 'adm';";

$result = mysqli_query($connect, $sql);

//this variable will hold the body for the table
$tbody = ''; 
if ($result->num_rows > 0) {
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $tbody .= "<tr>
            <td><img class='img-thumbnail rounded-circle' src='pictures/" . $row['picture'] . "' alt=" . $row['first_name'] . "></td>
            <td>" . $row['first_name'] . " " . $row['last_name'] . "</td>
            <td>" . $row['date_of_birth'] . "</td>
            <td>" . $row['email'] . "</td>
            <td>" . $row['room'] . "</td>
            <td><a href='update.php?id=" . $row['id'] . "'><button class='btn btn-primary btn-sm' type='button'>Edit</button></a>
            <a href='delete.php?id=" . $row['id'] . "'><button class='btn btn-danger btn-sm' type='button'>Delete</button></a></td>
         </tr>";
    }
} else {
    $tbody = "<tr><td colspan='5'><center>No Data Available </center></td></tr>";
}

mysqli_close($connect);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adm-DashBoard</title>
    <?php require_once 'components/boot.php'?>
    <style type="text/css">        
        .img-thumbnail{
            width: 70px !important;
            height: 70px !important;
        }
        td
        {
            text-align: center;
            vertical-align: middle;
        }
        tr
        {
            text-align: center;
        }
        .userImage{
            width: 100px;
            height: auto;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-2">
        <img class="userImage" src="pictures/admavatar.png" alt="Adm avatar">
        <p class="">Administrator</p>
        <a href="logout.php?logout">Sign Out</a>
        <a href="products/index.php">Rooms</a>
        </div>
        <div class="col-8 mt-2">
        <p class='h2'>Users</p>
        <table class='table table-striped'>
            <thead class='table-success'>
                <tr>
                    <th>Picture</th>
                    <th>Name</th>
                    <th>Date of birth</th>
                    <th>Email</th>
                    <th>Booked</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?=$tbody?>
            </tbody>
        </table>
        </div>
    </div>
</div>
</body>
</html>