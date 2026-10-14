@extends('layouts.app')

@section('title', 'Supplier & Customer AR')
@section('header_title', 'Master Supplier &amp; Customer AR')
@section('header_subtitle', 'Database vendor rekanan MBS, verifikasi registrasi Customer AR Oracle, dan kelengkapan alamat penagihan faktur.')

@section('content')
<div class="space-y-6">

    <!-- KPI Summary Pills -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div class="white-card p-4 border-l-4 border-l-slate-400">
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Supplier Terdaftar</span>
            <div class="mt-2 flex items-baseline justify-between">
                <span class="text-2xl font-extrabold text-slate-800">{{ $stats['total'] }}</span>
                <span class="text-xs text-slate-500 font-semibold bg-slate-100 px-2 py-0.5 rounded-full">Vendor</span>
            </div>
        </div>

        <div class="white-card p-4 border-l-4 border-l-emerald-500">
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Customer AR Terdaftar (Oracle)</span>
            <div class="mt-2 flex items-baseline justify-between">
                <span class="text-2xl font-extrabold text-emerald-600">{{ $stats['ar_terdaftar'] }}</span>
                <span class="text-xs text-emerald-700 font-semibold bg-emerald-50 px-2 py-0.5 rounded-full">Valid</span>
            </div>
        </div>

        <div class="white-card p-4 border-l-4 border-l-rose-500">
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Belum Customer AR</span>
            <div class="mt-2 flex items-baseline justify-between">
                <span class="text-2xl font-extrabold text-rose-600">{{ $stats['ar_belum'] }}</span>
                <span class="text-xs text-rose-700 font-semibold bg-rose-50 px-2 py-0.5 rounded-full">Perlu Sync</span>
            </div>
        </div>

        <div class="white-card p-4 border-l-4 border-l-amber-500">
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Alamat Tagih Belum Lengkap</span>
            <div class="mt-2 flex items-baseline justify-between">
                <span class="text-2xl font-extrabold text-amber-600">{{ $stats['alamat_kurang'] }}</span>
                <span class="text-xs text-amber-700 font-semibold bg-amber-50 px-2 py-0.5 rounded-full">Lengkapi</span>
            </div>
        </div>
    </div>

    <!-- Toolbar Filter -->
    <div class="white-card p-4 sm:p-5">
        <form method="GET" action="{{ route('master.supplier') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3.5 items-end">
            <div>
                <label class="block text-xs font-bold text-slate-600 mb-1">Cari Supplier</label>
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}" 
                    placeholder="Nama vendor, kode supplier..."
                    class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-slate-50/50"
                />
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-600 mb-1">Status Customer AR (Oracle)</label>
                <select name="status_customer_ar" class="w-full text-xs px-3 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-slate-50/50">
                    <option value="">Semua Status AR</option>
                    <option value="terdaftar" {{ request('status_customer_ar') === 'terdaftar' ? 'selected' : '' }}>Terdaftar di Oracle</option>
                    <option value="belum_terdaftar" {{ request('status_customer_ar') === 'belum_terdaftar' ? 'selected' : '' }}>Belum Terdaftar</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-600 mb-1">Kelengkapan Alamat Tagihan</label>
                <select name="status_alamat_tagih" class="w-full text-xs px-3 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-slate-50/50">
                    <option value="">Semua Status Alamat</option>
                    <option value="lengkap" {{ request('status_alamat_tagih') === 'lengkap' ? 'selected' : '' }}>Alamat Lengkap</option>
                    <option value="belum_lengkap" {{ request('status_alamat_tagih') === 'belum_lengkap' ? 'selected' : '' }}>Belum Lengkap</option>
                </select>
            </div>

            <div class="flex items-center gap-2">
                <button type="submit" class="flex-1 bg-[#0070e0] hover:bg-blue-600 text-white font-bold text-xs py-2.5 px-4 rounded-xl shadow-sm transition-all flex items-center justify-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                    <span>Filter</span>
                </button>
                <button type="button" onclick="openAddSupplierModal()" class="bg-blue-50 hover:bg-blue-100 text-blue-700 font-bold text-xs py-2.5 px-3 rounded-xl border border-blue-200 transition-colors whitespace-nowrap">
                    + Tambah
                </button>
            </div>
        </form>
    </div>

    <!-- Data Table -->
    <div class="white-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider text-[10px] border-b border-slate-200/80">
                        <th class="py-3 px-4">Kode &amp; Supplier</th>
                        <th class="py-3 px-4">Kategori Produk</th>
                        <th class="py-3 px-4">Kontak / Person</th>
                        <th class="py-3 px-4 text-center">Status Customer AR</th>
                        <th class="py-3 px-4 text-center">Alamat Tagihan Cabang</th>
                        <th class="py-3 px-4 text-center">Riwayat Promo</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($suppliers as $sup)
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="py-3.5 px-4 whitespace-nowrap">
                            <div class="font-bold text-slate-800 text-sm">{{ $sup->nama_supplier }}</div>
                            <div class="font-mono text-[11px] text-blue-700 font-semibold">{{ $sup->kode_supplier }}</div>
                        </td>
                        <td class="py-3.5 px-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-700">
                                {{ $sup->kategori }}
                            </span>
                        </td>
                        <td class="py-3.5 px-4 whitespace-nowrap text-slate-600">
                            <div class="font-medium text-slate-800">{{ $sup->kontak_person ?? '-' }}</div>
                            <div class="text-[10px] text-slate-400">{{ $sup->email ?? ($sup->telepon ?? '-') }}</div>
                        </td>
                        <td class="py-3.5 px-4 text-center whitespace-nowrap">
                            <form method="POST" action="{{ route('master.supplier.toggle', $sup->id) }}">
                                @csrf
                                <input type="hidden" name="action" value="ar">
                                <button type="submit" title="Klik untuk ubah status AR" class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase border transition-all cursor-pointer {{ $sup->status_customer_ar === 'terdaftar' ? 'bg-emerald-50 text-emerald-700 border-emerald-300 hover:bg-emerald-100' : 'bg-rose-50 text-rose-700 border-rose-300 hover:bg-rose-100' }}">
                                    {{ $sup->status_customer_ar === 'terdaftar' ? '✓ Terdaftar AR' : '✗ Belum Terdaftar' }}
                                </button>
                            </form>
                        </td>
                        <td class="py-3.5 px-4 text-center whitespace-nowrap">
                            <form method="POST" action="{{ route('master.supplier.toggle', $sup->id) }}">
                                @csrf
                                <input type="hidden" name="action" value="alamat">
                                <button type="submit" title="Klik untuk ubah status alamat tagih" class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase border transition-all cursor-pointer {{ $sup->status_alamat_tagih === 'lengkap' ? 'bg-blue-50 text-blue-700 border-blue-300 hover:bg-blue-100' : 'bg-amber-50 text-amber-700 border-amber-300 hover:bg-amber-100' }}">
                                    {{ $sup->status_alamat_tagih === 'lengkap' ? '✓ Alamat Lengkap' : '⚠ Belum Lengkap' }}
                                </button>
                            </form>
                        </td>
                        <td class="py-3.5 px-4 text-center whitespace-nowrap">
                            <div class="font-bold text-slate-800">{{ $sup->program_promos_count }} Program</div>
                            <div class="text-[10px] text-slate-400">{{ $sup->tagihan_ar_count }} Invoice AR</div>
                        </td>
                        <td class="py-3.5 px-4 text-center whitespace-nowrap">
                            <button 
                                type="button" 
                                onclick="openEditSupplierModal({{ $sup->id }}, '{{ $sup->kode_supplier }}', '{{ addslashes($sup->nama_supplier) }}', '{{ addslashes($sup->kategori) }}', '{{ addslashes($sup->kontak_person ?? '') }}', '{{ addslashes($sup->email ?? '') }}', '{{ addslashes($sup->telepon ?? '') }}', '{{ $sup->status_customer_ar }}', '{{ $sup->status_alamat_tagih }}')"
                                class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-[11px] px-3 py-1.5 rounded-lg transition-colors"
                            >
                                Edit
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-12 text-center text-slate-400">Tidak ada supplier yang sesuai dengan filter.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($suppliers->hasPages())
        <div class="p-4 border-t border-slate-100">
            {{ $suppliers->links() }}
        </div>
        @endif
    </div>

</div>

<!-- Modal Tambah / Edit Supplier -->
<div id="supplierModal" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full overflow-hidden">
        <form id="supplierForm" method="POST" action="" class="space-y-4">
            @csrf
            <input type="hidden" name="_method" id="supplierFormMethod" value="POST">

            <div class="px-5 py-4 bg-gradient-to-r from-[#072147] to-[#0070e0] text-white flex items-center justify-between">
                <h4 id="supplierModalTitle" class="font-extrabold text-sm">Tambah Supplier Partner</h4>
                <button type="button" onclick="closeSupplierModal()" class="text-white/80 hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="p-5 space-y-4 text-xs">
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Kode Supplier <span class="text-rose-500">*</span></label>
                        <input type="text" name="kode_supplier" id="inputKodeSupplier" required placeholder="SUP-BRAND" class="w-full text-xs px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 font-mono">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Kategori Produk <span class="text-rose-500">*</span></label>
                        <input type="text" name="kategori" id="inputKategoriSupplier" required placeholder="Keramik, Cat, Sanitary..." class="w-full text-xs px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Nama Supplier / PT <span class="text-rose-500">*</span></label>
                    <input type="text" name="nama_supplier" id="inputNamaSupplier" required placeholder="Nama Perusahaan / Brand Principal" class="w-full text-xs px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 font-bold">
                </div>

                <div class="grid grid-cols-3 gap-2.5">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Kontak Person</label>
                        <input type="text" name="kontak_person" id="inputKontakSupplier" placeholder="Nama PIC" class="w-full text-xs px-2.5 py-2 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Email Tagihan</label>
                        <input type="email" name="email" id="inputEmailSupplier" placeholder="finance@brand.com" class="w-full text-xs px-2.5 py-2 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Telepon</label>
                        <input type="text" name="telepon" id="inputTeleponSupplier" placeholder="08..." class="w-full text-xs px-2.5 py-2 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3 pt-1">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Status Customer AR (Oracle)</label>
                        <select name="status_customer_ar" id="inputArSupplier" class="w-full text-xs px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 font-semibold">
                            <option value="terdaftar">Terdaftar di Oracle AR</option>
                            <option value="belum_terdaftar">Belum Terdaftar</option>
                        </select>
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Alamat Tagihan Cabang</label>
                        <select name="status_alamat_tagih" id="inputAlamatSupplier" class="w-full text-xs px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 font-semibold">
                            <option value="lengkap">Lengkap di Seluruh Cabang</option>
                            <option value="belum_lengkap">Belum Lengkap / Sebagian</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="px-5 py-3.5 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-2">
                <button type="button" onclick="closeSupplierModal()" class="px-4 py-2 rounded-xl text-slate-600 font-bold hover:bg-slate-100">Batal</button>
                <button type="submit" class="px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold shadow-sm">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function openAddSupplierModal() {
        document.getElementById('supplierForm').action = "{{ route('master.supplier.store') }}";
        document.getElementById('supplierFormMethod').value = "POST";
        document.getElementById('supplierModalTitle').textContent = "Tambah Supplier Partner";
        document.getElementById('inputKodeSupplier').value = "";
        document.getElementById('inputNamaSupplier').value = "";
        document.getElementById('inputKategoriSupplier').value = "";
        document.getElementById('inputKontakSupplier').value = "";
        document.getElementById('inputEmailSupplier').value = "";
        document.getElementById('inputTeleponSupplier').value = "";
        document.getElementById('inputArSupplier').value = "terdaftar";
        document.getElementById('inputAlamatSupplier').value = "lengkap";
        document.getElementById('supplierModal').classList.remove('hidden');
    }

    function openEditSupplierModal(id, kode, nama, kategori, kontak, email, telp, ar, alamat) {
        document.getElementById('supplierForm').action = `/supplier-ar/${id}`;
        document.getElementById('supplierFormMethod').value = "PUT";
        document.getElementById('supplierModalTitle').textContent = "Edit Data Supplier";
        document.getElementById('inputKodeSupplier').value = kode;
        document.getElementById('inputNamaSupplier').value = nama;
        document.getElementById('inputKategoriSupplier').value = kategori;
        document.getElementById('inputKontakSupplier').value = kontak;
        document.getElementById('inputEmailSupplier').value = email;
        document.getElementById('inputTeleponSupplier').value = telp;
        document.getElementById('inputArSupplier').value = ar;
        document.getElementById('inputAlamatSupplier').value = alamat;
        document.getElementById('supplierModal').classList.remove('hidden');
    }

    function closeSupplierModal() {
        document.getElementById('supplierModal').classList.add('hidden');
    }
</script>
@endpush
