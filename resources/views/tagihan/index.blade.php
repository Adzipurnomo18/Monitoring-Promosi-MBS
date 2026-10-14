@extends('layouts.app')

@section('title', 'Tagihan AR')
@section('header_title', 'Tagihan AR (Accounts Receivable)')
@section('header_subtitle', 'Kelola penagihan piutang promosi ke supplier rekanan, monitor umur jatuh tempo, dan integrasi modul Oracle AR.')

@section('content')
<div class="space-y-6">

    <!-- KPI Summary Pills -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div class="white-card p-4 border-l-4 border-l-rose-500">
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Piutang Belum Lunas</span>
            <div class="mt-2 flex items-baseline justify-between">
                <span class="text-xl font-black text-rose-600">
                    Rp {{ number_format($stats['sisa_piutang'] / 1000000, 1, ',', '.') }} Jt
                </span>
                <span class="text-xs text-rose-700 font-bold bg-rose-50 px-2 py-0.5 rounded-full">{{ $stats['unpaid_count'] }} Inv</span>
            </div>
        </div>

        <div class="white-card p-4 border-l-4 border-l-emerald-500">
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Terbayar Tahun Berjalan</span>
            <div class="mt-2 flex items-baseline justify-between">
                <span class="text-xl font-black text-emerald-600">
                    Rp {{ number_format($stats['total_terbayar'] / 1000000, 1, ',', '.') }} Jt
                </span>
                <span class="text-xs text-emerald-700 font-bold bg-emerald-50 px-2 py-0.5 rounded-full">Lunas</span>
            </div>
        </div>

        <div class="white-card p-4 border-l-4 border-l-amber-500">
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Tagihan Lewat Jatuh Tempo</span>
            <div class="mt-2 flex items-baseline justify-between">
                <span class="text-xl font-black text-amber-600">
                    {{ $stats['overdue_count'] }} Invoice
                </span>
                <span class="text-xs text-amber-700 font-bold bg-amber-50 px-2 py-0.5 rounded-full">Perhatian</span>
            </div>
        </div>

        <div class="white-card p-4 bg-gradient-to-br from-[#072147] to-blue-900 text-white">
            <span class="text-[11px] font-bold text-blue-200 uppercase tracking-wider">Integrasi Oracle AR</span>
            <div class="mt-2 flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-white">Status Sync:</span>
                    <span class="text-xs font-mono font-bold text-emerald-300 block">Terhubung (Realtime)</span>
                </div>
                <div class="w-8 h-8 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center font-bold text-xs">
                    &check;
                </div>
            </div>
        </div>
    </div>

    <!-- Antrean Program Siap Ditagih (Ready to Bill Alert) -->
    @if($programSiapTagih->count() > 0)
    <div class="bg-gradient-to-r from-rose-50 to-orange-50 border border-rose-200/80 rounded-2xl p-5 shadow-xs">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-3">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-rose-500 text-white flex items-center justify-center shrink-0 shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                    </svg>
                </div>
                <div>
                    <h4 class="font-extrabold text-sm text-slate-800">
                        {{ $programSiapTagih->count() }} Program Promosi Siap Diterbitkan Invoice AR
                    </h4>
                    <p class="text-xs text-slate-600">
                        Realisasi cabang telah lengkap dan tervalidasi. Silakan terbitkan invoice untuk proses penagihan ke supplier rekanan.
                    </p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mt-3">
            @foreach($programSiapTagih as $psp)
            <div class="bg-white p-3.5 rounded-xl border border-rose-100 shadow-2xs flex items-center justify-between">
                <div>
                    <div class="font-mono text-[10px] font-bold text-slate-400">{{ $psp->nomor_program }}</div>
                    <div class="font-bold text-xs text-slate-800">{{ $psp->judul_program }}</div>
                    <div class="text-[11px] text-slate-500 mt-0.5">
                        {{ $psp->supplier?->nama_supplier }} &bull; 
                        <span class="font-bold text-blue-700">Rp {{ number_format($psp->total_nilai, 0, ',', '.') }}</span>
                    </div>
                </div>
                <button 
                    type="button" 
                    onclick="openGenerateInvoiceModal({{ $psp->id }}, '{{ $psp->nomor_program }}', '{{ addslashes($psp->judul_program) }}', {{ $psp->total_nilai }})"
                    class="bg-[#0070e0] hover:bg-blue-600 text-white text-xs font-bold px-3 py-1.5 rounded-xl shadow-xs transition-colors shrink-0"
                >
                    Terbitkan Invoice
                </button>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Toolbar Filter -->
    <div class="white-card p-4 sm:p-5">
        <form method="GET" action="{{ route('tagihan.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3.5 items-end">
            <div class="lg:col-span-2">
                <label class="block text-xs font-bold text-slate-600 mb-1">Cari Invoice / Oracle Ref</label>
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}" 
                    placeholder="INV-..., AR-ORCL-..., nama supplier..."
                    class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-slate-50/50"
                />
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-600 mb-1">Status Pembayaran</label>
                <select name="status_pembayaran" class="w-full text-xs px-3 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-slate-50/50">
                    <option value="semua">Semua Status</option>
                    <option value="belum_lunas" {{ request('status_pembayaran') === 'belum_lunas' ? 'selected' : '' }}>Belum Lunas</option>
                    <option value="sebagian" {{ request('status_pembayaran') === 'sebagian' ? 'selected' : '' }}>Sebagian</option>
                    <option value="lunas" {{ request('status_pembayaran') === 'lunas' ? 'selected' : '' }}>Lunas</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-600 mb-1">Umur Piutang (Aging)</label>
                <select name="aging" class="w-full text-xs px-3 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-slate-50/50">
                    <option value="">Semua Umur</option>
                    <option value="overdue" {{ request('aging') === 'overdue' ? 'selected' : '' }}>Lewat Jatuh Tempo</option>
                    <option value="overdue30" {{ request('aging') === 'overdue30' ? 'selected' : '' }}>Lewat > 30 Hari</option>
                </select>
            </div>

            <div class="flex items-center gap-2">
                <button type="submit" class="flex-1 bg-[#0070e0] hover:bg-blue-600 text-white font-bold text-xs py-2.5 px-4 rounded-xl shadow-sm transition-all flex items-center justify-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                    <span>Filter</span>
                </button>
                @if(request()->hasAny(['search', 'status_pembayaran', 'aging']))
                <a href="{{ route('tagihan.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold text-xs py-2.5 px-3 rounded-xl transition-colors">
                    Reset
                </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Data Table Tagihan AR -->
    <div class="white-card overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
            <div class="flex items-center gap-2.5">
                <h3 class="font-extrabold text-sm text-slate-800">Daftar Faktur Tagihan AR</h3>
                <span class="text-xs bg-slate-100 text-slate-600 px-2 py-0.5 rounded-full font-bold">{{ $tagihans->total() }} Faktur</span>
            </div>
            <div class="text-[11px] text-slate-400">
                Terhubung dengan Master Oracle Customer AR &bull; Sinkronisasi otomatis.
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider text-[10px] border-b border-slate-200/80">
                        <th class="py-3 px-4">No. Invoice &amp; Oracle</th>
                        <th class="py-3 px-4">Supplier &amp; Outlet</th>
                        <th class="py-3 px-4">Tgl Faktur / Jatuh Tempo</th>
                        <th class="py-3 px-4 text-right">Total Tagihan</th>
                        <th class="py-3 px-4 text-right">Terbayar</th>
                        <th class="py-3 px-4 text-right">Sisa Piutang</th>
                        <th class="py-3 px-4 text-center">Status / Aging</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($tagihans as $t)
                    @php
                        $sisa = $t->total_tagihan - $t->jumlah_terbayar;
                    @endphp
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="py-3.5 px-4 whitespace-nowrap">
                            <div class="font-mono font-bold text-slate-800">{{ $t->nomor_invoice }}</div>
                            <div class="flex items-center gap-1 mt-0.5">
                                <span class="font-mono text-[10px] text-blue-600 bg-blue-50 px-1.5 py-0.2 rounded border border-blue-200">
                                    {{ $t->nomor_oracle_ar ?? 'Unsynced' }}
                                </span>
                            </div>
                        </td>
                        <td class="py-3.5 px-4 whitespace-nowrap">
                            <div class="font-bold text-slate-800">{{ $t->supplier?->nama_supplier ?? '-' }}</div>
                            <div class="text-[10px] text-slate-400">{{ $t->outlet?->nama_outlet }} ({{ $t->outlet?->ou_code }})</div>
                        </td>
                        <td class="py-3.5 px-4 whitespace-nowrap text-slate-600">
                            <div>{{ $t->tanggal_invoice ? $t->tanggal_invoice->format('d M Y') : '-' }}</div>
                            <div class="text-[10px] {{ $t->hari_keterlambatan > 0 && $t->status_pembayaran !== 'lunas' ? 'text-rose-600 font-bold' : 'text-slate-400' }}">
                                JT: {{ $t->tanggal_jatuh_tempo ? $t->tanggal_jatuh_tempo->format('d M Y') : '-' }}
                            </div>
                        </td>
                        <td class="py-3.5 px-4 text-right whitespace-nowrap font-bold text-slate-800">
                            Rp {{ number_format($t->total_tagihan, 0, ',', '.') }}
                        </td>
                        <td class="py-3.5 px-4 text-right whitespace-nowrap text-emerald-600 font-semibold">
                            Rp {{ number_format($t->jumlah_terbayar, 0, ',', '.') }}
                        </td>
                        <td class="py-3.5 px-4 text-right whitespace-nowrap font-extrabold {{ $sisa > 0 ? 'text-rose-600' : 'text-slate-400' }}">
                            Rp {{ number_format($sisa, 0, ',', '.') }}
                        </td>
                        <td class="py-3.5 px-4 text-center whitespace-nowrap">
                            @if($t->status_pembayaran === 'lunas')
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-green-50 text-green-700 border border-green-300">
                                    Lunas
                                </span>
                            @elseif($t->hari_keterlambatan > 0)
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-300">
                                    Lewat {{ $t->hari_keterlambatan }} Hari
                                </span>
                            @else
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-300">
                                    Belum Lunas
                                </span>
                            @endif
                        </td>
                        <td class="py-3.5 px-4 text-center whitespace-nowrap">
                            <div class="flex items-center justify-center gap-1.5">
                                @if($t->status_pembayaran !== 'lunas')
                                <button 
                                    type="button" 
                                    onclick="openBayarModal({{ $t->id }}, '{{ $t->nomor_invoice }}', {{ $sisa }})"
                                    class="bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 font-bold text-[11px] px-2.5 py-1 rounded-lg transition-colors"
                                >
                                    Bayar
                                </button>
                                @endif

                                <form method="POST" action="{{ route('tagihan.sync', $t->id) }}">
                                    @csrf
                                    <button type="submit" title="Sync Oracle AR" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-[11px] px-2 py-1 rounded-lg transition-colors">
                                        Sync
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="py-12 text-center text-slate-400">
                            <p class="font-medium text-xs">Belum ada faktur tagihan AR yang sesuai dengan filter.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($tagihans->hasPages())
        <div class="p-4 border-t border-slate-100">
            {{ $tagihans->links() }}
        </div>
        @endif
    </div>

</div>

<!-- Modal Terbitkan Invoice Baru -->
<div id="genInvoiceModal" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full overflow-hidden">
        <form method="POST" action="{{ route('tagihan.generate') }}" class="space-y-4">
            @csrf
            <input type="hidden" name="program_promo_id" id="genProgramId">

            <div class="px-5 py-4 bg-gradient-to-r from-[#072147] to-[#0070e0] text-white flex items-center justify-between">
                <div>
                    <h4 class="font-extrabold text-sm">Terbitkan Invoice AR</h4>
                    <p id="genProgramNomor" class="text-xs text-blue-200 font-mono mt-0.5"></p>
                </div>
                <button type="button" onclick="closeGenInvoiceModal()" class="text-white/80 hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="p-5 space-y-4 text-xs">
                <div>
                    <label class="block text-slate-400 font-semibold mb-1">Judul Program</label>
                    <div id="genProgramJudul" class="font-bold text-slate-800 bg-slate-50 p-2.5 rounded-xl border border-slate-200"></div>
                </div>

                <div>
                    <label class="block text-slate-400 font-semibold mb-1">Total Nilai Tagihan</label>
                    <div id="genProgramNilai" class="font-extrabold text-blue-700 text-sm bg-blue-50 p-2.5 rounded-xl border border-blue-200"></div>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Tanggal Jatuh Tempo <span class="text-rose-500">*</span></label>
                    <input 
                        type="date" 
                        name="tanggal_jatuh_tempo" 
                        value="{{ now()->addDays(30)->toDateString() }}" 
                        required 
                        class="w-full text-xs px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    />
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Metode / Jalur Pembayaran</label>
                    <select name="metode_pembayaran" class="w-full text-xs px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="Transfer Mandiri Virtual Account">Transfer Mandiri Virtual Account</option>
                        <option value="Transfer BCA Virtual Account">Transfer BCA Virtual Account</option>
                        <option value="Potong Faktur Pembelian Supplier (AP Offset)">Potong Faktur Pembelian Supplier (AP Offset)</option>
                        <option value="Giro Mundur 30 Hari">Giro Mundur 30 Hari</option>
                    </select>
                </div>
            </div>

            <div class="px-5 py-3.5 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-2">
                <button type="button" onclick="closeGenInvoiceModal()" class="px-4 py-2 rounded-xl text-slate-600 font-bold hover:bg-slate-100">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold shadow-sm">
                    Kirim &amp; Sinkron ke Oracle AR
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Catat Pembayaran -->
<div id="bayarModal" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full overflow-hidden">
        <form id="bayarForm" method="POST" action="" class="space-y-4">
            @csrf

            <div class="px-5 py-4 bg-gradient-to-r from-[#072147] to-[#0070e0] text-white flex items-center justify-between">
                <div>
                    <h4 class="font-extrabold text-sm">Catat Pembayaran AR</h4>
                    <p id="bayarInvoiceNomor" class="text-xs text-blue-200 font-mono mt-0.5"></p>
                </div>
                <button type="button" onclick="closeBayarModal()" class="text-white/80 hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="p-5 space-y-4 text-xs">
                <div>
                    <label class="block text-slate-400 font-semibold mb-1">Sisa Piutang</label>
                    <div id="bayarSisaDisplay" class="font-extrabold text-rose-600 text-sm bg-rose-50 p-2.5 rounded-xl border border-rose-200"></div>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Jumlah Pembayaran (Rp) <span class="text-rose-500">*</span></label>
                    <input 
                        type="number" 
                        name="jumlah_bayar" 
                        id="bayarJumlahInput"
                        required 
                        min="1000"
                        class="w-full text-xs px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 font-bold"
                    />
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Tanggal Transaksi Pembayaran <span class="text-rose-500">*</span></label>
                    <input 
                        type="date" 
                        name="tanggal_bayar" 
                        value="{{ now()->toDateString() }}" 
                        required 
                        class="w-full text-xs px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    />
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Metode Pembayaran <span class="text-rose-500">*</span></label>
                    <select name="metode_pembayaran" required class="w-full text-xs px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="Transfer Bank Mandiri">Transfer Bank Mandiri</option>
                        <option value="Transfer Bank BCA">Transfer Bank BCA</option>
                        <option value="Potong Faktur Supplier (AP Offset)">Potong Faktur Supplier (AP Offset)</option>
                        <option value="Giro Bilyet Cair">Giro Bilyet Cair</option>
                    </select>
                </div>
            </div>

            <div class="px-5 py-3.5 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-2">
                <button type="button" onclick="closeBayarModal()" class="px-4 py-2 rounded-xl text-slate-600 font-bold hover:bg-slate-100">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold shadow-sm">
                    Simpan Pelunasan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function openGenerateInvoiceModal(id, nomor, judul, nilai) {
        document.getElementById('genProgramId').value = id;
        document.getElementById('genProgramNomor').textContent = nomor;
        document.getElementById('genProgramJudul').textContent = judul;
        document.getElementById('genProgramNilai').textContent = 'Rp ' + Number(nilai).toLocaleString('id-ID');
        document.getElementById('genInvoiceModal').classList.remove('hidden');
    }

    function closeGenInvoiceModal() {
        document.getElementById('genInvoiceModal').classList.add('hidden');
    }

    function openBayarModal(id, invoiceNomor, sisa) {
        document.getElementById('bayarForm').action = `/tagihan-ar/${id}/bayar`;
        document.getElementById('bayarInvoiceNomor').textContent = invoiceNomor;
        document.getElementById('bayarSisaDisplay').textContent = 'Rp ' + Number(sisa).toLocaleString('id-ID');
        document.getElementById('bayarJumlahInput').value = sisa;
        document.getElementById('bayarJumlahInput').max = sisa;
        document.getElementById('bayarModal').classList.remove('hidden');
    }

    function closeBayarModal() {
        document.getElementById('bayarModal').classList.add('hidden');
    }
</script>
@endpush
