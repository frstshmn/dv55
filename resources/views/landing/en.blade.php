<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>DV55 — Security Training Center</title>
    <meta name="description" content="DV55 — certified security guard training courses. Licensed by the Ministry of Education of Ukraine.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="/public/css/landing.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

{{-- ── NAV ── --}}
<nav class="site-nav" id="siteNav">
    <div class="nav-inner">
        <a href="#hero" class="nav-logo">
            <img src="/public/images/logo_small.svg" alt="DV55">
            <span class="nav-logo-text">DV55</span>
        </a>
        <div class="nav-links">
            <a href="#hero">Home</a>
            <a href="#about">About</a>
            <a href="#courses">Courses</a>
            <a href="#contact">Contact</a>
        </div>
        <div class="nav-right">
            <div class="nav-lang">
                <a href="/">UA</a>
                <a href="/en" class="active">EN</a>
            </div>
            @auth
                <a href="{{ url('/cabinet') }}" class="nav-cta">My cabinet →</a>
            @else
                <a href="{{ route('login') }}" class="nav-cta">Log in →</a>
            @endauth
        </div>
        <button class="nav-mobile-toggle" id="mobileToggle" aria-label="Menu">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
        </button>
    </div>
</nav>

<div class="nav-mobile-menu" id="mobileMenu">
    <a href="#hero"    onclick="closeMobile()">Home</a>
    <a href="#about"   onclick="closeMobile()">About</a>
    <a href="#courses" onclick="closeMobile()">Courses</a>
    <a href="#contact" onclick="closeMobile()">Contact</a>
    <div style="display:flex;gap:8px;padding:4px 16px">
        <a href="/" style="font-size:.8rem;font-weight:700;color:var(--text-muted)">UA</a>
        <a href="/en" style="font-size:.8rem;font-weight:700;color:var(--accent)">EN</a>
    </div>
    @auth
        <a href="{{ url('/cabinet') }}" style="color:var(--accent)">→ My cabinet</a>
    @else
        <a href="{{ route('login') }}" style="color:var(--accent)">→ Log in</a>
    @endauth
</div>

{{-- ── HERO ── --}}
<section class="hero" id="hero">
    <div class="hero-bg"></div>
    <div class="hero-slides">
        <div class="hero-slide" style="background-image:url('/public/images/hero_1.png')"></div>
        <div class="hero-slide" style="background-image:url('/public/images/hero_2.png')"></div>
        <div class="hero-slide" style="background-image:url('/public/images/hero_3.png')"></div>
        <div class="hero-slide" style="background-image:url('/public/images/hero_4.png')"></div>
    </div>
    <div class="hero-overlay"></div>
    <div class="hero-grid-lines"></div>
    <div class="hero-glow"></div>
    <div class="hero-inner">
        <div class="hero-content reveal">
            <div class="hero-badge">
                <span></span>
                Licensed by the Ministry of Education of Ukraine
            </div>
            <h1 class="hero-title">
                Certified <em>security</em><br>training of the<br>next level
            </h1>
            <p class="hero-desc">
                Prepare yourself for a career in the security industry with DV55 — 30+ years of hands-on experience, official state-certified qualifications.
            </p>
            <div class="hero-actions">
                <a href="#courses" class="btn-primary">
                    Explore courses
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14"/><path d="M12 5l7 7-7 7"/></svg>
                </a>
                <a href="#about" class="btn-ghost">Learn more</a>
            </div>
        </div>
        <div class="hero-card reveal" style="transition-delay:.15s">
            <div class="hero-card-title">Training programmes</div>
            <div class="hero-course-item"><div class="hci-dot"></div><div class="hci-text">Security guard grades 1–4</div></div>
            <div class="hero-course-item"><div class="hci-dot"></div><div class="hci-text">Close protection officer</div></div>
            <div class="hero-course-item"><div class="hci-dot"></div><div class="hci-text">Shopping centre security</div></div>
            <div class="hero-course-item"><div class="hci-dot"></div><div class="hci-text">Educational facility security</div></div>
            <div class="hero-course-item"><div class="hci-dot"></div><div class="hci-text">Cargo escort operations</div></div>
            <div class="hero-course-item"><div class="hci-dot"></div><div class="hci-text">Maritime & river security</div></div>
            <div class="hero-course-item"><div class="hci-dot"></div><div class="hci-text">Information security</div></div>
        </div>
    </div>
</section>

{{-- ── STATS ── --}}
<div class="stats-strip">
    <div class="stats-inner container">
        <div class="stat-item reveal">
            <div class="stat-num" data-count="30">0+</div>
            <div class="stat-label">years in ground<br>security & transport</div>
        </div>
        <div class="stat-item reveal" style="transition-delay:.07s">
            <div class="stat-num" data-count="1100">0+</div>
            <div class="stat-label">cargo escort<br>missions in Ukraine</div>
        </div>
        <div class="stat-item reveal" style="transition-delay:.14s">
            <div class="stat-num" data-count="30">0+</div>
            <div class="stat-label">guarded<br>facilities</div>
        </div>
        <div class="stat-item reveal" style="transition-delay:.21s">
            <div class="stat-num" data-count="150">0+</div>
            <div class="stat-label">maritime security<br>contracts in HRA</div>
        </div>
        <div class="stat-item reveal" style="transition-delay:.28s">
            <div class="stat-num" data-count="7">0</div>
            <div class="stat-label">international<br>escort operations</div>
        </div>
        <div class="stat-item reveal" style="transition-delay:.35s">
            <div class="stat-num">1</div>
            <div class="stat-label">shooting club &<br>training facility</div>
        </div>
    </div>
</div>

{{-- ── ABOUT ── --}}
<section class="section" id="about">
    <div class="container">
        <div class="grid-2">
            <div class="about-visual reveal">
                <div class="about-logo-wrap">
                    <img src="/public/images/logo_big.svg" alt="DV55 Logo">
                </div>
            </div>
            <div class="reveal" style="transition-delay:.1s">
                <div class="eyebrow">About us</div>
                <h2 class="section-title">DV55 Group of Companies</h2>
                <p class="section-sub" style="margin-bottom:24px">
                    Operating under a <strong>licence from the Ministry of Education and Science of Ukraine</strong>, we deliver comprehensive vocational training and professional development. Graduates receive an <strong>official state-recognised certificate of qualification</strong>.
                </p>
                <div class="specialties">
                    <div class="spec-item">
                        <div class="spec-icon"><i class="fa-solid fa-shield-halved"></i></div>
                        <div class="spec-text">Security guard — grades 1–4</div>
                    </div>
                    <div class="spec-item">
                        <div class="spec-icon"><i class="fa-solid fa-user-shield"></i></div>
                        <div class="spec-text">Close protection officer (bodyguard)</div>
                    </div>
                    <div class="spec-item">
                        <div class="spec-icon"><i class="fa-solid fa-building"></i></div>
                        <div class="spec-text">Shopping centre security personnel</div>
                    </div>
                    <div class="spec-item">
                        <div class="spec-icon"><i class="fa-solid fa-school"></i></div>
                        <div class="spec-text">Educational facility security personnel</div>
                    </div>
                    <div class="spec-item">
                        <div class="spec-icon"><i class="fa-solid fa-truck"></i></div>
                        <div class="spec-text">Cargo transport escort</div>
                    </div>
                    <div class="spec-item">
                        <div class="spec-icon"><i class="fa-solid fa-anchor"></i></div>
                        <div class="spec-text">Maritime & river transport security</div>
                    </div>
                    <div class="spec-item">
                        <div class="spec-icon"><i class="fa-solid fa-lock"></i></div>
                        <div class="spec-text">Information security</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="expertise-grid">
            @php
            $exp = [
                ['30+',  'years in ground security, personal protection and transport'],
                ['1100+','cargo escort missions completed across Ukraine'],
                ['30+',  'protected facilities as of 2021'],
                ['150+', 'maritime security contracts executed in the High Risk Area'],
                ['7',    'international escort operations to North & Central Africa'],
                ['∞',    'On-site shooting club & professional training centre'],
            ];
            @endphp
            @foreach($exp as $i => $e)
            <div class="exp-card reveal" style="transition-delay:{{ $i * 0.07 }}s">
                <div class="exp-num">{{ $e[0] }}</div>
                <div class="exp-text">{{ $e[1] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ── MISSION ── --}}
<section class="section mission-section">
    <div class="container">
        <div class="mission-inner reveal">
            <div class="eyebrow" style="justify-content:center">Our mission</div>
            <div class="mission-icons">
                <div class="mission-icon"><i class="fa-solid fa-handshake"></i></div>
                <div class="mission-icon"><i class="fa-solid fa-star"></i></div>
                <div class="mission-icon"><i class="fa-solid fa-graduation-cap"></i></div>
            </div>
            <p class="mission-quote">
                Delivering security services of a new standard, where <strong>teamwork, professionalism and knowledge</strong> define every member of staff
            </p>
        </div>
    </div>
</section>

{{-- ── COURSES ── --}}
<section class="section" id="courses">
    <div class="container">
        <div class="reveal">
            <div class="eyebrow">Training</div>
            <h2 class="section-title">Our courses</h2>
            <p class="section-sub">
                Under Ukrainian law, security activities may only be carried out by personnel who meet established qualification requirements. Obtain your official <strong>Security Guard Certificate</strong>.
            </p>
        </div>
        <div class="courses-grid">
            @foreach($courses as $i => $course)
            <div class="course-card reveal" style="transition-delay:{{ ($i % 3) * 0.08 }}s">
                <div class="cc-top">
                    <div class="cc-icon">
                        <img src="/public/images/logo_big.svg" alt="DV55">
                    </div>
                    <div class="cc-title">{{ $course->title }}</div>
                </div>
                <div class="cc-body">
                    <p class="cc-desc">{{ $course->description }}</p>
                </div>
                <div class="cc-footer">
                    <span class="cc-modules">{{ count($course->modules) }} {{ count($course->modules) === 1 ? 'module' : 'modules' }}</span>
                    @auth
                        <a href="/courses/{{ $course->id }}" class="cc-btn">Start →</a>
                    @else
                        <a href="{{ route('login') }}" class="cc-btn">Log in →</a>
                    @endauth
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ── CONTACT ── --}}
<section class="section" id="contact" style="background:var(--bg-2);border-top:1px solid var(--border)">
    <div class="container">
        <div class="reveal">
            <div class="eyebrow">Get in touch</div>
            <h2 class="section-title">Contact us</h2>
            <p class="section-sub">Have a question about our courses or enrolment? Write to us and we'll get back to you promptly.</p>
        </div>
        <div class="contact-grid">
            <div class="contact-form-card reveal" style="transition-delay:.1s">
                <form method="POST" action="/sendmail" autocomplete="off">
                    @csrf
                    <div class="cf-group">
                        <label class="cf-label">Your name</label>
                        <input type="text" name="name" class="cf-input" placeholder="First and last name" required>
                    </div>
                    <div class="cf-group">
                        <label class="cf-label">Email address</label>
                        <input type="email" name="email" class="cf-input" placeholder="your@email.com" required>
                    </div>
                    <div class="cf-group">
                        <label class="cf-label">Message</label>
                        <textarea name="message" class="cf-textarea" placeholder="Your question..." required></textarea>
                    </div>
                    <button type="submit" class="cf-submit">Send message</button>
                </form>
            </div>
            <div class="contact-info reveal" style="transition-delay:.2s">
                <a href="tel:+380963905907" class="social-card">
                    <div class="sc-icon em">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.81a19.79 19.79 0 01-3.07-8.72A2 2 0 012 1h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 8.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>
                    </div>
                    <div>
                        <div class="sc-label">Phone</div>
                        <div class="sc-val">+380 (96) 390 59 07</div>
                    </div>
                </a>
                <a href="tel:+380982203329" class="social-card">
                    <div class="sc-icon em">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.81a19.79 19.79 0 01-3.07-8.72A2 2 0 012 1h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 8.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>
                    </div>
                    <div>
                        <div class="sc-label">Phone</div>
                        <div class="sc-val">+380 (98) 220 33 29</div>
                    </div>
                </a>
                <a href="mailto:55divizion55@gmail.com" class="social-card">
                    <div class="sc-icon em">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                    </div>
                    <div>
                        <div class="sc-label">Email</div>
                        <div class="sc-val">55divizion55@gmail.com</div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>

{{-- ── SOCIALS ── --}}
<div class="socials-strip">
    <div class="container" style="text-align:center">
        <div class="eyebrow" style="justify-content:center">Follow us</div>
        <h2 class="section-title" style="margin-bottom:0">Find us on social media</h2>
        <div class="socials-grid">
            <a href="https://www.linkedin.com/company/75043983" target="_blank" class="social-big reveal">
                <div class="sb-icon li"><svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor"><path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z"/><circle cx="4" cy="4" r="2"/></svg></div>
                <span class="sb-label">LinkedIn</span>
            </a>
            <a href="https://www.instagram.com/dv55.center" target="_blank" class="social-big reveal" style="transition-delay:.08s">
                <div class="sb-icon ig"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg></div>
                <span class="sb-label">Instagram</span>
            </a>
            <a href="https://www.facebook.com/%D0%A2%D1%80%D0%B5%D0%BD%D1%83%D0%B2%D0%B0%D0%BB%D1%8C%D0%BD%D0%B8%D0%B9-%D1%86%D0%B5%D0%BD%D1%82%D1%80-DV55-125913529670812" target="_blank" class="social-big reveal" style="transition-delay:.16s">
                <div class="sb-icon fb"><svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg></div>
                <span class="sb-label">Facebook</span>
            </a>
        </div>
    </div>
</div>

{{-- ── FOOTER ── --}}
<footer>
    <div class="container">
        <div class="footer-inner">
            <div>
                <div class="footer-brand-logo">
                    <img src="/public/images/logo_small.svg" alt="DV55">
                    <span>DV55</span>
                </div>
                <p class="footer-tagline">Security Training Centre. Licensed by the Ministry of Education and Science of Ukraine.</p>
            </div>
            <div>
                <div class="footer-col-title">Navigation</div>
                <div class="footer-links">
                    <a href="#hero">Home</a>
                    <a href="#about">About</a>
                    <a href="#courses">Courses</a>
                    <a href="#contact">Contact</a>
                </div>
            </div>
            <div>
                <div class="footer-col-title">Useful links</div>
                <div class="footer-links">
                    <a href="{{ route('login') }}">Log in</a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <span class="footer-copy">© {{ date('Y') }} <span class="footer-accent">DV55</span> Training Center. All rights reserved.</span>
            <div style="display:flex;gap:10px">
                <a href="/" style="font-size:.78rem;font-weight:700;color:var(--text-muted)">UA</a>
                <a href="/en" style="font-size:.78rem;font-weight:700;color:var(--accent)">EN</a>
            </div>
        </div>
    </div>
</footer>

<script>
var nav = document.getElementById('siteNav');
window.addEventListener('scroll', function() { nav.classList.toggle('scrolled', window.scrollY > 30); }, { passive: true });
nav.classList.toggle('scrolled', window.scrollY > 30);
document.getElementById('mobileToggle').addEventListener('click', function() { document.getElementById('mobileMenu').classList.toggle('open'); });
function closeMobile() { document.getElementById('mobileMenu').classList.remove('open'); }
var observer = new IntersectionObserver(function(entries) {
    entries.forEach(function(e) { if(e.isIntersecting) { e.target.classList.add('visible'); observer.unobserve(e.target); } });
}, { threshold: 0.12 });
document.querySelectorAll('.reveal').forEach(function(el) { observer.observe(el); });
function animateCounter(el) {
    var target = +el.getAttribute('data-count'); if(!target) return;
    var suffix = el.textContent.includes('+') ? '+' : '', start = 0, duration = 1800;
    var step = function(ts) {
        if(!start) start = ts;
        var p = Math.min((ts - start) / duration, 1), ease = 1 - Math.pow(1 - p, 3);
        el.textContent = Math.floor(ease * target) + suffix;
        if(p < 1) requestAnimationFrame(step); else el.textContent = target + suffix;
    };
    requestAnimationFrame(step);
}
var co = new IntersectionObserver(function(entries) { entries.forEach(function(e) { if(e.isIntersecting) { animateCounter(e.target); co.unobserve(e.target); } }); }, { threshold: 0.5 });
document.querySelectorAll('[data-count]').forEach(function(el) { co.observe(el); });
</script>
</body>
</html>
