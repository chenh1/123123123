<?php

session_start();

require("mysql_connect.php");

if($_POST[loadType] == "register") {

    $_POST[password] = sha1($_POST[password]);

    $query = "INSERT INTO `users` (username, password, email, firstName, lastName, worker, city)
VALUES ('$_POST[username]', '$_POST[password]', '$_POST[email]', '$_POST[firstName]', '$_POST[lastName]', '$_POST[worker]', '$_POST[city]')";

    $result = mysqli_query($conn, $query);

    $query = "SELECT * FROM `users` WHERE `email` = '$_POST[email]'";

    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $userOutput['userId'] = $row['id'];
            $userOutput['username'] = $row['username'];
            $userOutput['email'] = $row['email'];
            $userOutput['firstName'] = $row['firstName'];
            $userOutput['lastName'] = $row['lastName'];
            $userOutput['worker'] = $row['worker'];
            $userOutput['city'] = $row['city'];

        }
    } else {
        $userOutput['error'] = 'Could Not Register';
        session_destroy();
    }
} else if($_POST[loadType] == "login") {

    $_POST[password] = sha1($_POST['password']);
    $query = "SELECT `id`, `username`, `email`, `firstName`, `lastName`, `worker`
              FROM `users`
              WHERE `password` = '$_POST[password]' AND `username` = '$_POST[username]'";

    $result = mysqli_query($conn, $query);

    $userOutput['success'] = false;

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $userOutput = $row;
            $userOutput['success'] = true;
            $_SESSION[id] = $row[id];
            $_SESSION[worker] = $row[worker];
        }
    } else {
        $userOutput['message'] = "Error: Invalid Username/Password";
    }
} else if($_POST[loadType] == "loginCheck"){

    if(isset($_SESSION[id])){
        $query = "SELECT `id`, `username`, `email`, `firstName`, `lastName`, `worker`, `city`
              FROM `users`
              WHERE `id` = '$_SESSION[id]'";

        $result = mysqli_query($conn, $query);

        $userOutput['success'] = false;

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $userOutput = $row;
                $userOutput['success'] = true;
                $_SESSION[id] = $row[id];
                $_SESSION[worker] = $row[worker];
            }
        } else {
            $userOutput['message'] = "Error: Invalid Username/Password";
        }
    }

} else if($_POST[loadType] == "logout"){
    session_destroy();
}

$output = json_encode($userOutput);

print($output);