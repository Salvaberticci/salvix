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

    <style>
        /* Public layout specific overrides for clean light mode */
        body {
            background-color: var(--color-white);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }
        .public-header {
            background-color: var(--color-black);
            border-bottom: 2px solid var(--color-gold);
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1001;
            color: white;
        }
        .app-content {
            flex: 1;
        }
    </style>
</head>
<body>

    <header class="public-header">
        <div style="display:flex; align-items:center; gap:15px;">
            <!-- Botón Volver (Solo en el Wizard) -->
            @if(Request::is('pagar'))
                <a href="{{ route('catalogo.index') }}" class="btn-standard" style="padding: 5px 12px !important; border-color:rgba(255,255,255,0.2) !important; color:white; font-size: 0.7rem; text-decoration:none; display:flex; align-items:center; gap:5px;">
                    <i class="ph ph-arrow-left"></i> Volver al Menú
                </a>
            @endif
            
            <div style="display:flex; align-items:center; gap:10px;">
                @if(file_exists(public_path('img/logo.png')))
                    <img src="{{ asset('img/logo.png') }}" alt="Logo" style="max-height: 40px; width:auto;">
                @else
                    <h1 style="margin:0; font-size:1.4rem; color:white; letter-spacing:-1px;">SALVIX</h1>
                @endif
                <span class="label-editorial" style="font-size:0.7rem; color:white; border-left: 1px solid rgba(255,255,255,0.3); padding-left:10px;">MENÚ DIGITAL</span>
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
