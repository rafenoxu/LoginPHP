<?php
    session_start();

    require 'dbh.inc.php';
    $mail = $_SESSION['userMail'];
    $sql = "UPDATE users SET logout=NOW() WHERE email=?";
    $statement = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($statement, $sql)) {
        header("Location: ../index.php?error=sqlerror");
        exit();
    } else {
        mysqli_stmt_bind_param($statement, "s", $mail);
        mysqli_stmt_execute($statement);
    }

    session_unset();
    session_destroy();

    header("Location: ../index.php");
?>