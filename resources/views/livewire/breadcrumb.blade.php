<nav class="breadcrumb bg-gray-100 p-4 shadow">
    <ol class="flex items-center space-x-3 text-sm text-gray-700">
        <!-- Link para Home -->
        <li class="flex items-center">
            <a href="{{ route('dashboard') }}" class="flex items-center text-blue-600 hover:text-blue-800">
                Home
            </a>
        </li>

        <!-- Separador e links dinâmicos -->
        @foreach($breadcrumbs as $breadcrumb)
            <li class="text-gray-400">/</li>
            <li>
                <a href="{{ $breadcrumb['url'] }}" class="text-blue-600 hover:text-blue-800 hover:underline">
                    {{ $breadcrumb['label'] }}
                </a>
            </li>
        @endforeach
    </ol>
</nav>
