<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Salvix') }} - Acceso</title>

        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="https://unpkg.com/@phosphor-icons/web@2.0.3/src/regular/style.css">
    </head>
    <body class="chiaroscuro-dark" style="display: flex; min-height: 100vh; align-items: center; justify-content: center; background-color: var(--color-black); font-family: var(--font-body);">
        
        <div style="width: 100%; max-width: 400px; padding: 40px; background: var(--color-surface); border-radius: 4px; box-shadow: 0 20px 40px rgba(0,0,0,0.5); text-align:center;">
            
            <div style="margin-bottom: 30px;">
                <a href="/">
                    @if(file_exists(public_path('img/logo.png')))
                        <img src="{{ asset('img/logo.png') }}" alt="Logo" style="max-height: 80px; width:auto; margin: 0 auto;">
                    @else
                        <h1 style="margin:0; font-size:2rem; color:var(--color-white); letter-spacing:-1px;">SALVIX</h1>
                    @endif
                </a>
                <p class="label-editorial" style="margin-top: 15px; color: var(--color-text-light);">Acceso Administrativo</p>
            </div>

            <div style="text-align: left;">
                {{ $slot }}
            </div>
            
            <div style="margin-top: 30px; border-top: 1px solid var(--color-border-dark); padding-top: 20px;">
                <p style="font-size: 0.7rem; color: var(--color-text-mid); margin: 0;">&copy; {{ date('Y') }} Salvix Restaurant System</p>
            </div>
        </div>

    </body>
</html>
