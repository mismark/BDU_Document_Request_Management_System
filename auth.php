<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];

    // LOGIN LOGIC
    if ($action == 'login') {
        $email = sanitize($conn, $_POST['email']);
        $password = $_POST['password'];

        $sql = "SELECT id, full_name, password, role FROM users WHERE email = '$email'";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            // Verify password
            if (password_verify($password, $row['password'])) {
                // Set session
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['full_name'] = $row['full_name'];
                $_SESSION['role'] = $row['role'];

                // Redirect based on role
                if ($row['role'] == 'admin') {
                    header("Location: admin/dashboard.php");
                } elseif ($row['role'] == 'registrar') {
                    header("Location: registrar/dashboard.php");
                } else {
                    header("Location: graduate/dashboard.php");
                }
                exit();
            } else {
                header("Location: login.php?error=Incorrect password");
                exit();
            }
        } else {
            header("Location: login.php?error=User not found");
            exit();
        }
    }

    // REGISTER LOGIC
    elseif ($action == 'register') {
        $full_name = sanitize($conn, $_POST['full_name']);
        $email = sanitize($conn, $_POST['email']);
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        if ($password !== $confirm_password) {
            header("Location: register.php?error=Passwords do not match");
            exit();
        }

        // Check if email exists
        $check = $conn->query("SELECT id FROM users WHERE email = '$email'");
        if ($check->num_rows > 0) {
            header("Location: register.php?error=Email already registered");
            exit();
        }

        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert User (Default role: graduate)
        $sql = "INSERT INTO users (full_name, email, password, role) VALUES ('$full_name', '$email', '$hashed_password', 'graduate')";
        
        if ($conn->query($sql) === TRUE) {
            header("Location: login.php?success=Account created successfully. Please login.");
        } else {
            header("Location: register.php?error=Error creating account: " . $conn->error);
        }
    }

    // PASSWORD RESET LOGIC (Simulated)
    elseif ($action == 'reset_request') {
        $email = sanitize($conn, $_POST['email']);
        
        // Check if email exists to avoid leaking info (or just pretend success)
        $check = $conn->query("SELECT id FROM users WHERE email = '$email'");
        
        // In a real app, we would generate a token and email it.
        // For this demo, we just simulate success.
        
        header("Location: login.php?success=If an account exists for $email, a password reset link has been sent.");
        exit();
    }
}
?>
