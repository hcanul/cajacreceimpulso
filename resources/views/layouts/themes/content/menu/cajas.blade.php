<li>
    <button type="button" class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-example" data-collapse-toggle="dropdown-example">
        @include('layouts.themes.icons.caja')
        <span class="flex-1 ml-3 text-left whitespace-nowrap">Reportes</span>
        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
        </svg>
    </button>
    <ul id="dropdown-example" class="hidden py-2 space-y-2">
        <li>
            <a href="{{ route('caja.Efectivo') }}" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                @include('layouts.themes.icons.preview')
                <span class="flex-1 ml-3 whitespace-nowrap">Efectivo</span>
            </a>
        </li>
        <li>
            <a href="{{ route('caja.Banco') }}" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                @include('layouts.themes.icons.preview')
                <span class="flex-1 ml-3 whitespace-nowrap">Bancos</span>
            </a>
        </li>
    </ul>
</li>
