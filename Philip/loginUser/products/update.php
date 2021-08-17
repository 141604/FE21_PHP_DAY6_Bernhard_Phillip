<?php
session_start();

if (isset($_SESSION['user']) != "") {
    header("Location: ../home.php");
    exit;
}

if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
    header("Location: ../index.php");
    exit;
}

require_once '../components/db_connect.php';


if ($_GET['id']) {
    $id = $_GET['id'];
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

        $status_list = "";
        $result = mysqli_fetch_assoc(mysqli_query($connect, "SHOW COLUMNS FROM hotel LIKE 'status'"));
        #echo gettype($result["Type"]);
        if ($result) $option_array = explode("','",preg_replace("/(enum|set)\('(.+?)'\)/","\\2", $result["Type"]));
        if (isset($option_array)) {
            foreach($option_array as $option) {
                if ($option == $status) $status_list .= "<option selected value='{$status}'>".ucfirst($status)."</option>";
                else $status_list .= "<option value='$option'>".ucfirst($option)."</option>";
            }
        } else $status_list = "<li>Status not available</li>";


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
            <legend class='h2'>Update request <img class='img-thumbnail rounded-circle' src='pictures/<?php echo $picture ?>' alt="<?php echo $room ?>"></legend>
            <form action="actions/a_update.php"  method="post" enctype="multipart/form-data">
                <table class="table">
                    <tr>
                        <th>Room</th>
                        <td><input class="form-control" type="text"  name="room" placeholder ="Room Name" value="<?php echo $room ?>"  /></td>
                    </tr>
                    <tr>
                        <th>Floor</th>
                        <td><input class="form-control" type="number"  step="any" name="floor" placeholder ="Floor" value="<?php echo $floor ?>"  /></td>
                    </tr>
                    <tr>
                        <th>Description</th>
                        <td><input class="form-control" type="text"  name="description" placeholder ="Description" value="<?php echo $description ?>"  /></td>
                    </tr>                                        
                    <tr>
                        <th>Price</th>
                        <td><input class="form-control" type= "number" name="price" step="any"  placeholder="Price" value ="<?php echo $price ?>" /></td>
                    </tr>
                    <tr>
                        <th>Duration</th>
                        <td><input class="form-control" type= "number" name="duration" step="any"  placeholder="Duration" value ="<?php echo $duration ?>" /></td>
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
                        <input type= "hidden" name= "id" value= "<?php echo $data['id'] ?>" />
                        <input type= "hidden" name= "picture" value= "<?php echo $data['picture'] ?>" />
                        <td><button class="btn btn-success" type= "submit">Save Changes</button></td>
                        <td><a href= "index.php"><button class="btn btn-warning" type="button">Back</button></a></td>
                    </tr>
                </table>
            </form>
        </fieldset>
    </body>
</html>