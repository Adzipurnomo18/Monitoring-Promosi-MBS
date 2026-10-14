@extends('layouts.app')

@section('title', 'Buat Program Promo')
@section('header_title', 'Form Pengajuan Program Promo')
@section('header_subtitle', 'Daftarkan inisiatif promosi baru, alokasikan ke cabang toko, dan tentukan skema kerjasama supplier.')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <a href="{{ route('program.index') }}" class="inline-flex items-center gap-2 text-xs font-bold text-slate-500 hover:text-blue-600 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
            <span>Kembali ke Daftar Program</span>
        </a>
        <span class="text-xs bg-blue-50 text-blue-700 font-mono font-bold px-3 py-1 rounded-full border border-blue-200">
            Nomor Otomatis: {{ $autoNomor }}
        </span>
    </div>

    @if ($errors->any())
    <div class="bg-rose-50 border-l-4 border-rose-500 p-4 rounded-xl text-xs text-rose-700">
        <div class="font-bold mb-1">Periksa kembali data formulir:</div>
        <ul class="list-disc pl-4 space-y-0.5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('program.store') }}" class="space-y-6">
        @csrf

        <!-- Card 1: Informasi Utama Program -->
        <div class="white-card p-6 space-y-5">
            <div class="border-b border-slate-100 pb-3 flex items-center gap-2">
                <div class="w-7 h-7 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-xs">1</div>
                <h3 class="font-extrabold text-sm text-slate-800">Informasi Dasar Promosi</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Judul Program -->
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Judul Program Promosi <span class="text-rose-500">*</span></label>
                    <input 
                        type="text" 
                        name="judul_program" 
                        value="{{ old('judul_program') }}" 
                        required
                        placeholder="Contoh: Gebyar Diskon Semen &amp; Cat Ramadhan 2026"
                        class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-slate-50/50"
                    />
                </div>

                <!-- Supplier Partner -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Supplier / Principal <span class="text-rose-500">*</span></label>
                    <select name="supplier_id" required class="w-full text-xs px-3 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-slate-50/50">
                        <option value="">-- Pilih Supplier Rekanan --</option>
                        @foreach($suppliers as $supp)
                            <option value="{{ $supp->id }}" {{ old('supplier_id') == $supp->id ? 'selected' : '' }}>
                                {{ $supp->nama_supplier }} ({{ $supp->kategori }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Metode Kesepakatan -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Metode Kesepakatan <span class="text-rose-500">*</span></label>
                    <select name="metode_kesepakatan_id" required class="w-full text-xs px-3 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-slate-50/50">
                        <option value="">-- Pilih Skema Kerjasama --</option>
                        @foreach($metodes as $met)
                            <option value="{{ $met->id }}" {{ old('metode_kesepakatan_id') == $met->id ? 'selected' : '' }}>
                                {{ $met->nama_metode }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Event Promosi (Opsional) -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Event Terkait (Opsional)</label>
                    <select name="event_promosi_id" class="w-full text-xs px-3 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-slate-50/50">
                        <option value="">Reguler Promo (Tanpa Event Khusus)</option>
                        @foreach($events as $ev)
                            <option value="{{ $ev->id }}" {{ old('event_promosi_id') == $ev->id ? 'selected' : '' }}>
                                {{ $ev->nama_event }} ({{ $ev->tahun }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Status Awal -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Status Awal Program</label>
                    <select name="status" class="w-full text-xs px-3 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-slate-50/50">
                        <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Draft (Konsep Internal)</option>
                        <option value="diajukan" {{ old('status') === 'diajukan' ? 'selected' : '' }}>Diajukan ke Manajemen</option>
                        <option value="disetujui" {{ old('status') === 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                        <option value="berjalan" {{ old('status', 'berjalan') === 'berjalan' ? 'selected' : '' }}>Langsung Berjalan</option>
                    </select>
                </div>

                <!-- Periode Mulai -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Tanggal Mulai <span class="text-rose-500">*</span></label>
                    <input 
                        type="date" 
                        name="tanggal_mulai" 
                        value="{{ old('tanggal_mulai', now()->toDateString()) }}" 
                        required
                        class="w-full text-xs px-3 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-slate-50/50"
                    />
                </div>

                <!-- Periode Selesai -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Tanggal Selesai <span class="text-rose-500">*</span></label>
                    <input 
                        type="date" 
                        name="tanggal_selesai" 
                        value="{{ old('tanggal_selesai', now()->addDays(30)->toDateString()) }}" 
                        required
                        class="w-full text-xs px-3 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-slate-50/50"
                    />
                </div>
            </div>
        </div>

        <!-- Card 2: Partisipasi Cabang & Alokasi Anggaran -->
        <div class="white-card p-6 space-y-4">
            <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <div class="w-7 h-7 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-xs">2</div>
                    <div>
                        <h3 class="font-extrabold text-sm text-slate-800">Partisipasi Cabang &amp; Alokasi Budget</h3>
                        <p class="text-[11px] text-slate-400">Centang cabang MBS yang ikut serta dan masukkan alokasi nilainya.</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <button type="button" onclick="toggleAllOutlets(true)" class="text-xs text-blue-600 font-bold hover:underline">Pilih Semua</button>
                    <span class="text-slate-300">|</span>
                    <button type="button" onclick="toggleAllOutlets(false)" class="text-xs text-slate-500 font-bold hover:underline">Hapus Semua</button>
                </div>
            </div>

            <div class="border border-slate-200 rounded-xl overflow-hidden">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-100 text-slate-500 text-[10px] uppercase font-bold">
                        <tr>
                            <th class="p-3 w-10 text-center">Pilih</th>
                            <th class="p-3">Cabang Outlet</th>
                            <th class="p-3">Kode OU</th>
                            <th class="p-3">Kota</th>
                            <th class="p-3 text-right">Alokasi Nilai (Rp)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($outlets as $idx => $out)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="p-3 text-center">
                                <input 
                                    type="checkbox" 
                                    name="outlets[]" 
                                    value="{{ $out->id }}" 
                                    id="outlet_{{ $out->id }}"
                                    class="outlet-checkbox rounded border-slate-300 text-blue-600 focus:ring-blue-500 w-4 h-4 cursor-pointer"
                                    {{ in_array($out->id, old('outlets', [1, 2, 3, 4])) ? 'checked' : '' }}
                                    onchange="calculateTotal()"
                                />
                            </td>
                            <td class="p-3 font-bold text-slate-800">
                                <label for="outlet_{{ $out->id }}" class="cursor-pointer">
                                    {{ $out->nama_outlet }}
                                </label>
                            </td>
                            <td class="p-3 font-mono text-[11px] text-slate-500">
                                {{ $out->ou_code }}
                            </td>
                            <td class="p-3 text-slate-600">
                                {{ $out->kota }}
                            </td>
                            <td class="p-3 text-right">
                                <input 
                                    type="number" 
                                    name="alokasi[{{ $out->id }}]" 
                                    value="{{ old('alokasi.'.$out->id, 10000000) }}"
                                    min="0"
                                    step="500000"
                                    class="outlet-alokasi w-36 text-right text-xs px-2.5 py-1.5 rounded-lg border border-slate-200 focus:outline-none focus:ring-1 focus:ring-blue-500 bg-slate-50/50 font-semibold"
                                    oninput="calculateTotal()"
                                />
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-blue-50/80 border-t border-blue-200 font-bold text-slate-800">
                        <tr>
                            <td colspan="4" class="p-3 text-right text-xs">
                                Total Komitmen Anggaran Terhitung:
                            </td>
                            <td class="p-3 text-right text-sm text-blue-700 font-extrabold" id="totalNilaiDisplay">
                                Rp 0
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Card 3: Catatan & Persyaratan Tambahan -->
        <div class="white-card p-6 space-y-4">
            <div class="border-b border-slate-100 pb-3 flex items-center gap-2">
                <div class="w-7 h-7 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-xs">3</div>
                <h3 class="font-extrabold text-sm text-slate-800">Catatan &amp; Ketentuan Kerjasama</h3>
            </div>

            <div>
                <textarea 
                    name="catatan" 
                    rows="3" 
                    placeholder="Tuliskan syarat khusus, rincian materi promosi, atau ketentuan penagihan..."
                    class="w-full text-xs p-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-slate-50/50"
                >{{ old('catatan') }}</textarea>
            </div>
        </div>

        <!-- Form Submission Actions -->
        <div class="flex items-center justify-end gap-3 pt-2">
            <a href="{{ route('program.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-300 text-slate-600 font-bold text-xs hover:bg-slate-100 transition-colors">
                Batal
            </a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#0070e0] hover:bg-blue-600 text-white font-bold text-xs shadow-md shadow-blue-500/20 transition-all">
                Simpan &amp; Daftarkan Program
            </button>
        </div>

    </form>

</div>
@endsection

@push('scripts')
<script>
    function calculateTotal() {
        let total = 0;
        const checkboxes = document.querySelectorAll('.outlet-checkbox');
        checkboxes.forEach(cb => {
            if (cb.checked) {
                const outletId = cb.value;
                const inputAlokasi = document.querySelector(`input[name="alokasi[${outletId}]"]`);
                if (inputAlokasi) {
                    total += parseFloat(inputAlokasi.value || 0);
                }
            }
        });
        document.getElementById('totalNilaiDisplay').textContent = 'Rp ' + total.toLocaleString('id-ID');
    }

    function toggleAllOutlets(status) {
        document.querySelectorAll('.outlet-checkbox').forEach(cb => {
            cb.checked = status;
        });
        calculateTotal();
    }

    document.addEventListener('DOMContentLoaded', function () {
        calculateTotal();
    });
</script>
@endpush
