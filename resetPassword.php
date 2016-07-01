<?php
include "bootstrap.php";
$con = get_connection();

$username = $_POST["username"];
$oldPassword = $_POST["oldPassword"];
$newPassword = $_POST["newPassword"];
$newPassword = password_hash($newPassword,PASSWORD_DEFAULT);

$response = array();
$response['success'] = false;

$stmt =  $con->stmt_init();
if ($stmt->prepare("SELECT `password` FROM `users` WHERE `username`=?")) {
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($db_password);
    while ($stmt->fetch()) {
        if (password_verify($oldPassword,$db_password)) {
            if ($stmt->prepare("UPDATE `users` SET `password`=? WHERE `username`=?")) {
                $stmt->bind_param("ss", $newPassword, $username);
                if ($stmt->execute()) {
                    $response['success'] = true;
                }
            }
        }
    }
}
$con->close();
echo json_encode($response);
?>
