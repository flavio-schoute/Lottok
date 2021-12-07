<nav class="flex justify-between items-center h-16 shadow-lg font-semibold text-xl text-gray-800 leading-tight">
    <div class="logo">
        <h1 class="ml-8 cursor-pointer">Logo</h1>
    </div>
    <ul>
        <li>
            <a {{ $attributes }} class="mr-8 whitespace-nowrap inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                {{ $slot }}
            </a>
        </li>
    </ul>
</nav>

