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
           RADICAL THEME OVERRIDES (Scoped by body class)
           ========================================================== */

        /* 1. RETRO DINER (Brutalist / Comic Style) */
        body.theme-retro-diner {
            background-image: radial-gradient(var(--public-primary) 1px, transparent 1px);
            background-size: 20px 20px;
            background-color: var(--public-bg);
        }
        .theme-retro-diner .public-header {
            border-bottom: 4px solid black;
            box-shadow: 0 4px 0 black;
        }
        .theme-retro-diner .card, .theme-retro-diner x-card, .theme-retro-diner [role="grid"] > article {
            border: 3px solid black !important;
            box-shadow: 6px 6px 0 black !important;
            transform: translate(-2px, -2px);
        }
        .theme-retro-diner .card:hover, .theme-retro-diner x-card:hover {
            transform: translate(0, 0);
            box-shadow: 2px 2px 0 black !important;
        }
        .theme-retro-diner .product-img-container {
            border-bottom: 3px solid black !important;
            margin: -20px -20px 20px -20px !important;
            border-radius: var(--public-radius) var(--public-radius) 0 0 !important;
        }
        .theme-retro-diner .btn-standard {
            border: 3px solid black !important;
            font-weight: 900 !important;
            box-shadow: 4px 4px 0 black !important;
            text-transform: uppercase;
        }
        .theme-retro-diner .btn-standard:active {
            transform: translate(4px, 4px);
            box-shadow: 0 0 0 black !important;
        }

        /* 2. NORDIC WHITE (Extreme Minimalism) */
        .theme-nordic-white .public-header {
            border-bottom: 1px solid rgba(0,0,0,0.05);
            background: transparent;
        }
        .theme-nordic-white .grid {
            gap: 60px !important;
        }
        .theme-nordic-white .card, .theme-nordic-white x-card {
            border: none !important;
            background: transparent !important;
            box-shadow: none !important;
            padding: 0 !important;
        }
        .theme-nordic-white .product-img-container {
            border-radius: 20px !important;
            height: 300px !important; /* Huge images */
            margin: 0 0 20px 0 !important;
            box-shadow: 0 20px 40px rgba(0,0,0,0.08);
            transition: transform 0.5s cubic-bezier(0.2, 0.8, 0.2, 1);
        }
        .theme-nordic-white .card:hover .product-img-container {
            transform: scale(1.02);
        }
        .theme-nordic-white h3 {
            font-size: 1.4rem;
            text-align: center;
            letter-spacing: 2px;
        }
        .theme-nordic-white .price-tag {
            display: block;
            text-align: center;
            font-size: 1.1rem;
            color: var(--color-text-mid) !important;
        }
        .theme-nordic-white .btn-standard {
            border-radius: 50px !important;
            border: 1px solid var(--public-primary) !important;
            color: var(--public-primary) !important;
        }
        .theme-nordic-white .btn-standard:hover {
            background: var(--public-primary) !important;
            color: white !important;
        }

        /* 3. CYBERPUNK NIGHT (Neon & Glitch) */
        body.theme-cyberpunk-night {
            background: repeating-linear-gradient(
                0deg,
                rgba(0, 0, 0, 0.15),
                rgba(0, 0, 0, 0.15) 1px,
                transparent 1px,
                transparent 2px
            ), var(--public-bg);
        }
        .theme-cyberpunk-night .public-header {
            border-bottom: 2px solid var(--public-primary);
            box-shadow: 0 0 15px var(--public-primary);
        }
        .theme-cyberpunk-night .card, .theme-cyberpunk-night x-card {
            border: 1px solid var(--public-primary) !important;
            box-shadow: inset 0 0 10px rgba(255, 0, 255, 0.2), 0 0 10px rgba(255, 0, 255, 0.2) !important;
            background: rgba(10, 10, 10, 0.8) !important;
            backdrop-filter: blur(5px);
        }
        .theme-cyberpunk-night .product-img-container {
            filter: contrast(1.2) saturate(1.5);
            border-bottom: 1px solid var(--public-primary) !important;
        }
        .theme-cyberpunk-night .card:hover {
            box-shadow: inset 0 0 20px var(--public-primary), 0 0 20px var(--public-primary) !important;
        }
        .theme-cyberpunk-night h3 {
            text-shadow: 2px 2px 0px rgba(0,255,255,0.5);
            text-transform: uppercase;
        }
        .theme-cyberpunk-night .price-tag {
            color: #00ffff !important;
            text-shadow: 0 0 5px #00ffff;
        }
        .theme-cyberpunk-night .btn-standard {
            background: transparent !important;
            color: var(--public-primary) !important;
            border: 1px solid var(--public-primary) !important;
            box-shadow: 0 0 5px var(--public-primary);
            text-transform: uppercase;
            letter-spacing: 3px;
        }
        .theme-cyberpunk-night .btn-standard:hover {
            background: var(--public-primary) !important;
            color: black !important;
            box-shadow: 0 0 15px var(--public-primary);
        }

        /* 4. MIDNIGHT EMERALD (Luxury Portrait) */
        body.theme-midnight-emerald {
            background-image: url('data:image/svg+xml;utf8,<svg width="20" height="20" xmlns="http://www.w3.org/2000/svg"><rect width="20" height="20" fill="none"/><circle cx="2" cy="2" r="1" fill="rgba(255,255,255,0.03)"/></svg>');
        }
        .theme-midnight-emerald .public-header {
            border-bottom: 1px solid rgba(192, 160, 128, 0.3); /* Gold border */
        }
        .theme-midnight-emerald .grid {
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)) !important; /* Wider cards */
        }
        .theme-midnight-emerald .card, .theme-midnight-emerald x-card {
            border: 1px solid rgba(192, 160, 128, 0.4) !important; /* Gold */
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5) !important;
        }
        .theme-midnight-emerald .product-img-container {
            height: 350px !important; /* Portrait mode images */
            margin: -20px -20px 20px -20px !important;
            border-bottom: 2px solid var(--public-primary) !important;
        }
        .theme-midnight-emerald h3 {
            font-style: italic;
            text-align: center;
            font-size: 1.5rem;
            color: var(--public-primary) !important;
        }
        .theme-midnight-emerald .price-tag {
            display: block;
            text-align: center;
            font-size: 1.2rem;
            margin-top: 5px;
        }
        .theme-midnight-emerald p {
            text-align: center;
            opacity: 0.8;
        }
        .theme-midnight-emerald .btn-standard {
            border: 1px solid var(--public-primary) !important;
            color: var(--public-primary) !important;
            border-radius: 0 !important;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .theme-midnight-emerald .btn-standard:hover {
            background: var(--public-primary) !important;
            color: var(--public-header-bg) !important;
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
