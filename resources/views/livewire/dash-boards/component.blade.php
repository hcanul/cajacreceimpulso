<div>
    <div class="pb-4 font-medium text-gray-900 whitespace-nowrap dark:text-white justify-self-auto">
        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">{{$componentName}} | {{$pageTitle}}</h3>
    </div>
    <div class="flex items-center justify-between pb-4 bg-white ma-3 dark:bg-gray-900">
        <div class="justify-self-auto">
            <div class="mt-2 ml-2">
                <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha</label>
                <input wire:model.live='fecha' type="date" id="first_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="John" required />
            </div>
        </div>

            <div class="mt-2 justify-self-auto">
                {{-- <button wire:click="limpiar()" class="relative inline-flex items-center justify-center p-0.5 mb-2 mr-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-purple-600 to-blue-500 group-hover:from-purple-600 group-hover:to-blue-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800" type="button">
                    <span class="block relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                        Imprimir Corte General
                    </span>
                </button> --}}
            </div>

    </div>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500 rtl:text-right dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3 bg-gray-50 dark:bg-gray-800">
                        Sucursal
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Efectivo
                    </th>
                    <th scope="col" class="px-6 py-3 bg-gray-50 dark:bg-gray-800">
                        Banco
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Total
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ( $totales['details'] as $total )
                    <tr class="border-b border-gray-200 dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                            @php
                                $sucursal = ucfirst(str_replace("creceimp_", "", $total['db_name']));
                            @endphp
                            {{ $sucursal }}
                        </th>
                        <td class="px-6 py-4">
                            {{ '$ ' . number_format($total['total_efectivo'],2) }}
                        </td>
                        <td class="px-6 py-4 bg-gray-50 dark:bg-gray-800">
                            {{ '$ ' . number_format($total['total_bancos'],2) }}
                        </td>
                        <td class="px-6 py-4">
                            {{ '$ ' . number_format($total['total_general'],2) }}
                        </td>
                    </tr>
                @empty
                <tr class="border-b border-gray-200 dark:border-gray-700">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                        Sin Data
                    </th>
                    <td class="px-6 py-4">
                        Sin Data
                    </td>
                    <td class="px-6 py-4 bg-gray-50 dark:bg-gray-800">
                        Sin Data
                    </td>
                    <td class="px-6 py-4">
                        Sin Data
                    </td>
                </tr>
                @endforelse

            </tbody>
        </table>
    </div>

    </div>
