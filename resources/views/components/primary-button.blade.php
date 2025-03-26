@props(['color' => 'gray-800', 'hoverColor' => 'gray-700', 'focusColor' => 'gray-700', 'activeColor' => 'gray-900', 'textColor' => 'white'])

<button {{ $attributes->merge([
    'type' => 'submit',
    'class' => "inline-flex items-center px-4 py-2 bg-{$color} border border-transparent rounded-md
                font-semibold text-xs text-{$textColor} uppercase tracking-widest
                hover:bg-{$hoverColor} focus:bg-{$focusColor} active:bg-{$activeColor}
                focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2
                transition ease-in-out duration-150"
]) }}>
    {{ $slot }}
</button>
