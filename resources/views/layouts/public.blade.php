<!DOCTYPE html>
<html lang="es" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Menú') - Salvix Restaurant</title>
    
    <!-- Pico CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
    
    <!-- Custom CSS (Ferrari Design System - Static) -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    
    <!-- Toastify CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    
    <!-- Phosphor Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- GSAP -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>

    <!-- Google Fonts Dynamic Injection -->
    @php
        $activeTheme = \App\Models\Tema::where('es_activo', true)->first();
        $themeConfig = $activeTheme->config ?? [];
        $activeFont = $themeConfig['font_family'] ?? "'Inter', sans-serif";
        // Extract font name for Google Fonts API
        preg_match("/'([^']+)'/", $activeFont, $matches);
        $fontName = $matches[1] ?? 'Inter';
        $fontQuery = str_replace(' ', '+', $fontName);
    @endphp
    <link href="https://fonts.googleapis.com/css2?family={{ $fontQuery }}:wght@400;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --public-bg: {{ $themeConfig['bg_color'] ?? 'var(--color-white)' }};
            --public-header-bg: {{ $themeConfig['header_bg'] ?? 'var(--color-black)' }};
            --public-header-text: {{ $themeConfig['header_text'] ?? 'white' }};
            --public-card-bg: {{ $themeConfig['card_bg'] ?? 'var(--color-white)' }};
            --public-card-text: {{ $themeConfig['card_text'] ?? '#1a1a1a' }};
            --public-primary: {{ $themeConfig['primary_color'] ?? 'var(--color-red)' }};
            --public-radius: {{ ($themeConfig['border_radius'] ?? 2) . 'px' }};
            --public-font: {!! $activeFont !!};
        }

        body {
            background-color: var(--public-bg);
            font-family: var(--public-font);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
            color: var(--public-card-text);
        }
        .public-header {
            background-color: var(--public-header-bg);
            border-bottom: 2px solid var(--public-primary);
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1001;
            color: var(--public-header-text);
        }
        .app-content {
            flex: 1;
        }
        
        /* Overrides para el diseño dinámico base */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 30px;
        }
        .category-link {
            text-decoration: none;
            text-transform: uppercase;
            font-size: 0.8rem;
            font-weight: bold;
            padding-bottom: 5px;
            color: var(--color-muted);
            transition: all 0.2s ease;
        }
        .category-link.active {
            border-bottom: 2px solid var(--public-primary);
            color: var(--color-text-dark);
        }
        .product-title {
            margin: 0;
            font-size: 1.2rem;
            line-height: 1.2;
        }
        .price-tag {
            font-weight: bold;
            color: var(--color-gold);
        }
        .product-desc {
            color: var(--color-text-mid);
            font-size: 0.9rem;
            margin-top: 10px;
            line-height: 1.4;
        }
        .btn-add-cart {
            width: 100%;
            margin-top: 15px !important;
        }
        .card, x-card, [role="grid"] > article {
            background-color: var(--public-card-bg) !important;
            color: var(--public-card-text) !important;
            border-radius: var(--public-radius) !important;
            border: 1px solid rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }
        .btn-critical, button[type="submit"]:not(.btn-standard) {
            background-color: var(--public-primary) !important;
            border-color: var(--public-primary) !important;
            border-radius: var(--public-radius) !important;
            transition: all 0.3s ease;
        }
        .label-editorial {
            font-family: var(--public-font);
        }

        /* ==========================================================
           RADICAL THEME OVERRIDES (ULTRA-PREMIUM UI/UX)
           ========================================================== */

        /* 1. FERRARI CHIAROSCURO (Modern Editorial - Default) */
        body.theme-ferrari-chiaroscuro {
            background-color: var(--public-bg);
        }
        .theme-ferrari-chiaroscuro .card, .theme-ferrari-chiaroscuro x-card {
            border: 1px solid rgba(0,0,0,0.08) !important;
            box-shadow: 0 10px 30px rgba(0,0,0,0.03) !important;
            padding: 25px !important;
            border-radius: 4px !important;
        }
        .theme-ferrari-chiaroscuro .card:hover {
            box-shadow: 0 20px 40px rgba(0,0,0,0.08) !important;
            transform: translateY(-5px);
        }
        .theme-ferrari-chiaroscuro .product-img-container {
            border-radius: 2px !important;
            margin: -25px -25px 25px -25px !important;
            height: 220px !important;
        }
        .theme-ferrari-chiaroscuro .product-title {
            font-weight: 700;
            letter-spacing: -0.5px;
            color: var(--public-card-text);
        }

        /* 2. RETRO DINER (Modern Pop-Art & Brutalism) */
        body.theme-retro-diner {
            background-color: #FFF9E6; /* Warm cream */
            background-image: radial-gradient(#FFD700 1.5px, transparent 1.5px);
            background-size: 30px 30px;
        }
        .theme-retro-diner .public-header {
            border-bottom: 4px solid #111;
            box-shadow: 0 6px 0 #111;
            background-color: var(--public-header-bg);
            padding: 20px 30px;
        }
        .theme-retro-diner .category-link {
            background: #FFF;
            border: 3px solid #111;
            border-radius: 8px 8px 0 0;
            padding: 10px 20px !important;
            color: #111 !important;
            transform: translateY(3px);
        }
        .theme-retro-diner .category-link.active {
            background: var(--public-primary);
            color: #FFF !important;
            transform: translateY(0);
            border-bottom-color: var(--public-primary);
        }
        .theme-retro-diner .card, .theme-retro-diner x-card, .theme-retro-diner article {
            border: 3px solid #111 !important;
            box-shadow: 8px 8px 0 #111 !important;
            border-radius: 12px !important;
            background-color: #FFFFFF !important;
            padding: 25px !important;
            transform: translate(0, 0);
            transition: all 0.15s ease-out;
        }
        .theme-retro-diner .card:hover {
            transform: translate(-4px, -4px);
            box-shadow: 12px 12px 0 #111 !important;
        }
        .theme-retro-diner .product-img-container {
            border-bottom: 3px solid #111 !important;
            margin: -25px -25px 20px -25px !important;
            border-radius: 9px 9px 0 0 !important;
            height: 200px !important;
        }
        .theme-retro-diner .product-title {
            font-family: 'Rubik', var(--public-font);
            font-weight: 900;
            font-size: 1.4rem;
            color: #111;
            text-transform: uppercase;
        }
        .theme-retro-diner .product-desc {
            color: #444;
            font-weight: 600;
            font-size: 0.95rem;
        }
        .theme-retro-diner .price-tag {
            background: var(--public-primary);
            color: #111 !important;
            padding: 4px 10px;
            border: 2px solid #111;
            border-radius: 20px;
            font-weight: 900;
            font-size: 1rem;
        }
        .theme-retro-diner .btn-add-cart {
            background-color: #111 !important;
            color: #FFF !important;
            border: 3px solid #111 !important;
            border-radius: 30px !important;
            font-weight: 900 !important;
            text-transform: uppercase;
            box-shadow: 4px 4px 0 var(--public-primary) !important;
            padding: 12px !important;
        }
        .theme-retro-diner .btn-add-cart:active {
            transform: translate(4px, 4px);
            box-shadow: 0 0 0 var(--public-primary) !important;
        }

        /* 3. NORDIC WHITE (Extreme Scandinavian Minimalism) */
        body.theme-nordic-white {
            background-color: #FAFAFA;
            color: #333;
        }
        .theme-nordic-white .public-header {
            border-bottom: 1px solid rgba(0,0,0,0.04);
            background: rgba(255,255,255,0.9);
            backdrop-filter: blur(10px);
            padding: 20px 40px;
        }
        .theme-nordic-white .category-link {
            font-size: 1rem;
            letter-spacing: 1px;
            color: #AAA !important;
            border: none !important;
        }
        .theme-nordic-white .category-link.active {
            color: #222 !important;
            font-weight: 400;
            border-bottom: 1px solid #222 !important;
        }
        .theme-nordic-white .product-grid {
            gap: 80px !important;
            padding: 40px 0;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        }
        .theme-nordic-white .card, .theme-nordic-white x-card, .theme-nordic-white article {
            border: none !important;
            background: transparent !important;
            box-shadow: none !important;
            padding: 0 !important;
        }
        .theme-nordic-white .product-img-container {
            border-radius: 24px !important;
            height: 350px !important; /* Huge gorgeous images */
            margin: 0 0 25px 0 !important;
            box-shadow: 0 20px 50px rgba(0,0,0,0.06);
            transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.6s ease;
        }
        .theme-nordic-white .card:hover .product-img-container {
            transform: scale(1.02);
            box-shadow: 0 30px 60px rgba(0,0,0,0.1);
        }
        .theme-nordic-white .product-title {
            font-size: 1.6rem;
            font-weight: 300;
            color: #222;
            text-align: center;
            letter-spacing: -0.5px;
            margin-bottom: 5px !important;
        }
        .theme-nordic-white .price-tag {
            display: block;
            text-align: center;
            font-size: 1.1rem;
            color: #888 !important;
            font-weight: 300 !important;
        }
        .theme-nordic-white .product-desc {
            text-align: center;
            color: #777;
            line-height: 1.6;
            margin-top: 15px !important;
            font-size: 1rem;
            font-weight: 300;
        }
        .theme-nordic-white .btn-add-cart {
            background-color: transparent !important;
            border: 1px solid #DDD !important;
            color: #222 !important;
            border-radius: 50px !important;
            padding: 12px 30px !important;
            margin-top: 25px !important;
            width: auto !important;
            display: block;
            margin-left: auto;
            margin-right: auto;
            transition: all 0.3s ease;
        }
        .theme-nordic-white .btn-add-cart:hover {
            background-color: #222 !important;
            color: #FFF !important;
            border-color: #222 !important;
        }

        /* 4. CYBERPUNK NIGHT (High-End Synthwave) */
        body.theme-cyberpunk-night {
            background-color: #050510;
            background-image: 
                linear-gradient(rgba(0, 255, 255, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(0, 255, 255, 0.03) 1px, transparent 1px);
            background-size: 30px 30px;
            color: #E0E0E0;
        }
        .theme-cyberpunk-night h1, .theme-cyberpunk-night h2, .theme-cyberpunk-night h3, .theme-cyberpunk-night h4, .theme-cyberpunk-night h5, .theme-cyberpunk-night h6 {
            color: #00FFFF !important;
            font-family: 'JetBrains Mono', monospace;
            text-shadow: 0 0 5px rgba(0,255,255,0.3);
        }
        .theme-cyberpunk-night .category-link {
            color: #00FFFF !important;
            font-family: 'JetBrains Mono', monospace;
            text-shadow: 0 0 5px rgba(0,255,255,0.3);
            border: 1px solid transparent;
            padding: 5px 15px;
        }
        .theme-cyberpunk-night .category-link.active {
            border: 1px solid #00FFFF !important;
            background: rgba(0,255,255,0.1);
            box-shadow: inset 0 0 10px rgba(0,255,255,0.2);
        }
        .theme-cyberpunk-night .card, .theme-cyberpunk-night x-card, .theme-cyberpunk-night article {
            background: rgba(10, 10, 20, 0.8) !important;
            border: 1px solid rgba(0, 255, 255, 0.2) !important;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.5) !important;
            border-radius: 0 !important; /* Sharp edges */
            padding: 20px !important;
            position: relative;
            overflow: visible !important;
            color: #FFF !important;
        }
        .theme-cyberpunk-night .card::before {
            content: '';
            position: absolute;
            top: -1px; left: -1px;
            width: 15px; height: 15px;
            border-top: 2px solid #00FFFF;
            border-left: 2px solid #00FFFF;
            box-shadow: -2px -2px 10px rgba(0,255,255,0.5);
            z-index: 10;
        }
        .theme-cyberpunk-night .card:hover {
            border-color: rgba(255, 0, 255, 0.5) !important;
            box-shadow: 0 0 20px rgba(255, 0, 255, 0.2) !important;
        }
        .theme-cyberpunk-night .product-img-container {
            height: 200px !important;
            margin: -20px -20px 20px -20px !important;
            border-bottom: 1px solid rgba(255, 0, 255, 0.3) !important;
            filter: contrast(1.1) saturate(1.2);
            clip-path: polygon(0 0, 100% 0, 100% 90%, 95% 100%, 0 100%);
        }
        .theme-cyberpunk-night .product-title {
            font-family: 'JetBrains Mono', monospace;
            font-size: 1.1rem;
            color: #FFF;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 5px;
            text-shadow: 2px 2px 0px rgba(0,255,255,0.3);
        }
        .theme-cyberpunk-night .price-tag {
            color: #00FFFF !important;
            font-family: monospace;
            font-size: 1.1rem;
            text-shadow: 0 0 8px rgba(0, 255, 255, 0.4);
        }
        .theme-cyberpunk-night .product-desc {
            color: #A0A0B0;
            font-size: 0.85rem;
            font-family: sans-serif;
        }
        .theme-cyberpunk-night .btn-add-cart {
            background: rgba(255, 0, 255, 0.1) !important;
            color: #FF00FF !important;
            border: 1px solid #FF00FF !important;
            border-radius: 0 !important;
            font-family: monospace;
            text-transform: uppercase;
            letter-spacing: 2px;
            position: relative;
            transition: all 0.2s;
        }
        .theme-cyberpunk-night .btn-add-cart:hover {
            background: #FF00FF !important;
            color: #000 !important;
            box-shadow: 0 0 15px rgba(255, 0, 255, 0.5) !important;
        }

        /* 5. MIDNIGHT EMERALD (Ultra-Luxury / Michelin Star) */
        body.theme-midnight-emerald {
            background-color: #080D0B; /* Deep dark emerald */
            color: #E8EBE9;
        }
        .theme-midnight-emerald .public-header {
            background-color: #050807;
            border-bottom: 1px solid rgba(212, 175, 55, 0.15); /* Subtle Gold */
        }
        .theme-midnight-emerald h1, .theme-midnight-emerald h2, .theme-midnight-emerald h3, .theme-midnight-emerald h4, .theme-midnight-emerald h5, .theme-midnight-emerald h6 {
            color: #D4AF37 !important;
            font-family: 'Playfair Display', serif;
        }
        .theme-midnight-emerald .category-link {
            color: #889988 !important;
            font-family: 'Playfair Display', serif;
            letter-spacing: 1px;
        }
        .theme-midnight-emerald .category-link.active {
            color: #D4AF37 !important;
            border-bottom: 1px solid #D4AF37 !important;
        }
        .theme-midnight-emerald .product-grid {
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 50px;
            padding: 30px 0;
        }
        .theme-midnight-emerald .card, .theme-midnight-emerald x-card, .theme-midnight-emerald article {
            background: #0C1411 !important; /* Slightly lighter emerald */
            border: 1px solid rgba(212, 175, 55, 0.1) !important;
            box-shadow: 0 15px 35px rgba(0,0,0,0.4) !important;
            border-radius: 2px !important;
            padding: 20px !important;
            transition: all 0.4s ease;
            color: #E8EBE9 !important;
        }
        .theme-midnight-emerald .card:hover {
            border-color: rgba(212, 175, 55, 0.4) !important;
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.6) !important;
        }
        .theme-midnight-emerald .product-img-container {
            height: 340px !important; /* Portrait mode (elegant) */
            margin: -20px -20px 25px -20px !important;
            border-bottom: 2px solid rgba(212, 175, 55, 0.2) !important;
            filter: brightness(0.9) contrast(1.1);
        }
        .theme-midnight-emerald .product-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.4rem;
            color: #E8EBE9;
            text-align: center;
            letter-spacing: 0.5px;
            margin-bottom: 8px !important;
        }
        .theme-midnight-emerald .price-tag {
            display: block;
            text-align: center;
            font-size: 1.1rem;
            color: #D4AF37 !important; /* Gold */
            font-family: 'Playfair Display', serif;
            font-style: italic;
        }
        .theme-midnight-emerald .product-desc {
            text-align: center;
            color: #889988;
            font-size: 0.95rem;
            line-height: 1.6;
            margin-top: 15px !important;
        }
        .theme-midnight-emerald .btn-add-cart, .theme-midnight-emerald .btn-standard {
            background: transparent !important;
            border: 1px solid rgba(212, 175, 55, 0.4) !important;
            color: #D4AF37 !important;
            border-radius: 0 !important;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-size: 0.8rem !important;
            padding: 12px !important;
            margin-top: 25px !important;
            transition: all 0.3s ease;
        }
        .theme-midnight-emerald .btn-add-cart:hover, .theme-midnight-emerald .btn-standard:hover {
            background: rgba(212, 175, 55, 0.1) !important;
            border-color: #D4AF37 !important;
            color: #FFF !important;
        }
        
        /* Hide scrollbars on category nav */
        .category-nav::-webkit-scrollbar {
            display: none;
        }
        .category-nav {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }
    </style>
</head>
<body class="theme-{{ Str::slug($activeTheme->nombre ?? 'default') }}">

    <header class="public-header">
        <div style="display:flex; align-items:center; gap:15px;">
            <div style="display:flex; align-items:center; gap:10px;">
                @if($activeTheme && $activeTheme->logo_path)
                    <img src="{{ asset('storage/' . $activeTheme->logo_path) }}" alt="Logo" style="max-height: 40px; width:auto;">
                @elseif(file_exists(public_path('img/logo.png')))
                    <img src="{{ asset('img/logo.png') }}" alt="Logo" style="max-height: 40px; width:auto;">
                @else
                    <h1 style="margin:0; font-size:1.4rem; color:var(--public-header-text); letter-spacing:-1px;">SALVIX</h1>
                @endif
                <span class="label-editorial" style="font-size:0.7rem; color:var(--public-header-text); border-left: 1px solid rgba(255,255,255,0.3); padding-left:10px;">MENÚ DIGITAL</span>
            </div>
        </div>
        <div>
            @if(!Request::is('pagar'))
                <a href="{{ url('/pagar') }}" class="btn-critical" style="padding: 10px 20px !important; font-size: 0.8rem; text-decoration:none; display:flex; align-items:center; gap:8px;">
                    <i class="ph ph-shopping-bag" style="font-size:1.2rem;"></i> 
                    <span>FINALIZAR</span>
                </a>
            @endif
        </div>
    </header>

    <main class="app-content">
        @yield('content')
    </main>

    <footer style="background-color:var(--color-black); color:var(--color-border); padding:40px 20px; text-align:center; flex-shrink:0;">
        <h3 style="color:var(--color-white); font-family:var(--font-heading); margin-bottom:5px;">Salvix</h3>
        <p class="label-editorial" style="color:var(--color-text-mid); margin-bottom:20px;">Restaurant System</p>
        <p style="font-size:0.8rem;">&copy; {{ date('Y') }} Todos los derechos reservados.</p>
    </footer>

    <!-- Chatbot Widget -->
    <x-chatbot-widget />

    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script>
        window.notify = (message, type = 'success') => {
            Toastify({
                text: message,
                duration: 3000,
                gravity: "top", 
                position: "center",
                style: {
                    background: type === 'success' ? "#03904A" : "var(--color-red)",
                }
            }).showToast();
        };
        
        @if(session('success')) notify('{{ session('success') }}', 'success'); @endif
        @if(session('error')) notify('{{ session('error') }}', 'error'); @endif
    </script>
    @yield('scripts')
</body>
</html>
