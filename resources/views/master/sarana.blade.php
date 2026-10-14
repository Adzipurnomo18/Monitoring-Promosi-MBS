@extends('layouts.app')

@section('title', 'Sarana Promosi')
@section('header_title', 'Master Sarana &amp; Media Promosi')
@section('header_subtitle', 'Inventarisasi titik promosi display toko, ruang sewa supplier, dan tarif standar MBS.')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div class="flex items-center gap-2">
            <h3 class="font-extrabold text-sm text-slate-800">Daftar Titik &amp; Media Display</h3>
            <span class="text-xs bg-blue-50 text-blue-700 font-bold px-2.5 py-0.5 rounded-full border border-blue-200">{{ count($saranas) }} Spot</span>
        </div>
        <div class="flex items-center gap-2">
            <!-- Filter Kategori -->
            <form method="GET" action="{{ route('master.sarana') }}" class="flex items-center gap-2">
                <select name="kategori" onchange="this.form.submit()" class="text-xs px-3 py-1.5 rounded-xl border border-slate-200 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 font-bold text-slate-700">
                    <option value="">Semua Kategori Media</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ request('kategori') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
            </form>

            <button type="button" onclick="openAddSaranaModal()" class="bg-[#0070e0] hover:bg-blue-600 text-white font-bold text-xs px-3.5 py-2 rounded-xl shadow-sm transition-all flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span>Tambah Sarana Baru</span>
            </button>
        </div>
    </div>

    <!-- Data Table -->
    <div class="white-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider text-[10px] border-b border-slate-200/80">
                        <th class="py-3 px-4">Kode Sarana</th>
                        <th class="py-3 px-4">Nama Sarana &amp; Media</th>
                        <th class="py-3 px-4">Kategori Display</th>
                        <th class="py-3 px-4">Lokasi di Area Toko</th>
                        <th class="py-3 px-4 text-right">Tarif Standar (Rp/Bln)</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($saranas as $s)
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="py-3.5 px-4 font-mono font-bold text-blue-700 whitespace-nowrap">
                            {{ $s->kode_sarana }}
                        </td>
                        <td class="py-3.5 px-4 font-bold text-slate-800 whitespace-nowrap">
                            {{ $s->nama_sarana }}
                        </td>
                        <td class="py-3.5 px-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-700 border border-slate-200">
                                {{ $s->kategori_sarana }}
                            </span>
                        </td>
                        <td class="py-3.5 px-4 text-slate-600 whitespace-nowrap">
                            {{ $s->lokasi }}
                        </td>
                        <td class="py-3.5 px-4 text-right font-extrabold text-slate-800 whitespace-nowrap">
                            Rp {{ number_format($s->tarif_standar, 0, ',', '.') }}
                        </td>
                        <td class="py-3.5 px-4 text-center whitespace-nowrap">
                            <div class="flex items-center justify-center gap-1.5">
                                <button 
                                    type="button" 
                                    onclick="openEditSaranaModal({{ $s->id }}, '{{ $s->kode_sarana }}', '{{ addslashes($s->nama_sarana) }}', '{{ addslashes($s->kategori_sarana) }}', '{{ addslashes($s->lokasi) }}', {{ $s->tarif_standar }})"
                                    class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-[11px] px-2.5 py-1 rounded-lg transition-colors"
                                >
                                    Edit
                                </button>
                                <form method="POST" action="{{ route('master.sarana.destroy', $s->id) }}" onsubmit="return confirmDeleteSarana(event, this, '{{ addslashes($s->nama_sarana) }}')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-rose-50 hover:bg-rose-100 text-rose-600 font-bold text-[11px] px-2.5 py-1 rounded-lg transition-colors border border-rose-200">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-12 text-center text-slate-400">Belum ada inventaris sarana promosi terdaftar.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Modal Tambah / Edit Sarana -->
<div id="saranaModal" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full overflow-hidden">
        <form id="saranaForm" method="POST" action="" class="space-y-4">
            @csrf
            <input type="hidden" name="_method" id="saranaFormMethod" value="POST">

            <div class="px-5 py-4 bg-gradient-to-r from-[#072147] to-[#0070e0] text-white flex items-center justify-between">
                <h4 id="saranaModalTitle" class="font-extrabold text-sm">Tambah Sarana Promosi</h4>
                <button type="button" onclick="closeSaranaModal()" class="text-white/80 hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="p-5 space-y-4 text-xs">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Kode Sarana <span class="text-rose-500">*</span></label>
                    <input type="text" name="kode_sarana" id="inputKodeSarana" required placeholder="Contoh: SRN-GON-A" class="w-full text-xs px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 font-mono">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Nama Sarana &amp; Media <span class="text-rose-500">*</span></label>
                    <input type="text" name="nama_sarana" id="inputNamaSarana" required placeholder="Contoh: Gondola Utama Lorong Cat &amp; Semen" class="w-full text-xs px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Kategori <span class="text-rose-500">*</span></label>
                        <input type="text" name="kategori_sarana" id="inputKategoriSarana" required placeholder="Gondola, End Cap..." class="w-full text-xs px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Tarif Standar (Rp) <span class="text-rose-500">*</span></label>
                        <input type="number" name="tarif_standar" id="inputTarifSarana" required min="0" step="100000" placeholder="5000000" class="w-full text-xs px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 font-bold">
                    </div>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Lokasi di Area Toko <span class="text-rose-500">*</span></label>
                    <input type="text" name="lokasi" id="inputLokasiSarana" required placeholder="Contoh: Hall Depan Lantai 1, Ujung Lorong Keramik" class="w-full text-xs px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <div class="px-5 py-3.5 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-2">
                <button type="button" onclick="closeSaranaModal()" class="px-4 py-2 rounded-xl text-slate-600 font-bold hover:bg-slate-100">Batal</button>
                <button type="submit" class="px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold shadow-sm">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function openAddSaranaModal() {
        document.getElementById('saranaForm').action = "{{ route('master.sarana.store') }}";
        document.getElementById('saranaFormMethod').value = "POST";
        document.getElementById('saranaModalTitle').textContent = "Tambah Sarana Promosi";
        document.getElementById('inputKodeSarana').value = "";
        document.getElementById('inputNamaSarana').value = "";
        document.getElementById('inputKategoriSarana').value = "";
        document.getElementById('inputTarifSarana').value = "5000000";
        document.getElementById('inputLokasiSarana').value = "";
        document.getElementById('saranaModal').classList.remove('hidden');
    }

    function openEditSaranaModal(id, kode, nama, kategori, lokasi, tarif) {
        document.getElementById('saranaForm').action = `/sarana-promosi/${id}`;
        document.getElementById('saranaFormMethod').value = "PUT";
        document.getElementById('saranaModalTitle').textContent = "Edit Sarana Promosi";
        document.getElementById('inputKodeSarana').value = kode;
        document.getElementById('inputNamaSarana').value = nama;
        document.getElementById('inputKategoriSarana').value = kategori;
        document.getElementById('inputTarifSarana').value = tarif;
        document.getElementById('inputLokasiSarana').value = lokasi;
        document.getElementById('saranaModal').classList.remove('hidden');
    }

    function closeSaranaModal() {
        document.getElementById('saranaModal').classList.add('hidden');
    }

    function confirmDeleteSarana(e, form, nama) {
        e.preventDefault();
        Swal.fire({
            title: 'Hapus Sarana Promosi?',
            text: `Yakin ingin menghapus titik sarana "${nama}"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e31e24',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal',
            customClass: { popup: 'rounded-2xl' }
        }).then((res) => {
            if (res.isConfirmed) {
                form.submit();
            }
        });
        return false;
    }
</script>
@endpush
