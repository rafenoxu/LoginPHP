<?php
    
    if (isset($_POST['signup-submit'])) {
        require 'dbh.inc.php';

        $userName = $_POST['username'];
        $userPwd = $_POST['pwd'];

        if (empty($userName) || empty($userPwd)) {
            header("Location: ../signup.php?error=emptyfields&username=".$userName);
            exit();
        } else if (!filter_var($userName, FILTER_VALIDATE_EMAIL)) {
            header("Location: ../signup.php?error=invalidusername&username=".$userName);
            exit();
        } else {
            $sql = "SELECT email FROM users WHERE email=?";
            $statement = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($statement, $sql)) {
                header("Location: ../signup.php?error=sqlerror");
                exit();
            } else {
                mysqli_stmt_bind_param($statement, "s", $userName);
                mysqli_stmt_execute($statement);
                mysqli_stmt_store_result($statement);
                $resultCheck = mysqli_stmt_num_rows($statement);
                if ($resultCheck > 0) {
                    header("Location: ../signup.php?error=mailtaken&username=".$userName);
                    exit();
                } else {
                    $sql = "INSERT INTO users (email, pwd, logout) VALUES (?, ?, NOW())";
                    $statement = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($statement, $sql)) {
                        header("Location: ../signup.php?error=sqlerror");
                        exit();
                    } else {
                        $hashedPwd = password_hash($userPwd, PASSWORD_DEFAULT);
                        mysqli_stmt_bind_param($statement, "ss", $userName, $hashedPwd);
                        mysqli_stmt_execute($statement);
                        header("Location: ../login.php?signup=success");
                        exit();
                    }
                }
            }
        }

        mysqli_stmt_close($statement);
        mysqli_close($conn);
    } else {
        header("Location: ../signup.php");
        exit();
    }

?>