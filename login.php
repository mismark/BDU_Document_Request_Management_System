<?php
include 'config.php';

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
?>
<?php include 'includes/header.php'; ?>

<div class="auth-box glass-card animate-fade-in mt-20">
    <div class="auth-header">
        <div class="auth-icon">
            <i data-lucide="lock"></i>
        </div>
        <h2>BDU Portal</h2>
        <p>Access the Document Management System</p>
    </div>
    
    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger">
            <?php echo htmlspecialchars($_GET['error']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">
            <?php echo htmlspecialchars($_GET['success']); ?>
        </div>
    <?php endif; ?>

    <form action="auth.php" method="POST">
        <input type="hidden" name="action" value="login">
        
        <div class="form-group">
            <label for="email">Username or Email</label>
            <input type="text" id="email" name="email" class="form-control" placeholder="user@example.com" required>
        </div>
        
        <div class="form-group">
            <div class="form-label-row">
                <label for="password" class="mb-0">Password</label>
                <a href="forgot_password.php" class="form-link">Forgot?</a>
            </div>
            <div class="password-toggle-group">
                <input type="password" id="password" name="password" class="form-control" placeholder="••••••••" required>
                <button type="button" class="password-toggle-btn">
                    <i data-lucide="eye" size="18"></i>
                </button>
            </div>
        </div>

        <button type="submit" class="btn btn-primary btn-block p-4">Sign In</button>
        
        <p class="auth-footer">
            New to BDU GDRMS? <a href="register.php">Create account</a>
        </p>
    </form>
</div>

<script>
    lucide.createIcons();
</script>

<?php include 'includes/footer.php'; ?>
