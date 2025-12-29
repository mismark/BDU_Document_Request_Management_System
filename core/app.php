<?php
// core/app.php

// Database Config
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'bdu_drms');

// Base URL detection
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
$host = $_SERVER['HTTP_HOST'];
$script = $_SERVER['SCRIPT_NAME'];
$base = dirname($script);

// Normalize slashes for consistency
$base = str_replace('\\', '/', $base);

// Logic to remove specific subdirectories from the base path
$path_parts = explode('/', trim($base, '/'));
$last_part = end($path_parts);
$known_subdirs = ['graduate', 'admin', 'registrar'];

if (in_array($last_part, $known_subdirs)) {
    $base = dirname($base);
}

// Final cleanup
if ($base === '/' || $base === '\\' || $base === '.') $base = '';
define('BASE_URL', $protocol . "://" . $host . $base . "/");

// Connect to Database
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Global Session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Utilities
function sanitize($conn, $data) {
    return mysqli_real_escape_string($conn, trim($data));
}

function redirect($path) {
    header("Location: " . BASE_URL . $path);
    exit();
}

function check_auth($role = null) {
    if (!isset($_SESSION['user_id'])) {
        redirect('login.php');
    }
    if ($role && (!isset($_SESSION['role']) || $_SESSION['role'] !== $role)) {
        redirect('index.php');
    }
}

