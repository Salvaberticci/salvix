<article {{ $attributes->merge(['class' => 'card-editorial']) }}>
    @if(isset($header))
    <header style="border-bottom: 1px solid var(--color-border); padding: 15px 20px;">
        {{ $header }}
    </header>
    @endif
    
    <div style="padding: 20px;">
        {{ $slot }}
    </div>

    @if(isset($footer))
    <footer style="border-top: 1px solid var(--color-border); padding: 15px 20px; background-color: #fafafa;">
        {{ $footer }}
    </footer>
    @endif
</article>
