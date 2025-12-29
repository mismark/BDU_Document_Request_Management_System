<?php
include 'config.php';
include 'includes/header.php';
?>

<div class="auth-box glass-card animate-fade-in mt-20">
    <div class="auth-header">
        <div class="auth-icon bg-secondary">
            <i data-lucide="key-round"></i>
        </div>
        <h2>Recovery</h2>
        <p>Reset your account password</p>
    </div>

    <form action="auth.php" method="POST">
        <input type="hidden" name="action" value="reset_request">
        
        <div class="alert alert-info">
            Enter your email address and we'll send you a link to reset your password.
        </div>

        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" class="form-control" placeholder="name@example.com" required>
        </div>

        <button type="submit" class="btn btn-primary btn-block p-4">Send Reset Link</button>
        
        <p class="auth-footer">
            Remember your password? <a href="login.php">Sign In</a>
        </p>
    </form>
</div>

<script>
    lucide.createIcons();
</script>

<?php include 'includes/footer.php'; ?>
