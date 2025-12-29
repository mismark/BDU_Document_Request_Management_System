<?php include 'config.php'; ?>
<?php include 'includes/header.php'; ?>

<div class="hero animate-fade-in">
    <div class="hero-badge">
        <i data-lucide="graduation-cap" size="14"></i>
        Bahir Dar University Document Portal
    </div>
    <h1 class="hero-title">Graduate Document <br><span class="text-primary">Request & Verification</span></h1>
    <p class="hero-subtitle">
        Official system to manage graduate document requests, authenticate academic originals, 
        and allow employers to verify documents online securely and instantly.
    </p>

    <div class="hero-actions">
        <?php if (!isset($_SESSION['user_id'])): ?>
            <a href="login.php" class="btn btn-primary shadow-lg" id="btn-login-hero">
                Portal Login
                <i data-lucide="arrow-right" size="18" class="ml-2"></i>
            </a>
            <a href="register.php" class="btn btn-outline" id="btn-register-hero">Graduate Registration</a>
        <?php else: ?>
            <a href="graduate/dashboard.php" class="btn btn-primary" id="btn-dashboard-hero">
                My Dashboard
                <i data-lucide="layout-dashboard" size="18" class="ml-2"></i>
            </a>
        <?php endif; ?>
        <a href="verify.php" class="btn btn-outline btn-success-outline" id="btn-verify-hero">
            <i data-lucide="shield-check" size="18" class="mr-2"></i>
            Employer Verification
        </a>
    </div>
</div>

<div class="stats-grid animate-fade-in" style="animation-delay: 0.2s;">
    <div class="stat-item">
        <div class="stat-value">25K+</div>
        <div class="stat-label">Documents Authenticated</div>
    </div>
    <div class="stat-item">
        <div class="stat-value">12K+</div>
        <div class="stat-label">Active Graduates</div>
    </div>
    <div class="stat-item">
        <div class="stat-value">100%</div>
        <div class="stat-label">Secure Authentication</div>
    </div>
    <div class="stat-item">
        <div class="stat-value">24/7</div>
        <div class="stat-label">Online Verification</div>
    </div>
</div>

<div class="features-grid">
    <div class="glass-card animate-fade-in hover-glow" style="animation-delay: 0.1s;">
        <div class="icon-box icon-box-primary">
            <i data-lucide="file-text" size="32"></i>
        </div>
        <h3 class="feature-title">Graduate Requests</h3>
        <p class="feature-text">Submit requests for transcripts, degree certificates, and letters. Track processing status in real-time from your dashboard.</p>
    </div>

    <div class="glass-card animate-fade-in hover-glow" style="animation-delay: 0.2s;">
        <div class="icon-box icon-box-secondary">
            <i data-lucide="user-check" size="32"></i>
        </div>
        <h3 class="feature-title">Employer Verification</h3>
        <p class="feature-text">Instant online validation of BDU academic documents using unique verification IDs or digital fingerprints.</p>
    </div>

    <div class="glass-card animate-fade-in hover-glow" style="animation-delay: 0.3s;">
        <div class="icon-box icon-box-accent">
            <i data-lucide="shield-check" size="32"></i>
        </div>
        <h3 class="feature-title">Registrar Approval</h3>
        <p class="feature-text">Secure authentication tools for the Registrar's Office to process, sign, and issue digital academic records.</p>
    </div>
</div>

<div class="section-footer animate-fade-in text-center mt-20 pb-12">
    <h2 class="heading-xl mb-4">Academic Integrity</h2>
    <p class="text-secondary mb-12 max-w-md mx-auto">Our management system ensures the highest standards of document security and reliability for all stakeholders.</p>
    
    <div class="bdu-integrity-card">
        <div class="flex items-center gap-4">
            <div class="header-logo-bdu">BDU</div>
            <div class="divider-v"></div>
            <div class="text-left">
                <h4 class="mb-0">Bahir Dar University</h4>
                <p class="mb-0 text-secondary text-sm">Office of the Registrar</p>
            </div>
        </div>
    </div>
</div>

<script>
    lucide.createIcons();
</script>

<?php include 'includes/footer.php'; ?>
