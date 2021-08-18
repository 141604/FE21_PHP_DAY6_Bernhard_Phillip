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
$sql = "SELECT id, `picture` AS 'Picture', CONCAT(`first_name`, ' ', `last_name`) AS 'Name', `date_of_birth` AS 'Date of Birth', `email` AS 'E-Mail' FROM user WHERE status != '$status';";
$result = mysqli_query($connect, $sql);

$filesAllowed = ["png", "jpg", "jpeg", "webp"];
$tbody = ''; // this variable will hold the body for the table
$thead = "<tr>";
$first = TRUE;
$i = 0;
$n = $result->num_rows;
if ($n > 0) {
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $tbody .= "<tr>";
        foreach ($row as $key => $value) {
            $fileExtension = strtolower(pathinfo($value,PATHINFO_EXTENSION));
            if (in_array($fileExtension, $filesAllowed)) $tbody .= "<td><img class='img-thumbnail rounded-circle' src='pictures/" . $value . "' alt=" . $row['Name'] . "></td>";
            else $tbody .= "<td>$value</td>";
            // create table header if we go through the first iteration
            if ($first) {
                $thead .= "<th>$key</th>";
                $i++;
            }
        }

        $book_string = "<td>";
        $qry = "SELECT hotel.room as 'room', booking.date as 'booking_date', user.id FROM user JOIN booking ON booking.fk_user_id = user.id JOIN hotel ON hotel.id = booking.fk_hotel_id WHERE user.status != 'adm' AND user.id = $row[id];";
        $res = mysqli_query($connect, $qry);

        if (mysqli_num_rows($res) > 0) {
            while ($row2 = mysqli_fetch_array($res)) $book_string .= $row2["room"]."<br />";
            # $book_string = rtrim($book_string);
        } else $book_string .= "-";

        $book_string .= "</td>";

        $tbody .= $book_string;

        $tbody .= "<td><a href='update.php?id=" . $row['id'] . "'><button class='btn btn-primary btn-sm' type='button'>Edit</button></a>
        <a href='delete.php?id=" . $row['id'] . "'><button class='btn btn-danger btn-sm' type='button'>Delete</button></a></td>
        </tr>";
        
        $first = FALSE;
    }
    $thead .= "<th>Booked</th><th>Action</th></tr>";

} else {
    $tbody = "<tr><td colspan='{$i}'><center>No Data Available </center></td></tr>";
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
                <?= $thead ?>
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