// Registrar Dashboard - Manage Authentication & Verification Queue
<?php
include '../config.php';
check_auth('registrar');

// Fetch pending requests with counts
$sql = "SELECT r.*, u.full_name, u.email 
        FROM requests r 
        JOIN users u ON r.user_id = u.id 
        WHERE r.status = 'pending' 
        ORDER BY r.created_at ASC";
$result = $conn->query($sql);
$pending_count = $result->num_rows;

$processed_count = $conn->query("SELECT COUNT(*) as count FROM requests WHERE status != 'pending'")->fetch_assoc()['count'];
?>
<?php include '../includes/header.php'; ?>

<div class="dashboard-container animate-fade-in p-8">
    <div class="dash-header">
        <div>
            <h2 class="heading-lg">Registrar Portal</h2>
            <p class="text-secondary text-lg">Authentication & Verification Queue Management</p>
        </div>
        <div class="flex gap-4">
            <button class="btn btn-outline" onclick="window.location.reload()">
                <i data-lucide="refresh-cw" size="18"></i>
                Sync Data
            </button>
        </div>
    </div>

    <!-- Overview Stats -->
    <div class="grid-3 mb-12">
        <div class="stat-card">
            <div class="stat-card-icon bg-warning/10 text-warning">
                <i data-lucide="clipboard-list"></i>
            </div>
            <div class="heading-md"><?php echo $pending_count; ?></div>
            <div class="text-secondary text-sm uppercase font-bold mt-1">Pending Actions</div>
        </div>
        <div class="stat-card">
            <div class="stat-card-icon bg-success/10 text-success">
                <i data-lucide="check-square"></i>
            </div>
            <div class="heading-md"><?php echo $processed_count; ?></div>
            <div class="text-secondary text-sm uppercase font-bold mt-1">Total Processed</div>
        </div>
        <div class="stat-card">
            <div class="stat-card-icon bg-primary/10 text-primary">
                <i data-lucide="activity"></i>
            </div>
            <div class="heading-md">Live</div>
            <div class="text-secondary text-sm uppercase font-bold mt-1">System Status</div>
        </div>
    </div>

    <div class="glass-card p-0 overflow-hidden">
        <div class="dash-header p-6 mb-0">
            <h3 class="heading-md">Document Request Queue</h3>
            <span class="badge badge-pending px-4 py-2"><?php echo $pending_count; ?> Pending Approval</span>
        </div>
        <div class="table-container border-0">
            <table>
                <thead>
                    <tr>
                        <th>Reference</th>
                        <th>Graduate Identity</th>
                        <th>Document Type</th>
                        <th>Date Requested</th>
                        <th>Dispatch</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><code class="text-primary font-bold">#<?php echo str_pad($row['id'], 5, '0', STR_PAD_LEFT); ?></code></td>
                                <td>
                                    <div class="font-bold"><?php echo htmlspecialchars($row['full_name']); ?></div>
                                    <div class="text-xs text-secondary"><?php echo htmlspecialchars($row['email']); ?></div>
                                </td>
                                <td><span class="badge bg-surface py-1"><?php echo ucfirst($row['document_type']); ?></span></td>
                                <td><span class="text-sm"><?php echo date('M d, Y', strtotime($row['created_at'])); ?></span></td>
                                <td>
                                    <div class="flex items-center gap-2 text-sm">
                                        <i data-lucide="<?php echo ($row['delivery_method'] == 'digital' ? 'mail' : 'truck'); ?>" size="14"></i>
                                        <?php echo ucfirst($row['delivery_method']); ?>
                                    </div>
                                </td>
                                <td>
                                    <a href="process_request.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">
                                        Authenticate
                                        <i data-lucide="chevron-right" size="14"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center p-20 text-secondary">
                                <div class="mb-4"><i data-lucide="check-circle-2" size="48" class="text-success"></i></div>
                                <h4 class="text-primary font-bold">Inbox Zero</h4>
                                <p class="text-sm">All requests have been successfully processed and verified.</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    lucide.createIcons();
</script>

<?php include '../includes/footer.php'; ?>
