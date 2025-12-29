<?php
include 'config.php';

$verification_result = null;
$error = null;

if ($_SERVER["REQUEST_METHOD"] == "POST" || isset($_GET['id'])) {
    $ver_id = isset($_GET['id']) ? sanitize($conn, $_GET['id']) : sanitize($conn, $_POST['verification_id']);
    
    // Check in database
    $sql = "SELECT d.*, u.full_name, r.document_type, r.created_at as request_date 
            FROM documents d 
            JOIN users u ON d.user_id = u.id 
            JOIN requests r ON d.request_id = r.id 
            WHERE d.verification_id = '$ver_id'";
            
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $verification_result = $result->fetch_assoc();
        // Increment verified count
        $conn->query("UPDATE documents SET verified_count = verified_count + 1 WHERE id = '{$verification_result['id']}'");
    } else {
        $error = "Invalid Verification ID. The document record could not be found.";
    }
}
?>
<?php include 'includes/header.php'; ?>

<div class="verify-portal-container animate-fade-in">
    <div class="verify-header">
        <div class="verify-icon-box">
            <i data-lucide="shield-check" size="32"></i>
        </div>
        <h2 class="verify-title">Employer Verification Portal</h2>
        <p class="verify-desc">
            Bahir Dar University Graduate Document Request, Authentication, and Verification Management System.
        </p>
    </div>

    <div class="glass-card verify-card-form">
        <div class="verify-accent-bar"></div>
        <form action="verify.php" method="POST">
            <div class="form-group">
                <label for="verification_id" class="text-left block mb-4 font-bold">Document Reference / QR ID</label>
                <div class="relative">
                    <i data-lucide="qr-code" class="absolute left-4 top-4 text-secondary" size="20"></i>
                    <input type="text" name="verification_id" id="verification_id" class="form-control ver-input" placeholder="e.g. BDU-2023-XXXX" required value="<?php echo isset($ver_id) ? htmlspecialchars($ver_id) : ''; ?>">
                </div>
            </div>
            <button type="submit" class="btn btn-primary btn-block p-4 text-lg rounded-xl">
                <i data-lucide="search" size="18"></i>
                Verify Online Authenticity
            </button>
        </form>
    </div>

    <?php if ($verification_result): ?>
        <div class="glass-card animate-fade-in border-t-4 border-success p-16">
            <div class="flex gap-8 items-start flex-wrap">
                <!-- Left side: Status and QR -->
                <div class="qr-container">
                    <div class="qr-preview-box">
                        <div class="qr-mock">
                            <div class="qr-inner"></div>
                            <div class="qr-center"><div class="qr-center-dot"></div></div>
                        </div>
                    </div>
                    <div class="badge badge-approved p-4 px-6 rounded-full text-base">
                        <i data-lucide="check-circle-2" size="18" class="mr-2 align-middle"></i>
                        LEGITIMATE RECORD
                    </div>
                </div>

                <!-- Right side: Details -->
                <div class="verification-details">
                    <div class="mb-12">
                        <h3 class="text-primary font-extrabold mb-4 text-4xl leading-tight">Academic Certification</h3>
                        <p class="text-secondary text-lg">Verified original document from the BDU National Archive.</p>
                    </div>

                    <div class="detail-row">
                        <div class="detail-item">
                            <label class="detail-label">Graduate Holder</label>
                            <p class="detail-value"><?php echo htmlspecialchars($verification_result['full_name']); ?></p>
                        </div>
                        <div class="detail-item">
                            <label class="detail-label">Reference Number</label>
                            <p class="detail-value detail-value-mono"><?php echo htmlspecialchars($verification_result['verification_id']); ?></p>
                        </div>
                        <div class="detail-item">
                            <label class="detail-label">Document Category</label>
                            <p class="detail-value"><?php echo ucfirst($verification_result['document_type']); ?></p>
                        </div>
                        <div class="detail-item">
                            <label class="detail-label">Authentication Date</label>
                            <p class="detail-value"><?php echo date('M d, Y', strtotime($verification_result['created_at'])); ?></p>
                        </div>
                    </div>

                    <!-- Journey Timeline -->
                    <div class="traceability-section">
                        <label class="detail-label block mb-8">Verification Traceability</label>
                        <div class="steps-container p-0">
                            <div class="step-item completed"><div class="step-circle"><i data-lucide="server"></i></div></div>
                            <div class="step-item completed"><div class="step-circle"><i data-lucide="user-check"></i></div></div>
                            <div class="step-item completed"><div class="step-circle"><i data-lucide="shield-check"></i></div></div>
                            <div class="step-item active"><div class="step-circle"><i data-lucide="map-pin"></i></div></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="footer-action-row">
                <div class="flex items-center gap-4 text-secondary text-sm">
                    <i data-lucide="globe" size="18"></i>
                    <span>Verified centrally from BDU Registrar database</span>
                </div>
                <button class="btn btn-outline p-2 px-4" onclick="window.print()">
                    <i data-lucide="printer" size="16" class="mr-2"></i>
                    Print Report
                </button>
            </div>
        </div>
    <?php elseif ($error): ?>
        <div class="glass-card animate-fade-in error-card">
            <div class="flex items-center gap-8 mb-10">
                <div class="error-icon-v">
                    <i data-lucide="alert-octagon" size="48"></i>
                </div>
                <div>
                    <h3 class="text-danger font-extrabold mb-2 text-3xl">INVALID CREDENTIALS</h3>
                    <p class="text-secondary text-lg"><?php echo $error; ?></p>
                </div>
            </div>
            <div class="info-note-box">
                <h4 class="text-primary mb-4">Employer Action Required:</h4>
                <p>1. Ensure you have entered the ID exactly as printed on the certificate.</p>
                <p>2. Verify that the document hasn't exceeded its validity period.</p>
                <p>3. Contact the BDU Registrar if you suspect document tampering.</p>
            </div>
        </div>
    <?php endif; ?>
</div>
</div>

<script>
    lucide.createIcons();
</script>

<?php include 'includes/footer.php'; ?>
