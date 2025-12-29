<?php
include '../config.php';
check_auth('graduate');

$error = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $doc_type = sanitize($conn, $_POST['document_type']);
    $purpose = sanitize($conn, $_POST['purpose']);
    $delivery = sanitize($conn, $_POST['delivery_method']);

    $stmt = $conn->prepare("INSERT INTO requests (user_id, document_type, purpose, delivery_method) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $user_id, $doc_type, $purpose, $delivery);

    if ($stmt->execute()) {
        redirect('graduate/dashboard.php?success=Request submitted successfully. Our team will review it shortly.');
    } else {
        $error = "Could not process request: " . $conn->error;
    }
}
?>
<?php include '../includes/header.php'; ?>

<div class="container animate-fade-in p-8 max-w-2xl mx-auto">
    <div class="mb-12">
        <a href="dashboard.php" class="sidebar-link active w-fit px-4" style="margin-bottom: 0;">
            <i data-lucide="arrow-left" size="16"></i> Back to Dashboard
        </a>
    </div>

    <div class="text-center mb-12">
        <div class="verify-icon-box bg-primary/10 text-primary">
            <i data-lucide="file-plus" size="32"></i>
        </div>
        <h2 class="heading-xl">New Document Request</h2>
        <p class="text-secondary text-lg">Official Bahir Dar University verification request.</p>
    </div>

    <?php if ($error): ?>
        <div class="alert alert-danger mb-8">
            <i data-lucide="alert-circle" size="18" class="mr-2"></i>
            <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <div class="glass-card p-12 relative overflow-hidden">
        <div class="verify-accent-bar"></div>
        
        <form action="" method="POST" id="requestForm">
            <div class="form-group">
                <label for="document_type">Document Category</label>
                <div class="relative">
                    <i data-lucide="book-open" class="absolute left-4 top-4 text-secondary" size="18"></i>
                    <select name="document_type" id="document_type" class="form-control pl-12" required>
                        <option value="">-- Choose document type --</option>
                        <option value="transcript">Official Academic Transcript</option>
                        <option value="certificate">Degree Certificate (Replacement Copy)</option>
                        <option value="letter">Graduation Eligibility Letter</option>
                        <option value="recommendation">Dean's Recommendation Letter</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="purpose">Statement of Purpose</label>
                <textarea name="purpose" id="purpose" rows="4" class="form-control" placeholder="Briefly explain why you need this document (e.g., job application, further studies abroad)..." required></textarea>
                <div class="flex justify-between mt-2">
                    <small class="text-secondary text-xs">Be specific for faster processing</small>
                    <small class="text-secondary text-xs" id="charCount">0 / 500</small>
                </div>
            </div>

            <div class="form-group">
                <label class="mb-4 block font-bold">Preferred Dispatch Method</label>
                <div class="grid-2">
                    <label class="stat-card hover-glow cursor-pointer relative delivery-option bg-surface" id="option-digital">
                        <input type="radio" name="delivery_method" value="digital" checked class="absolute right-4 top-4">
                        <div class="text-secondary mb-2"><i data-lucide="mail" size="24"></i></div>
                        <div class="font-bold">Digital Express</div>
                        <div class="text-xs text-secondary">Secured PDF via Email</div>
                    </label>

                    <label class="stat-card hover-glow cursor-pointer relative delivery-option" id="option-physical">
                        <input type="radio" name="delivery_method" value="physical" class="absolute right-4 top-4">
                        <div class="text-primary mb-2"><i data-lucide="truck" size="24"></i></div>
                        <div class="font-bold">Campus Pickup</div>
                        <div class="text-xs text-secondary">Direct from Registrar</div>
                    </label>
                </div>
            </div>

            <div class="info-note-box bg-primary/5 border-primary/10 mt-8 mb-8">
                <p class="text-sm text-secondary flex items-start gap-4">
                    <i data-lucide="info" size="20" class="text-primary"></i>
                    Your document will be assigned a unique verification ID for institutional authentication.
                </p>
            </div>

            <button type="submit" class="btn btn-primary btn-block p-4 text-lg">
                Submit Request
            </button>
        </form>
    </div>
</div>

<style>
    .pl-12 { padding-left: 3rem !important; }
    .cursor-pointer { cursor: pointer; }
    .delivery-option { border: 2px solid transparent; }
    .delivery-option:has(input:checked) { border-color: var(--primary); background: rgba(37, 99, 235, 0.05); }
</style>

<script>
    lucide.createIcons();
    
    // Character Counter
    const textarea = document.getElementById('purpose');
    const charCount = document.getElementById('charCount');
    textarea.addEventListener('input', () => {
        const count = textarea.value.length;
        charCount.textContent = count + ' / 500';
        if(count > 500) charCount.classList.add('text-danger');
        else charCount.classList.remove('text-danger');
    });
</script>

<?php include '../includes/footer.php'; ?>
