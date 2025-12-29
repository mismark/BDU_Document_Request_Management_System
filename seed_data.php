<?php
require_once 'config.php';

echo "Seeding database with sample data...\n";

// 1. Create Sample Graduate User
$email = 'graduate_test@bdu.edu.et';
$check = $conn->query("SELECT id FROM users WHERE email = '$email'");

if ($check->num_rows == 0) {
    $password = password_hash('password123', PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (full_name, email, password, role) VALUES (?, ?, ?, 'graduate')");
    $name = "Test Graduate";
    $stmt->bind_param("sss", $name, $email, $password);
    if ($stmt->execute()) {
        $user_id = $stmt->insert_id;
        echo "[SUCCESS] Created User: $email (ID: $user_id)\n";
    } else {
        die("[ERROR] Failed to create user: " . $stmt->error);
    }
} else {
    $user_id = $check->fetch_assoc()['id'];
    echo "[INFO] User $email already exists (ID: $user_id)\n";
}

// 2. Create Sample Request
// Check if this user already has requests
$check_req = $conn->query("SELECT id FROM requests WHERE user_id = $user_id LIMIT 1");
if ($check_req->num_rows == 0) {
    $stmt = $conn->prepare("INSERT INTO requests (user_id, document_type, purpose, delivery_method, status) VALUES (?, 'transcript', 'Job Application at Bank of Abyssinia', 'digital', 'approved')");
    $stmt->bind_param("i", $user_id);
    if ($stmt->execute()) {
        $request_id = $stmt->insert_id;
        echo "[SUCCESS] Created Request (ID: $request_id)\n";
    } else {
        die("[ERROR] Failed to create request: " . $stmt->error);
    }
} else {
    $request_id = $check_req->fetch_assoc()['id'];
    echo "[INFO] Request already exists for user (ID: $request_id)\n";
}

// 3. Create Sample Document
$check_doc = $conn->query("SELECT id FROM documents WHERE request_id = $request_id");
if ($check_doc->num_rows == 0) {
    $verification_id = 'BDU-' . strtoupper(substr(md5(time()), 0, 8));
    $stmt = $conn->prepare("INSERT INTO documents (request_id, user_id, verification_id, generated_file_path) VALUES (?, ?, ?, 'assets/docs/sample_transcript.pdf')");
    $stmt->bind_param("iis", $request_id, $user_id, $verification_id);
    if ($stmt->execute()) {
        $document_id = $stmt->insert_id;
        echo "[SUCCESS] Created Document (ID: $document_id, REF: $verification_id)\n";
    } else {
        die("[ERROR] Failed to create document: " . $stmt->error);
    }
} else {
    $doc_row = $check_doc->fetch_assoc();
    $document_id = $doc_row['id'];
    echo "[INFO] Document already exists (ID: $document_id)\n";
}

// 4. Create Sample Verification Log
$stmt = $conn->prepare("INSERT INTO verification_logs (document_id, verifier_ip) VALUES (?, '192.168.1.100')");
$stmt->bind_param("i", $document_id);
if ($stmt->execute()) {
    echo "[SUCCESS] Created Verification Log Entry\n";
} else {
    echo "[ERROR] Failed to create log: " . $stmt->error . "\n";
}

echo "\nDone! You can login with:\nEmail: graduate_test@bdu.edu.et\nPassword: password123\n";
?>
