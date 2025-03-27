@props([
    'color' => 'gray-800',
    'hoverColor' => 'gray-800/10',
    'focusColor' => 'gray-700',
    'activeColor' => 'gray-900',
    'textColor' => 'white',

    'darkColor' => 'white',
    'darkHoverColor' => 'gray-200',
    'darkFocusColor' => 'gray-300',
    'darkActiveColor' => 'gray-400',
    'darkTextColor' => 'gray-900'
])

<button {{ $attributes->merge([
    'type' => 'submit',
    'class' => "inline-flex items-center px-4 py-2 border border-transparent rounded-md
                font-semibold text-xs uppercase tracking-widest transition ease-in-out duration-150
                bg-{$color} text-{$textColor} hover:bg-{$hoverColor} focus:bg-{$focusColor} active:bg-{$activeColor}
                dark:bg-{$darkColor} dark:text-{$darkTextColor} dark:hover:bg-{$darkHoverColor}
                dark:focus:bg-{$darkFocusColor} dark:active:bg-{$darkActiveColor}
                focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
]) }}>
    {{ $slot }}
</button>
