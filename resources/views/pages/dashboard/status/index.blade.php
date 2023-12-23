<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Car Status
        </h2>

    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-10">
                <a href="{{ route('dashboard.car-status.edit', $status->id) }}"
                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded shadow-lg">
                    ✏️ UPDATE STATUS
                </a>
            </div>
            <div class="bg-white overflow-hidden shadow sm:rounded-lg mb-10">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex-grow ml-2">
                        <table class="table-auto w-full ml-4">
                            <tr>
                                <th class="border px-6 py-4 text-left">Suhu</th>
                                <td class="border px-6 py-4">{{ $status->temperature }}</td>
                            </tr>
                            <tbody>
                                <tr>
                                    <th class="border px-6 py-4 text-left">Stasiun Asal</th>
                                    <td class="border px-6 py-4">{{ $status->origin }}</td>
                                </tr>
                                <tr>
                                    <th class="border px-6 py-4 text-left">Stasiun Tujuan</th>
                                    <td class="border px-6 py-4">{{ $status->destination }}</td>
                                </tr>
                                <tr>
                                    <th class="border px-6 py-4 text-left">Stasiun Berikutnya</th>
                                    <td class="border px-6 py-4">{{ $status->next_station }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>


    </div>
    </div>
</x-app-layout>
