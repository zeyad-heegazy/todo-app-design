<?php
$conn = mysqli_connect("localhost", "root", "", "todoapp");

session_start();

$title = "";
$id = 0;

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM tasks WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);

    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);
        $task = mysqli_fetch_assoc($result);

        $title = $task['title'];
    } else {
        $_SESSION['error'] = "Failed to fetch task details.";
        header("Location: ../index.php");
        exit;
    }
    mysqli_stmt_close($stmt);
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <title>Update Task</title>
</head>

<body>
    <div class="row">
        <div class="col-4 mx-auto mt-4">
            <h3 class="text-center mb-4 text-info">Update Task</h3>
            <form action="handelers/update-task.php?id=<?php echo $_GET['id']; ?>" method="POST"
                class="form border p-2 my-5">
                <?php if (isset($_SESSION["success"])): ?>
                    <div class="alert alert-success text-center">
                        <?php
                        echo $_SESSION["success"];
                        unset($_SESSION["success"]);
                        ?>
                    </div>
                <?php endif ?>

                <?php if (isset($_SESSION["error"])): ?>
                    <div class="alert alert-danger text-center">
                        <?php
                        echo $_SESSION["error"];
                        unset($_SESSION["error"]);
                        ?>
                    </div>
                <?php endif ?>

                <label for="title" class="font-weight-bold">Task Title</label>
                <input type="text" name="title" id="title" class="form-control my-3 border border-info"
                    placeholder="Update task title" value="<?php echo htmlspecialchars($title); ?>" required>

                <input type="submit" value="Edit" class="form-control btn btn-success my-3 " placeholder="edit todo">
            </form>
        </div>
    </div>
</body>

</html>