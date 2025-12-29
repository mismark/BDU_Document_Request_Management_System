    </main>
    <footer>
        <div class="container">
            <div class="grid-3 mb-12 text-left">
                <div>
                    <div class="flex items-center gap-3 mb-6">
                        <div class="header-logo-bdu">BDU</div>
                        <h3 class="heading-md text-primary mb-0">GDRMS</h3>
                    </div>
                    <p class="text-secondary text-sm leading-relaxed">
                        The official high-integrity system for academic document management and 
                        secure verification for Bahir Dar University graduates. Built with security and efficiency as core principles.
                    </p>
                </div>
                <div>
                    <h4 class="font-bold mb-6">Navigation</h4>
                    <ul class="list-none p-0">
                        <li class="mb-3"><a href="<?php echo BASE_URL; ?>index.php" class="text-secondary text-sm no-underline hover:text-primary transition flex items-center gap-2"><i data-lucide="home" size="14"></i> Home Portal</a></li>
                        <li class="mb-3"><a href="<?php echo BASE_URL; ?>verify.php" class="text-secondary text-sm no-underline hover:text-primary transition flex items-center gap-2"><i data-lucide="shield-check" size="14"></i> Document Verification</a></li>
                        <li class="mb-3"><a href="<?php echo BASE_URL; ?>help.php" class="text-secondary text-sm no-underline hover:text-primary transition flex items-center gap-2"><i data-lucide="help-circle" size="14"></i> Support Center</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-6">Connect & Legal</h4>
                    <p class="text-xs text-secondary mb-4 italic">Official University Channels</p>
                    <div class="flex gap-4 mb-8">
                        <a href="https://twitter.com/bdu_ethiopia" target="_blank" class="text-secondary hover:text-primary transition p-2 bg-surface rounded-lg"><i data-lucide="twitter" size="18"></i></a>
                        <a href="https://linkedin.com/school/bahir-dar-university" target="_blank" class="text-secondary hover:text-primary transition p-2 bg-surface rounded-lg"><i data-lucide="linkedin" size="18"></i></a>
                        <a href="https://bdu.edu.et" target="_blank" class="text-secondary hover:text-primary transition p-2 bg-surface rounded-lg"><i data-lucide="globe" size="18"></i></a>
                    </div>
                    <p class="text-xs text-secondary">
                        <i data-lucide="map-pin" size="12" class="mr-1"></i> Bahir Dar, Ethiopia
                    </p>
                </div>
            </div>
            
            <div class="footer-bottom border-t border-white/5 pt-8 flex justify-between items-center flex-wrap gap-4">
                <p class="text-secondary text-xs">
                    &copy; <?php echo date('Y'); ?> Bahir Dar University Graduate Document Request, Authentication, and Verification Management System.
                </p>
                <div class="flex items-center gap-2 px-3 py-1 bg-success/5 border border-success/10 rounded-full">
                    <span class="w-2 h-2 rounded-full bg-success animate-pulse"></span>
                    <span class="text-xs text-success font-mono font-bold">Encrypted & Online</span>
                </div>
            </div>
        </div>
    </footer>
    <script>
        lucide.createIcons();
    </script>
</body>
</html>
