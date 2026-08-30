<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Muhammad Ahmad Raza | Laravel Developer</title>
  <meta name="description" content="Laravel Developer with 3+ years of hands-on web development experience, including 2+ years of practical Laravel development. Building eCommerce, POS & inventory, project management, and CMS applications with Laravel, PHP, MySQL, and REST APIs.">

  <!-- Canonical -->
  <link rel="canonical" href="https://ahmadrazadev.com">

  <!-- Open Graph -->
  <meta property="og:title" content="Muhammad Ahmad Raza | Laravel Developer">
  <meta property="og:description" content="Laravel Developer with 3+ years of hands-on web development experience, including 2+ years of practical Laravel development. Available immediately for remote, hybrid, or on-site roles.">
  <meta property="og:type" content="website">
  <meta property="og:url" content="https://ahmadrazadev.com">
  <meta property="og:image" content="{{asset('portfolio/images/og-image.jpg')}}">

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="{{asset('portfolio/images/favicon.ico')}}">

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

  <!-- AOS Animation CSS -->
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

  <!-- Site styles -->
  <link rel="stylesheet" href="{{asset('portfolio/css/style.css')}}">

  <!-- JSON-LD Structured Data -->
  <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Person",
      "name": "Muhammad Ahmad Raza",
      "jobTitle": "Laravel Developer",
      "url": "https://ahmadrazadev.com",
      "sameAs": [
        "https://github.com/ahmadraza348",
        "https://linkedin.com/in/ahmadraza348"
      ]
    }
  </script>
</head>
<body>

  <!-- ============================================
       CUSTOM CURSOR
  ============================================ -->
  <div class="cursor-dot" id="cursorDot"></div>
  <div class="cursor-ring" id="cursorRing"></div>

  <!-- ============================================
       NAVBAR
  ============================================ -->
  <nav id="navbar" class="navbar-custom" aria-label="Primary">
    <div class="navbar-inner container-narrow">

      <a href="#hero" class="navbar-brand-custom" aria-label="Ahmad Raza — home">
        <img src="{{asset('portfolio/images/logo-light.png')}}" style="width: 60px; height: auto;" alt="Ahmad Raza Logo">
      </a>

      <button
        class="navbar-toggler-custom"
        id="navToggle"
        type="button"
        aria-expanded="false"
        aria-label="Toggle navigation menu"
      >
        <i class="bi bi-list" aria-hidden="true"></i>
      </button>

      <div class="navbar-collapse-custom" id="navMenu">
        <!-- Mobile Close Button -->
        <button class="nav-close-btn" id="navCloseBtn" aria-label="Close menu">
          <i class="bi bi-x-lg"></i>
        </button>

        <ul class="navbar-links">
          <li><a href="#hero" class="nav-link-custom" data-nav-link>Home</a></li>
          <li><a href="#about" class="nav-link-custom" data-nav-link>About</a></li>
          <li><a href="#skills" class="nav-link-custom" data-nav-link>Skills</a></li>
          <li><a href="#projects" class="nav-link-custom" data-nav-link>Projects</a></li>
          <li><a href="#experience" class="nav-link-custom" data-nav-link>Experience</a></li>
          <li><a href="#education" class="nav-link-custom" data-nav-link>Education</a></li>
          <li><a href="#cv" class="nav-link-custom" data-nav-link>CV</a></li>
          <li><a href="#contact" class="nav-link-custom" data-nav-link>Contact</a></li>
        </ul>

        <a
          href="{{asset('portfolio/Ahmad-Raza-Laravel-Resume.pdf')}}"
          class="btn-cta-nav mono"
          download
        >
          <i class="bi bi-download" aria-hidden="true"></i>
          Download CV
        </a>

        <!-- Mobile Social Links -->
        <div class="mobile-socials">
          <a href="https://github.com/ahmadraza348/" target="_blank" rel="noopener" aria-label="GitHub">
            <i class="bi bi-github"></i>
          </a>
          <a href="https://linkedin.com/in/ahmadraza348/" target="_blank" rel="noopener" aria-label="LinkedIn">
            <i class="bi bi-linkedin"></i>
          </a>
          <a href="mailto:engr.ahmadraza348@gmail.com" aria-label="Email">
            <i class="bi bi-envelope"></i>
          </a>
        </div>
      </div>

    </div>
  </nav>

  <main>

    <!-- ============================================
         01 // HERO
    ============================================ -->
    <section id="hero" class="section hero-section">
      <div class="hero-bg-grid" aria-hidden="true"></div>

      <!-- Animated particles background -->
      <div class="particles-container" id="particlesContainer"></div>

      <div class="container-narrow hero-grid">

        <div class="hero-content" data-aos="fade-right" data-aos-duration="1000">
          <p class="hero-eyebrow mono">Hi, I&rsquo;m</p>
          <h1 class="hero-name">Muhammad Ahmad Raza</h1>
          <h2 class="hero-role">Laravel Developer</h2>
          <p class="hero-tagline mono">PHP &middot; MySQL &middot; REST APIs</p>
          <p class="hero-desc">
            Building practical Laravel web applications, eCommerce platforms,
            POS &amp; inventory systems, REST APIs, and business software.
            Available immediately for remote, hybrid, or on-site roles.
          </p>

          <div class="hero-actions">
            <a href="#projects" class="btn-hero btn-hero-primary" data-nav-link-scroll>View My Work</a>
            <a href="{{asset('portfolio/Ahmad-Raza-Laravel-Resume.pdf')}}" target="_blank" rel="noopener" class="btn-hero btn-hero-outline">View CV</a>
          </div>

          <div class="hero-socials">
            <a href="https://github.com/ahmadraza348/" target="_blank" rel="noopener" aria-label="GitHub" class="hero-social-link">
              <i class="bi bi-github" aria-hidden="true"></i>
            </a>
            <a href="https://linkedin.com/in/ahmadraza348/" target="_blank" rel="noopener" aria-label="LinkedIn" class="hero-social-link">
              <i class="bi bi-linkedin" aria-hidden="true"></i>
            </a>
            <a href="mailto:engr.ahmadraza348@gmail.com" aria-label="Email" class="hero-social-link">
              <i class="bi bi-envelope" aria-hidden="true"></i>
            </a>
          </div>
        </div>

        <div class="hero-panel-wrap" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">
          <div class="code-panel" id="heroCodePanel">
            <div class="code-panel-header">
              <div class="code-panel-dots" aria-hidden="true">
                <span></span><span></span><span></span>
              </div>
              <span class="code-panel-filename mono">developer.js</span>
              <span class="code-panel-status mono">
                <span class="status-pulse" aria-hidden="true"></span>online
              </span>
            </div>

            <div class="code-panel-body mono">
              <div class="code-line"><span class="line-no">1</span><span class="code-content"><span class="tok-keyword">const</span> developer = {</span></div>
              <div class="code-line"><span class="line-no">2</span><span class="code-content">&nbsp;&nbsp;name: <span class="tok-string">"Muhammad Ahmad Raza"</span>,</span></div>
              <div class="code-line"><span class="line-no">3</span><span class="code-content">&nbsp;&nbsp;role: <span class="tok-string">"Laravel Developer"</span>,</span></div>
              <div class="code-line"><span class="line-no">4</span><span class="code-content">&nbsp;&nbsp;experience: <span class="tok-string">"3+ Yrs Web Dev (2+ Laravel)"</span>,</span></div>
              <div class="code-line"><span class="line-no">5</span><span class="code-content">&nbsp;&nbsp;stack: [<span class="tok-string">"PHP"</span>, <span class="tok-string">"Laravel"</span>, <span class="tok-string">"MySQL"</span>],</span></div>
              <div class="code-line"><span class="line-no">6</span><span class="code-content">&nbsp;&nbsp;focus: <span class="tok-string">"Business Applications"</span></span></div>
              <div class="code-line"><span class="line-no">7</span><span class="code-content">};</span></div>
            </div>

            <div class="code-panel-footer mono">
              <span class="prompt-symbol" aria-hidden="true">$</span>
              <span id="heroStatusText" class="hero-status-text" data-full-text="status --open-to-work"></span><span class="cursor-blink" aria-hidden="true"></span>
            </div>
          </div>
        </div>

      </div>
    </section>

    <!-- ============================================
         02 // ABOUT
    ============================================ -->
    <section id="about" class="section about-section">
      <div class="container-narrow">

        <div class="about-grid">
          <div class="about-text" data-aos="fade-right" data-aos-duration="800">
            <h2>Building practical software that lasts.</h2>
            <p>
              Laravel Developer with 3+ years of hands-on web development experience, including
              2+ years of practical Laravel development through professional work and independent
              projects. I build eCommerce platforms, POS &amp; inventory systems, project management
              tools, and CMS applications — from database design and backend logic to APIs,
              frontend integration, and production deployment.
            </p>
            <p>
              With experience in both professional and independent development, I focus on
              delivering clean, maintainable, and functional systems. Available immediately for
              remote, hybrid, or on-site roles.
            </p>
          </div>

          <div class="about-meta-grid" data-aos="fade-left" data-aos-duration="800" data-aos-delay="100">
            <div class="meta-card">
              <span class="meta-label mono">Web Dev Experience</span>
              <span class="meta-value">3+ Years</span>
            </div>
            <div class="meta-card">
              <span class="meta-label mono">Laravel Experience</span>
              <span class="meta-value">2+ Years</span>
            </div>
            <div class="meta-card">
              <span class="meta-label mono">Backend</span>
              <span class="meta-value">PHP / MySQL</span>
            </div>
            <div class="meta-card">
              <span class="meta-label mono">Frontend</span>
              <span class="meta-value">Blade / Basic React</span>
            </div>
            <div class="meta-card">
              <span class="meta-label mono">APIs</span>
              <span class="meta-value">REST / Sanctum</span>
            </div>
            <div class="meta-card">
              <span class="meta-label mono">Deployment</span>
              <span class="meta-value">Hostinger / cPanel</span>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ============================================
         03 // SKILLS (Restructured)
    ============================================ -->
    <section id="skills" class="section skills-section">
      <div class="container-narrow">
        <h2 data-aos="fade-up" data-aos-delay="50">Technical Skills</h2>
        <p class="skills-intro" data-aos="fade-up" data-aos-delay="100">
          Laravel and PHP anchor everything I build, with supporting frontend and deployment skills.
        </p>

        <div class="skills-tabs-wrap" data-aos="fade-up" data-aos-delay="150">
          <div class="skills-tab-scroll">
            <ul class="skills-tab-list" id="skillsTab" role="tablist">
              <li role="presentation">
                <button class="skills-tab-btn mono is-emphasis active" id="tab-laravel" data-bs-toggle="tab" data-bs-target="#panel-laravel" type="button" role="tab" aria-controls="panel-laravel" aria-selected="true">
                  <i class="bi bi-lightning-charge" aria-hidden="true"></i> Laravel
                </button>
              </li>
              <li role="presentation">
                <button class="skills-tab-btn mono" id="tab-backend" data-bs-toggle="tab" data-bs-target="#panel-backend" type="button" role="tab" aria-controls="panel-backend" aria-selected="false">
                  <i class="bi bi-hdd-stack" aria-hidden="true"></i> Backend
                </button>
              </li>
              <li role="presentation">
                <button class="skills-tab-btn mono" id="tab-frontend" data-bs-toggle="tab" data-bs-target="#panel-frontend" type="button" role="tab" aria-controls="panel-frontend" aria-selected="false">
                  <i class="bi bi-window" aria-hidden="true"></i> Frontend
                </button>
              </li>
              <li role="presentation">
                <button class="skills-tab-btn mono" id="tab-api" data-bs-toggle="tab" data-bs-target="#panel-api" type="button" role="tab" aria-controls="panel-api" aria-selected="false">
                  <i class="bi bi-diagram-2" aria-hidden="true"></i> APIs &amp; Integrations
                </button>
              </li>
              <li role="presentation">
                <button class="skills-tab-btn mono" id="tab-testing" data-bs-toggle="tab" data-bs-target="#panel-testing" type="button" role="tab" aria-controls="panel-testing" aria-selected="false">
                  <i class="bi bi-bug" aria-hidden="true"></i> Testing &amp; Debugging
                </button>
              </li>
              <li role="presentation">
                <button class="skills-tab-btn mono" id="tab-packages" data-bs-toggle="tab" data-bs-target="#panel-packages" type="button" role="tab" aria-controls="panel-packages" aria-selected="false">
                  <i class="bi bi-box-seam" aria-hidden="true"></i> Packages
                </button>
              </li>
              <li role="presentation">
                <button class="skills-tab-btn mono" id="tab-devops" data-bs-toggle="tab" data-bs-target="#panel-devops" type="button" role="tab" aria-controls="panel-devops" aria-selected="false">
                  <i class="bi bi-gear" aria-hidden="true"></i> Deployment &amp; Tools
                </button>
              </li>
              <li role="presentation">
                <button class="skills-tab-btn mono" id="tab-seo" data-bs-toggle="tab" data-bs-target="#panel-seo" type="button" role="tab" aria-controls="panel-seo" aria-selected="false">
                  <i class="bi bi-graph-up-arrow" aria-hidden="true"></i> SEO &amp; Analytics
                </button>
              </li>
              <li role="presentation">
                <button class="skills-tab-btn mono" id="tab-methodologies" data-bs-toggle="tab" data-bs-target="#panel-methodologies" type="button" role="tab" aria-controls="panel-methodologies" aria-selected="false">
                  <i class="bi bi-diagram-3" aria-hidden="true"></i> Methodologies
                </button>
              </li>
              <li role="presentation">
                <button class="skills-tab-btn mono" id="tab-additional" data-bs-toggle="tab" data-bs-target="#panel-additional" type="button" role="tab" aria-controls="panel-additional" aria-selected="false">
                  <i class="bi bi-palette2" aria-hidden="true"></i> Additional
                </button>
              </li>
            </ul>
          </div>

          <div class="tab-content skills-tab-content" id="skillsTabContent">

            <!-- Laravel -->
            <div class="tab-pane fade show active" id="panel-laravel" role="tabpanel" aria-labelledby="tab-laravel">
              <div class="skills-tags">
                <span class="skill-tag tag-emphasis">Routing</span>
                <span class="skill-tag tag-emphasis">Middleware</span>
                <span class="skill-tag tag-emphasis">Authentication</span>
                <span class="skill-tag tag-emphasis">Authorization (RBAC)</span>
                <span class="skill-tag tag-emphasis">Policies &amp; Guards</span>
                <span class="skill-tag tag-emphasis">Validation</span>
                <span class="skill-tag tag-emphasis">Eloquent ORM</span>
                <span class="skill-tag tag-emphasis">Relationships</span>
                <span class="skill-tag tag-emphasis">Migrations &amp; Seeders</span>
                <span class="skill-tag tag-emphasis">Service Container</span>
                <span class="skill-tag tag-emphasis">Dependency Injection</span>
                <span class="skill-tag tag-emphasis">Repository Pattern</span>
                <span class="skill-tag tag-emphasis">SOLID Principles</span>
                <span class="skill-tag tag-emphasis">Accessors &amp; Mutators</span>
                <span class="skill-tag tag-emphasis">Blade Templates</span>
                <span class="skill-tag tag-emphasis">Testing</span>
              </div>
            </div>

            <!-- Backend -->
            <div class="tab-pane fade" id="panel-backend" role="tabpanel" aria-labelledby="tab-backend">
              <div class="skills-tags">
                <span class="skill-tag">PHP (OOP, Core PHP)</span>
                <span class="skill-tag">Laravel (v8–12)</span>
                <span class="skill-tag">MySQL</span>
                <span class="skill-tag">Eloquent ORM</span>
                <span class="skill-tag">Query Builder</span>
                <span class="skill-tag">MVC Architecture</span>
                <span class="skill-tag">Database Transactions</span>
                <span class="skill-tag">Factories</span>
                <span class="skill-tag">Eager Loading</span>
                <span class="skill-tag">N+1 Query Resolution</span>
                <span class="skill-tag">Soft Deletes</span>
                <span class="skill-tag">Query Optimization</span>
                <span class="skill-tag">Form Request Classes</span>
                <span class="skill-tag">Ajax</span>
                <span class="skill-tag">Service Classes</span>
                <span class="skill-tag">Separation of Concerns</span>
              </div>
            </div>

            <!-- Frontend -->
            <div class="tab-pane fade" id="panel-frontend" role="tabpanel" aria-labelledby="tab-frontend">
              <div class="skills-tags">
                <span class="skill-tag">HTML5</span>
                <span class="skill-tag">CSS3</span>
                <span class="skill-tag">Bootstrap</span>
                <span class="skill-tag">Blade</span>
                <span class="skill-tag">jQuery</span>
                <span class="skill-tag">Basic JavaScript</span>
                <span class="skill-tag">React.js (Basic)</span>
                <span class="skill-tag">API Integration</span>
              </div>
            </div>

            <!-- APIs & Integrations -->
            <div class="tab-pane fade" id="panel-api" role="tabpanel" aria-labelledby="tab-api">
              <div class="skills-tags">
                <span class="skill-tag">RESTful API Design</span>
                <span class="skill-tag">Postman</span>
                <span class="skill-tag">API Resource Controllers</span>
                <span class="skill-tag">Laravel Sanctum</span>
                <span class="skill-tag">Laravel Passport</span>
                <span class="skill-tag">Rate Limiting</span>
                <span class="skill-tag">Stripe Payment Integration</span>
                <span class="skill-tag">Email &amp; Notifications</span>
                <span class="skill-tag">File Storage</span>
              </div>
            </div>

            <!-- Testing & Debugging -->
            <div class="tab-pane fade" id="panel-testing" role="tabpanel" aria-labelledby="tab-testing">
              <div class="skills-tags">
                <span class="skill-tag">PHPUnit</span>
                <span class="skill-tag">Tinker</span>
                <span class="skill-tag">Log Analysis</span>
                <span class="skill-tag">Browser DevTools</span>
                <span class="skill-tag">Exception Handling</span>
                <span class="skill-tag">Production Troubleshooting</span>
              </div>
            </div>

            <!-- Packages -->
            <div class="tab-pane fade" id="panel-packages" role="tabpanel" aria-labelledby="tab-packages">
              <div class="skills-tags">
                <span class="skill-tag">Laravel Breeze</span>
                <span class="skill-tag">Sanctum</span>
                <span class="skill-tag">Passport</span>
                <span class="skill-tag">Spatie Permission</span>
                <span class="skill-tag">Laravel Excel</span>
                <span class="skill-tag">Laravel Livewire</span>
                <span class="skill-tag">Laravel Scout</span>
                <span class="skill-tag">Laravel Reverb</span>
                <span class="skill-tag">Intervention Image</span>
                <span class="skill-tag">Stripe PHP</span>
              </div>
            </div>

            <!-- Deployment & Tools -->
            <div class="tab-pane fade" id="panel-devops" role="tabpanel" aria-labelledby="tab-devops">
              <div class="skills-tags">
                <span class="skill-tag">Git</span>
                <span class="skill-tag">GitHub</span>
                <span class="skill-tag">CI/CD</span>
                <span class="skill-tag">SSH</span>
                <span class="skill-tag">Composer</span>
                <span class="skill-tag">Hostinger</span>
                <span class="skill-tag">cPanel</span>
                <span class="skill-tag">Domain / DNS</span>
                <span class="skill-tag">Production Deployment</span>
                <span class="skill-tag">Environment Configuration</span>
                <span class="skill-tag">Cron Jobs</span>
              </div>
            </div>

            <!-- SEO & Analytics -->
            <div class="tab-pane fade" id="panel-seo" role="tabpanel" aria-labelledby="tab-seo">
              <div class="skills-tags">
                <span class="skill-tag">Technical SEO</span>
                <span class="skill-tag">On-page SEO</span>
                <span class="skill-tag">SEO based content writing</span>
                <span class="skill-tag">Google Analytics</span>
                <span class="skill-tag">Google Search Console</span>
                <span class="skill-tag">Google Tag Manager</span>
                <span class="skill-tag">Facebook Pixel</span>
                <span class="skill-tag">Performance Optimization</span>
              </div>
            </div>

            <!-- Methodologies -->
            <div class="tab-pane fade" id="panel-methodologies" role="tabpanel" aria-labelledby="tab-methodologies">
              <div class="skills-tags">
                <span class="skill-tag">Agile</span>
                <span class="skill-tag">Scrum</span>
                <span class="skill-tag">SDLC</span>
              </div>
            </div>

            <!-- Additional -->
            <div class="tab-pane fade" id="panel-additional" role="tabpanel" aria-labelledby="tab-additional">
              <div class="skills-tags">
                <span class="skill-tag">WordPress</span>
                <span class="skill-tag">Shopify</span>
                <span class="skill-tag">Basic Design (Canva & Photoshop)</span>
              </div>
            </div>

          </div>
        </div>
      </div>
    </section>

    <!-- ============================================
         04 // PROJECTS (Reordered & Updated)
    ============================================ -->
    <section id="projects" class="section projects-section">
      <div class="container-narrow">
        <h2 data-aos="fade-up" data-aos-delay="50">Projects</h2>
        <p class="skills-intro" data-aos="fade-up" data-aos-delay="100">
          Personal projects, client work, and ongoing business systems.
        </p>

        <div class="project-filters mono" role="group" aria-label="Filter projects by category" data-aos="fade-up" data-aos-delay="150">
          <button class="filter-btn active" data-filter="all" aria-pressed="true">All</button>
          <button class="filter-btn" data-filter="laravel" aria-pressed="false">Laravel</button>
          <button class="filter-btn" data-filter="ecommerce" aria-pressed="false">E-commerce</button>
          <button class="filter-btn" data-filter="business" aria-pressed="false">Business</button>
          <button class="filter-btn" data-filter="react" aria-pressed="false">React</button>
          <button class="filter-btn" data-filter="client" aria-pressed="false">Client</button>
          <button class="filter-btn" data-filter="personal" aria-pressed="false">Personal</button>
        </div>

        <div class="projects-grid" id="projectsGrid">

          <!-- ===== PRIMARY 1: E-Commerce Platform ===== -->
          <article class="project-card" data-category="laravel ecommerce personal" data-aos="fade-up" data-aos-delay="100">
            <button type="button" class="project-thumb" data-bs-toggle="modal" data-bs-target="#modal-project-2" aria-label="View details for E-Commerce Platform">
              <span class="project-thumb-index mono">01</span>
              <img src="{{asset('portfolio/images/ecommerce.png')}}" alt="E-Commerce Platform screenshot" class="project-thumb-img">
              <span class="project-thumb-overlay">
                <span class="project-thumb-cta mono">View Details <i class="bi bi-arrow-up-right" aria-hidden="true"></i></span>
              </span>
            </button>
            <div class="project-card-body">
              <span class="project-card-category mono">Independent Project &middot; Deployed</span>
              <h3 class="project-card-title">E-Commerce Platform</h3>
              <p class="project-card-desc">Built a complete Laravel online store with dynamic product variants and attributes, cart and coupon workflows, order processing, and automated stock updates using database locking, queues, and real-time features.</p>
              <div class="project-card-tech">
                <span class="skill-tag">Laravel</span>
                <span class="skill-tag">PHP</span>
                <span class="skill-tag">MySQL</span>
                <span class="skill-tag">Stripe</span>
                <span class="skill-tag">Reverb</span>
              </div>
              <div class="project-card-links">
                <a href="https://ecommerce.ahmadrazadev.com" target="_blank" rel="noopener" class="project-link mono">Live Demo <i class="bi bi-box-arrow-up-right" aria-hidden="true"></i></a>
              </div>
            </div>
          </article>

          <!-- ===== PRIMARY 2: POS & Inventory ===== -->
          <article class="project-card" data-category="laravel business personal" data-aos="fade-up" data-aos-delay="150">
            <button type="button" class="project-thumb" data-bs-toggle="modal" data-bs-target="#modal-project-1" aria-label="View details for POS & Inventory System">
              <span class="project-thumb-index mono">02</span>
              <img src="{{asset('portfolio/images/pos.png')}}" alt="POS & Inventory System screenshot" class="project-thumb-img">
              <span class="project-thumb-overlay">
                <span class="project-thumb-cta mono">View Details <i class="bi bi-arrow-up-right" aria-hidden="true"></i></span>
              </span>
            </button>
            <div class="project-card-body">
              <span class="project-card-category mono">Independent Project &middot; Deployed</span>
              <h3 class="project-card-title">POS &amp; Inventory System</h3>
              <p class="project-card-desc">Developed a Laravel-based POS and inventory management system covering suppliers, purchases, sales management, automatic stock tracking, profit-margin-based pricing, role-based access control, and sales, purchase, inventory, and profit reporting.</p>
              <div class="project-card-tech">
                <span class="skill-tag">Laravel</span>
                <span class="skill-tag">PHP</span>
                <span class="skill-tag">MySQL</span>
              </div>
              <div class="project-card-links">
                <a href="https://ahmadrazadev.com/admin/dashboard" target="_blank" rel="noopener" class="project-link mono">Live Demo <i class="bi bi-box-arrow-up-right" aria-hidden="true"></i></a>
              </div>
            </div>
          </article>

          <!-- ===== PRIMARY 3: Project Management System ===== -->
          <article class="project-card" data-category="laravel business personal" data-aos="fade-up" data-aos-delay="175">
            <button type="button" class="project-thumb" data-bs-toggle="modal" data-bs-target="#modal-project-8" aria-label="View details for Project Management System">
              <span class="project-thumb-index mono">03</span>
              <i class="bi bi-kanban project-thumb-icon" aria-hidden="true"></i>
              <span class="project-thumb-overlay">
                <span class="project-thumb-cta mono">View Details <i class="bi bi-arrow-up-right" aria-hidden="true"></i></span>
              </span>
            </button>
            <div class="project-card-body">
              <span class="project-card-category mono">Independent Project &middot; Repository</span>
              <h3 class="project-card-title">Project Management System</h3>
              <p class="project-card-desc">Built a multi-user Laravel project management platform with role-based dashboards (Admin, Manager, Member) for task assignment, commenting, and reporting; currently converting the CRUD modules into RESTful APIs with Laravel Passport.</p>
              <div class="project-card-tech">
                <span class="skill-tag">Laravel</span>
                <span class="skill-tag">Passport</span>
                <span class="skill-tag">PHPUnit</span>
              </div>
              <div class="project-card-links">
                <a href="https://github.com/ahmadraza348" target="_blank" rel="noopener" class="project-link mono">View Code <i class="bi bi-box-arrow-up-right" aria-hidden="true"></i></a>
              </div>
            </div>
          </article>

          <!-- ===== PRIMARY 4: Web Tech Tutorials ===== -->
          <article class="project-card" data-category="laravel personal" data-aos="fade-up" data-aos-delay="200">
            <button type="button" class="project-thumb" data-bs-toggle="modal" data-bs-target="#modal-project-3" aria-label="View details for Web Tech Tutorials">
              <span class="project-thumb-index mono">04</span>
              <img src="{{asset('portfolio/images/tutorials.png')}}" alt="Web Tech Tutorials screenshot" class="project-thumb-img">
              <span class="project-thumb-overlay">
                <span class="project-thumb-cta mono">View Details <i class="bi bi-arrow-up-right" aria-hidden="true"></i></span>
              </span>
            </button>
            <div class="project-card-body">
              <span class="project-card-category mono">Independent Project &middot; Deployed</span>
              <h3 class="project-card-title">Tutorials &amp; Learning Platform</h3>
              <p class="project-card-desc">Developed and deployed an SEO-focused educational platform with course management, content-adding tools, and a custom blog/CMS, built with Laravel Livewire — deployed on Hostinger.</p>
              <div class="project-card-tech">
                <span class="skill-tag">Laravel</span>
                <span class="skill-tag">Livewire</span>
                <span class="skill-tag">MySQL</span>
              </div>
              <div class="project-card-links">
                <a href="https://tutorials.ahmadrazadev.com" target="_blank" rel="noopener" class="project-link mono">Live Demo <i class="bi bi-box-arrow-up-right" aria-hidden="true"></i></a>
              </div>
            </div>
          </article>

          <!-- ===== PRIMARY 5: ImperialRide.ae (Client) ===== -->
          <article class="project-card" data-category="client" data-aos="fade-up" data-aos-delay="250">
            <button type="button" class="project-thumb" data-bs-toggle="modal" data-bs-target="#modal-project-6" aria-label="View details for ImperialRide.ae">
              <span class="project-thumb-index mono">05</span>
              <img src="{{asset('portfolio/images/ride.png')}}" alt="ImperialRide.ae screenshot" class="project-thumb-img">
              <span class="project-thumb-overlay">
                <span class="project-thumb-cta mono">View Details <i class="bi bi-arrow-up-right" aria-hidden="true"></i></span>
              </span>
            </button>
            <div class="project-card-body">
              <span class="project-card-category mono">Client Project &middot; Deployed</span>
              <h3 class="project-card-title">ImperialRide.ae</h3>
              <p class="project-card-desc">Designed the responsive frontend and contributed to backend modules for a UAE vehicle-booking platform, with a focus on booking flow, usability, and performance.</p>
              <div class="project-card-tech">
                <span class="skill-tag">PHP</span>
                <span class="skill-tag">JavaScript</span>
                <span class="skill-tag">Bootstrap</span>
              </div>
              <div class="project-card-links">
                <a href="https://imperialride.ae" target="_blank" rel="noopener" class="project-link mono">Live Demo <i class="bi bi-box-arrow-up-right" aria-hidden="true"></i></a>
              </div>
            </div>
          </article>

          <!-- ===== SECONDARY: Job Portal ===== -->
          <article class="project-card" data-category="laravel personal" data-aos="fade-up" data-aos-delay="100">
            <button type="button" class="project-thumb" data-bs-toggle="modal" data-bs-target="#modal-project-4" aria-label="View details for Job Portal">
              <span class="project-thumb-index mono">06</span>
              <i class="bi bi-briefcase project-thumb-icon" aria-hidden="true"></i>
              <span class="project-thumb-overlay">
                <span class="project-thumb-cta mono">View Details <i class="bi bi-arrow-up-right" aria-hidden="true"></i></span>
              </span>
            </button>
            <div class="project-card-body">
              <span class="project-card-category mono">Independent Project &middot; Completed</span>
              <h3 class="project-card-title">Job Portal</h3>
              <p class="project-card-desc">Job listing platform with authentication, job posting, search/filter, and admin management.</p>
              <div class="project-card-tech">
                <span class="skill-tag">Laravel</span>
                <span class="skill-tag">React.js</span>
                <span class="skill-tag">Sanctum</span>
              </div>
              <div class="project-card-links">
                <a href="https://github.com/ahmadraza348/job-portal" target="_blank" rel="noopener" class="project-link mono">View Code <i class="bi bi-box-arrow-up-right" aria-hidden="true"></i></a>
              </div>
            </div>
          </article>

          <!-- ===== SECONDARY: Construction Website ===== -->
          <article class="project-card" data-category="laravel react personal" data-aos="fade-up" data-aos-delay="150">
            <button type="button" class="project-thumb" data-bs-toggle="modal" data-bs-target="#modal-project-5" aria-label="View details for Construction Website">
              <span class="project-thumb-index mono">07</span>
              <i class="bi bi-building project-thumb-icon" aria-hidden="true"></i>
              <span class="project-thumb-overlay">
                <span class="project-thumb-cta mono">View Details <i class="bi bi-arrow-up-right" aria-hidden="true"></i></span>
              </span>
            </button>
            <div class="project-card-body">
              <span class="project-card-category mono">Independent Project &middot; Completed</span>
              <h3 class="project-card-title">Construction Website</h3>
              <p class="project-card-desc">Dynamic company site with Laravel backend, React frontend, and Sanctum-powered admin panel.</p>
              <div class="project-card-tech">
                <span class="skill-tag">Laravel</span>
                <span class="skill-tag">React.js</span>
                <span class="skill-tag">Sanctum</span>
              </div>
              <div class="project-card-links">
                <a href="https://github.com/ahmadraza348/construction" target="_blank" rel="noopener" class="project-link mono">View Code <i class="bi bi-box-arrow-up-right" aria-hidden="true"></i></a>
              </div>
            </div>
          </article>

          <!-- ===== SECONDARY: Art Portfolio (Client) ===== -->
          <article class="project-card" data-category="client" data-aos="fade-up" data-aos-delay="200">
            <button type="button" class="project-thumb" data-bs-toggle="modal" data-bs-target="#modal-project-7" aria-label="View details for Art Portfolio Website">
              <span class="project-thumb-index mono">08</span>
              <img src="{{asset('portfolio/images/baig.png')}}" alt="Art Portfolio screenshot" class="project-thumb-img">
              <span class="project-thumb-overlay">
                <span class="project-thumb-cta mono">View Details <i class="bi bi-arrow-up-right" aria-hidden="true"></i></span>
              </span>
            </button>
            <div class="project-card-body">
              <span class="project-card-category mono">Client Project &middot; Deployed</span>
              <h3 class="project-card-title">Art Portfolio Website</h3>
              <p class="project-card-desc">WordPress-based portfolio site for an artist — fully functional and customised.</p>
              <div class="project-card-tech">
                <span class="skill-tag">WordPress</span>
                <span class="skill-tag">CMS</span>
              </div>
              <div class="project-card-links">
                <a href="https://adnanbaig.pk" target="_blank" rel="noopener" class="project-link mono">Live Demo <i class="bi bi-box-arrow-up-right" aria-hidden="true"></i></a>
              </div>
            </div>
          </article>

        </div>

        <p class="projects-empty-state mono" id="projectsEmptyState" hidden>No projects match this filter yet.</p>
      </div>
    </section>

    <!-- ============================================
         PROJECT MODALS (Updated with My Role, Flows, etc.)
    ============================================ -->

    <!-- Modal 1: POS & Inventory -->
    <div class="modal fade project-modal" id="modal-project-1" tabindex="-1" aria-labelledby="modal-project-1-label" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modal-project-1-label">POS &amp; Inventory System</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="modal-thumb">
              <img src="{{asset('portfolio/images/pos.png')}}" alt="POS & Inventory System screenshot" class="modal-thumb-img">
            </div>
            <p class="modal-desc">
              A Laravel-based point-of-sale and inventory management system designed for small to medium businesses.
              This independent project demonstrates my ability to build complex business logic.
            </p>
            <div class="modal-section">
              <h6 class="modal-subheading">My Role</h6>
              <p>Independent Laravel development — full ownership of backend, database, and frontend.</p>
            </div>
            <div class="modal-section">
              <h6 class="modal-subheading">Business Flow</h6>
              <p><strong>Purchase → Stock Increase → Sale → Stock Reduction → Reporting</strong></p>
            </div>
            <div class="modal-section">
              <h6 class="modal-subheading">Key Features</h6>
              <ul class="modal-feature-list">
                <li>Product &amp; variant management</li>
                <li>Supplier &amp; purchase order management</li>
                <li>AJAX-driven sales &amp; POS interface</li>
                <li>Automatic, transaction-safe stock updates</li>
                <li>Profit-margin-based pricing</li>
                <li>Spatie Roles &amp; Permissions (role-based access control)</li>
                <li>Dynamic sales, purchase &amp; inventory reports</li>
              </ul>
            </div>
            <div class="modal-section">
              <h6 class="modal-subheading">Technical Implementation</h6>
              <p>
                Built with Laravel (MVC, Eloquent, relationships, migrations, seeders, authentication, authorization),
                MySQL, Blade, Bootstrap, and custom JavaScript. Implements complex database queries and business
                logic for inventory tracking and reporting.
              </p>
            </div>
            <div class="modal-section">
              <h6 class="modal-subheading">Stack</h6>
              <div class="skills-tags">
                <span class="skill-tag">Laravel</span>
                <span class="skill-tag">PHP</span>
                <span class="skill-tag">MySQL</span>
                <span class="skill-tag">AJAX</span>
                <span class="skill-tag">Database Transactions</span>
                <span class="skill-tag">Spatie Roles &amp; Permissions</span>
              </div>
            </div>
            <div class="modal-section">
              <h6 class="modal-subheading">Status</h6>
              <span class="badge bg-success text-dark">Deployed</span>
            </div>
            <div class="modal-section">
              <h6 class="modal-subheading">Live Demo</h6>
              <a href="https://ahmadrazadev.com/admin/dashboard" target="_blank" rel="noopener" class="btn btn-outline-light">Visit Site</a>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal 2: E-Commerce Platform -->
    <div class="modal fade project-modal" id="modal-project-2" tabindex="-1" aria-labelledby="modal-project-2-label" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modal-project-2-label">E-Commerce Platform</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="modal-thumb">
              <img src="{{asset('portfolio/images/ecommerce.png')}}" alt="E-Commerce Platform screenshot" class="modal-thumb-img">
            </div>
            <p class="modal-desc">
              A full-featured eCommerce platform built with Laravel, covering dynamic product variants and attributes, cart and coupon workflows, Stripe payment, order processing, automated stock updates, and notifications.
            </p>
            <div class="modal-section">
              <h6 class="modal-subheading">My Role</h6>
              <p>Full-stack Laravel development — backend, database, and frontend integration.</p>
            </div>
            <div class="modal-section">
              <h6 class="modal-subheading">Business Flow</h6>
              <p><strong>Cart → Checkout → Stripe Payment → Order → Inventory Update → Customer Email → Admin Notification</strong></p>
            </div>
            <div class="modal-section">
              <h6 class="modal-subheading">Key Features</h6>
              <ul class="modal-feature-list">
                <li>Product management with dynamic variants &amp; attributes</li>
                <li>Shopping cart, coupon &amp; checkout workflows</li>
                <li>Stripe payment integration</li>
                <li>Order processing &amp; status tracking</li>
                <li>Automated stock updates with database locking (lockForUpdate)</li>
                <li>Queues &amp; background jobs, real-time updates via Laravel Reverb</li>
                <li>Live search with Laravel Scout, AJAX filtering, rate limiting</li>
                <li>Admin dashboard with analytics</li>
                <li>Spatie Permissions-based role access (admin, staff, customer)</li>
                <li>Customer and admin email notifications</li>
              </ul>
            </div>
            <div class="modal-section">
              <h6 class="modal-subheading">Technical Implementation</h6>
              <p>
                Laravel backend with Eloquent relationships, authentication, middleware, validation, Stripe PHP SDK, database
                locking for stock-safe concurrent orders, queued jobs, and Laravel Reverb for real-time features.
                Frontend uses Blade with Bootstrap and AJAX for a responsive interface.
              </p>
            </div>
            <div class="modal-section">
              <h6 class="modal-subheading">Stack</h6>
              <div class="skills-tags">
                <span class="skill-tag">Laravel</span>
                <span class="skill-tag">PHP</span>
                <span class="skill-tag">MySQL</span>
                <span class="skill-tag">Blade</span>
                <span class="skill-tag">Bootstrap</span>
                <span class="skill-tag">Stripe API</span>
                <span class="skill-tag">Laravel Reverb</span>
                <span class="skill-tag">Laravel Scout</span>
                <span class="skill-tag">Spatie Permissions</span>
              </div>
            </div>
            <div class="modal-section">
              <h6 class="modal-subheading">Status</h6>
              <span class="badge bg-success text-dark">Deployed</span>
            </div>
            <div class="modal-section">
              <h6 class="modal-subheading">Live Demo</h6>
              <a href="https://ecommerce.ahmadrazadev.com" target="_blank" rel="noopener" class="btn btn-outline-light">Visit Site</a>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal 3: Web Tech Tutorials -->
    <div class="modal fade project-modal" id="modal-project-3" tabindex="-1" aria-labelledby="modal-project-3-label" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modal-project-3-label">Tutorials &amp; Learning Platform</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="modal-thumb">
              <img src="{{asset('portfolio/images/tutorials.png')}}" alt="Web Tech Tutorials screenshot" class="modal-thumb-img">
            </div>
            <p class="modal-desc">
              A learning platform combining course/tutorial management with a blog/CMS. Built with Laravel and Livewire, deployed on Hostinger.
            </p>
            <div class="modal-section">
              <h6 class="modal-subheading">My Role</h6>
              <p>Independent Laravel development — full stack, including SEO implementation.</p>
            </div>
            <div class="modal-section">
              <h6 class="modal-subheading">Key Features</h6>
              <ul class="modal-feature-list">
                <li>Course &amp; tutorial management with content-adding tools</li>
                <li>Blog / CMS with content management workflows</li>
                <li>Spatie Roles &amp; Permissions (admin, editor, user)</li>
                <li>SEO-friendly URLs and metadata</li>
                <li>Sitemap generation</li>
                <li>User authentication</li>
                <li>Admin dashboard for content management</li>
              </ul>
            </div>
            <div class="modal-section">
              <h6 class="modal-subheading">Technical Implementation</h6>
              <p>
                Laravel with Eloquent, relationships, authentication, Laravel Livewire for dynamic UI, Spatie Permission, Blade templates.
                Deployed on Hostinger with custom domain and SSL.
              </p>
            </div>
            <div class="modal-section">
              <h6 class="modal-subheading">Stack</h6>
              <div class="skills-tags">
                <span class="skill-tag">Laravel</span>
                <span class="skill-tag">Livewire</span>
                <span class="skill-tag">PHP</span>
                <span class="skill-tag">MySQL</span>
                <span class="skill-tag">Spatie Roles &amp; Permissions</span>
                <span class="skill-tag">SEO</span>
              </div>
            </div>
            <div class="modal-section">
              <h6 class="modal-subheading">Status</h6>
              <span class="badge bg-success text-dark">Deployed</span>
            </div>
            <div class="modal-section">
              <h6 class="modal-subheading">Live Demo</h6>
              <a href="https://tutorials.ahmadrazadev.com" target="_blank" rel="noopener" class="btn btn-outline-light">Visit Site</a>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal 4: Job Portal -->
    <div class="modal fade project-modal" id="modal-project-4" tabindex="-1" aria-labelledby="modal-project-4-label" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modal-project-4-label">Job Portal</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="modal-thumb">
              <i class="bi bi-briefcase" aria-hidden="true"></i>
            </div>
            <p class="modal-desc">
              A Laravel-powered job portal with authentication, job posting, search/filter, and admin management.
            </p>
            <div class="modal-section">
              <h6 class="modal-subheading">My Role</h6>
              <p>Independent full-stack development.</p>
            </div>
            <div class="modal-section">
              <h6 class="modal-subheading">Key Features</h6>
              <ul class="modal-feature-list">
                <li>Job posting &amp; management</li>
                <li>Search &amp; filter jobs</li>
                <li>User authentication (job seekers &amp; employers)</li>
                <li>Admin dashboard</li>
                <li>Database relationships (jobs, users, categories)</li>
              </ul>
            </div>
            <div class="modal-section">
              <h6 class="modal-subheading">Technical Implementation</h6>
              <p>Laravel with Eloquent, authentication, validation, and Blade.</p>
            </div>
            <div class="modal-section">
              <h6 class="modal-subheading">Stack</h6>
              <div class="skills-tags">
                <span class="skill-tag">Laravel</span>
                <span class="skill-tag">PHP</span>
                <span class="skill-tag">MySQL</span>
                <span class="skill-tag">Blade</span>
                <span class="skill-tag">Bootstrap</span>
              </div>
            </div>
            <div class="modal-section">
              <h6 class="modal-subheading">Status</h6>
              <span class="badge bg-success text-dark">Completed</span>
            </div>
            <div class="modal-section">
              <h6 class="modal-subheading">Visit Repository</h6>
              <a href="https://github.com/ahmadraza348/job-portal" target="_blank" rel="noopener" class="btn btn-outline-light">View Code</a>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal 5: Construction Website -->
    <div class="modal fade project-modal" id="modal-project-5" tabindex="-1" aria-labelledby="modal-project-5-label" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modal-project-5-label">Construction Website</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="modal-thumb">
              <i class="bi bi-building" aria-hidden="true"></i>
            </div>
            <p class="modal-desc">
              A dynamic company website with a Laravel backend, React frontend, and Sanctum-based authentication for the admin panel.
            </p>
            <div class="modal-section">
              <h6 class="modal-subheading">My Role</h6>
              <p>Independent full-stack development — Laravel API + React SPA.</p>
            </div>
            <div class="modal-section">
              <h6 class="modal-subheading">Key Features</h6>
              <ul class="modal-feature-list">
                <li>Laravel REST API backend</li>
                <li>React frontend (components, hooks)</li>
                <li>Sanctum authentication for admin</li>
                <li>Dynamic project &amp; blog content</li>
                <li>Admin panel for content management</li>
              </ul>
            </div>
            <div class="modal-section">
              <h6 class="modal-subheading">Technical Implementation</h6>
              <p>API-first architecture with Laravel Sanctum for token-based authentication. React consumes the API.</p>
            </div>
            <div class="modal-section">
              <h6 class="modal-subheading">Stack</h6>
              <div class="skills-tags">
                <span class="skill-tag">Laravel</span>
                <span class="skill-tag">React.js</span>
                <span class="skill-tag">Sanctum</span>
                <span class="skill-tag">MySQL</span>
              </div>
            </div>
            <div class="modal-section">
              <h6 class="modal-subheading">Visit Repository</h6>
              <a href="https://github.com/ahmadraza348/construction" target="_blank" rel="noopener" class="btn btn-outline-light">View Code</a>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal 6: ImperialRide.ae -->
    <div class="modal fade project-modal" id="modal-project-6" tabindex="-1" aria-labelledby="modal-project-6-label" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modal-project-6-label">ImperialRide.ae</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="modal-thumb">
              <img src="{{asset('portfolio/images/ride.png')}}" alt="ImperialRide.ae screenshot" class="modal-thumb-img">
            </div>
            <p class="modal-desc">
              A ride-booking platform for a UAE client. I designed and developed the frontend, improved the
              booking flow, and enhanced overall usability and performance.
            </p>
            <div class="modal-section">
              <h6 class="modal-subheading">My Role</h6>
              <ul class="modal-feature-list">
                <li>Frontend development from scratch</li>
                <li>Booking flow &amp; user experience improvements</li>
                <li>Responsive design &amp; cross-browser compatibility</li>
                <li>Performance optimisation</li>
                <li>Backend contribution (where applicable)</li>
              </ul>
            </div>
            <div class="modal-section">
              <h6 class="modal-subheading">Technical Implementation</h6>
              <p>
                Built with Laravel, PHP, JavaScript, and Bootstrap. Custom frontend for a smooth booking experience.
                Collaborated with backend team on API integration.
              </p>
            </div>
            <div class="modal-section">
              <h6 class="modal-subheading">Stack</h6>
              <div class="skills-tags">
                <span class="skill-tag">Laravel</span>
                <span class="skill-tag">PHP</span>
                <span class="skill-tag">MySQL</span>
                <span class="skill-tag">JavaScript</span>
                <span class="skill-tag">Bootstrap</span>
              </div>
            </div>
            <div class="modal-section">
              <h6 class="modal-subheading">Status</h6>
              <span class="badge bg-success text-dark">Deployed</span>
            </div>
            <div class="modal-section">
              <h6 class="modal-subheading">Live Demo</h6>
              <a href="https://imperialride.ae" target="_blank" rel="noopener" class="btn btn-outline-light">Visit Site</a>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal 7: Art Portfolio -->
    <div class="modal fade project-modal" id="modal-project-7" tabindex="-1" aria-labelledby="modal-project-7-label" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modal-project-7-label">Art Portfolio Website</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="modal-thumb">
              <img src="{{asset('portfolio/images/baig.png')}}" alt="Art Portfolio Website screenshot" class="modal-thumb-img">
            </div>
            <p class="modal-desc">
              A WordPress-based portfolio site built for an artist client. Fully functional, customised, and deployed.
            </p>
            <div class="modal-section">
              <h6 class="modal-subheading">My Role</h6>
              <p>Client project — WordPress theme customisation, plugin integration, and deployment.</p>
            </div>
            <div class="modal-section">
              <h6 class="modal-subheading">Key Features</h6>
              <ul class="modal-feature-list">
                <li>Custom WordPress theme</li>
                <li>Portfolio gallery</li>
                <li>Contact form</li>
                <li>Responsive design</li>
                <li>SEO-friendly structure</li>
              </ul>
            </div>
            <div class="modal-section">
              <h6 class="modal-subheading">Technical Implementation</h6>
              <p>Built with WordPress, custom CSS/JS, and plugin integrations.</p>
            </div>
            <div class="modal-section">
              <h6 class="modal-subheading">Stack</h6>
              <div class="skills-tags">
                <span class="skill-tag">WordPress</span>
                <span class="skill-tag">PHP</span>
                <span class="skill-tag">CSS</span>
              </div>
            </div>
            <div class="modal-section">
              <h6 class="modal-subheading">Live Demo</h6>
              <a href="https://adnanbaig.pk" target="_blank" rel="noopener" class="btn btn-outline-light">Visit Site</a>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal 8: Project Management System -->
    <div class="modal fade project-modal" id="modal-project-8" tabindex="-1" aria-labelledby="modal-project-8-label" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modal-project-8-label">Project Management System</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="modal-thumb">
              <i class="bi bi-kanban" aria-hidden="true"></i>
            </div>
            <p class="modal-desc">
              A multi-user Laravel project management platform with role-based dashboards for task assignment,
              commenting, and reporting. Actively being extended into a set of RESTful APIs.
            </p>
            <div class="modal-section">
              <h6 class="modal-subheading">My Role</h6>
              <p>Independent full-stack development — design, backend, database, and ongoing API layer.</p>
            </div>
            <div class="modal-section">
              <h6 class="modal-subheading">Key Features</h6>
              <ul class="modal-feature-list">
                <li>Role-based dashboards (Admin, Manager, Member)</li>
                <li>Projects, tasks &amp; categories management with task assignment</li>
                <li>Task comments, time logs, and attachments</li>
                <li>Commenting &amp; reporting</li>
                <li>Custom Guards &amp; Policies for authorization (RBAC)</li>
                <li>In-progress: RESTful APIs via Laravel Passport, converting each CRUD module one at a time</li>
              </ul>
            </div>
            <div class="modal-section">
              <h6 class="modal-subheading">Technical Implementation</h6>
              <p>
                Built with Laravel, Eloquent relationships, custom Guards and Policies, and SOLID principles for
                maintainable code. RESTful APIs are being added with Laravel Passport and tested end-to-end
                with PHPUnit and Postman, without breaking the existing website or its authentication.
              </p>
            </div>
            <div class="modal-section">
              <h6 class="modal-subheading">Stack</h6>
              <div class="skills-tags">
                <span class="skill-tag">Laravel</span>
                <span class="skill-tag">PHP</span>
                <span class="skill-tag">MySQL</span>
                <span class="skill-tag">Laravel Passport</span>
                <span class="skill-tag">PHPUnit</span>
                <span class="skill-tag">RESTful APIs</span>
              </div>
            </div>
            <div class="modal-section">
              <h6 class="modal-subheading">Status</h6>
              <span class="badge bg-warning text-dark">In Progress &middot; API Conversion</span>
            </div>
            <div class="modal-section">
              <h6 class="modal-subheading">Repository</h6>
              <a href="https://github.com/ahmadraza348" target="_blank" rel="noopener" class="btn btn-outline-light">View Code</a>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

    <!-- ============================================
         05 // EXPERIENCE
    ============================================ -->
    <section id="experience" class="section experience-section">
      <div class="container-narrow">
        <h2 data-aos="fade-up" data-aos-delay="50">Work Experience</h2>

        <div class="timeline">

          <div class="timeline-item" data-aos="fade-right" data-aos-duration="800">
            <span class="timeline-dot is-current" aria-hidden="true"></span>
            <div class="timeline-content">
              <span class="timeline-date mono">Oct 2023 &mdash; July 2026</span>
              <h3 class="timeline-role">Web Developer &amp; Manager</h3>
              <p class="timeline-company mono">OPEA, Gojra</p>
              <ul class="timeline-list">
                <li>eCommerce Development: Developed core online store features and optimized backend queries and assets to improve site speed and performance</li>
                <li>ERP &amp; Integration: Collaborated with senior Laravel/ERP developers to implement product, variant, and stock synchronization, reducing manual data-entry errors and improving inventory accuracy across the platform</li>
                <li>QA &amp; System Support: Identified technical bugs, coordinated issue resolution with the core team, and optimized workflows to ensure a smooth shopping experience for customers</li>
              </ul>
            </div>
          </div>

          <div class="timeline-item" data-aos="fade-right" data-aos-duration="800" data-aos-delay="75">
            <span class="timeline-dot is-current" aria-hidden="true"></span>
            <div class="timeline-content">
              <span class="timeline-date mono">2023 &mdash; Present</span>
              <h3 class="timeline-role">Independent Laravel Projects</h3>
              <p class="timeline-company mono">Freelance / Side projects</p>
              <ul class="timeline-list">
                <li>Development: Built complete Laravel applications including eCommerce, POS/inventory, project management, learning platforms, and Laravel-with-React projects</li>
                <li>Deployment: Managed Git-based version control workflows, server environment configuration (.env), shared-host deployments (cPanel/Hostinger), database migrations, and production troubleshooting</li>
              </ul>
            </div>
          </div>

          <div class="timeline-item" data-aos="fade-right" data-aos-duration="800" data-aos-delay="150">
            <span class="timeline-dot" aria-hidden="true"></span>
            <div class="timeline-content">
              <span class="timeline-date mono">Oct 2022 &mdash; Sep 2023</span>
              <h3 class="timeline-role">Junior Laravel Developer</h3>
              <p class="timeline-company mono">BriskBase Software House, Gojra</p>
              <ul class="timeline-list">
                <li>Full-Stack Development: Developed and maintained client-facing Laravel web applications using PHP, MySQL, Blade, and Bootstrap to deliver responsive, dynamic user interfaces</li>
                <li>Collaboration &amp; Delivery: Collaborated with senior developers to debug issues, execute code changes, and reliably deliver production updates for client web applications</li>
              </ul>
            </div>
          </div>

        </div>
      </div>
    </section>

    <!-- ============================================
         06 // EDUCATION
    ============================================ -->
    <section id="education" class="section education-section">
      <div class="container-narrow">
        <h2 data-aos="fade-up" data-aos-delay="50">Education</h2>

        <div class="education-grid">

          <div class="education-card education-card-current" data-aos="fade-up" data-aos-duration="600">
            <span class="education-years mono">2026 &ndash; Present</span>
            <h3 class="education-degree">BS Software Engineering</h3>
            <p class="education-institute">Virtual University of Pakistan</p>
            <span class="education-score mono education-status-badge">In Progress &middot; 2nd Semester</span>
          </div>

          <div class="education-card" data-aos="fade-up" data-aos-duration="600">
            <span class="education-years mono">2019 &ndash; 2021</span>
            <h3 class="education-degree">FSc Pre-Engineering</h3>
            <p class="education-institute">Govt. Postgraduate College Gojra</p>
            <span class="education-score mono">68%</span>
          </div>

          <div class="education-card" data-aos="fade-up" data-aos-duration="600" data-aos-delay="100">
            <span class="education-years mono">2016 &ndash; 2018</span>
            <h3 class="education-degree">Matriculation</h3>
            <p class="education-institute">Govt. High School 348 JB</p>
            <span class="education-score mono">86%</span>
          </div>

        </div>
      </div>
    </section>

    <!-- ============================================
         07 // CORE CAPABILITIES (unchanged)
    ============================================ -->
    <section id="core-capabilities" class="section build-section">
      <div class="container-narrow">
        <h2 data-aos="fade-up" data-aos-delay="50">What I Build</h2>
        <p class="skills-intro" data-aos="fade-up" data-aos-delay="100">
          Applications I build across personal projects, work, and client engagements.
        </p>

        <div class="build-grid">
          <div class="build-card" data-aos="fade-up" data-aos-duration="500">
            <i class="bi bi-diagram-3 build-icon" aria-hidden="true"></i>
            <h3 class="build-title">Laravel Business Applications</h3>
          </div>
          <div class="build-card" data-aos="fade-up" data-aos-duration="500" data-aos-delay="50">
            <i class="bi bi-cart3 build-icon" aria-hidden="true"></i>
            <h3 class="build-title">E-commerce Systems</h3>
          </div>
          <div class="build-card" data-aos="fade-up" data-aos-duration="500" data-aos-delay="100">
            <i class="bi bi-shop build-icon" aria-hidden="true"></i>
            <h3 class="build-title">POS &amp; Inventory Management</h3>
          </div>
          <div class="build-card" data-aos="fade-up" data-aos-duration="500" data-aos-delay="150">
            <i class="bi bi-building-gear build-icon" aria-hidden="true"></i>
            <h3 class="build-title">Admin Dashboards</h3>
          </div>
          <div class="build-card" data-aos="fade-up" data-aos-duration="500" data-aos-delay="200">
            <i class="bi bi-diagram-2 build-icon" aria-hidden="true"></i>
            <h3 class="build-title">REST APIs</h3>
          </div>
          <div class="build-card" data-aos="fade-up" data-aos-duration="500" data-aos-delay="250">
            <i class="bi bi-lock build-icon" aria-hidden="true"></i>
            <h3 class="build-title">Authentication &amp; RBAC</h3>
          </div>
          <div class="build-card" data-aos="fade-up" data-aos-duration="500" data-aos-delay="300">
            <i class="bi bi-database build-icon" aria-hidden="true"></i>
            <h3 class="build-title">Database-driven Applications</h3>
          </div>
          <div class="build-card" data-aos="fade-up" data-aos-duration="500" data-aos-delay="350">
            <i class="bi bi-cloud-upload build-icon" aria-hidden="true"></i>
            <h3 class="build-title">Production Deployment</h3>
          </div>
        </div>
      </div>
    </section>

    <!-- ============================================
         08 // CV
    ============================================ -->
    <section id="cv" class="section cv-section">
      <div class="container-narrow">

        <div class="cv-grid">
          <div class="cv-text" data-aos="fade-right" data-aos-duration="800">
            <h2>My Resume</h2>
            <p>
              Full details on my experience, skills, and education.
              Open or download a copy.
            </p>

            <div class="cv-actions">
              <a href="{{asset('portfolio/Ahmad-Raza-Laravel-Resume.pdf')}}" target="_blank" rel="noopener" class="btn-hero btn-hero-primary">
                <i class="bi bi-eye" aria-hidden="true"></i> View CV
              </a>
              <a href="{{asset('portfolio/Ahmad-Raza-Laravel-Resume.pdf')}}" download class="btn-hero btn-hero-outline">
                <i class="bi bi-download" aria-hidden="true"></i> Download CV
              </a>
            </div>
          </div>

          <a href="{{asset('portfolio/Ahmad-Raza-Laravel-Resume.pdf')}}" target="_blank" rel="noopener" class="cv-preview-card" aria-label="Open CV" data-aos="fade-left" data-aos-duration="800" data-aos-delay="100">
            <div class="cv-preview-header">
              <div class="code-panel-dots" aria-hidden="true">
                <span></span><span></span><span></span>
              </div>
              <span class="cv-preview-filename mono">Ahmad-Raza-Laravel-Resume.pdf</span>
            </div>
            <div class="cv-preview-body">
              <i class="bi bi-file-earmark-pdf cv-preview-icon" aria-hidden="true"></i>
              <span class="cv-preview-name">Muhammad Ahmad Raza</span>
              <span class="cv-preview-role mono">Laravel Developer</span>
            </div>
            <div class="cv-preview-footer mono">
              <span><i class="bi bi-eye" aria-hidden="true"></i> Open PDF</span>
            </div>
          </a>
        </div>
      </div>
    </section>

    <!-- ============================================
         09 // CONTACT
    ============================================ -->
    <section id="contact" class="section contact-section">
      <div class="container-narrow">
        <h2 class="contact-heading" data-aos="fade-up" data-aos-delay="50">Let&rsquo;s Build Something</h2>
        <p class="skills-intro" data-aos="fade-up" data-aos-delay="100">
          Open to Laravel roles, freelance projects, and conversations. Available immediately for remote, hybrid, or on-site roles.
        </p>

        <div class="contact-grid">

          <a href="mailto:engr.ahmadraza348@gmail.com" class="contact-card" data-aos="fade-up" data-aos-delay="50">
            <i class="bi bi-envelope contact-icon" aria-hidden="true"></i>
            <span class="contact-label mono">Email</span>
            <span class="contact-value">engr.ahmadraza348@gmail.com</span>
          </a>

          <a href="tel:+923499153486" class="contact-card" data-aos="fade-up" data-aos-delay="100">
            <i class="bi bi-telephone contact-icon" aria-hidden="true"></i>
            <span class="contact-label mono">Phone</span>
            <span class="contact-value">+92 349 9153486</span>
          </a>

          <a href="https://github.com/ahmadraza348/" target="_blank" rel="noopener" class="contact-card" data-aos="fade-up" data-aos-delay="150">
            <i class="bi bi-github contact-icon" aria-hidden="true"></i>
            <span class="contact-label mono">GitHub</span>
            <span class="contact-value">github.com/ahmadraza348</span>
          </a>

          <a href="https://linkedin.com/in/ahmadraza348/" target="_blank" rel="noopener" class="contact-card" data-aos="fade-up" data-aos-delay="200">
            <i class="bi bi-linkedin contact-icon" aria-hidden="true"></i>
            <span class="contact-label mono">LinkedIn</span>
            <span class="contact-value">linkedin.com/in/ahmadraza348</span>
          </a>

          <div class="contact-card contact-card-static" data-aos="fade-up" data-aos-delay="250">
            <i class="bi bi-geo-alt contact-icon" aria-hidden="true"></i>
            <span class="contact-label mono">Location</span>
            <span class="contact-value">Gojra, Punjab, Pakistan</span>
          </div>

          <a href="https://kwork.com/user/ahmad_218" target="_blank" rel="noopener" class="contact-card" data-aos="fade-up" data-aos-delay="300">
            <i class="bi bi-briefcase contact-icon" aria-hidden="true"></i>
            <span class="contact-label mono">Freelance</span>
            <span class="contact-value">kwork.com/user/ahmad_218</span>
          </a>

        </div>
      </div>
    </section>

  </main>

  <!-- ============================================
       FOOTER
  ============================================ -->
  <footer id="footer" class="site-footer">
    <div class="container-narrow">
      <div class="footer-content">
        <a href="#hero" class="navbar-brand-custom" aria-label="Ahmad Raza — home">
          <img src="{{asset('portfolio/images/logo-light.png')}}" style="width: 50px; height: auto;" alt="Ahmad Raza Logo">
        </a>

        <div class="footer-social-links">
          <a href="https://github.com/ahmadraza348/" target="_blank" rel="noopener" aria-label="GitHub">
            <i class="bi bi-github"></i>
          </a>
          <a href="https://linkedin.com/in/ahmadraza348/" target="_blank" rel="noopener" aria-label="LinkedIn">
            <i class="bi bi-linkedin"></i>
          </a>
          <a href="mailto:engr.ahmadraza348@gmail.com" aria-label="Email">
            <i class="bi bi-envelope"></i>
          </a>
          <a href="tel:+923499153486" aria-label="Phone">
            <i class="bi bi-telephone"></i>
          </a>
        </div>

        <p class="footer-copy mono">
          &copy; <span id="footerYear">2026</span> Muhammad Ahmad Raza
          <span class="footer-separator">•</span>
          Built with <span class="footer-heart">❤</span>
        </p>
      </div>
    </div>
  </footer>

  <!-- Bootstrap Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- AOS Animation JS -->
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

  <!-- Site scripts -->
  <script src="{{asset('portfolio/js/script.js')}}"></script>
</body>
</html>