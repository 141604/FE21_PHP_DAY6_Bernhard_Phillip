<?php
session_start();

// if (isset($_SESSION['user']) != "") {
//     header("Location: ../home.php");
//     exit;
// }

if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
    header("Location: ../index.php");
    exit;
}

require_once '../components/db_connect.php';

$book_date = "";
$dateError = "";
$error = false;
if (isset($_POST['btn-book'])) {
    echo $book_date = CleanInput($_POST['book_date']);

    if (empty($book_date) || $book_date == "0000-00-00") {
        $error = true;
        $dateError = "Please enter a valid date.";
    }
}
if ($_GET) {
    $id = $_GET["id"];
    $user = $_GET["user"];
    
    $sql = "SELECT * FROM hotel WHERE id = {$id}";
    $result = mysqli_query($connect, $sql);
    if (mysqli_num_rows($result) == 1) {
        $data = mysqli_fetch_assoc($result);
        $room = $data['room'];
        $floor = $data["floor"];
        $description = $data["description"];
        $status = $data["status"];
        $price = $data['price'];
        $duration = $data["duration"];
        $picture = $data['picture'];
        $result = mysqli_fetch_assoc(mysqli_query($connect, "SHOW COLUMNS FROM hotel LIKE 'status'"));


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
        <title>Edit Room</title>
        <?php require_once '../components/boot.php'?>
        <style type= "text/css">
            fieldset {
                margin: auto;
                margin-top: 100px;
                width: 60% ;
            }  
            .img-thumbnail{
                width: 70px !important;
                height: 70px !important;
            }     
        </style>
    </head>
    <body>
        <fieldset>
            <legend class='h2'>Book request <img class='img-thumbnail rounded-circle' src='pictures/<?php echo $picture ?>' alt="<?php echo $room ?>"></legend>
            <form action="actions/a_book.php"  method="post" enctype="multipart/form-data">
                <table class="table d-flex">
                    <tr>
                        <th>Room</th>
                        <td><?php echo $room ?></td>
                    </tr>
                    <tr>
                        <th>Floor</th>
                        <td><?php echo $floor ?></td>
                    </tr>
                    <tr>
                        <th>Description</th>
                        <td><?php echo $description ?></td>
                    </tr>                                        
                    <tr>
                        <th>Price</th>
                        <td><?php echo $price ?></td>
                    </tr>
                    <tr>
                        <th>Duration</th>
                        <td><?php echo $duration ?></td>
                    </tr>                    
                    <tr>
                        <th>Status</th>
                        <td>
                            <?php echo $status;?>
                        </td>
                    </tr>
                    <tr>
                        <th>Date</th>
                        <td>
                            <input class='form-control' type="date"  name="book_date" value ="<?php echo $book_date ?>"/>
                            <span class="text-danger"> <?php echo $dateError; ?> </span>
                        </td>
                    </tr>                    
                    <tr>
                        <input type= "hidden" name= "id" value= "<?php echo $data['id'] ?>" />
                        <input type= "hidden" name= "user" value= "<?php echo $user ?>" />
                        <td><button class="btn btn-success" type= "submit" name="btn-book">Book room</button></td>
                        <td><a href= "index.php"><button class="btn btn-warning" type="button">Back</button></a></td>
                    </tr>
                </table>
            </form>
        </fieldset>
    </body>
</html>