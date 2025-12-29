<?php
include '../config.php';
check_auth('admin');

// Handle Role Update (Prepared Statement)
if (isset($_POST['update_role'])) {
    $uid = sanitize($conn, $_POST['user_id']);
    $new_role = sanitize($conn, $_POST['role']);
    $stmt = $conn->prepare("UPDATE users SET role = ? WHERE id = ?");
    $stmt->bind_param("si", $new_role, $uid);
    $stmt->execute();
    redirect('admin/dashboard.php?success=Privileges updated.');
}

// Stats Queries
$user_stats = $conn->query("SELECT 
    (SELECT COUNT(*) FROM users) as total_users,
    (SELECT COUNT(*) FROM requests) as total_requests,
    (SELECT COUNT(*) FROM documents) as total_docs,
    (SELECT COUNT(*) FROM requests WHERE status='pending') as pending_count
")->fetch_assoc();

// Fetch Users List
$users_result = $conn->query("SELECT * FROM users ORDER BY created_at DESC");
?>
<?php include '../includes/header.php'; ?>

<div class="dashboard-container animate-fade-in p-8">
    <div class="dash-header flex-wrap">
        <div>
            <h2 class="heading-xl">Administrative Governance</h2>
            <p class="text-secondary text-lg">Infrastructure Oversight for Bahir Dar University</p>
        </div>
        <div class="flex gap-4">
            <button class="btn btn-outline btn-sm">
                <i data-lucide="database" size="16"></i>
                Backup Node
            </button>
            <button class="btn btn-primary btn-sm">
                <i data-lucide="shield-plus" size="16"></i>
                Security Audit
            </button>
        </div>
    </div>

    <!-- Analytics Dashboard -->
    <div class="grid-3 mb-16">
        <div class="stat-card border-l-4 border-primary">
            <div class="text-primary mb-4"><i data-lucide="users" size="32"></i></div>
            <div class="heading-xl"><?php echo $user_stats['total_users']; ?></div>
            <div class="text-secondary text-xs uppercase font-bold tracking-widest">Registered Entities</div>
        </div>
        <div class="stat-card border-l-4 border-secondary">
            <div class="text-secondary mb-4"><i data-lucide="file-check" size="32"></i></div>
            <div class="heading-xl"><?php echo $user_stats['total_docs']; ?></div>
            <div class="text-secondary text-xs uppercase font-bold tracking-widest">Verified Artifacts</div>
        </div>
        <div class="stat-card border-l-4 border-warning">
            <div class="text-warning mb-4"><i data-lucide="activity" size="32"></i></div>
            <div class="heading-xl"><?php echo $user_stats['pending_count']; ?></div>
            <div class="text-secondary text-xs uppercase font-bold tracking-widest">Sync Requests</div>
        </div>
    </div>

    <div class="grid-main">
        <div class="glass-card p-0 overflow-hidden">
            <div class="dash-header p-6 mb-0">
                <h3 class="heading-md">System Directory</h3>
                <div class="relative max-w-xs">
                    <i data-lucide="search" size="14" class="absolute left-3 top-3 text-secondary"></i>
                    <input type="text" class="form-control text-sm pl-10" placeholder="Identity lookup...">
                </div>
            </div>
            <div class="table-container border-0">
                <table>
                    <thead>
                        <tr>
                            <th>Member Entity</th>
                            <th>Privilege Level</th>
                            <th>Registration</th>
                            <th>Authority</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = $users_result->fetch_assoc()): ?>
                            <tr>
                                <td>
                                    <div class="flex items-center gap-4">
                                        <div class="w-8 h-8 bg-surface rounded-full flex items-center justify-center font-bold text-xs uppercase">
                                            <?php echo substr($row['full_name'], 0, 1); ?>
                                        </div>
                                        <div>
                                            <div class="font-bold text-sm"><?php echo htmlspecialchars($row['full_name']); ?></div>
                                            <div class="text-xs text-secondary font-mono"><?php echo htmlspecialchars($row['email']); ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <form action="" method="POST">
                                        <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                                        <select name="role" onchange="this.form.submit()" class="form-control py-1 px-3 text-xs bg-surface border-white/10">
                                            <option value="graduate" <?php if($row['role'] == 'graduate') echo 'selected'; ?>>Graduate</option>
                                            <option value="registrar" <?php if($row['role'] == 'registrar') echo 'selected'; ?>>Registrar</option>
                                            <option value="admin" <?php if($row['role'] == 'admin') echo 'selected'; ?>>Administrator</option>
                                        </select>
                                        <input type="hidden" name="update_role" value="1">
                                    </form>
                                </td>
                                <td><span class="text-xs text-secondary"><?php echo date('M d, Y', strtotime($row['created_at'])); ?></span></td>
                                <td>
                                    <button class="btn btn-outline btn-xs border-danger text-danger py-1 px-2 text-[10px]">Revoke</button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="flex flex-col gap-6">
            <div class="glass-card">
                <h4 class="heading-sm mb-6">Operations Hub</h4>
                <div class="flex flex-col gap-3">
                    <a href="#" class="sidebar-link text-sm">
                        <i data-lucide="file-spreadsheet" size="16"></i> Data Export (.xlsx)
                    </a>
                    <a href="#" class="sidebar-link text-sm">
                        <i data-lucide="lock" size="16"></i> Access Audit Logs
                    </a>
                    <a href="#" class="sidebar-link text-sm">
                        <i data-lucide="settings" size="16"></i> Node Configuration
                    </a>
                </div>
            </div>

            <div class="glass-card bg-gradient-to-br from-primary/10 to-transparent">
                <h4 class="heading-sm mb-4">Core Integrity</h4>
                <div class="flex flex-col gap-6">
                    <div>
                        <div class="flex justify-between text-xs font-bold mb-2 uppercase tracking-tighter">
                            <span>Database Cluster</span>
                            <span class="text-success">Nominal</span>
                        </div>
                        <div class="w-full bg-white/5 h-1.5 rounded-full overflow-hidden">
                            <div class="bg-success h-full" style="width: 14%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between text-xs font-bold mb-1 uppercase tracking-tighter">
                            <span>System Latency</span>
                            <span class="text-primary">12ms</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .btn-xs { padding: 0.25rem 0.5rem; font-size: 0.7rem; }
</style>

<script>
    lucide.createIcons();
</script>

<?php include '../includes/footer.php'; ?>
