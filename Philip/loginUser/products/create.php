<?php
session_start();
require_once '../components/db_connect.php';


if (isset($_SESSION['user']) != "") {
    header("Location: ../home.php");
    exit;
}

if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
    header("Location: ../index.php");
    exit;
}
$status_list = "";
$result = mysqli_fetch_assoc(mysqli_query($connect, "SHOW COLUMNS FROM hotel LIKE 'status'"));
#echo gettype($result["Type"]);
if ($result) $option_array = explode("','",preg_replace("/(enum|set)\('(.+?)'\)/","\\2", $result["Type"]));
if (isset($option_array)) foreach($option_array as $option) $status_list .= "<option value='$option'>".ucfirst($option)."</option>";
else $status_list = "<li>Status not available</li>";


?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php require_once '../components/boot.php'?>
        <title>PHP CRUD  |  Add Room</title>
        <style>
            fieldset {
                margin: auto;
                margin-top: 100px;
                width: 60% ;
            }       
        </style>
    </head>
    <body>
        <fieldset>
            <legend class='h2'>Add Room</legend>
            <form action="actions/a_create.php" method= "post" enctype="multipart/form-data">
                <table class='table'>
                    <tr>
                        <th>Room</th>
                        <td><input class="form-control" type="text" name="room" placeholder = "Room Name" /></td>
                    </tr>
                    <tr>
                        <th>Floor</th>
                        <td><input class="form-control" type="number" step="any" name="floor" placeholder = "Floor" /></td>
                    </tr>
                    <tr>
                        <th>Description</th>
                        <td><input class="form-control" type="text" name="description" placeholder = "Description" /></td>
                    </tr>                                        
                    <tr>
                        <th>Price</th>
                        <td><input class="form-control" type= "number" name="price" step="any" placeholder= "Price" /></td>
                    </tr>
                    <tr>
                        <th>Duration</th>
                        <td><input class="form-control" type= "number" name="duration" step="any" placeholder= "Duration in weeks" /></td>
                    </tr>                    
                    <tr>
                        <th>Picture</th>
                        <td><input class="form-control" type="file" name= "picture" /></td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            <select class="form-select" name="status" aria-label="Default select example">
                                <?php echo $status_list;?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><button class='btn btn-success' type="submit">Insert Room</button></td>
                        <td><a href="index.php"><button class='btn btn-warning' type="button">Home</button></a></td>
                    </tr>
                </table>
            </form>
        </fieldset>
    </body>
</html>