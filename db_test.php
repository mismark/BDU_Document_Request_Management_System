<?php
// db_test.php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Database Connection Test</h1>";

// Check for Extensions
if (!extension_loaded('mysqli')) {
    echo "<p style='color:red'>❌ Error: PHP 'mysqli' extension is NOT enabled. Please enable it in your php.ini or XAMPP config.</p>";
    exit();
}

// Check if core/app.php exists
if (!file_exists(__DIR__ . '/core/app.php')) {
    echo "<p style='color:red'>❌ Error: core/app.php not found.</p>";
    exit();
}

// Attempt to load config (which loads app.php)
try {
    include 'config.php';
    echo "<p style='color:green'>✅ config.php and core/app.php loaded successfully.</p>";
} catch (Exception $e) {
    echo "<p style='color:red'>❌ Error loading config: " . $e->getMessage() . "</p>";
    exit();
}

// Test MySQLi connection
$test_conn = new mysqli(DB_HOST, DB_USER, DB_PASS);

if ($test_conn->connect_error) {
    echo "<p style='color:red'>❌ MySQL Connection Failed: " . $test_conn->connect_error . "</p>";
    echo "<p>Please ensure MySQL is running in XAMPP.</p>";
} else {
    echo "<p style='color:green'>✅ MySQL Server is running and accessible.</p>";
    
    // Check if database exists
    $db_check = $test_conn->select_db(DB_NAME);
    if (!$db_check) {
        echo "<p style='color:orange'>⚠️ Database '" . DB_NAME . "' NOT found.</p>";
        echo "<p>Please import <strong>database.sql</strong> into your phpMyAdmin or run the CREATE DATABASE command.</p>";
    } else {
        echo "<p style='color:green'>✅ Database '" . DB_NAME . "' exists.</p>";
        
        // Check for users table
        $table_check = $test_conn->query("SHOW TABLES LIKE 'users'");
        if ($table_check->num_rows == 0) {
            echo "<p style='color:orange'>⚠️ Tables NOT found in database.</p>";
            echo "<p>Please import <strong>database.sql</strong> to create the necessary tables.</p>";
        } else {
            echo "<p style='color:green'>✅ Tables found. System should be ready!</p>";
        }
    }
}

$test_conn->close();
?>
