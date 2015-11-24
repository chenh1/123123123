<?php

session_start();

require("mysql_connect.php");

if($_POST[loadType] == "newOrder") {

    $query = "INSERT INTO `orders` (userid, username, city, address, store)
              VALUES ('$_POST[userid]', '$_POST[username]', '$_POST[city]', '$_POST[address]', '$_POST[store]')";

    $result = mysqli_query($conn, $query);

    $userOutput = mysqli_affected_rows($conn)." ordercreated";

} else if ($_POST[loadType] == "listOrders"){

    $query = "SELECT *
              FROM `orders`
              WHERE `city` = '$_POST[city]'";

    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $i = 0;
        while ($row = mysqli_fetch_assoc($result)) {
            $userOutput[$i] = $row;
            $i++;
        }
    } else {
        $userOutput['message'] = "Error: Could Not Load List";
    }

}

$userOutput = json_encode($userOutput);

print_r($userOutput);

?>