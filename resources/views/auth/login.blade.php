<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DV55 — Вхід</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --accent: #A6192E;
            --accent2: #7c1a2e;
            --dark: #0d0d1a;
            --card-bg: rgba(255,255,255,0.07);
            --card-border: rgba(255,255,255,0.13);
            --input-bg: rgba(255,255,255,0.08);
            --input-border: rgba(255,255,255,0.18);
            --input-focus: rgba(166,25,46,0.7);
            --text: #f0f0f5;
            --text-sub: rgba(240,240,245,0.55);
        }

        body {
            font-family: 'Inter', system-ui, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--dark);
            overflow: hidden;
            position: relative;
        }

        /* ── Animated gradient background ── */
        .bg-gradient {
            position: fixed;
            inset: -50%;
            width: 200%;
            height: 200%;
            background: conic-gradient(
                from 0deg at 40% 50%,
                #0d0d1a 0deg,
                #1a0510 60deg,
                #2d0a18 100deg,
                #A6192E 160deg,
                #2d0a18 200deg,
                #0d0d1a 260deg,
                #0a0a1f 300deg,
                #0d0d1a 360deg
            );
            animation: rotateBg 18s linear infinite;
            filter: blur(80px) saturate(1.4);
            opacity: 0.9;
            z-index: 0;
        }
        @keyframes rotateBg {
            to { transform: rotate(360deg); }
        }

        /* ── Floating orbs ── */
        .orbs { position: fixed; inset: 0; z-index: 1; pointer-events: none; }
        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            animation: floatOrb linear infinite;
            opacity: 0;
        }
        .orb:nth-child(1) { width:340px;height:340px; background:rgba(166,25,46,0.35); top:10%; left:5%;  animation-duration:22s; animation-delay:0s; }
        .orb:nth-child(2) { width:220px;height:220px; background:rgba(100,15,40,0.45); top:60%; left:75%; animation-duration:17s; animation-delay:-6s; }
        .orb:nth-child(3) { width:280px;height:280px; background:rgba(30,10,60,0.55);  top:30%; left:55%; animation-duration:25s; animation-delay:-11s; }
        .orb:nth-child(4) { width:180px;height:180px; background:rgba(166,25,46,0.25); top:75%; left:20%; animation-duration:19s; animation-delay:-4s; }
        .orb:nth-child(5) { width:400px;height:400px; background:rgba(10,5,30,0.6);    top:-5%; left:40%; animation-duration:30s; animation-delay:-15s; }

        @keyframes floatOrb {
            0%   { transform: translate(0,0) scale(1);    opacity:0; }
            10%  { opacity:1; }
            50%  { transform: translate(40px,-60px) scale(1.1); }
            90%  { opacity:1; }
            100% { transform: translate(0,0) scale(1);    opacity:0; }
        }

        /* ── Particle dots ── */
        .particles { position: fixed; inset: 0; z-index: 1; pointer-events: none; }
        .dot {
            position: absolute;
            width: 2px; height: 2px;
            background: rgba(255,255,255,0.6);
            border-radius: 50%;
            animation: riseDot linear infinite;
        }
        @keyframes riseDot {
            0%   { transform: translateY(0) scale(1);   opacity:0; }
            20%  { opacity:0.7; }
            80%  { opacity:0.3; }
            100% { transform: translateY(-100vh) scale(0.5); opacity:0; }
        }

        /* ── Card ── */
        .login-wrap {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 400px;
            padding: 20px;
        }

        .login-card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 20px;
            padding: 44px 40px 40px;
            backdrop-filter: blur(24px) saturate(1.8);
            -webkit-backdrop-filter: blur(24px) saturate(1.8);
            box-shadow:
                0 0 0 1px rgba(255,255,255,0.05) inset,
                0 32px 64px rgba(0,0,0,0.5),
                0 0 80px rgba(166,25,46,0.12);
            animation: cardIn 0.7s cubic-bezier(0.16,1,0.3,1) both;
        }
        @keyframes cardIn {
            from { opacity:0; transform:translateY(28px) scale(0.96); }
            to   { opacity:1; transform:translateY(0)    scale(1); }
        }

        /* ── Logo ── */
        .login-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin-bottom: 28px;
        }
        .login-logo-icon {
            width: 46px; height: 46px;
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 4px 20px rgba(166,25,46,0.5);
        }
        .login-logo-icon svg { width:22px; height:22px; }
        .login-logo-text {
            font-size: 1.6rem;
            font-weight: 700;
            color: var(--text);
            letter-spacing: -0.5px;
        }

        .login-title {
            text-align: center;
            font-size: 1.05rem;
            font-weight: 500;
            color: var(--text-sub);
            margin-bottom: 32px;
            letter-spacing: 0.2px;
        }

        /* ── Form ── */
        .form-group { margin-bottom: 18px; }

        .form-label {
            display: block;
            font-size: 0.78rem;
            font-weight: 600;
            color: var(--text-sub);
            text-transform: uppercase;
            letter-spacing: 0.6px;
            margin-bottom: 7px;
        }

        .form-input {
            width: 100%;
            background: var(--input-bg);
            border: 1px solid var(--input-border);
            border-radius: 10px;
            padding: 12px 16px;
            font-size: 0.95rem;
            font-family: inherit;
            color: var(--text);
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
        }
        .form-input::placeholder { color: rgba(240,240,245,0.3); }
        .form-input:focus {
            border-color: var(--input-focus);
            background: rgba(255,255,255,0.11);
            box-shadow: 0 0 0 3px rgba(166,25,46,0.2);
        }
        .form-input:-webkit-autofill,
        .form-input:-webkit-autofill:focus {
            -webkit-box-shadow: 0 0 0 1000px rgba(30,10,25,0.9) inset;
            -webkit-text-fill-color: var(--text);
            caret-color: var(--text);
        }

        .form-error {
            font-size: 0.78rem;
            color: #f87171;
            margin-top: 5px;
        }

        /* ── Submit ── */
        .btn-login {
            width: 100%;
            margin-top: 8px;
            padding: 13px;
            background: linear-gradient(135deg, var(--accent) 0%, #c41f38 100%);
            border: none;
            border-radius: 10px;
            color: #fff;
            font-size: 0.97rem;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            letter-spacing: 0.3px;
            transition: transform 0.15s, box-shadow 0.15s, filter 0.15s;
            box-shadow: 0 4px 20px rgba(166,25,46,0.45);
            position: relative;
            overflow: hidden;
        }
        .btn-login::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.15), transparent);
            pointer-events: none;
        }
        .btn-login:hover  { transform: translateY(-1px); box-shadow: 0 6px 28px rgba(166,25,46,0.6); filter: brightness(1.08); }
        .btn-login:active { transform: translateY(0);    box-shadow: 0 2px 10px rgba(166,25,46,0.35); filter: brightness(0.96); }

        /* ── Bottom note ── */
        .login-note {
            text-align: center;
            margin-top: 22px;
            font-size: 0.78rem;
            color: var(--text-sub);
        }

        @media (max-width: 480px) {
            .login-card { padding: 32px 24px 28px; border-radius: 16px; }
        }
    </style>
</head>
<body>

<div class="bg-gradient"></div>

<div class="orbs">
    <div class="orb"></div>
    <div class="orb"></div>
    <div class="orb"></div>
    <div class="orb"></div>
    <div class="orb"></div>
</div>

<div class="particles" id="particles"></div>

<div class="login-wrap">
    <div class="login-card">

        <div class="login-logo">
            <div class="login-logo-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.2"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>
            </div>
            <span class="login-logo-text">DV55</span>
        </div>

        <p class="login-title">Ласкаво просимо до платформи навчання</p>

        <form method="POST" action="{{ route('login') }}" autocomplete="off">
            @csrf

            <div class="form-group">
                <label class="form-label">Електронна пошта</label>
                <input type="email" name="email" class="form-input" placeholder="your@email.com"
                    value="{{ old('email') }}" required autofocus>
                @error('email')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Пароль</label>
                <input type="password" name="password" class="form-input" placeholder="••••••••" required>
                @error('password')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn-login">Увійти</button>
        </form>

        <p class="login-note">Навчальна платформа DV55 &nbsp;·&nbsp; {{ date('Y') }}</p>
    </div>
</div>

<script>
// Generate floating particles
(function(){
    var container = document.getElementById('particles');
    for(var i = 0; i < 55; i++){
        var dot = document.createElement('div');
        dot.className = 'dot';
        var size = Math.random() * 2.5 + 1;
        dot.style.cssText = [
            'width:'  + size + 'px',
            'height:' + size + 'px',
            'left:'   + Math.random() * 100 + '%',
            'bottom:' + (Math.random() * -20) + 'vh',
            'animation-duration:' + (Math.random() * 12 + 8) + 's',
            'animation-delay:' + (Math.random() * -20) + 's',
            'opacity:' + (Math.random() * 0.5 + 0.1)
        ].join(';');
        container.appendChild(dot);
    }
})();
</script>
</body>
</html>
