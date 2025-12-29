document.addEventListener("DOMContentLoaded", () => {
  // Initialize Lucide Icons
  if (typeof lucide !== "undefined") {
    lucide.createIcons();
  }

  // Add scroll effect to header
  const header = document.querySelector("header");
  window.addEventListener("scroll", () => {
    if (window.scrollY > 20) {
      header.classList.add("header-scrolled");
    } else {
      header.classList.remove("header-scrolled");
    }
  });

  // Handle Form Submissions with Loading State
  const forms = document.querySelectorAll("form");
  forms.forEach((form) => {
    form.addEventListener("submit", (e) => {
      const submitBtn = form.querySelector('button[type="submit"]');
      if (submitBtn) {
        const originalText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = `
                    <span class="spinner"></span>
                    Processing...
                `;
      }
    });
  });

  // Simple Toast Notification System
  window.showToast = (message, type = "success") => {
    const toast = document.createElement("div");
    toast.className = `toast toast-${type} animate-fade-in`;

    let icon = "check-circle";
    if (type === "error") icon = "alert-circle";
    if (type === "warning") icon = "help-circle";

    toast.innerHTML = `
            <i data-lucide="${icon}" size="18"></i>
            <span>${message}</span>
        `;

    document.body.appendChild(toast);
    lucide.createIcons();

    setTimeout(() => {
      toast.classList.add("toast-fade-out");
      setTimeout(() => toast.remove(), 500);
    }, 4000);
  };

  // Check for success/error in URL and show toast
  const urlParams = new URLSearchParams(window.location.search);
  if (urlParams.has("success")) {
    showToast(urlParams.get("success"), "success");
  }
  if (urlParams.has("error")) {
    showToast(urlParams.get("error"), "error");
  }

  // Mobile Menu Toggle
  const menuToggle = document.getElementById("menu-toggle");
  const mainNav = document.getElementById("main-nav");

  if (menuToggle && mainNav) {
    menuToggle.addEventListener("click", () => {
      mainNav.classList.toggle("active");
      const icon = menuToggle.querySelector("i");
      if (mainNav.classList.contains("active")) {
        icon.setAttribute("data-lucide", "x");
      } else {
        icon.setAttribute("data-lucide", "menu");
      }
      lucide.createIcons();
    });

    // Close menu when clicking outside
    document.addEventListener("click", (e) => {
      if (!mainNav.contains(e.target) && !menuToggle.contains(e.target)) {
        mainNav.classList.remove("active");
        menuToggle.querySelector("i").setAttribute("data-lucide", "menu");
        lucide.createIcons();
      }
    });

    // Close menu when clicking a link
    mainNav.querySelectorAll("a").forEach((link) => {
      link.addEventListener("click", () => {
        mainNav.classList.remove("active");
        menuToggle.querySelector("i").setAttribute("data-lucide", "menu");
        lucide.createIcons();
      });
    });
  }

  // Interactive card hover effects
  const cards = document.querySelectorAll(".glass-card, .stat-card");
  cards.forEach((card) => {
    card.addEventListener("mouseenter", () => {
      card.style.transform = "translateY(-5px)";
    });
    card.addEventListener("mouseleave", () => {
      card.style.transform = "translateY(0)";
    });
  });
});
