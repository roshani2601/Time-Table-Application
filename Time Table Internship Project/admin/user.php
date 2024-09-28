<?php
require ("../db_connect.php");
require("header.php");

if (isset($_POST['delete'])) {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $logged_in_user_id = $_SESSION['user_id'];

    $sql = "SELECT username FROM admin WHERE id = $id";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $imageFile = $row['username'] . ".jpg";

        $filePath = "upload/" . $imageFile;

        if (file_exists($filePath)) {
            if (unlink($filePath)) {
                $query = "DELETE FROM admin WHERE id = $id";
                if (mysqli_query($conn, $query)) {
                    if ($id == $logged_in_user_id) {
                        session_destroy();
                    }
                    header('Location: user.php');
                    exit();
                } else {
                    echo "Error deleting record: " . mysqli_error($conn);
                }
            } else {
                echo "Error deleting file: Unable to delete the image file.";
            }
        } else {
            echo "File does not exist: $filePath";
        }
    } else {
        echo "No record found with ID: $id";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User</title>
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <!-- custom css file link  -->
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        tbody tr td img {
            height: 7rem;
            width: 7rem;
            border-radius: 5%;
            object-fit: cover;
        }

        .table-row .btn {
            width: 68% !important;
        }

        .table-row {
            overflow-x: auto !important;
            justify-content: start !important;
        }
    </style>
</head>

<body>
    <!-- user start -->

    <section class="user">
        <h3 class="heading">Users</h3>
        <div class="show">
            <button class="btn"><a href="useradd.php"><i class="fa fa-plus"></i> New User</a></button>
        </div>

        <br>
        <div class="table-row">
            <table>
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Type</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $users = $conn->query("SELECT * FROM admin ORDER BY id ASC");
                    $i = 1;
                    while ($row = $users->fetch_assoc()):
                        ?>
                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td><?php echo $row['username']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo ucwords($row['type']); ?></td>
                            <td style="text-align: center;"><img src="upload/<?= $row['image']; ?>?v=<?php echo time(); ?>"></td>
                            <td>
                                <center>
                                    <div class="btn-group">
                                        <button type="button" class="btn">Action <i
                                                class="fa-solid fa-caret-down"></i></button>
                                        <div class="dropdown-menu">
                                            <a href="useredit.php?get_id=<?php echo $row['id']; ?>">Edit</a>
                                            <form action="" method="POST"
                                                onsubmit="return confirm('Are you sure to delete this user?');">
                                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                <input type="submit" name="delete" value="Delete" class="delete-button">
                                            </form>

                                        </div>
                                </center>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

    </section>

    <!-- user end -->


    <!-- custom js file link  -->
    <script src="../js/script.js"></script>

</body>

</html>