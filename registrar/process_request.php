// Process Request - Registrar Review & Action
<?php
include '../config.php';
check_auth('registrar');

if (!isset($_GET['id'])) {
    redirect('registrar/dashboard.php');
}

$request_id = sanitize($conn, $_GET['id']);
$error = null;

// POST Action (Approve/Reject) using prepared statements
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];
    
    if ($action == 'approve') {
        $verification_id = "BDU-" . date('Y') . "-" . strtoupper(substr(md5(uniqid()), 0, 8));
        $user_id = $_POST['user_id'];
        
        $conn->begin_transaction();
        try {
            $stmt_doc = $conn->prepare("INSERT INTO documents (request_id, user_id, verification_id) VALUES (?, ?, ?)");
            $stmt_doc->bind_param("iis", $request_id, $user_id, $verification_id);
            $stmt_doc->execute();
            
            $stmt_req = $conn->prepare("UPDATE requests SET status = 'approved' WHERE id = ?");
            $stmt_req->bind_param("i", $request_id);
            $stmt_req->execute();
            
            $conn->commit();
            redirect('registrar/dashboard.php?success=Authentication successful. Record ID: ' . $verification_id);
        } catch (Exception $e) {
            $conn->rollback();
            $error = "Transaction failed: " . $e->getMessage();
        }

    } elseif ($action == 'reject') {
        $reason = sanitize($conn, $_POST['reason']);
        $stmt_rej = $conn->prepare("UPDATE requests SET status = 'rejected', rejection_reason = ? WHERE id = ?");
        $stmt_rej->bind_param("si", $reason, $request_id);
        
        if ($stmt_rej->execute()) {
            redirect('registrar/dashboard.php?info=Request declined.');
        } else {
            $error = "Could not decline request.";
        }
    }
}

// Fetch Request Details
$stmt_fetch = $conn->prepare("SELECT r.*, u.full_name, u.email 
                            FROM requests r 
                            JOIN users u ON r.user_id = u.id 
                            WHERE r.id = ?");
$stmt_fetch->bind_param("i", $request_id);
$stmt_fetch->execute();
$result = $stmt_fetch->get_result();

if ($result->num_rows == 0) {
    die("Error: Request record missing.");
}

$request = $result->fetch_assoc();
?>
<?php include '../includes/header.php'; ?>

<div class="container animate-fade-in p-8 max-w-2xl mx-auto">
    <div class="mb-12">
        <a href="dashboard.php" class="sidebar-link active w-fit px-4" style="margin-bottom: 0;">
            <i data-lucide="arrow-left" size="16"></i> Back to Queue
        </a>
    </div>

    <div class="dash-header flex-col items-start gap-2 mb-12">
        <h2 class="heading-xl">Document Verification</h2>
        <p class="text-secondary text-lg">System Audit for Reference <code class="text-primary font-bold">#<?php echo str_pad($request['id'], 5, '0', STR_PAD_LEFT); ?></code></p>
    </div>

    <?php if ($error): ?>
        <div class="alert alert-danger mb-8">
            <i data-lucide="alert-circle" size="18" class="mr-2"></i>
            <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <div class="grid-2 mb-12">
        <div class="glass-card">
            <div class="flex items-center gap-4 mb-6 text-secondary">
                <i data-lucide="user" size="24"></i>
                <h4 class="font-bold">Applicant Identity</h4>
            </div>
            <div class="flex flex-col gap-4">
                <div>
                    <span class="text-xs text-secondary uppercase font-bold tracking-wider">Legal Name</span>
                    <div class="text-lg font-bold"><?php echo htmlspecialchars($request['full_name']); ?></div>
                </div>
                <div>
                    <span class="text-xs text-secondary uppercase font-bold tracking-wider">Identity Reference</span>
                    <div class="text-sm font-mono text-primary"><?php echo htmlspecialchars($request['email']); ?></div>
                </div>
            </div>
        </div>

        <div class="glass-card bg-surface">
            <div class="flex items-center gap-4 mb-6 text-primary">
                <i data-lucide="file-text" size="24"></i>
                <h4 class="font-bold">Document Specs</h4>
            </div>
            <div class="flex flex-col gap-4">
                <div class="flex justify-between border-b border-white/5 pb-2">
                    <span class="text-sm text-secondary">Class</span>
                    <span class="badge bg-primary/10 text-primary py-1"><?php echo ucfirst($request['document_type']); ?></span>
                </div>
                <div class="flex justify-between border-b border-white/5 pb-2">
                    <span class="text-sm text-secondary">Submission</span>
                    <span class="text-sm font-bold"><?php echo date('M d, Y', strtotime($request['created_at'])); ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-secondary">Logistics</span>
                    <span class="text-sm font-bold flex items-center gap-2">
                        <i data-lucide="<?php echo ($request['delivery_method'] == 'digital' ? 'mail' : 'truck'); ?>" size="14"></i>
                        <?php echo ucfirst($request['delivery_method']); ?>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="glass-card mb-12">
        <h4 class="text-xs text-secondary uppercase font-bold tracking-widest mb-4">Verification Context</h4>
        <p class="text-lg leading-relaxed text-slate-200"><?php echo nl2br(htmlspecialchars($request['purpose'])); ?></p>
    </div>

    <div class="grid-2">
        <!-- Approve -->
        <div class="stat-card border-t-4 border-success p-8 flex flex-col items-center text-center">
            <div class="text-success mb-6 bg-success/10 p-4 rounded-2xl"><i data-lucide="shield-check" size="40"></i></div>
            <h3 class="heading-md mb-4">Validate & Sign</h3>
            <p class="text-sm text-secondary mb-8 flex-1">Issue official digital credentials. This action is recorded in the university audit log.</p>
            <form action="" method="POST" class="w-full">
                <input type="hidden" name="user_id" value="<?php echo $request['user_id']; ?>">
                <input type="hidden" name="action" value="approve">
                <button type="submit" class="btn btn-primary w-full shadow-lg shadow-success/20" style="background: var(--success);">
                    Authorize Issue
                </button>
            </form>
        </div>

        <!-- Reject -->
        <div class="stat-card border-t-4 border-danger p-8 flex flex-col items-center text-center">
            <div class="text-danger mb-6 bg-danger/10 p-4 rounded-2xl"><i data-lucide="alert-triangle" size="40"></i></div>
            <h3 class="heading-md mb-4">Decline Approval</h3>
            <p class="text-sm text-secondary mb-6">If the applicant provides insufficient data, decline with a formal reason.</p>
            <form action="" method="POST" class="w-full">
                <input type="hidden" name="action" value="reject">
                <textarea name="reason" class="form-control mb-4 text-sm" rows="3" placeholder="Enter formal rejection reason..." required></textarea>
                <button type="submit" class="btn btn-outline w-full text-danger border-danger hover:bg-danger/10">
                    Reject Request
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    lucide.createIcons();
</script>

<?php include '../includes/footer.php'; ?>
