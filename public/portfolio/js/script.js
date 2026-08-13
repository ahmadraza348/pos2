/* ==========================================================================
   AHMAD RAZA — PORTFOLIO
   script.js
   ========================================================================== */

document.addEventListener('DOMContentLoaded', function() {

  'use strict';

  // ========================================================================
  // 1. AOS INIT (Scroll Animations)
  // ========================================================================
  if (typeof AOS !== 'undefined') {
    AOS.init({
      duration: 800,
      once: true,
      offset: 60,
      easing: 'ease-out-cubic',
      disable: window.innerWidth < 576 ? true : false
    });
  }

  // ========================================================================
  // 2. CUSTOM CURSOR
  // ========================================================================
  const cursorDot = document.getElementById('cursorDot');
  const cursorRing = document.getElementById('cursorRing');

  if (cursorDot && cursorRing && window.innerWidth > 991) {
    let mouseX = 0, mouseY = 0;
    let ringX = 0, ringY = 0;

    document.addEventListener('mousemove', function(e) {
      mouseX = e.clientX;
      mouseY = e.clientY;
      cursorDot.style.left = mouseX + 'px';
      cursorDot.style.top = mouseY + 'px';
    });

    function animateRing() {
      ringX += (mouseX - ringX) * 0.12;
      ringY += (mouseY - ringY) * 0.12;
      cursorRing.style.left = ringX + 'px';
      cursorRing.style.top = ringY + 'px';
      requestAnimationFrame(animateRing);
    }
    animateRing();

    const interactiveElements = document.querySelectorAll(
      'a, button, .btn-hero, .project-card, .skill-tag, .meta-card, .contact-card, .build-card, .education-card, .nav-link-custom'
    );

    interactiveElements.forEach(el => {
      el.addEventListener('mouseenter', function() {
        cursorRing.classList.add('hover');
      });
      el.addEventListener('mouseleave', function() {
        cursorRing.classList.remove('hover');
      });
      el.addEventListener('mousedown', function() {
        cursorRing.classList.add('click');
        setTimeout(() => cursorRing.classList.remove('click'), 200);
      });
    });

    document.addEventListener('mouseleave', function() {
      cursorDot.style.opacity = '0';
      cursorRing.style.opacity = '0';
    });
    document.addEventListener('mouseenter', function() {
      cursorDot.style.opacity = '1';
      cursorRing.style.opacity = '1';
    });
  }

  // ========================================================================
  // 3. NAVBAR — Mobile Menu
  // ========================================================================
  const navToggle = document.getElementById('navToggle');
  const navClose = document.getElementById('navCloseBtn');
  const navMenu = document.getElementById('navMenu');
  const body = document.body;

  function openNav() {
    navMenu.classList.add('show');
    navToggle.setAttribute('aria-expanded', 'true');
    body.classList.add('nav-open');
    navToggle.innerHTML = '<i class="bi bi-x-lg"></i>';
  }

  function closeNav() {
    navMenu.classList.remove('show');
    navToggle.setAttribute('aria-expanded', 'false');
    body.classList.remove('nav-open');
    navToggle.innerHTML = '<i class="bi bi-list"></i>';
  }

  if (navToggle && navMenu) {
    navToggle.addEventListener('click', function() {
      if (navMenu.classList.contains('show')) {
        closeNav();
      } else {
        openNav();
      }
    });

    if (navClose) {
      navClose.addEventListener('click', closeNav);
    }

    // Close on link click
    const navLinks = navMenu.querySelectorAll('.nav-link-custom');
    navLinks.forEach(link => {
      link.addEventListener('click', closeNav);
    });

    // Close on outside click (overlay)
    navMenu.addEventListener('click', function(e) {
      if (e.target === navMenu) {
        closeNav();
      }
    });

    // Close on Escape key
    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape' && navMenu.classList.contains('show')) {
        closeNav();
      }
    });
  }

  // ========================================================================
  // 4. NAVBAR — Scroll & Active State
  // ========================================================================
  const navbar = document.getElementById('navbar');
  const navLinks = document.querySelectorAll('[data-nav-link]');
  const sections = document.querySelectorAll('section[id]');

  window.addEventListener('scroll', function() {
    const currentScroll = window.pageYOffset || document.documentElement.scrollTop;
    if (currentScroll > 60) {
      navbar.classList.add('is-scrolled');
    } else {
      navbar.classList.remove('is-scrolled');
    }
  }, { passive: true });

  function updateActiveLink() {
    const scrollPos = window.pageYOffset + 120;

    sections.forEach(section => {
      const sectionTop = section.offsetTop;
      const sectionBottom = sectionTop + section.offsetHeight;
      const id = section.getAttribute('id');

      if (scrollPos >= sectionTop && scrollPos < sectionBottom) {
        navLinks.forEach(link => {
          link.classList.remove('is-active');
          if (link.getAttribute('href') === '#' + id) {
            link.classList.add('is-active');
          }
        });
      }
    });
  }

  window.addEventListener('scroll', updateActiveLink, { passive: true });
  window.addEventListener('resize', updateActiveLink, { passive: true });
  updateActiveLink();

  // Smooth scroll for nav links
  navLinks.forEach(link => {
    link.addEventListener('click', function(e) {
      const href = this.getAttribute('href');
      if (href && href.startsWith('#')) {
        e.preventDefault();
        const targetId = href.substring(1);
        const target = document.getElementById(targetId);
        if (target) {
          const offsetTop = target.offsetTop - 70;
          window.scrollTo({ top: offsetTop, behavior: 'smooth' });
        }
      }
    });
  });

  // ========================================================================
  // 5. HERO CODE PANEL ANIMATION
  // ========================================================================
  const codePanel = document.getElementById('heroCodePanel');
  if (codePanel) {
    setTimeout(function() {
      codePanel.classList.add('is-loaded');
    }, 400);
  }

  // ========================================================================
  // 6. PROJECT FILTERS
  // ========================================================================
  const filterBtns = document.querySelectorAll('.filter-btn');
  const projectCards = document.querySelectorAll('.project-card');
  const emptyState = document.getElementById('projectsEmptyState');

  if (filterBtns.length > 0) {
    filterBtns.forEach(btn => {
      btn.addEventListener('click', function() {
        filterBtns.forEach(b => {
          b.classList.remove('active');
          b.setAttribute('aria-pressed', 'false');
        });
        this.classList.add('active');
        this.setAttribute('aria-pressed', 'true');

        const filter = this.getAttribute('data-filter');
        let visibleCount = 0;

        projectCards.forEach(card => {
          const categories = card.getAttribute('data-category') || '';
          const match = filter === 'all' || categories.includes(filter);

          if (match) {
            card.classList.remove('is-filtered-out');
            visibleCount++;
            if (typeof AOS !== 'undefined') {
              card.removeAttribute('data-aos');
              card.setAttribute('data-aos', 'fade-up');
              AOS.refresh();
            }
          } else {
            card.classList.add('is-filtered-out');
          }
        });

        if (emptyState) {
          emptyState.hidden = visibleCount > 0;
        }
      });
    });
  }

  // ========================================================================
  // 7. TYPING EFFECT FOR HERO STATUS
  // ========================================================================
  const statusText = document.getElementById('heroStatusText');
  if (statusText) {
    const fullText = statusText.getAttribute('data-full-text') || 'status --open-to-work';
    statusText.textContent = '';
    let charIndex = 0;

    function typeCharacter() {
      if (charIndex < fullText.length) {
        statusText.textContent += fullText.charAt(charIndex);
        charIndex++;
        setTimeout(typeCharacter, 80 + Math.random() * 40);
      } else {
        statusText.style.borderRight = 'none';
      }
    }

    setTimeout(typeCharacter, 1200);
  }

  // ========================================================================
  // 8. DYNAMIC FOOTER YEAR
  // ========================================================================
  const yearSpan = document.getElementById('footerYear');
  if (yearSpan) {
    yearSpan.textContent = new Date().getFullYear();
  }

  // ========================================================================
  // 9. PARALLAX EFFECT ON HERO
  // ========================================================================
  const heroGrid = document.querySelector('.hero-grid');
  if (heroGrid && window.innerWidth > 991) {
    window.addEventListener('scroll', function() {
      const heroSection = document.querySelector('.hero-section');
      if (heroSection) {
        const rect = heroSection.getBoundingClientRect();
        if (rect.top < window.innerHeight && rect.bottom > 0) {
          const scrollY = window.pageYOffset;
          const offset = Math.min(scrollY * 0.08, 60);
          heroGrid.style.transform = `translateY(${offset * 0.3}px)`;
        }
      }
    }, { passive: true });
  }

  // ========================================================================
  // 10. RESIZE HANDLER
  // ========================================================================
  let resizeTimer;
  window.addEventListener('resize', function() {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(function() {
      if (typeof AOS !== 'undefined') {
        AOS.refresh();
      }
      if (window.innerWidth < 992) {
        if (cursorDot) cursorDot.style.display = 'none';
        if (cursorRing) cursorRing.style.display = 'none';
        document.body.style.cursor = 'auto';
        // Close mobile nav if open
        if (navMenu && navMenu.classList.contains('show')) {
          closeNav();
        }
      } else {
        if (cursorDot) cursorDot.style.display = 'block';
        if (cursorRing) cursorRing.style.display = 'block';
        document.body.style.cursor = 'none';
        if (navMenu) navMenu.classList.remove('show');
      }
    }, 250);
  });

  // ========================================================================
  // 11. KEYBOARD ACCESSIBILITY
  // ========================================================================
  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
      const openModals = document.querySelectorAll('.modal.show');
      openModals.forEach(modal => {
        const closeBtn = modal.querySelector('.btn-close');
        if (closeBtn) closeBtn.click();
      });
    }
  });

  // ========================================================================
  // 12. INTERSECTION OBSERVER
  // ========================================================================
  if ('IntersectionObserver' in window) {
    const animateElements = document.querySelectorAll('.project-card, .build-card, .education-card, .meta-card');
    
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.style.opacity = '1';
          entry.target.style.transform = 'translateY(0)';
        }
      });
    }, {
      threshold: 0.1,
      rootMargin: '0px 0px -50px 0px'
    });

    animateElements.forEach(el => {
      if (!el.hasAttribute('data-aos')) {
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(el);
      }
    });
  }

  console.log('🚀 Ahmad Raza — Portfolio loaded successfully!');
  console.log('💼 Laravel & Full-Stack Developer');
});