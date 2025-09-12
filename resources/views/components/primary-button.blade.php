@props([
    'loading' => 'Processing...',
    'target' => null, // allow passing a wire target dynamically
])

<button
    {{ $attributes->merge([
        'type' => 'button',
        'class' => 'btn btn-primary',
        'style' => 'background:#1e40af; border-color:#2563eb;',
    ]) }}
    wire:loading.attr="disabled"
    @if($target) wire:target="{{ $target }}" @endif
>
    <span wire:loading.remove @if($target) wire:target="{{ $target }}" @endif>
        {{ $slot }}
    </span>

    <span wire:loading @if($target) wire:target="{{ $target }}" @endif>
        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        {{ $loading }}
    </span>
</button>
