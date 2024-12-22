<?php

$conn = mysqli_connect("localhost", "root", "", "todoapp");

session_start();

if (isset($_GET["id"])) {

    $id = $_GET["id"];

    $sql = "SELECT * FROM tasks WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_row($result);
    if (!$row) {
        $_SESSION["error"] = "Task not exists";
        header("Location: ../index.php");
        exit();
    } else {
        if ($conn) {
            $sql = "DELETE FROM tasks WHERE id = ?";
            $stmt = mysqli_prepare($conn, $sql);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "i", $id);

                if (mysqli_stmt_execute($stmt)) {
                    $_SESSION["success"] = "Task Deleted successfully";
                } else {
                    $_SESSION["error"] = "Failed to insert data";
                }

                mysqli_stmt_close($stmt);
            } else {
                $_SESSION["error"] = "Failed to prepare the statement";
            }

            mysqli_close($conn);
        } else {
            $_SESSION["error"] = "Database connection error";
        }
    }

    header("Location: ../index.php");
    exit;
}

