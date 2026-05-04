// Common Header - Included in all pages for consistent layout & navigation
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BDU-GDRMS | Graduate Document Management System</title>
    <!-- Use base tag or dynamic paths -->
    <link rel="stylesheet" href="<?php echo (defined('BASE_URL') ? BASE_URL : '/'); ?>assets/css/style.css?v=<?php echo time(); ?>">
    <!-- Lucide Icons for modern feel -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <!-- Main JS -->
    <script src="<?php echo (defined('BASE_URL') ? BASE_URL : '/'); ?>assets/js/main.js" defer></script>
</head>
<body>
    <header>
        <div class="container header-content">
            <div class="logo-area">
                <a href="<?php echo BASE_URL; ?>index.php" class="flex items-center gap-4 no-underline">
                    <div class="header-logo-bdu">BDU</div>
                    <h1 id="site-logo">GDRMS</h1>
                </a>
            </div>

            <!-- Mobile Menu Toggle -->
            <button class="mobile-toggle" id="menu-toggle" aria-label="Toggle Navigation">
                <i data-lucide="menu"></i>
            </button>

            <nav id="main-nav">
                <ul>
                    <li><a href="<?php echo BASE_URL; ?>index.php">Home</a></li>
                    <?php if (!isset($_SESSION['user_id']) || $_SESSION['role'] == 'graduate'): ?>
                        <li><a href="<?php echo BASE_URL; ?><?php echo isset($_SESSION['user_id']) ? 'graduate/request.php' : 'login.php'; ?>">Request</a></li>
                    <?php endif; ?>
                    <li><a href="<?php echo BASE_URL; ?>verify.php">Verify</a></li>
                    <li><a href="<?php echo BASE_URL; ?>help.php">Help</a></li>
                    
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <?php if ($_SESSION['role'] == 'graduate'): ?>
                            <li><a href="<?php echo BASE_URL; ?>graduate/dashboard.php">Dashboard</a></li>
                        <?php elseif ($_SESSION['role'] == 'registrar'): ?>
                            <li><a href="<?php echo BASE_URL; ?>registrar/dashboard.php">Registrar</a></li>
                        <?php elseif ($_SESSION['role'] == 'admin'): ?>
                            <li><a href="<?php echo BASE_URL; ?>admin/dashboard.php">Admin</a></li>
                        <?php endif; ?>
                        <li><a href="<?php echo BASE_URL; ?>logout.php" class="btn btn-outline btn-sm">Logout</a></li>
                    <?php else: ?>
                        <li><a href="<?php echo BASE_URL; ?>login.php" class="btn btn-outline btn-sm">Login</a></li>
                        <li><a href="<?php echo BASE_URL; ?>register.php" class="btn btn-primary btn-sm">Register</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>
    <main class="container">
