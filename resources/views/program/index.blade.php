@extends('layouts.app')

@section('title', 'Program Promo')
@section('header_title', 'Daftar Program Promosi')
@section('header_subtitle', 'Pantau seluruh program promosi, progres eksekusi, dan alokasi budget cabang MBS.')

@section('content')
<div class="space-y-6">

    <!-- KPI Summary Pills -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3.5">
        <div class="white-card p-4 flex flex-col justify-between">
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Program</span>
            <div class="flex items-baseline justify-between mt-2">
                <span class="text-2xl font-extrabold text-slate-800">{{ $stats['total'] }}</span>
                <span class="text-xs text-blue-600 font-semibold bg-blue-50 px-2 py-0.5 rounded-full">Semua</span>
            </div>
        </div>

        <div class="white-card p-4 flex flex-col justify-between border-l-4 border-l-emerald-500">
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Berjalan</span>
            <div class="flex items-baseline justify-between mt-2">
                <span class="text-2xl font-extrabold text-emerald-600">{{ $stats['berjalan'] }}</span>
                <span class="text-xs text-emerald-700 font-semibold bg-emerald-50 px-2 py-0.5 rounded-full">Aktif</span>
            </div>
        </div>

        <div class="white-card p-4 flex flex-col justify-between border-l-4 border-l-rose-500">
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Siap Tagih</span>
            <div class="flex items-baseline justify-between mt-2">
                <span class="text-2xl font-extrabold text-rose-600">{{ $stats['siap_tagih'] }}</span>
                <span class="text-xs text-rose-700 font-semibold bg-rose-50 px-2 py-0.5 rounded-full">Action</span>
            </div>
        </div>

        <div class="white-card p-4 flex flex-col justify-between border-l-4 border-l-cyan-500">
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Ditagih</span>
            <div class="flex items-baseline justify-between mt-2">
                <span class="text-2xl font-extrabold text-cyan-600">{{ $stats['ditagih'] }}</span>
                <span class="text-xs text-cyan-700 font-semibold bg-cyan-50 px-2 py-0.5 rounded-full">Invoice</span>
            </div>
        </div>

        <div class="white-card p-4 flex flex-col justify-between border-l-4 border-l-green-600">
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Lunas</span>
            <div class="flex items-baseline justify-between mt-2">
                <span class="text-2xl font-extrabold text-green-700">{{ $stats['lunas'] }}</span>
                <span class="text-xs text-green-700 font-semibold bg-green-50 px-2 py-0.5 rounded-full">Selesai</span>
            </div>
        </div>

        <div class="white-card p-4 flex flex-col justify-between bg-gradient-to-br from-blue-900 to-[#072147] text-white">
            <span class="text-[11px] font-bold text-blue-200 uppercase tracking-wider">Total Nilai</span>
            <div class="mt-2">
                <span class="text-lg font-black tracking-tight text-white">
                    Rp {{ number_format($stats['total_nilai'] / 1000000, 1, ',', '.') }} Jt
                </span>
            </div>
        </div>
    </div>

    <!-- Filter & Search Toolbar -->
    <div class="white-card p-4 sm:p-5">
        <form method="GET" action="{{ route('program.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3.5 items-end">
            
            <!-- Search Keyword -->
            <div class="lg:col-span-2">
                <label class="block text-xs font-bold text-slate-600 mb-1">Cari Program / Supplier</label>
                <div class="relative">
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}" 
                        placeholder="Ketik judul promo, nomor program..."
                        class="w-full text-xs px-3.5 py-2.5 pl-9 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-slate-50/50"
                    />
                    <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                </div>
            </div>

            <!-- Filter Status -->
            <div>
                <label class="block text-xs font-bold text-slate-600 mb-1">Status Alur</label>
                <select name="status" class="w-full text-xs px-3 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-slate-50/50">
                    <option value="semua">Semua Status</option>
                    @foreach($statuses as $key => $lbl)
                        <option value="{{ $key }}" {{ request('status') === $key ? 'selected' : '' }}>{{ $lbl }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Filter Supplier -->
            <div>
                <label class="block text-xs font-bold text-slate-600 mb-1">Supplier</label>
                <select name="supplier_id" class="w-full text-xs px-3 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-slate-50/50">
                    <option value="">Semua Supplier</option>
                    @foreach($suppliers as $supp)
                        <option value="{{ $supp->id }}" {{ request('supplier_id') == $supp->id ? 'selected' : '' }}>{{ $supp->nama_supplier }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-2">
                <button type="submit" class="flex-1 bg-[#0070e0] hover:bg-blue-600 text-white font-bold text-xs py-2.5 px-4 rounded-xl shadow-sm transition-all flex items-center justify-center gap-2">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                    <span>Filter</span>
                </button>
                @if(request()->hasAny(['search', 'status', 'supplier_id', 'tahun']))
                <a href="{{ route('program.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold text-xs py-2.5 px-3 rounded-xl transition-colors">
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
                <h3 class="font-extrabold text-sm text-slate-800">Daftar Program Promo</h3>
                <span class="text-xs bg-slate-100 text-slate-600 px-2 py-0.5 rounded-full font-bold">{{ $programs->total() }} Data</span>
            </div>
            <a href="{{ route('program.create') }}" class="text-xs font-bold text-blue-600 hover:text-blue-700 flex items-center gap-1.5">
                <span>+ Buat Program Baru</span>
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider text-[10px] border-b border-slate-200/80">
                        <th class="py-3 px-4">No. Program</th>
                        <th class="py-3 px-4">Judul Promo &amp; Event</th>
                        <th class="py-3 px-4">Supplier &amp; Metode</th>
                        <th class="py-3 px-4">Periode Promo</th>
                        <th class="py-3 px-4 text-center">Outlet</th>
                        <th class="py-3 px-4 text-right">Nilai Total</th>
                        <th class="py-3 px-4 text-center">Status</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($programs as $p)
                    @php
                        $badgeClasses = match($p->status) {
                            'draft' => 'bg-slate-100 text-slate-700 border-slate-300',
                            'diajukan' => 'bg-sky-50 text-sky-700 border-sky-300',
                            'disetujui' => 'bg-teal-50 text-teal-700 border-teal-300',
                            'berjalan' => 'bg-emerald-50 text-emerald-700 border-emerald-300',
                            'realisasi' => 'bg-amber-50 text-amber-700 border-amber-300',
                            'verifikasi' => 'bg-orange-50 text-orange-700 border-orange-300',
                            'konfirmasi_supplier' => 'bg-purple-50 text-purple-700 border-purple-300',
                            'siap_tagih' => 'bg-rose-50 text-rose-700 border-rose-300 animate-pulse',
                            'ditagih' => 'bg-cyan-50 text-cyan-700 border-cyan-300',
                            'lunas' => 'bg-green-50 text-green-700 border-green-300',
                            default => 'bg-slate-100 text-slate-700 border-slate-200'
                        };
                    @endphp
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="py-3.5 px-4 font-mono font-bold text-slate-800 whitespace-nowrap">
                            {{ $p->nomor_program }}
                        </td>
                        <td class="py-3.5 px-4 max-w-xs">
                            <div class="font-bold text-slate-800 truncate" title="{{ $p->judul_program }}">
                                {{ $p->judul_program }}
                            </div>
                            <div class="text-[11px] text-slate-500 flex items-center gap-1.5 mt-0.5">
                                <span>{{ $p->eventPromosi?->nama_event ?? 'Reguler (Non-Event)' }}</span>
                            </div>
                        </td>
                        <td class="py-3.5 px-4 whitespace-nowrap">
                            <div class="font-semibold text-slate-700">{{ $p->supplier?->nama_supplier ?? '-' }}</div>
                            <div class="text-[10px] text-slate-400 mt-0.5">{{ $p->metodeKesepakatan?->nama_metode ?? '-' }}</div>
                        </td>
                        <td class="py-3.5 px-4 whitespace-nowrap text-slate-600">
                            <div>{{ $p->tanggal_mulai ? $p->tanggal_mulai->format('d M Y') : '-' }}</div>
                            <div class="text-[10px] text-slate-400">s/d {{ $p->tanggal_selesai ? $p->tanggal_selesai->format('d M Y') : '-' }}</div>
                        </td>
                        <td class="py-3.5 px-4 text-center whitespace-nowrap">
                            <span class="inline-flex items-center justify-center px-2 py-0.5 rounded-full text-[11px] font-bold bg-blue-50 text-blue-700 border border-blue-200">
                                {{ $p->programPromoOutlets->count() }} Cabang
                            </span>
                        </td>
                        <td class="py-3.5 px-4 text-right whitespace-nowrap">
                            <div class="font-bold text-slate-800">
                                Rp {{ number_format($p->total_nilai, 0, ',', '.') }}
                            </div>
                            @if($p->nilai_realisasi > 0)
                            <div class="text-[10px] text-emerald-600 font-medium">
                                Realisasi: Rp {{ number_format($p->nilai_realisasi, 0, ',', '.') }}
                            </div>
                            @endif
                        </td>
                        <td class="py-3.5 px-4 text-center whitespace-nowrap">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider border {{ $badgeClasses }}">
                                {{ str_replace('_', ' ', $p->status) }}
                            </span>
                        </td>
                        <td class="py-3.5 px-4 text-center whitespace-nowrap">
                            <button 
                                type="button" 
                                onclick="openProgramDetailModal({{ $p->id }})"
                                class="bg-blue-50 hover:bg-blue-100 text-blue-700 font-bold text-[11px] px-3 py-1.5 rounded-lg transition-colors border border-blue-200"
                            >
                                Detail
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="py-12 text-center text-slate-400">
                            <svg class="w-10 h-10 mx-auto text-slate-300 mb-2" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                            </svg>
                            <p class="font-medium text-xs">Belum ada data program promosi yang sesuai dengan kriteria filter.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($programs->hasPages())
        <div class="p-4 border-t border-slate-100">
            {{ $programs->links() }}
        </div>
        @endif
    </div>

</div>

<!-- Modal Detail Program -->
<div id="detailModal" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-hidden flex flex-col animate-on-scroll is-visible">
        <!-- Header -->
        <div class="px-6 py-4 bg-gradient-to-r from-[#072147] to-[#0070e0] text-white flex items-center justify-between">
            <div>
                <h4 id="modalTitle" class="font-extrabold text-base">Detail Program Promo</h4>
                <p id="modalNomor" class="text-xs text-blue-200 font-mono mt-0.5"></p>
            </div>
            <button type="button" onclick="closeDetailModal()" class="text-white/80 hover:text-white p-1 rounded-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Body -->
        <div class="p-6 overflow-y-auto space-y-5 text-xs text-slate-700 flex-1">
            <div class="grid grid-cols-2 gap-4 bg-slate-50 p-3.5 rounded-xl border border-slate-200">
                <div>
                    <span class="text-slate-400 font-semibold block text-[10px] uppercase">Supplier Partner</span>
                    <span id="modalSupplier" class="font-bold text-slate-900 text-sm"></span>
                </div>
                <div>
                    <span class="text-slate-400 font-semibold block text-[10px] uppercase">Metode Kerjasama</span>
                    <span id="modalMetode" class="font-bold text-slate-900"></span>
                </div>
                <div>
                    <span class="text-slate-400 font-semibold block text-[10px] uppercase">Event Tematik</span>
                    <span id="modalEvent" class="font-medium text-slate-800"></span>
                </div>
                <div>
                    <span class="text-slate-400 font-semibold block text-[10px] uppercase">Total Komitmen Biaya</span>
                    <span id="modalTotalNilai" class="font-bold text-blue-700 text-sm"></span>
                </div>
            </div>

            <!-- Outlets List -->
            <div>
                <h5 class="font-bold text-slate-800 mb-2 flex items-center justify-between">
                    <span>Partisipasi Cabang &amp; Alokasi Budget</span>
                    <span id="modalOutletCount" class="text-[11px] text-slate-500 font-normal"></span>
                </h5>
                <div class="border border-slate-200 rounded-xl overflow-hidden">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-100 text-slate-500 text-[10px] uppercase">
                            <tr>
                                <th class="p-2.5">Cabang Toko</th>
                                <th class="p-2.5">Status Realisasi</th>
                                <th class="p-2.5 text-right">Alokasi Nilai</th>
                            </tr>
                        </thead>
                        <tbody id="modalOutletTable" class="divide-y divide-slate-100">
                            <!-- Populated via JS -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Catatan -->
            <div id="modalCatatanContainer">
                <span class="text-slate-400 font-semibold block text-[10px] uppercase mb-1">Catatan Program</span>
                <p id="modalCatatan" class="text-slate-600 bg-slate-50 p-3 rounded-lg border border-slate-200"></p>
            </div>
        </div>

        <!-- Footer -->
        <div class="px-6 py-3.5 bg-slate-50 border-t border-slate-200 flex justify-end">
            <button type="button" onclick="closeDetailModal()" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold rounded-xl text-xs transition-colors">
                Tutup
            </button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function openProgramDetailModal(id) {
        fetch(`/program-promo/${id}`)
            .then(res => res.json())
            .then(res => {
                if (res.success) {
                    const p = res.data;
                    document.getElementById('modalTitle').textContent = p.judul_program;
                    document.getElementById('modalNomor').textContent = p.nomor_program + ' (' + (p.status || '').toUpperCase() + ')';
                    document.getElementById('modalSupplier').textContent = p.supplier ? p.supplier.nama_supplier : '-';
                    document.getElementById('modalMetode').textContent = p.metode_kesepakatan ? p.metode_kesepakatan.nama_metode : '-';
                    document.getElementById('modalEvent').textContent = p.event_promosi ? p.event_promosi.nama_event : 'Reguler Promo';
                    document.getElementById('modalTotalNilai').textContent = 'Rp ' + Number(p.total_nilai).toLocaleString('id-ID');
                    document.getElementById('modalCatatan').textContent = p.catatan || 'Tidak ada catatan tambahan.';

                    // Outlet Table
                    const tbody = document.getElementById('modalOutletTable');
                    tbody.innerHTML = '';
                    if (p.program_promo_outlets && p.program_promo_outlets.length > 0) {
                        document.getElementById('modalOutletCount').textContent = p.program_promo_outlets.length + ' Cabang Terdaftar';
                        p.program_promo_outlets.forEach(po => {
                            const tr = document.createElement('tr');
                            const statusLabel = po.status_realisasi_outlet.replace('_', ' ');
                            const badgeColor = po.status_realisasi_outlet === 'sudah_realisasi' 
                                ? 'bg-emerald-100 text-emerald-800' 
                                : (po.status_realisasi_outlet === 'revisi' ? 'bg-rose-100 text-rose-800' : 'bg-amber-100 text-amber-800');

                            tr.innerHTML = `
                                <td class="p-2.5 font-medium text-slate-800">${po.outlet ? po.outlet.nama_outlet : 'Cabang'} <span class="text-slate-400 font-mono text-[10px]">(${po.outlet ? po.outlet.ou_code : ''})</span></td>
                                <td class="p-2.5"><span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase ${badgeColor}">${statusLabel}</span></td>
                                <td class="p-2.5 text-right font-bold text-slate-800">Rp ${Number(po.nilai_alokasi).toLocaleString('id-ID')}</td>
                            `;
                            tbody.appendChild(tr);
                        });
                    } else {
                        tbody.innerHTML = '<tr><td colspan="3" class="p-4 text-center text-slate-400">Belum ada alokasi cabang.</td></tr>';
                    }

                    document.getElementById('detailModal').classList.remove('hidden');
                }
            })
            .catch(err => {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Membuka Detail',
                    text: 'Tidak dapat memuat rincian program.',
                    customClass: { popup: 'rounded-2xl' }
                });
            });
    }

    function closeDetailModal() {
        document.getElementById('detailModal').classList.add('hidden');
    }
</script>
@endpush
