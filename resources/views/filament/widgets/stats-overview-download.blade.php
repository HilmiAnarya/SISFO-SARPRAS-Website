<x-filament::section>
    <x-filament::grid :columns="3" class="gap-4">

        <x-filament::card>
            <div class="text-lg font-bold">Total Peminjaman</div>
            <div class="text-sm text-gray-500 mb-2">Semua data peminjaman</div>
            <div class="text-3xl font-semibold mb-4">
                {{ \App\Models\Peminjaman::count() }}
            </div>
            <x-filament::button
                tag="a"
                href="{{ route('downloadpeminjaman') }}"
                icon="heroicon-o-arrow-down-tray"
                color="warning"
                target="_blank"
            >
                Download Laporan Peminjaman
            </x-filament::button>
        </x-filament::card>

        <x-filament::card>
            <div class="text-lg font-bold">Total Pengembalian</div>
            <div class="text-sm text-gray-500 mb-2">Semua data pengembalian</div>
            <div class="text-3xl font-semibold mb-4">
                {{ \App\Models\Pengembalian::count() }}
            </div>
            <x-filament::button
                tag="a"
                href="{{ route('downloadpengembalian') }}"
                icon="heroicon-o-arrow-down-tray"
                color="success"
                target="_blank"
            >
                Download Laporan Pengembalian
            </x-filament::button>
        </x-filament::card>
    </x-filament::grid>
</x-filament::section>
