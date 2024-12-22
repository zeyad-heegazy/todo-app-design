<?php

$conn = mysqli_connect("localhost", "root", "", "todoapp");

session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["title"])) {
    $title = trim($_POST["title"]);

    if (strlen($title) < 3) {
        $_SESSION['error'] = "title of task must be greater than 3 chars ";
        exit();
    }

    if ($conn) {
        $sql = "INSERT INTO tasks (title) VALUES (?)";
        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $title);

            if (mysqli_stmt_execute($stmt)) {
                $_SESSION["success"] = "Task inserted successfully";
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

    header("Location: ../index.php");
    exit;
}
