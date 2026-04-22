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
        
        /* Overrides para el diseño dinámico */
        .card, x-card, [role="grid"] > article {
            background-color: var(--public-card-bg) !important;
            color: var(--public-card-text) !important;
            border-radius: var(--public-radius) !important;
            border: 1px solid rgba(0,0,0,0.05);
        }
        .btn-critical, button[type="submit"]:not(.btn-standard) {
            background-color: var(--public-primary) !important;
            border-color: var(--public-primary) !important;
            border-radius: var(--public-radius) !important;
        }
        .label-editorial {
            font-family: var(--public-font);
        }
    </style>
</head>
<body>

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
