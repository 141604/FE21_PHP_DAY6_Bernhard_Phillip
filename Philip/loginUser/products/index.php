<?php 
session_start();
require_once '../components/db_connect.php';


// if (isset($_SESSION['user']) != "") {
//     header("Location: ../home.php");
//     exit;
// }

if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
    header("Location: ../index.php");
    exit;
}

// automize generating of the table head
$thead = ""; // get the column names from the hotel room db-table
$sql = "SHOW COLUMNS FROM hotel";
$result = mysqli_query($connect ,$sql);
$num_tab_col = 0; // paying homage
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
   $thead .= "<th>".ucfirst(($row["Field"] == "id") ? "#" : $row["Field"])."</th>";
    $num_tab_col++;
}
$thead .= "<th>Action</th>";

$sql = "SELECT * FROM hotel";
$result = mysqli_query($connect ,$sql);
$tbody = ''; //this variable will hold the body for the table
$filesAllowed = ["png", "jpg", "jpeg", "webp"];

if(mysqli_num_rows($result)  > 0) {   
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
        $tbody .= "<tr>"; 
        foreach ($row as $key => $value) {
            $fileExtension = strtolower(pathinfo($value,PATHINFO_EXTENSION));
            if (in_array($fileExtension, $filesAllowed)) $tbody .= "<td><img class='img-thumbnail' src='pictures/" .$value."' /></td>";
            elseif ($key == "duration") $tbody .= "<td>" .$value." week(s)</td>";
            elseif ($key == "price") $tbody .= "<td>" .$value."&euro;</td>";
            elseif ($value == "booked") $tbody .= "<td colspan='2' class='text-muted'><em>not available</em></td>";
            else $tbody .= "<td>$value</td>";
        }

        // make sure only the admin can mod stuff and user can book
        if (isset($_SESSION['user'])) {
            
            if ($row["status"] == "available") {
                $tbody .= "
                <td>
                <a href='book.php?id=" .$row['id']."&user=".$_SESSION['user']."'><button class='btn btn-primary btn-sm' type='button'>Book</button></a>
                </td>";
            }

        } else {
            $tbody .= "
            <td>
                <a href='update.php?id=" .$row['id']."'><button class='btn btn-primary btn-sm' type='button'>Edit</button></a>
                <a href='delete.php?id=" .$row['id']."'><button class='btn btn-danger btn-sm' type='button'>Delete</button></a>
            </td>";
        }
       
        $tbody .= "</tr>"; 
    };
} else {
    $tbody =  "<tr><td colspan='".$num_tab_col."'><center>No Data Available </center></td></tr>";
}

mysqli_close($connect);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>PHP CRUD</title>
        <?php require_once '../components/boot.php'?>
        <style type="text/css">
            .manageProduct {           
                margin: auto;
            }
            .img-thumbnail {
                width: 70px !important;
                height: 70px !important;
            }
            td {          
                text-align: center;
                vertical-align: middle;
            }
            tr {
                text-align: center;
            }
        </style>
    </head>
    <body>
        <div class="manageProduct w-75 mt-3">    
            <div class='mb-3'>
                <a href= "create.php"><button class='btn btn-primary'type="button" >Add room</button></a>
            </div>
            <p class='h2'>Hotel Rooms</p>
            <table class='table table-striped'>
                <thead class='table-success'>
                    <tr>
                        <?= $thead; ?>
                    </tr>
                </thead>
                <tbody>
                    <?= $tbody; ?>
                </tbody>
            </table>
            <a href= "../home.php"><button class="btn btn-warning" type="button">Home</button></a>
        </div>
    </body>
</html>