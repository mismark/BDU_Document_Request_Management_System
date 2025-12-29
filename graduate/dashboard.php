<?php
include '../config.php';
check_auth('graduate');

$user_id = $_SESSION['user_id'];

// Get Requests using prepared statement with documents join
$stmt = $conn->prepare("SELECT r.*, d.verification_id 
                        FROM requests r 
                        LEFT JOIN documents d ON r.id = d.request_id 
                        WHERE r.user_id = ? 
                        ORDER BY r.created_at DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Get counts for stats
$total_requests = $result->num_rows;

$stmt_p = $conn->prepare("SELECT COUNT(*) as count FROM requests WHERE user_id = ? AND status = 'pending'");
$stmt_p->bind_param("i", $user_id);
$stmt_p->execute();
$pending = $stmt_p->get_result()->fetch_assoc()['count'];

$stmt_a = $conn->prepare("SELECT COUNT(*) as count FROM requests WHERE user_id = ? AND status = 'approved'");
$stmt_a->bind_param("i", $user_id);
$stmt_a->execute();
$approved = $stmt_a->get_result()->fetch_assoc()['count'];
?>
<?php include '../includes/header.php'; ?>

<div class="dashboard-container animate-fade-in p-8">
    <!-- Header -->
    <div class="dash-header">
        <div>
            <h2 class="heading-lg">Graduate Portal</h2>
            <p class="text-secondary">Welcome back, <span class="text-primary font-bold"><?php echo htmlspecialchars($_SESSION['full_name']); ?></span>.</p>
        </div>
        <a href="request.php" class="btn btn-primary">
            <i data-lucide="plus-circle" size="18"></i>
            New Document Request
        </a>
    </div>

    <!-- Stats -->
    <div class="grid-3 mb-12">
        <div class="stat-card">
            <div class="stat-card-icon bg-primary/10 text-primary">
                <i data-lucide="file-text"></i>
            </div>
            <div class="heading-md"><?php echo $total_requests; ?></div>
            <div class="text-secondary text-sm uppercase font-bold mt-1">Total Requests</div>
        </div>
        <div class="stat-card">
            <div class="stat-card-icon bg-warning/10 text-warning">
                <i data-lucide="clock"></i>
            </div>
            <div class="heading-md"><?php echo $pending; ?></div>
            <div class="text-secondary text-sm uppercase font-bold mt-1">Pending Processing</div>
        </div>
        <div class="stat-card">
            <div class="stat-card-icon bg-success/10 text-success">
                <i data-lucide="check-circle"></i>
            </div>
            <div class="heading-md"><?php echo $approved; ?></div>
            <div class="text-secondary text-sm uppercase font-bold mt-1">Ready for Download</div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="grid-main">
        <div class="glass-card p-0 overflow-hidden">
            <div class="dash-header p-6 mb-0">
                <h3 class="heading-md">Recent Requests</h3>
                <div class="text-secondary text-sm"><i data-lucide="filter" size="14"></i> Filter: All</div>
            </div>
            <div class="table-container border-0">
                <table>
                    <thead>
                        <tr>
                            <th>Reference</th>
                            <th>Document Type</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result->num_rows > 0): ?>
                            <?php while($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><code class="text-primary font-bold">#<?php echo str_pad($row['id'], 5, '0', STR_PAD_LEFT); ?></code></td>
                                    <td><span class="font-bold"><?php echo ucfirst($row['document_type']); ?></span></td>
                                    <td><span class="text-sm"><?php echo date('M d, Y', strtotime($row['created_at'])); ?></span></td>
                                    <td>
                                        <span class="badge badge-<?php echo $row['status']; ?>">
                                            <?php echo ucfirst($row['status']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if($row['status'] == 'approved'): ?>
                                            <a href="../verify.php?id=<?php echo htmlspecialchars($row['verification_id']); ?>" target="_blank" class="btn btn-outline btn-sm border-success text-success">
                                                <i data-lucide="download" size="14"></i>
                                                Get PDF
                                            </a>
                                        <?php else: ?>
                                            <span class="text-secondary text-sm italic">Pending Review</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center p-16 text-secondary">
                                    <i data-lucide="inbox" size="40" class="mb-4"></i>
                                    <p>Your request queue is empty.</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Sidebar / Notifications -->
        <div class="flex flex-col gap-6">
            <div class="glass-card">
                <h3 class="heading-md mb-6 flex items-center gap-2">
                    <i data-lucide="bell" size="20" class="text-primary"></i>
                    Updates
                </h3>
                <div class="flex flex-col gap-4">
                    <div class="notif-item">
                        <div class="text-primary"><i data-lucide="info" size="16"></i></div>
                        <div>
                            <p class="text-sm font-bold">GDRMS System Active</p>
                            <p class="text-xs text-secondary">Request your official transcripts online anytime.</p>
                        </div>
                    </div>
                    <?php if ($approved > 0): ?>
                    <div class="notif-item border-success bg-success/5">
                        <div class="text-success"><i data-lucide="check-circle" size="16"></i></div>
                        <div>
                            <p class="text-sm font-bold text-success">Action Required</p>
                            <p class="text-xs text-secondary">A document is ready for download. Please click 'Get PDF' to download.</p>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="glass-card bg-primary/5 border-primary/20">
                <h4 class="text-sm font-bold mb-2">Need help?</h4>
                <p class="text-xs text-secondary mb-4">Questions about your document status? Contact the BDU Registrar.</p>
                <a href="<?php echo BASE_URL; ?>help.php" class="btn btn-outline btn-sm w-full">Support Center</a>
            </div>
        </div>
    </div>
</div>

<script>
    lucide.createIcons();
</script>

<?php include '../includes/footer.php'; ?>
