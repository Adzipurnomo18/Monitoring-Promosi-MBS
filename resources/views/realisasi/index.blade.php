@extends('layouts.app')

@section('title', 'Realisasi & Verifikasi')
@section('header_title', 'Realisasi & Verifikasi Promosi')
@section('header_subtitle', 'Pantau bukti implementasi display cabang, verifikasi data penjualan, dan validasi sebelum penerbitan invoice AR.')

@section('content')
<div class="space-y-6">

    <!-- KPI Summary Cards -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div class="white-card p-4 border-l-4 border-l-slate-400">
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Penugasan Outlet</span>
            <div class="mt-2 flex items-baseline justify-between">
                <span class="text-2xl font-extrabold text-slate-800">{{ $stats['total'] }}</span>
                <span class="text-xs text-slate-500 font-semibold bg-slate-100 px-2 py-0.5 rounded-full">Unit</span>
            </div>
        </div>

        <div class="white-card p-4 border-l-4 border-l-amber-500">
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Menunggu Realisasi Toko</span>
            <div class="mt-2 flex items-baseline justify-between">
                <span class="text-2xl font-extrabold text-amber-600">{{ $stats['menunggu_outlet'] }}</span>
                <span class="text-xs text-amber-700 font-semibold bg-amber-50 px-2 py-0.5 rounded-full">Pending</span>
            </div>
        </div>

        <div class="white-card p-4 border-l-4 border-l-emerald-500">
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Sudah Realisasi &amp; Valid</span>
            <div class="mt-2 flex items-baseline justify-between">
                <span class="text-2xl font-extrabold text-emerald-600">{{ $stats['sudah_realisasi'] }}</span>
                <span class="text-xs text-emerald-700 font-semibold bg-emerald-50 px-2 py-0.5 rounded-full">Verified</span>
            </div>
        </div>

        <div class="white-card p-4 border-l-4 border-l-rose-500">
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Perlu Revisi</span>
            <div class="mt-2 flex items-baseline justify-between">
                <span class="text-2xl font-extrabold text-rose-600">{{ $stats['revisi'] }}</span>
                <span class="text-xs text-rose-700 font-semibold bg-rose-50 px-2 py-0.5 rounded-full">Revisi</span>
            </div>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="white-card p-4 sm:p-5">
        <form method="GET" action="{{ route('realisasi.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3.5 items-end">
            
            <!-- Search -->
            <div>
                <label class="block text-xs font-bold text-slate-600 mb-1">Cari Program / Cabang</label>
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}" 
                    placeholder="Nama cabang, nomor promo..."
                    class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-slate-50/50"
                />
            </div>

            <!-- Filter Status -->
            <div>
                <label class="block text-xs font-bold text-slate-600 mb-1">Status Realisasi Cabang</label>
                <select name="status_realisasi" class="w-full text-xs px-3 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-slate-50/50">
                    <option value="semua">Semua Status</option>
                    <option value="menunggu_outlet" {{ request('status_realisasi') === 'menunggu_outlet' ? 'selected' : '' }}>Menunggu Outlet</option>
                    <option value="sudah_realisasi" {{ request('status_realisasi') === 'sudah_realisasi' ? 'selected' : '' }}>Sudah Realisasi</option>
                    <option value="revisi" {{ request('status_realisasi') === 'revisi' ? 'selected' : '' }}>Perlu Revisi</option>
                </select>
            </div>

            <!-- Filter Outlet -->
            <div>
                <label class="block text-xs font-bold text-slate-600 mb-1">Cabang Toko</label>
                <select name="outlet_id" class="w-full text-xs px-3 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-slate-50/50">
                    <option value="">Semua Cabang MBS</option>
                    @foreach($outlets as $o)
                        <option value="{{ $o->id }}" {{ request('outlet_id') == $o->id ? 'selected' : '' }}>
                            {{ $o->nama_outlet }} ({{ $o->ou_code }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Filter Submit -->
            <div class="flex items-center gap-2">
                <button type="submit" class="flex-1 bg-[#0070e0] hover:bg-blue-600 text-white font-bold text-xs py-2.5 px-4 rounded-xl shadow-sm transition-all flex items-center justify-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                    <span>Filter</span>
                </button>
                @if(request()->hasAny(['search', 'status_realisasi', 'outlet_id']))
                <a href="{{ route('realisasi.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold text-xs py-2.5 px-3 rounded-xl transition-colors">
                    Reset
                </a>
                @endif
            </div>

        </form>
    </div>

    <!-- Data Table -->
    <div class="white-card overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
            <div class="flex items-center gap-2.5">
                <h3 class="font-extrabold text-sm text-slate-800">Antrean Verifikasi Realisasi Outlet</h3>
                <span class="text-xs bg-slate-100 text-slate-600 px-2 py-0.5 rounded-full font-bold">{{ $realisasis->total() }} Data</span>
            </div>
            <div class="text-[11px] text-slate-400">
                Persetujuan HO akan otomatis memperbarui nilai realisasi program promo terkait.
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider text-[10px] border-b border-slate-200/80">
                        <th class="py-3 px-4">Cabang MBS</th>
                        <th class="py-3 px-4">Program Promo</th>
                        <th class="py-3 px-4">Supplier &amp; Skema</th>
                        <th class="py-3 px-4 text-right">Alokasi Biaya</th>
                        <th class="py-3 px-4">Tgl Realisasi</th>
                        <th class="py-3 px-4 text-center">Status</th>
                        <th class="py-3 px-4 text-center">Bukti / Catatan</th>
                        <th class="py-3 px-4 text-center">Aksi Verifikasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($realisasis as $r)
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="py-3.5 px-4 whitespace-nowrap">
                            <div class="font-bold text-slate-800">{{ $r->outlet?->nama_outlet ?? '-' }}</div>
                            <div class="text-[10px] font-mono text-slate-400">{{ $r->outlet?->ou_code }} &bull; {{ $r->outlet?->kota }}</div>
                        </td>
                        <td class="py-3.5 px-4 max-w-xs">
                            <div class="font-mono text-[11px] font-bold text-blue-700">{{ $r->programPromo?->nomor_program }}</div>
                            <div class="font-semibold text-slate-800 truncate" title="{{ $r->programPromo?->judul_program }}">
                                {{ $r->programPromo?->judul_program }}
                            </div>
                        </td>
                        <td class="py-3.5 px-4 whitespace-nowrap">
                            <div class="font-semibold text-slate-700">{{ $r->programPromo?->supplier?->nama_supplier ?? '-' }}</div>
                            <div class="text-[10px] text-slate-400">{{ $r->programPromo?->metodeKesepakatan?->nama_metode ?? '-' }}</div>
                        </td>
                        <td class="py-3.5 px-4 text-right whitespace-nowrap font-bold text-slate-800">
                            Rp {{ number_format($r->nilai_alokasi, 0, ',', '.') }}
                        </td>
                        <td class="py-3.5 px-4 whitespace-nowrap text-slate-600">
                            {{ $r->tanggal_realisasi ? $r->tanggal_realisasi->format('d M Y') : '-' }}
                        </td>
                        <td class="py-3.5 px-4 text-center whitespace-nowrap">
                            @if($r->status_realisasi_outlet === 'sudah_realisasi')
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-300">
                                    Sudah Realisasi
                                </span>
                            @elseif($r->status_realisasi_outlet === 'revisi')
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-300">
                                    Perlu Revisi
                                </span>
                            @else
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-300">
                                    Menunggu Outlet
                                </span>
                            @endif
                        </td>
                        <td class="py-3.5 px-4 text-center whitespace-nowrap">
                            @if($r->catatan_outlet)
                                <button type="button" onclick="showNoteModal('{{ addslashes($r->catatan_outlet) }}')" class="text-blue-600 hover:underline text-[11px] font-semibold">
                                    Lihat Catatan
                                </button>
                            @else
                                <span class="text-slate-400 text-[11px]">-</span>
                            @endif
                        </td>
                        <td class="py-3.5 px-4 text-center whitespace-nowrap">
                            <div class="flex items-center justify-center gap-1.5">
                                @if($r->status_realisasi_outlet !== 'sudah_realisasi')
                                <!-- Form HO Approve -->
                                <form method="POST" action="{{ route('realisasi.verify', $r->id) }}" onsubmit="return confirmVerify(event, this)">
                                    @csrf
                                    <input type="hidden" name="action" value="approve">
                                    <button type="submit" class="bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-300 font-bold text-[11px] px-2.5 py-1 rounded-lg transition-colors" title="Setujui Realisasi">
                                        &check; Setujui HO
                                    </button>
                                </form>
                                @endif

                                <!-- Update Dialog Trigger -->
                                <button 
                                    type="button" 
                                    onclick="openEditRealisasiModal({{ $r->id }}, '{{ $r->status_realisasi_outlet }}', '{{ $r->tanggal_realisasi ? $r->tanggal_realisasi->format('Y-m-d') : '' }}', '{{ addslashes($r->catatan_outlet ?? '') }}')"
                                    class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-[11px] px-2.5 py-1 rounded-lg transition-colors"
                                >
                                    Ubah
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="py-12 text-center text-slate-400">
                            <p class="font-medium text-xs">Tidak ada data realisasi promosi yang sesuai filter.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($realisasis->hasPages())
        <div class="p-4 border-t border-slate-100">
            {{ $realisasis->links() }}
        </div>
        @endif
    </div>

</div>

<!-- Modal Ubah Status & Bukti Realisasi -->
<div id="realisasiModal" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full overflow-hidden">
        <form id="realisasiForm" method="POST" action="" class="space-y-4">
            @csrf
            @method('PATCH')

            <div class="px-5 py-4 bg-gradient-to-r from-[#072147] to-[#0070e0] text-white flex items-center justify-between">
                <h4 class="font-extrabold text-sm">Update Realisasi Cabang</h4>
                <button type="button" onclick="closeRealisasiModal()" class="text-white/80 hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="p-5 space-y-4 text-xs">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Status Realisasi</label>
                    <select name="status_realisasi_outlet" id="modalStatusSelect" class="w-full text-xs px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="menunggu_outlet">Menunggu Outlet</option>
                        <option value="sudah_realisasi">Sudah Realisasi (Display Terpasang / Promo Berjalan)</option>
                        <option value="revisi">Revisi (Bukti Kurang / Belum Sesuai)</option>
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Tanggal Realisasi Lapangan</label>
                    <input type="date" name="tanggal_realisasi" id="modalTanggalInput" class="w-full text-xs px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Catatan Verifikasi / Keterangan</label>
                    <textarea name="catatan_outlet" id="modalCatatanInput" rows="3" placeholder="Contoh: Display gondola lorong 2 terpasang sesuai spek supplier." class="w-full text-xs p-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                </div>
            </div>

            <div class="px-5 py-3.5 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-2">
                <button type="button" onclick="closeRealisasiModal()" class="px-4 py-2 rounded-xl text-slate-600 font-bold hover:bg-slate-100">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold shadow-sm">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function openEditRealisasiModal(id, status, tanggal, catatan) {
        document.getElementById('realisasiForm').action = `/realisasi/${id}`;
        document.getElementById('modalStatusSelect').value = status;
        document.getElementById('modalTanggalInput').value = tanggal || '{{ now()->toDateString() }}';
        document.getElementById('modalCatatanInput').value = catatan || '';
        document.getElementById('realisasiModal').classList.remove('hidden');
    }

    function closeRealisasiModal() {
        document.getElementById('realisasiModal').classList.add('hidden');
    }

    function confirmVerify(e, form) {
        e.preventDefault();
        Swal.fire({
            title: 'Verifikasi Realisasi HO',
            text: 'Apakah Anda menyetujui bahwa display/promo telah terpasang dan tervalidasi di cabang ini?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#10b981',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Verifikasi & Setujui',
            cancelButtonText: 'Batal',
            customClass: { popup: 'rounded-2xl' }
        }).then((res) => {
            if (res.isConfirmed) {
                form.submit();
            }
        });
        return false;
    }

    function showNoteModal(text) {
        Swal.fire({
            title: 'Catatan Realisasi Outlet',
            text: text,
            icon: 'info',
            confirmButtonColor: '#0070e0',
            confirmButtonText: 'Tutup',
            customClass: { popup: 'rounded-2xl' }
        });
    }
</script>
@endpush
