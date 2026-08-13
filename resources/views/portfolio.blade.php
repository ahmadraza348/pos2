<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Muhammad Ahmad Raza | Laravel & Full-Stack Developer</title>
  <meta name="description" content="Muhammad Ahmad Raza — Laravel & Full-Stack Developer with 2+ years of experience building web applications, e-commerce platforms, and business software.">

  <!-- Canonical -->
  <link rel="canonical" href="https://ahmadrazadev.com">

  <!-- Open Graph -->
  <meta property="og:title" content="Muhammad Ahmad Raza | Laravel & Full-Stack Developer">
  <meta property="og:description" content="Laravel & Full-Stack Developer building practical web applications and business software.">
  <meta property="og:type" content="website">
  <meta property="og:url" content="https://ahmadrazadev.com">

  <!-- Favicon -->
  <link rel="icon" type="image/png" href="{{asset('portfolio/images/favicon.png')}}">

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
        <!-- <span class="text-accent">&lt;</span>AhmadRaza<span class="text-accent">/&gt;</span> -->
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
          href="{{asset('portfolio/cv/muhammad-ahmad-raza-cv.pdf')}}"
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
          <h2 class="hero-role">Laravel &amp; Full-Stack Developer</h2>
          <p class="hero-desc">
            2+ years of full-stack experience building Laravel web apps, 
            e-commerce platforms, REST APIs, and business software.
          </p>

          <div class="hero-actions">
            <a href="#projects" class="btn-hero btn-hero-primary" data-nav-link-scroll>View My Work</a>
            <a href="{{asset('portfolio/cv/muhammad-ahmad-raza-cv.pdf')}}" target="_blank" rel="noopener" class="btn-hero btn-hero-outline">View CV</a>
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
              <div class="code-line"><span class="line-no">4</span><span class="code-content">&nbsp;&nbsp;experience: <span class="tok-string">"2+ Years"</span>,</span></div>
              <div class="code-line"><span class="line-no">5</span><span class="code-content">&nbsp;&nbsp;stack: [<span class="tok-string">"PHP"</span>, <span class="tok-string">"Laravel"</span>, <span class="tok-string">"MySQL"</span>, <span class="tok-string">"JavaScript"</span>],</span></div>
              <div class="code-line"><span class="line-no">6</span><span class="code-content">&nbsp;&nbsp;focus: <span class="tok-string">"Full-Stack Development"</span></span></div>
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
         02 // ABOUT (Condensed)
    ============================================ -->
    <section id="about" class="section about-section">
      <div class="container-narrow">
        <p class="section-label" data-aos="fade-up">02 // About</p>

        <div class="about-grid">
          <div class="about-text" data-aos="fade-right" data-aos-duration="800">
            <h2>Building practical software that lasts.</h2>
            <p>
              Laravel-focused full-stack developer with 2+ years of hands-on experience.
              I build web applications, e-commerce platforms, and business tools 
              — from database design to deployment.
            </p>

            <div class="about-tags-block">
              <span class="meta-label mono">Soft Skills</span>
              <div class="skills-tags">
                <span class="skill-tag">Team Player</span>
                <span class="skill-tag">Communication</span>
                <span class="skill-tag">Problem-Solving</span>
                <span class="skill-tag">Continuous Learning</span>
              </div>
            </div>
          </div>

          <div class="about-meta-grid" data-aos="fade-left" data-aos-duration="800" data-aos-delay="100">
            <div class="meta-card">
              <span class="meta-label mono">Experience</span>
              <span class="meta-value">2+ Years</span>
            </div>
            <div class="meta-card">
              <span class="meta-label mono">Framework</span>
              <span class="meta-value">Laravel</span>
            </div>
            <div class="meta-card">
              <span class="meta-label mono">Backend</span>
              <span class="meta-value">PHP / MySQL</span>
            </div>
            <div class="meta-card">
              <span class="meta-label mono">Frontend</span>
              <span class="meta-value">React / Bootstrap</span>
            </div>
            <div class="meta-card">
              <span class="meta-label mono">API</span>
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
         03 // SKILLS
    ============================================ -->
    <section id="skills" class="section skills-section">
      <div class="container-narrow">
        <p class="section-label" data-aos="fade-up">03 // Skills</p>
        <h2 data-aos="fade-up" data-aos-delay="50">Tech Stack</h2>
        <p class="skills-intro" data-aos="fade-up" data-aos-delay="100">
          Laravel and PHP anchor everything I build, extending to frontend, APIs, and deployment.
        </p>

        <div class="skills-tabs-wrap" data-aos="fade-up" data-aos-delay="150">
          <div class="skills-tab-scroll">
            <ul class="skills-tab-list" id="skillsTab" role="tablist">
              <li role="presentation">
                <button class="skills-tab-btn mono is-emphasis active" id="tab-laravel" data-bs-toggle="tab" data-bs-target="#panel-laravel" type="button" role="tab" aria-controls="panel-laravel" aria-selected="true">
                  <i class="bi bi-lightning-charge" aria-hidden="true"></i> laravel <span class="tab-count">11</span>
                </button>
              </li>
              <li role="presentation">
                <button class="skills-tab-btn mono" id="tab-backend" data-bs-toggle="tab" data-bs-target="#panel-backend" type="button" role="tab" aria-controls="panel-backend" aria-selected="false">
                  <i class="bi bi-hdd-stack" aria-hidden="true"></i> backend <span class="tab-count">11</span>
                </button>
              </li>
              <li role="presentation">
                <button class="skills-tab-btn mono" id="tab-frontend" data-bs-toggle="tab" data-bs-target="#panel-frontend" type="button" role="tab" aria-controls="panel-frontend" aria-selected="false">
                  <i class="bi bi-window" aria-hidden="true"></i> frontend <span class="tab-count">11</span>
                </button>
              </li>
              <li role="presentation">
                <button class="skills-tab-btn mono" id="tab-api" data-bs-toggle="tab" data-bs-target="#panel-api" type="button" role="tab" aria-controls="panel-api" aria-selected="false">
                  <i class="bi bi-diagram-2" aria-hidden="true"></i> apis <span class="tab-count">6</span>
                </button>
              </li>
              <li role="presentation">
                <button class="skills-tab-btn mono" id="tab-packages" data-bs-toggle="tab" data-bs-target="#panel-packages" type="button" role="tab" aria-controls="panel-packages" aria-selected="false">
                  <i class="bi bi-box-seam" aria-hidden="true"></i> packages <span class="tab-count">8</span>
                </button>
              </li>
              <li role="presentation">
                <button class="skills-tab-btn mono" id="tab-devops" data-bs-toggle="tab" data-bs-target="#panel-devops" type="button" role="tab" aria-controls="panel-devops" aria-selected="false">
                  <i class="bi bi-gear" aria-hidden="true"></i> devops <span class="tab-count">9</span>
                </button>
              </li>
              <li role="presentation">
                <button class="skills-tab-btn mono" id="tab-seo" data-bs-toggle="tab" data-bs-target="#panel-seo" type="button" role="tab" aria-controls="panel-seo" aria-selected="false">
                  <i class="bi bi-graph-up-arrow" aria-hidden="true"></i> seo <span class="tab-count">9</span>
                </button>
              </li>
              <li role="presentation">
                <button class="skills-tab-btn mono" id="tab-additional" data-bs-toggle="tab" data-bs-target="#panel-additional" type="button" role="tab" aria-controls="panel-additional" aria-selected="false">
                  <i class="bi bi-palette2" aria-hidden="true"></i> additional <span class="tab-count">6</span>
                </button>
              </li>
            </ul>
          </div>

          <div class="tab-content skills-tab-content" id="skillsTabContent">

            <div class="tab-pane fade show active" id="panel-laravel" role="tabpanel" aria-labelledby="tab-laravel">
              <div class="skills-tags">
                <span class="skill-tag tag-emphasis">Authentication</span>
                <span class="skill-tag tag-emphasis">Authorization</span>
                <span class="skill-tag tag-emphasis">Routing</span>
                <span class="skill-tag tag-emphasis">Middleware</span>
                <span class="skill-tag tag-emphasis">Caching</span>
                <span class="skill-tag tag-emphasis">Queues</span>
                <span class="skill-tag tag-emphasis">Jobs</span>
                <span class="skill-tag tag-emphasis">Events</span>
                <span class="skill-tag tag-emphasis">Notifications</span>
                <span class="skill-tag tag-emphasis">Mail</span>
                <span class="skill-tag tag-emphasis">File Uploads</span>
              </div>
            </div>

            <div class="tab-pane fade" id="panel-backend" role="tabpanel" aria-labelledby="tab-backend">
              <div class="skills-tags">
                <span class="skill-tag tag-emphasis">PHP</span>
                <span class="skill-tag">OOP</span>
                <span class="skill-tag">MVC</span>
                <span class="skill-tag tag-emphasis">Laravel v8&ndash;12</span>
                <span class="skill-tag">MySQL</span>
                <span class="skill-tag">Eloquent ORM</span>
                <span class="skill-tag">Query Builder</span>
                <span class="skill-tag">Relationships</span>
                <span class="skill-tag">Migrations</span>
                <span class="skill-tag">Seeders</span>
                <span class="skill-tag">Database Optimization</span>
              </div>
            </div>

            <div class="tab-pane fade" id="panel-frontend" role="tabpanel" aria-labelledby="tab-frontend">
              <div class="skills-tags">
                <span class="skill-tag">HTML5</span>
                <span class="skill-tag">CSS3</span>
                <span class="skill-tag">SCSS</span>
                <span class="skill-tag">JavaScript ES6+</span>
                <span class="skill-tag">jQuery</span>
                <span class="skill-tag">Bootstrap</span>
                <span class="skill-tag">Tailwind CSS</span>
                <span class="skill-tag">Responsive Design</span>
                <span class="skill-tag">Blade</span>
                <span class="skill-tag">AJAX</span>
                <span class="skill-tag">React.js</span>
              </div>
            </div>

            <div class="tab-pane fade" id="panel-api" role="tabpanel" aria-labelledby="tab-api">
              <div class="skills-tags">
                <span class="skill-tag">RESTful APIs</span>
                <span class="skill-tag">Postman</span>
                <span class="skill-tag">Resource Controllers</span>
                <span class="skill-tag">Sanctum</span>
                <span class="skill-tag">Validation</span>
                <span class="skill-tag">Exception Handling</span>
              </div>
            </div>

            <div class="tab-pane fade" id="panel-packages" role="tabpanel" aria-labelledby="tab-packages">
              <div class="skills-tags">
                <span class="skill-tag">Laravel Breeze</span>
                <span class="skill-tag">Sanctum</span>
                <span class="skill-tag">Spatie Roles &amp; Permissions</span>
                <span class="skill-tag">Socialite</span>
                <span class="skill-tag">Laravel Excel</span>
                <span class="skill-tag">Intervention Image</span>
                <span class="skill-tag">Stripe</span>
                <span class="skill-tag">PayPal Sandbox</span>
              </div>
            </div>

            <div class="tab-pane fade" id="panel-devops" role="tabpanel" aria-labelledby="tab-devops">
              <div class="skills-tags">
                <span class="skill-tag">Hostinger</span>
                <span class="skill-tag">cPanel</span>
                <span class="skill-tag">Domain &amp; DNS</span>
                <span class="skill-tag">SSH</span>
                <span class="skill-tag">GitHub Actions</span>
                <span class="skill-tag">CI/CD</span>
                <span class="skill-tag">Cron Jobs</span>
                <span class="skill-tag">Git</span>
                <span class="skill-tag">GitHub</span>
              </div>
            </div>

            <div class="tab-pane fade" id="panel-seo" role="tabpanel" aria-labelledby="tab-seo">
              <div class="skills-tags">
                <span class="skill-tag">Technical SEO</span>
                <span class="skill-tag">On-page SEO</span>
                <span class="skill-tag">Speed Optimization</span>
                <span class="skill-tag">Core Web Vitals</span>
                <span class="skill-tag">Google Analytics</span>
                <span class="skill-tag">Google Search Console</span>
                <span class="skill-tag">Google Tag Manager</span>
                <span class="skill-tag">Facebook Pixel</span>
                <span class="skill-tag">Meta Ads</span>
              </div>
            </div>

            <div class="tab-pane fade" id="panel-additional" role="tabpanel" aria-labelledby="tab-additional">
              <div class="skills-tags">
                <span class="skill-tag">WordPress</span>
                <span class="skill-tag">Shopify</span>
                <span class="skill-tag">Product Photography</span>
                <span class="skill-tag">Content Writing</span>
                <span class="skill-tag">Canva</span>
                <span class="skill-tag">Photoshop</span>
              </div>
            </div>

          </div>
        </div>
      </div>
    </section>

    <!-- ============================================
         04 // PROJECTS
    ============================================ -->
    <section id="projects" class="section projects-section">
      <div class="container-narrow">
        <p class="section-label" data-aos="fade-up">04 // Projects</p>
        <h2 data-aos="fade-up" data-aos-delay="50">Selected Work</h2>
        <p class="skills-intro" data-aos="fade-up" data-aos-delay="100">
          Personal projects, client work, and an ongoing business system.
        </p>

        <div class="project-filters mono" role="group" aria-label="Filter projects by category" data-aos="fade-up" data-aos-delay="150">
          <button class="filter-btn active" data-filter="all" aria-pressed="true">All</button>
          <button class="filter-btn" data-filter="laravel" aria-pressed="false">Laravel</button>
          <button class="filter-btn" data-filter="ecommerce" aria-pressed="false">E-commerce</button>
          <button class="filter-btn" data-filter="business" aria-pressed="false">Business</button>
          <button class="filter-btn" data-filter="react" aria-pressed="false">React</button>
          <button class="filter-btn" data-filter="client" aria-pressed="false">Client</button>
        </div>

        <div class="projects-grid" id="projectsGrid">

          <!-- Project 1 -->
          <article class="project-card" data-category="laravel" data-aos="fade-up" data-aos-delay="100">
            <button type="button" class="project-thumb" data-bs-toggle="modal" data-bs-target="#modal-project-1" aria-label="View details for Web Tech Tutorials">
              <span class="project-thumb-index mono">01</span>
              <i class="bi bi-journal-code project-thumb-icon" aria-hidden="true"></i>
              <span class="project-thumb-overlay">
                <span class="project-thumb-cta mono">View Details <i class="bi bi-arrow-up-right" aria-hidden="true"></i></span>
              </span>
            </button>
            <div class="project-card-body">
              <span class="project-card-category mono">Personal Project &middot; Laravel</span>
              <h3 class="project-card-title">Web Tech Tutorials</h3>
              <p class="project-card-desc">Learning platform with CMS, role-based permissions, blog & course modules.</p>
              <div class="project-card-tech">
                <span class="skill-tag">Laravel</span>
                <span class="skill-tag">PHP</span>
                <span class="skill-tag">MySQL</span>
              </div>
              <div class="project-card-links">
                <a href="https://webtechtutorials.com" target="_blank" rel="noopener" class="project-link mono">Live Demo <i class="bi bi-box-arrow-up-right" aria-hidden="true"></i></a>
              </div>
            </div>
          </article>

          <!-- Project 2 -->
          <article class="project-card" data-category="laravel ecommerce" data-aos="fade-up" data-aos-delay="150">
            <button type="button" class="project-thumb" data-bs-toggle="modal" data-bs-target="#modal-project-2" aria-label="View details for E-Commerce Website">
              <span class="project-thumb-index mono">02</span>
              <i class="bi bi-cart3 project-thumb-icon" aria-hidden="true"></i>
              <span class="project-thumb-overlay">
                <span class="project-thumb-cta mono">View Details <i class="bi bi-arrow-up-right" aria-hidden="true"></i></span>
              </span>
            </button>
            <div class="project-card-body">
              <span class="project-card-category mono">Laravel &middot; E-commerce</span>
              <h3 class="project-card-title">E-Commerce Platform</h3>
              <p class="project-card-desc">Full-featured online store with cart, orders, inventory & admin dashboard.</p>
              <div class="project-card-tech">
                <span class="skill-tag">Laravel</span>
                <span class="skill-tag">PHP</span>
                <span class="skill-tag">MySQL</span>
              </div>
            </div>
          </article>

          <!-- Project 3 -->
          <article class="project-card" data-category="laravel business" data-aos="fade-up" data-aos-delay="200">
            <button type="button" class="project-thumb" data-bs-toggle="modal" data-bs-target="#modal-project-3" aria-label="View details for POS and Inventory Management System">
              <span class="project-thumb-index mono">03</span>
              <i class="bi bi-shop project-thumb-icon" aria-hidden="true"></i>
              <span class="project-thumb-overlay">
                <span class="project-thumb-cta mono">View Details <i class="bi bi-arrow-up-right" aria-hidden="true"></i></span>
              </span>
            </button>
            <div class="project-card-body">
              <span class="project-card-category mono">Laravel &middot; Business</span>
              <h3 class="project-card-title">POS &amp; Inventory System</h3>
              <p class="project-card-desc">Point-of-sale, inventory, purchases, sales, and reporting — in progress.</p>
              <div class="project-card-tech">
                <span class="skill-tag">Laravel</span>
                <span class="skill-tag">PHP</span>
                <span class="skill-tag">MySQL</span>
              </div>
            </div>
          </article>

          <!-- Project 4 -->
          <article class="project-card" data-category="client" data-aos="fade-up" data-aos-delay="100">
            <button type="button" class="project-thumb" data-bs-toggle="modal" data-bs-target="#modal-project-4" aria-label="View details for ImperialRide.ae">
              <span class="project-thumb-index mono">04</span>
              <i class="bi bi-car-front project-thumb-icon" aria-hidden="true"></i>
              <span class="project-thumb-overlay">
                <span class="project-thumb-cta mono">View Details <i class="bi bi-arrow-up-right" aria-hidden="true"></i></span>
              </span>
            </button>
            <div class="project-card-body">
              <span class="project-card-category mono">Client Project</span>
              <h3 class="project-card-title">ImperialRide.ae</h3>
              <p class="project-card-desc">Ride-booking platform for UAE client — frontend & booking flow.</p>
              <div class="project-card-links">
                <a href="https://imperialride.ae" target="_blank" rel="noopener" class="project-link mono">Live Demo <i class="bi bi-box-arrow-up-right" aria-hidden="true"></i></a>
              </div>
            </div>
          </article>

          <!-- Project 5 -->
          <article class="project-card" data-category="laravel" data-aos="fade-up" data-aos-delay="150">
            <button type="button" class="project-thumb" data-bs-toggle="modal" data-bs-target="#modal-project-5" aria-label="View details for Laravel Job Portal">
              <span class="project-thumb-index mono">05</span>
              <i class="bi bi-briefcase project-thumb-icon" aria-hidden="true"></i>
              <span class="project-thumb-overlay">
                <span class="project-thumb-cta mono">View Details <i class="bi bi-arrow-up-right" aria-hidden="true"></i></span>
              </span>
            </button>
            <div class="project-card-body">
              <span class="project-card-category mono">Personal Project &middot; Laravel</span>
              <h3 class="project-card-title">Job Portal</h3>
              <p class="project-card-desc">Job portal with authentication, job posting, and filtered search.</p>
              <div class="project-card-tech">
                <span class="skill-tag">Laravel</span>
                <span class="skill-tag">PHP</span>
                <span class="skill-tag">MySQL</span>
              </div>
            </div>
          </article>

          <!-- Project 6 -->
          <article class="project-card" data-category="laravel react" data-aos="fade-up" data-aos-delay="200">
            <button type="button" class="project-thumb" data-bs-toggle="modal" data-bs-target="#modal-project-6" aria-label="View details for Construction Website">
              <span class="project-thumb-index mono">06</span>
              <i class="bi bi-building project-thumb-icon" aria-hidden="true"></i>
              <span class="project-thumb-overlay">
                <span class="project-thumb-cta mono">View Details <i class="bi bi-arrow-up-right" aria-hidden="true"></i></span>
              </span>
            </button>
            <div class="project-card-body">
              <span class="project-card-category mono">Laravel &middot; React</span>
              <h3 class="project-card-title">Construction Website</h3>
              <p class="project-card-desc">Sanctum-secured admin panel with dynamic project and blog modules.</p>
              <div class="project-card-tech">
                <span class="skill-tag">Laravel</span>
                <span class="skill-tag">React.js</span>
              </div>
            </div>
          </article>

          <!-- Project 7 -->
          <article class="project-card" data-category="client" data-aos="fade-up" data-aos-delay="100">
            <button type="button" class="project-thumb" data-bs-toggle="modal" data-bs-target="#modal-project-7" aria-label="View details for Art Portfolio Website">
              <span class="project-thumb-index mono">07</span>
              <i class="bi bi-palette project-thumb-icon" aria-hidden="true"></i>
              <span class="project-thumb-overlay">
                <span class="project-thumb-cta mono">View Details <i class="bi bi-arrow-up-right" aria-hidden="true"></i></span>
              </span>
            </button>
            <div class="project-card-body">
              <span class="project-card-category mono">Client Project &middot; WordPress</span>
              <h3 class="project-card-title">Art Portfolio Website</h3>
              <p class="project-card-desc">Fully functional WordPress art portfolio for a client.</p>
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
         PROJECT MODALS (Same as before, kept for brevity)
    ============================================ -->
    <!-- ... modals remain the same ... -->

    <!-- ============================================
         05 // EXPERIENCE
    ============================================ -->
    <section id="experience" class="section experience-section">
      <div class="container-narrow">
        <p class="section-label" data-aos="fade-up">05 // Experience</p>
        <h2 data-aos="fade-up" data-aos-delay="50">Work Experience</h2>

        <div class="timeline">

          <div class="timeline-item" data-aos="fade-right" data-aos-duration="800">
            <span class="timeline-dot is-current" aria-hidden="true"></span>
            <div class="timeline-content">
              <span class="timeline-date mono">Oct 2023 &mdash; Dec 2025</span>
              <h3 class="timeline-role">Web Manager</h3>
              <p class="timeline-company mono">OPEA, Rafiq Center, Gojra</p>
              <ul class="timeline-list">
                <li>Laravel eCommerce website management</li>
                <li>SEO optimization & traffic growth</li>
                <li>Performance optimization</li>
                <li>Full-stack Laravel & React projects</li>
              </ul>
            </div>
          </div>

          <div class="timeline-item" data-aos="fade-right" data-aos-duration="800" data-aos-delay="100">
            <span class="timeline-dot" aria-hidden="true"></span>
            <div class="timeline-content">
              <span class="timeline-date mono">Oct 2022 &mdash; Sep 2023</span>
              <h3 class="timeline-role">Junior Full Stack Developer</h3>
              <p class="timeline-company mono">BriskBase Software House, Gojra</p>
              <ul class="timeline-list">
                <li>Laravel & full-stack development</li>
                <li>Backend logic & frontend integration</li>
                <li>Deployment & maintenance</li>
                <li>Real-world project collaboration</li>
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
        <p class="section-label" data-aos="fade-up">06 // Education</p>
        <h2 data-aos="fade-up" data-aos-delay="50">Education</h2>

        <div class="education-grid">

          
          <div class="education-card education-card-current" data-aos="fade-up" data-aos-duration="600">
            <span class="education-years mono">2025 &ndash; Present</span>
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
         07 // WHAT I BUILD
    ============================================ -->
    <section id="what-i-build" class="section build-section">
      <div class="container-narrow">
        <p class="section-label" data-aos="fade-up">07 // What I Build</p>
        <h2 data-aos="fade-up" data-aos-delay="50">What I Build</h2>
        <p class="skills-intro" data-aos="fade-up" data-aos-delay="100">
          Applications I build across personal projects, work, and clients.
        </p>

        <div class="build-grid">

          <div class="build-card" data-aos="fade-up" data-aos-duration="500">
            <i class="bi bi-diagram-3 build-icon" aria-hidden="true"></i>
            <h3 class="build-title">Laravel Web Apps</h3>
          </div>

          <div class="build-card" data-aos="fade-up" data-aos-duration="500" data-aos-delay="50">
            <i class="bi bi-cart3 build-icon" aria-hidden="true"></i>
            <h3 class="build-title">E-commerce Platforms</h3>
          </div>

          <div class="build-card" data-aos="fade-up" data-aos-duration="500" data-aos-delay="100">
            <i class="bi bi-shop build-icon" aria-hidden="true"></i>
            <h3 class="build-title">POS &amp; Inventory</h3>
          </div>

          <div class="build-card" data-aos="fade-up" data-aos-duration="500" data-aos-delay="150">
            <i class="bi bi-building-gear build-icon" aria-hidden="true"></i>
            <h3 class="build-title">Business Systems</h3>
          </div>

          <div class="build-card" data-aos="fade-up" data-aos-duration="500" data-aos-delay="200">
            <i class="bi bi-diagram-2 build-icon" aria-hidden="true"></i>
            <h3 class="build-title">REST APIs</h3>
          </div>

          <div class="build-card" data-aos="fade-up" data-aos-duration="500" data-aos-delay="250">
            <i class="bi bi-speedometer2 build-icon" aria-hidden="true"></i>
            <h3 class="build-title">Admin Dashboards</h3>
          </div>

          <div class="build-card" data-aos="fade-up" data-aos-duration="500" data-aos-delay="300">
            <i class="bi bi-phone build-icon" aria-hidden="true"></i>
            <h3 class="build-title">Responsive Websites</h3>
          </div>

          <div class="build-card" data-aos="fade-up" data-aos-duration="500" data-aos-delay="350">
            <i class="bi bi-graph-up-arrow build-icon" aria-hidden="true"></i>
            <h3 class="build-title">SEO &amp; Optimization</h3>
          </div>

        </div>
      </div>
    </section>

    <!-- ============================================
         08 // CV
    ============================================ -->
    <section id="cv" class="section cv-section">
      <div class="container-narrow">
        <p class="section-label" data-aos="fade-up">08 // CV</p>

        <div class="cv-grid">
          <div class="cv-text" data-aos="fade-right" data-aos-duration="800">
            <h2>My Resume</h2>
            <p>
              Full details on my experience, skills, and education.
              Open or download a copy.
            </p>

            <div class="cv-actions">
              <a href="{{asset('portfolio/cv/muhammad-ahmad-raza-cv.pdf')}}" target="_blank" rel="noopener" class="btn-hero btn-hero-primary">
                <i class="bi bi-eye" aria-hidden="true"></i> View CV
              </a>
              <a href="{{asset('portfolio/cv/muhammad-ahmad-raza-cv.pdf')}}" download class="btn-hero btn-hero-outline">
                <i class="bi bi-download" aria-hidden="true"></i> Download CV
              </a>
            </div>
          </div>

          <a href="{{asset('portfolio/cv/muhammad-ahmad-raza-cv.pdf')}}" target="_blank" rel="noopener" class="cv-preview-card" aria-label="Open CV" data-aos="fade-left" data-aos-duration="800" data-aos-delay="100">
            <div class="cv-preview-header">
              <div class="code-panel-dots" aria-hidden="true">
                <span></span><span></span><span></span>
              </div>
              <span class="cv-preview-filename mono">muhammad-ahmad-raza-cv.pdf</span>
            </div>
            <div class="cv-preview-body">
              <i class="bi bi-file-earmark-pdf cv-preview-icon" aria-hidden="true"></i>
              <span class="cv-preview-name">Muhammad Ahmad Raza</span>
              <span class="cv-preview-role mono">Laravel &amp; Full-Stack Developer</span>
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
        <p class="section-label" data-aos="fade-up">09 // Contact</p>
        <h2 class="contact-heading" data-aos="fade-up" data-aos-delay="50">Let&rsquo;s Build Something</h2>
        <p class="skills-intro" data-aos="fade-up" data-aos-delay="100">
          Open to Laravel roles, freelance projects, and conversations.
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
       FOOTER - Short & Clean
  ============================================ -->
  <footer id="footer" class="site-footer">
    <div class="container-narrow">
      <div class="footer-content">
        <a href="#hero" class="navbar-brand-custom" aria-label="Ahmad Raza — home">
          <span class="text-accent">&lt;</span>AhmadRaza<span class="text-accent">/&gt;</span>
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