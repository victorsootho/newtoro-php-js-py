<?php
session_start();

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function requireLogin() {
    if (!isLoggedIn()) {
        // Redirect to the login page with an absolute path
        header('Location: /newtoro/login.php');
        exit;
    }
}

// You can add more session-related functions here
