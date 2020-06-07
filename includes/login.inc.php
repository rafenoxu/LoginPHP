<?php

    if (isset($_POST['login-submit'])) {
        require 'dbh.inc.php';

        $userName = $_POST['username'];
        $userPwd = $_POST['pwd'];

        if (empty($userName) || empty($userPwd)) {
            header("Location: ../login.php?error=emptyfields&username=".$userName);
            exit();
        } else {
            $sql = "SELECT * FROM users WHERE email=?";
            $statement = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($statement, $sql)) {
                header("Location: ../login.php?error=sqlerror");
                exit();
            } else {
                mysqli_stmt_bind_param($statement, "s", $userName);
                mysqli_stmt_execute($statement);
                $result = mysqli_stmt_get_result($statement);
                if ($row = mysqli_fetch_assoc($result)) {
                    $pwdCheck = password_verify($userPwd, $row['pwd']);
                    if ($pwdCheck == false) {
                        header("Location: ../login.php?error=wrongpassword&username=".$userName);
                        exit();
                    } else {
                        $sql = "UPDATE users SET lastaccess=NOW() WHERE email=?";
                        $statement = mysqli_stmt_init($conn);
                        if (!mysqli_stmt_prepare($statement, $sql)) {
                            header("Location: ../index.php?error=sqlerror");
                            exit();
                        } else {
                            mysqli_stmt_bind_param($statement, "s", $userName);
                            mysqli_stmt_execute($statement);
                        }

                        session_start();
                        $_SESSION['userId'] = $row['id'];
                        $_SESSION['userMail'] = $row['email'];

                        header("Location: ../index.php?login=success");
                        exit();
                    }
                } else {
                    header("Location: ../login.php?error=nosuchuser&username=".$userName);
                    exit();
                }
            }
        }
    } else {
        header("Location: ../login.php");
        exit();
    }
?>