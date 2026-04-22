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
        }
        .public-header {
            background-color: var(--color-white);
            border-bottom: 1px solid var(--color-border);
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
        }
    </style>
</head>
<body>

    <header class="public-header">
        <div>
            <h1 style="margin:0; font-size:1.5rem;">Salvix</h1>
            <span class="label-editorial" style="font-size:0.65rem;">Menú Digital</span>
        </div>
        <div>
            <!-- Could be cart indicator or logic -->
            <a href="{{ url('/pagar') }}" class="btn-critical" style="padding: 10px 15px !important; font-size: 0.8rem; text-decoration:none;">
                <i class="ph ph-shopping-cart" style="font-size:1.2rem; margin-right:5px;"></i> Finalizar
            </a>
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
