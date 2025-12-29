<?php include 'config.php'; ?>
<?php include 'includes/header.php'; ?>

<div class="container animate-fade-in py-16 max-w-2xl mx-auto">
    <div class="text-center mb-16">
        <h2 class="heading-xl mb-4">Help & Support Center</h2>
        <p class="text-secondary text-lg">Everything you need to know about the BDU Graduate Document Management System.</p>
    </div>

    <div class="grid-3 mb-16">
        <div class="glass-card flex flex-col items-start gap-4">
            <div class="text-primary bg-primary/10 p-3 rounded-xl"><i data-lucide="help-circle" size="28"></i></div>
            <h4 class="font-bold">Graduate FAQ</h4>
            <p class="text-xs text-secondary leading-relaxed">Learn how to request transcripts, track status, and download authenticated documents.</p>
            <a href="#" class="btn btn-outline btn-sm w-full mt-2">Read Guide</a>
        </div>
        <div class="glass-card flex flex-col items-start gap-4">
            <div class="text-secondary bg-surface p-3 rounded-xl"><i data-lucide="shield-check" size="28"></i></div>
            <h4 class="font-bold">Employer Guide</h4>
            <p class="text-xs text-secondary leading-relaxed">How to use verification IDs to instantly validate the authenticity of BDU academic records.</p>
            <a href="#" class="btn btn-outline btn-sm w-full mt-2">View Process</a>
        </div>
        <div class="glass-card flex flex-col items-start gap-4">
            <div class="text-warning bg-warning/10 p-3 rounded-xl"><i data-lucide="message-square" size="28"></i></div>
            <h4 class="font-bold">Contact Support</h4>
            <p class="text-xs text-secondary leading-relaxed">Having technical issues? Contact the Bahir Dar University ICT department for assistance.</p>
            <a href="#" class="btn btn-outline btn-sm w-full mt-2">Get Help</a>
        </div>
    </div>

    <div class="glass-card p-12">
        <h3 class="heading-md mb-8 text-center">Frequently Asked Questions</h3>
        
        <div class="flex flex-col gap-4">
            <details class="faq-item">
                <summary class="faq-summary">
                    How long does it take to process a transcript request?
                    <i data-lucide="chevron-down" size="18" class="text-secondary"></i>
                </summary>
                <div class="faq-content">
                    Typically, requests are processed by the Registrar's Office within 3-5 working days. You will receive an email notification once your request is approved and ready for verification.
                </div>
            </details>

            <details class="faq-item">
                <summary class="faq-summary">
                    Can I verify a document using a mobile phone?
                    <i data-lucide="chevron-down" size="18" class="text-secondary"></i>
                </summary>
                <div class="faq-content">
                    Yes, our verification system is fully responsive. You can enter the Verification ID on any mobile browser, or scan the unique QR code printed on the official document.
                </div>
            </details>

            <details class="faq-item">
                <summary class="faq-summary">
                    What should I do if my request is rejected?
                    <i data-lucide="chevron-down" size="18" class="text-secondary"></i>
                </summary>
                <div class="faq-content">
                    If a request is rejected, a reason will be provided in your dashboard. Common reasons include missing information or pending university clearances. You can resubmit with corrected details.
                </div>
            </details>
        </div>
    </div>
</div>


<script>
    lucide.createIcons();
    // Simple accordion animation toggle
    document.querySelectorAll('details').forEach(detail => {
        detail.addEventListener('toggle', (e) => {
            if (detail.open) {
                document.querySelectorAll('details').forEach(other => {
                    if (other !== detail) other.removeAttribute('open');
                });
            }
        });
    });
</script>

<?php include 'includes/footer.php'; ?>
