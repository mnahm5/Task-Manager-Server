<?php

function get_connection() {
    return mysqli_connect("localhost","mnahm5x1_mnahm5","password","mnahm5x1_taskManager");
}

function is_logged_in() {
    return (isset($_SESSION['userId'])) ? true : false;
}

function date_converter($timestamp) {
    return date("g:iA - l jS F ",$timestamp);
}