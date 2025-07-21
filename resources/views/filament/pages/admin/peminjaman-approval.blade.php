<x-filament::page>
    <x-filament::section heading="Peminjaman Pending Approval">
        @foreach ($pendingPeminjaman as $peminjaman)
            <x-filament::card class="mb-4">
                <div class="flex justify-between items-center">
                    <div>
                        <p><strong>Nama:</strong> {{ $peminjaman->nama_peminjam }}</p>
                        <p><strong>Tanggal Pinjam:</strong> {{ $peminjaman->tanggal_pinjam }}</p>
                        <p><strong>Status:</strong> {{ $peminjaman->status_approval }}</p>
                    </div>
                    <div class="space-x-2">
                        <form method="POST" action="{{ route('admin.peminjaman.approve', $peminjaman->id_peminjaman) }}">
                            @csrf
                            <x-filament::button color="success" type="submit">Approve</x-filament::button>
                        </form>
                        <form method="POST" action="{{ route('admin.peminjaman.reject', $peminjaman->id_peminjaman) }}">
                            @csrf
                            <x-filament::button color="danger" type="submit">Tolak</x-filament::button>
                        </form>
                    </div>
                </div>
            </x-filament::card>
        @endforeach
    </x-filament::section>

    <x-filament::section heading="Peminjaman Sedang Berlangsung">
        @foreach ($berlangsungPeminjaman as $peminjaman)
            <x-filament::card class="mb-4">
                <p><strong>Nama:</strong> {{ $peminjaman->nama_peminjam }}</p>
                <p><strong>Tanggal Pinjam:</strong> {{ $peminjaman->tanggal_pinjam }}</p>
                <p><strong>Status:</strong> {{ $peminjaman->status }}</p>
            </x-filament::card>
        @endforeach
    </x-filament::section>
</x-filament::page>
