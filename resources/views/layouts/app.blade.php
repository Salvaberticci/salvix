<!DOCTYPE html>
<html lang="es" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') - Salvix Restaurant</title>
    
    <!-- Pico CSS (Base framework) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
    
    <!-- Custom CSS (Ferrari Design System - Static for Shared Hosting) -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    
    <!-- Toastify CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    
    <!-- Phosphor Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- GSAP -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="app-layout" x-data="{ sidebarOpen: false }">
        
        <!-- Sidebar (Desktop - Void Black) -->
        <aside class="app-sidebar">
            <div class="app-sidebar-logo">
                <h3 style="margin:0; font-family:var(--font-heading);">Salvix</h3>
                <span class="label-editorial" style="display:block; margin-top:5px; color:#888;">Restaurant System</span>
            </div>
            
            <nav class="app-sidebar-nav">
                <a href="{{ url('/dashboard') }}" class="app-sidebar-link {{ request()->is('dashboard') ? 'active' : '' }}">
                    <i class="ph ph-squares-four app-sidebar-icon"></i>
                    <span>Dashboard</span>
                </a>
                
                <a href="{{ url('/pedidos') }}" class="app-sidebar-link {{ request()->is('pedidos*') ? 'active' : '' }}">
                    <i class="ph ph-receipt app-sidebar-icon"></i>
                    <span>Pedidos</span>
                </a>
                
                <a href="{{ url('/catalogo') }}" class="app-sidebar-link {{ request()->is('catalogo') ? 'active' : '' }}">
                    <i class="ph ph-book-open app-sidebar-icon"></i>
                    <span>Catálogo POS</span>
                </a>
                
                <a href="{{ url('/pagos') }}" class="app-sidebar-link {{ request()->is('pagos*') ? 'active' : '' }}">
                    <i class="ph ph-wallet app-sidebar-icon"></i>
                    <span>Pagos</span>
                </a>
                
                @if(auth()->user() && auth()->user()->rol === 'admin')
                    <div style="margin: 20px 0 10px 25px;">
                        <span class="label-editorial" style="color:#555;">Administración</span>
                    </div>
                
                    <a href="{{ url('/productos') }}" class="app-sidebar-link {{ request()->is('productos*') || request()->is('categorias*') ? 'active' : '' }}">
                        <i class="ph ph-hamburger app-sidebar-icon"></i>
                        <span>Menú & Productos</span>
                    </a>
                    
                    <a href="{{ url('/inventario') }}" class="app-sidebar-link {{ request()->is('inventario*') ? 'active' : '' }}">
                        <i class="ph ph-package app-sidebar-icon"></i>
                        <span>Inventario</span>
                    </a>
                    
                    <a href="{{ url('/chatbot') }}" class="app-sidebar-link {{ request()->is('chatbot*') ? 'active' : '' }}">
                        <i class="ph ph-robot app-sidebar-icon"></i>
                        <span>Chatbot IA</span>
                    </a>
                    
                    <a href="{{ url('/configuracion') }}" class="app-sidebar-link {{ request()->is('configuracion') ? 'active' : '' }}">
                        <i class="ph ph-gear app-sidebar-icon"></i>
                        <span>Configuración</span>
                    </a>
                @endif
            </nav>
            
            <div class="app-sidebar-footer">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn-standard" style="width:100%;">Salir</button>
                </form>
            </div>
        </aside>

        <!-- Main Workspace -->
        <main class="app-workspace">
            <!-- Topbar (Editorial White Header) -->
            <header class="app-header">
                <div>
                    <h2 class="app-header-title">@yield('header_title', 'Dashboard')</h2>
                </div>
                <div class="d-flex align-center gap-3">
                    <span class="label-editorial" style="color:var(--color-text-dark);">
                        @if(auth()->user())
                            {{ auth()->user()->name }} <span style="color:#aaa;">({{ auth()->user()->rol }})</span>
                        @else
                            Usuario
                        @endif
                    </span>
                    <div class="badge badge-gold">Tasa: Bs <span class="tasa-bcv-display">{{ \App\Models\Configuracion::where('clave', 'tasa_bcv')->value('valor') ?? '36.50' }}</span></div>
                </div>
            </header>

            <!-- Page Content -->
            <div class="app-content">
                @yield('content')
            </div>
        </main>

        <!-- Bottom Nav (Mobile - Precision Instrument look) -->
        <nav class="app-bottom-nav">
            <a href="{{ url('/dashboard') }}" class="app-bottom-link {{ request()->is('dashboard') ? 'active' : '' }}">
                <i class="ph ph-squares-four"></i>
                Inicio
            </a>
            <a href="{{ url('/pedidos') }}" class="app-bottom-link {{ request()->is('pedidos*') ? 'active' : '' }}">
                <i class="ph ph-receipt"></i>
                Pedidos
            </a>
            <a href="{{ url('/catalogo') }}" class="app-bottom-link {{ request()->is('catalogo') ? 'active' : '' }}">
                <i class="ph ph-book-open"></i>
                Catálogo
            </a>
            <a href="{{ url('/pagos') }}" class="app-bottom-link {{ request()->is('pagos*') ? 'active' : '' }}">
                <i class="ph ph-wallet"></i>
                Pagos
            </a>
            @if(auth()->user() && auth()->user()->rol === 'admin')
            <a href="{{ url('/configuracion') }}" class="app-bottom-link {{ request()->is('configuracion') ? 'active' : '' }}">
                <i class="ph ph-gear"></i>
                Ajustes
            </a>
            @endif
        </nav>
    </div>

    <!-- Toastify JS -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    
    <!-- Notification helper -->
    <script>
        window.notify = (message, type = 'success') => {
            Toastify({
                text: message,
                duration: 3000,
                close: true,
                gravity: "top", 
                position: "right",
                style: {
                    background: type === 'success' ? "#03904A" : 
                               (type === 'error' ? "var(--color-red)" : "#4C98B9"),
                }
            }).showToast();
        };

        // BCV Reactive Polling
        const updateTasaUI = (tasa) => {
            document.querySelectorAll('.tasa-bcv-display').forEach(el => {
                if(el.tagName === 'INPUT') {
                    if(document.activeElement !== el) el.value = tasa;
                } else {
                    el.innerText = tasa;
                }
            });
            window.dispatchEvent(new CustomEvent('bcv-updated', { detail: tasa }));
        };

        const fetchTasa = () => {
            fetch('{{ url("/api/tasa-sync") }}', { 
                cache: 'no-store',
                headers: {
                    'Accept': 'application/json'
                }
            })
            .then(r => r.json())
            .then(data => {
                if(data.success && data.tasa) updateTasaUI(data.tasa);
                else console.warn("Sincronización falló:", data);
            }).catch(e => console.error("Error al sincronizar BCV:", e));
        };

        // Solicitar inmediatamente al cargar la página
        fetchTasa();

        // Y luego consultar cada hora
        setInterval(fetchTasa, 3600000);
        
        @if(session('success'))
            notify('{{ session('success') }}', 'success');
        @endif
        @if(session('error'))
            notify('{{ session('error') }}', 'error');
        @endif
    </script>
    
    @yield('scripts')
</body>
</html>
