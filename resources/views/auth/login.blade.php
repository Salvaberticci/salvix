<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" style="color: var(--color-white);">
        @csrf

        <!-- Email Address -->
        <div style="margin-bottom: 20px;">
            <label for="email" style="display: block; font-size: 0.9rem; margin-bottom: 5px; color: var(--color-border);">Correo Electrónico</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" 
                   style="width: 100%; padding: 10px; background: var(--color-black); border: 1px solid var(--color-border-dark); color: var(--color-white); border-radius: 2px;">
            <x-input-error :messages="$errors->get('email')" style="color: var(--color-red); font-size: 0.8rem; margin-top: 5px;" />
        </div>

        <!-- Password -->
        <div style="margin-bottom: 20px;">
            <label for="password" style="display: block; font-size: 0.9rem; margin-bottom: 5px; color: var(--color-border);">Contraseña</label>
            <input id="password" type="password" name="password" required autocomplete="current-password" 
                   style="width: 100%; padding: 10px; background: var(--color-black); border: 1px solid var(--color-border-dark); color: var(--color-white); border-radius: 2px;">
            <x-input-error :messages="$errors->get('password')" style="color: var(--color-red); font-size: 0.8rem; margin-top: 5px;" />
        </div>

        <!-- Remember Me -->
        <div style="margin-bottom: 25px; display: flex; align-items: center;">
            <input id="remember_me" type="checkbox" name="remember" style="margin-right: 10px;">
            <label for="remember_me" style="font-size: 0.85rem; color: var(--color-text-light);">Recordar mi sesión</label>
        </div>

        <div style="display: flex; flex-direction: column; gap: 15px;">
            <button type="submit" class="btn-critical" style="width: 100%; padding: 12px !important;">
                Iniciar Sesión
            </button>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" style="font-size: 0.85rem; color: var(--color-text-mid); text-align: center; text-decoration: none;">
                    ¿Olvidaste tu contraseña?
                </a>
            @endif
        </div>
    </form>
</x-guest-layout>
