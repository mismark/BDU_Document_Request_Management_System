<?php
include 'config.php';

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
?>
<?php include 'includes/header.php'; ?>

<div class="auth-box glass-card animate-fade-in mt-12 max-w-md mx-auto">
    <div class="auth-header mb-8">
        <div class="auth-icon bg-secondary">
            <i data-lucide="user-plus" class="text-white"></i>
        </div>
        <h2 class="text-2xl font-bold">Join BDU Portal</h2>
        <p class="text-secondary">Register for academic document management</p>
    </div>
    
    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger">
            <?php echo htmlspecialchars($_GET['error']); ?>
        </div>
    <?php endif; ?>

    <form action="auth.php" method="POST">
        <input type="hidden" name="action" value="register">
        
        <div class="form-group">
            <label for="full_name">Full Name</label>
            <input type="text" id="full_name" name="full_name" class="form-control" placeholder="John Doe" required>
        </div>

        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" class="form-control" placeholder="john@example.com" required>
        </div>
        
        <div class="flex gap-4">
            <div class="form-group w-full">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="••••••••" required>
            </div>

            <div class="form-group w-full">
                <label for="confirm_password">Confirm</label>
                <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="••••••••" required>
            </div>
        </div>

        <button type="submit" class="btn btn-primary btn-block w-full p-4 mt-4">Create Account</button>
        
        <p class="auth-footer">
            Already have an account? <a href="login.php">Sign in instead</a>
        </p>
    </form>
</div>

<script>
    lucide.createIcons();
</script>

<?php include 'includes/footer.php'; ?>
