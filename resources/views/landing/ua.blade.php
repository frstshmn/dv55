<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>DV55 — Навчальний центр охорони</title>
    <meta name="description" content="DV55 — сертифіковані курси для отримання свідоцтва охоронника та охоронця. Ліцензовано МОН України.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="{{ asset('css/landing.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

{{-- ── NAV ── --}}
<nav class="site-nav" id="siteNav">
    <div class="nav-inner">
        <a href="#hero" class="nav-logo">
            <img src="{{ asset('images/logo_small.svg') }}" alt="DV55">
            <span class="nav-logo-text">DV55</span>
        </a>
        <div class="nav-links">
            <a href="#hero">Головна</a>
            <a href="#about">Про нас</a>
            <a href="#courses">Курси</a>
            <a href="#contact">Контакти</a>
        </div>
        <div class="nav-right">
            <div class="nav-lang">
                <a href="/" class="active">UA</a>
                <a href="/en">EN</a>
            </div>
            @auth
                <a href="{{ url('/cabinet') }}" class="nav-cta">Кабінет →</a>
            @else
                <a href="{{ route('login') }}" class="nav-cta">Увійти →</a>
            @endauth
        </div>
        <button class="nav-mobile-toggle" id="mobileToggle" aria-label="Menu">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
        </button>
    </div>
</nav>

<div class="nav-mobile-menu" id="mobileMenu">
    <a href="#hero"    onclick="closeMobile()">Головна</a>
    <a href="#about"   onclick="closeMobile()">Про нас</a>
    <a href="#courses" onclick="closeMobile()">Курси</a>
    <a href="#contact" onclick="closeMobile()">Контакти</a>
    <div style="display:flex;gap:8px;padding:4px 16px">
        <a href="/" style="font-size:.8rem;font-weight:700;color:var(--accent)">UA</a>
        <a href="/en" style="font-size:.8rem;font-weight:700;color:var(--text-muted)">EN</a>
    </div>
    @auth
        <a href="{{ url('/cabinet') }}" style="color:var(--accent)">→ Кабінет</a>
    @else
        <a href="{{ route('login') }}" style="color:var(--accent)">→ Увійти</a>
    @endauth
</div>

{{-- ── HERO ── --}}
<section class="hero" id="hero">
    <div class="hero-bg"></div>
    <div class="hero-slides">
        <div class="hero-slide" style="background-image:url('{{ asset('images/hero_1.png') }}')"></div>
        <div class="hero-slide" style="background-image:url('{{ asset('images/hero_2.png') }}')"></div>
        <div class="hero-slide" style="background-image:url('{{ asset('images/hero_3.png') }}')"></div>
        <div class="hero-slide" style="background-image:url('{{ asset('images/hero_4.png') }}')"></div>
    </div>
    <div class="hero-overlay"></div>
    <div class="hero-grid-lines"></div>
    <div class="hero-glow"></div>
    <div class="hero-inner">
        <div class="hero-content reveal">
            <div class="hero-badge">
                <span></span>
                Ліцензовано МОН України
            </div>
            <h1 class="hero-title">
                Сертифіковані<br>курси <em>охорони</em><br>нового рівня
            </h1>
            <p class="hero-desc">
                Підготуйте себе до роботи в охоронній галузі з DV55 — 30+ років практичного досвіду, офіційне свідоцтво державного зразка.
            </p>
            <div class="hero-actions">
                <a href="#courses" class="btn-primary">
                    Переглянути курси
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14"/><path d="M12 5l7 7-7 7"/></svg>
                </a>
                <a href="#about" class="btn-ghost">Про нас</a>
            </div>
        </div>
        <div class="hero-card reveal" style="transition-delay:.15s">
            <div class="hero-card-title">Напрямки навчання</div>
            <div class="hero-course-item"><div class="hci-dot"></div><div class="hci-text">Охоронник 1–4 розряд</div></div>
            <div class="hero-course-item"><div class="hci-dot"></div><div class="hci-text">Охоронець (тілоохоронець)</div></div>
            <div class="hero-course-item"><div class="hci-dot"></div><div class="hci-text">Охорона торгових центрів</div></div>
            <div class="hero-course-item"><div class="hci-dot"></div><div class="hci-text">Охорона навчальних закладів</div></div>
            <div class="hero-course-item"><div class="hci-dot"></div><div class="hci-text">Супровід вантажоперевезень</div></div>
            <div class="hero-course-item"><div class="hci-dot"></div><div class="hci-text">Морська та річкова охорона</div></div>
            <div class="hero-course-item"><div class="hci-dot"></div><div class="hci-text">Інформаційна безпека</div></div>
        </div>
    </div>
</section>

{{-- ── STATS ── --}}
<div class="stats-strip">
    <div class="stats-inner container">
        <div class="stat-item reveal">
            <div class="stat-num" data-count="30">0+</div>
            <div class="stat-label">років у сфері<br>наземної охорони</div>
        </div>
        <div class="stat-item reveal" style="transition-delay:.07s">
            <div class="stat-num" data-count="1100">0+</div>
            <div class="stat-label">рейсів охоронного<br>супроводу вантажів</div>
        </div>
        <div class="stat-item reveal" style="transition-delay:.14s">
            <div class="stat-num" data-count="30">0+</div>
            <div class="stat-label">охоронюваних<br>об'єктів</div>
        </div>
        <div class="stat-item reveal" style="transition-delay:.21s">
            <div class="stat-num" data-count="150">0+</div>
            <div class="stat-label">контрактів з морської<br>охорони у зоні ризику</div>
        </div>
        <div class="stat-item reveal" style="transition-delay:.28s">
            <div class="stat-num" data-count="7">0</div>
            <div class="stat-label">міжнародних операцій<br>ескортування</div>
        </div>
        <div class="stat-item reveal" style="transition-delay:.35s">
            <div class="stat-num">1</div>
            <div class="stat-label">стрілецький клуб<br>& тренінговий центр</div>
        </div>
    </div>
</div>

{{-- ── ABOUT ── --}}
<section class="section" id="about">
    <div class="container">
        <div class="grid-2">
            <div class="about-visual reveal">
                <div class="about-logo-wrap">
                    <img src="{{ asset('images/logo_big.svg') }}" alt="DV55 Logo">
                </div>
            </div>
            <div class="reveal" style="transition-delay:.1s">
                <div class="eyebrow">Про нас</div>
                <h2 class="section-title">Група компаній DV55</h2>
                <p class="section-sub" style="margin-bottom:24px">
                    На підставі <strong>Ліцензії Міністерства освіти і науки України</strong> проводимо комплексне професійно-технічне навчання та підвищення кваліфікації. Особам, що успішно завершили навчання, видається <strong>Свідоцтво встановленого державного зразка</strong>.
                </p>
                <div class="specialties">
                    <div class="spec-item">
                        <div class="spec-icon"><i class="fa-solid fa-shield-halved"></i></div>
                        <div class="spec-text">Охоронник 1–4 розряд</div>
                    </div>
                    <div class="spec-item">
                        <div class="spec-icon"><i class="fa-solid fa-user-shield"></i></div>
                        <div class="spec-text">Охоронець (тілоохоронець)</div>
                    </div>
                    <div class="spec-item">
                        <div class="spec-icon"><i class="fa-solid fa-building"></i></div>
                        <div class="spec-text">Персонал торгових центрів</div>
                    </div>
                    <div class="spec-item">
                        <div class="spec-icon"><i class="fa-solid fa-school"></i></div>
                        <div class="spec-text">Персонал навчальних закладів</div>
                    </div>
                    <div class="spec-item">
                        <div class="spec-icon"><i class="fa-solid fa-truck"></i></div>
                        <div class="spec-text">Супровід вантажоперевезень</div>
                    </div>
                    <div class="spec-item">
                        <div class="spec-icon"><i class="fa-solid fa-anchor"></i></div>
                        <div class="spec-text">Судноплавство та морська охорона</div>
                    </div>
                    <div class="spec-item">
                        <div class="spec-icon"><i class="fa-solid fa-lock"></i></div>
                        <div class="spec-text">Інформаційна безпека</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Expertise cards --}}
        <div class="expertise-grid">
            @php
            $exp = [
                ['30+',  'років у сфері наземної охорони, безпеки та транспорту'],
                ['1100+','рейсів охоронного супроводу вантажів по всій Україні'],
                ['30+',  'охоронюваних об\'єктів станом на 2021 рік'],
                ['150+', 'контрактів з морської охорони в Зоні Високого Ризику'],
                ['7',    'операцій ескортування до країн Північної та Центральної Африки'],
                ['∞',    'Власний стрілецький клуб та тренувальний центр'],
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
            <div class="eyebrow" style="justify-content:center">Наша місія</div>
            <div class="mission-icons">
                <div class="mission-icon"><i class="fa-solid fa-handshake"></i></div>
                <div class="mission-icon"><i class="fa-solid fa-star"></i></div>
                <div class="mission-icon"><i class="fa-solid fa-graduation-cap"></i></div>
            </div>
            <p class="mission-quote">
                Впровадження охоронних послуг нового рівня, де превалює <strong>командна робота, професіоналізм та освіченість</strong> персоналу
            </p>
        </div>
    </div>
</section>

{{-- ── COURSES ── --}}
<section class="section" id="courses">
    <div class="container">
        <div class="reveal">
            <div class="eyebrow">Навчання</div>
            <h2 class="section-title">Наші курси</h2>
            <p class="section-sub">
                Відповідно до законодавства України, охоронна діяльність здійснюється персоналом, який відповідає встановленим кваліфікаційним вимогам. Отримайте <strong>Свідоцтво охоронника</strong> державного зразка.
            </p>
        </div>
        <div class="courses-grid">
            @foreach($courses as $i => $course)
            <div class="course-card reveal" style="transition-delay:{{ ($i % 3) * 0.08 }}s">
                <div class="cc-top">
                    <div class="cc-icon">
                        <img src="{{ asset('images/logo_big.svg') }}" alt="DV55">
                    </div>
                    <div class="cc-title">{{ $course->title }}</div>
                </div>
                <div class="cc-body">
                    <p class="cc-desc">{{ $course->description }}</p>
                </div>
                <div class="cc-footer">
                    <span class="cc-modules">{{ count($course->modules) }} {{ count($course->modules) === 1 ? 'модуль' : (count($course->modules) < 5 ? 'модулі' : 'модулів') }}</span>
                    @auth
                        <a href="/courses/{{ $course->id }}" class="cc-btn">Розпочати →</a>
                    @else
                        <a href="{{ route('login') }}" class="cc-btn">Увійти →</a>
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
            <div class="eyebrow">Зв'язок</div>
            <h2 class="section-title">Зв'яжіться з нами</h2>
            <p class="section-sub">Маєте питання щодо курсів чи навчання? Напишіть нам — відповімо якнайшвидше.</p>
        </div>
        <div class="contact-grid">
            <div class="contact-form-card reveal" style="transition-delay:.1s">
                <form method="POST" action="/sendmail" autocomplete="off">
                    @csrf
                    <div class="cf-group">
                        <label class="cf-label">Ваше ім'я</label>
                        <input type="text" name="name" class="cf-input" placeholder="Ім'я та прізвище" required>
                    </div>
                    <div class="cf-group">
                        <label class="cf-label">Електронна пошта</label>
                        <input type="email" name="email" class="cf-input" placeholder="your@email.com" required>
                    </div>
                    <div class="cf-group">
                        <label class="cf-label">Повідомлення</label>
                        <textarea name="message" class="cf-textarea" placeholder="Ваше питання..." required></textarea>
                    </div>
                    <button type="submit" class="cf-submit">Надіслати повідомлення</button>
                </form>
            </div>
            <div class="contact-info reveal" style="transition-delay:.2s">
                <a href="tel:+380963905907" class="social-card">
                    <div class="sc-icon em">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.81a19.79 19.79 0 01-3.07-8.72A2 2 0 012 1h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 8.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>
                    </div>
                    <div>
                        <div class="sc-label">Телефон</div>
                        <div class="sc-val">+380 (96) 390 59 07</div>
                    </div>
                </a>
                <a href="tel:+380982203329" class="social-card">
                    <div class="sc-icon em">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.81a19.79 19.79 0 01-3.07-8.72A2 2 0 012 1h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 8.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>
                    </div>
                    <div>
                        <div class="sc-label">Телефон</div>
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
        <div class="eyebrow" style="justify-content:center">Ми у соцмережах</div>
        <h2 class="section-title" style="margin-bottom:0">Слідкуйте за нами</h2>
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
                    <img src="{{ asset('images/logo_small.svg') }}" alt="DV55">
                    <span>DV55</span>
                </div>
                <p class="footer-tagline">Навчальний центр охорони. Ліцензовано Міністерством освіти і науки України.</p>
            </div>
            <div>
                <div class="footer-col-title">Навігація</div>
                <div class="footer-links">
                    <a href="#hero">Головна</a>
                    <a href="#about">Про нас</a>
                    <a href="#courses">Курси</a>
                    <a href="#contact">Контакти</a>
                </div>
            </div>
            <div>
                <div class="footer-col-title">Корисне</div>
                <div class="footer-links">
                    <a href="{{ route('login') }}">Вхід</a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <span class="footer-copy">© {{ date('Y') }} <span class="footer-accent">DV55</span> Training Center. Всі права захищено.</span>
            <div style="display:flex;gap:10px">
                <a href="/" style="font-size:.78rem;font-weight:700;color:var(--accent)">UA</a>
                <a href="/en" style="font-size:.78rem;font-weight:700;color:var(--text-muted)">EN</a>
            </div>
        </div>
    </div>
</footer>

<script>
// Nav scroll effect
var nav = document.getElementById('siteNav');
window.addEventListener('scroll', function() {
    nav.classList.toggle('scrolled', window.scrollY > 30);
}, { passive: true });
nav.classList.toggle('scrolled', window.scrollY > 30);

// Mobile menu
document.getElementById('mobileToggle').addEventListener('click', function() {
    document.getElementById('mobileMenu').classList.toggle('open');
});
function closeMobile() { document.getElementById('mobileMenu').classList.remove('open'); }

// Reveal on scroll
var observer = new IntersectionObserver(function(entries) {
    entries.forEach(function(e) { if(e.isIntersecting) { e.target.classList.add('visible'); observer.unobserve(e.target); } });
}, { threshold: 0.12 });
document.querySelectorAll('.reveal').forEach(function(el) { observer.observe(el); });

// Counter animation
function animateCounter(el) {
    var target = +el.getAttribute('data-count');
    if(!target) return;
    var suffix = el.textContent.includes('+') ? '+' : '';
    var start = 0, duration = 1800;
    var step = function(ts) {
        if(!start) start = ts;
        var progress = Math.min((ts - start) / duration, 1);
        var ease = 1 - Math.pow(1 - progress, 3);
        el.textContent = Math.floor(ease * target) + suffix;
        if(progress < 1) requestAnimationFrame(step);
        else el.textContent = target + suffix;
    };
    requestAnimationFrame(step);
}
var counterObserver = new IntersectionObserver(function(entries) {
    entries.forEach(function(e) {
        if(e.isIntersecting) { animateCounter(e.target); counterObserver.unobserve(e.target); }
    });
}, { threshold: 0.5 });
document.querySelectorAll('[data-count]').forEach(function(el) { counterObserver.observe(el); });
</script>
</body>
</html>
