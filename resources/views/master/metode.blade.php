@extends('layouts.app')

@section('title', 'Metode Kesepakatan')
@section('header_title', 'Master Metode Kesepakatan')
@section('header_subtitle', 'Kelola skema dan jenis kerjasama promosi antara MBS Group dan pihak supplier rekanan.')

@section('content')
<div class="space-y-6">

    <div class="flex items-center justify-between">
        <div class="flex items-center gap-2">
            <h3 class="font-extrabold text-sm text-slate-800">Daftar Metode Kesepakatan</h3>
            <span class="text-xs bg-blue-50 text-blue-700 font-bold px-2.5 py-0.5 rounded-full border border-blue-200">{{ count($metodes) }} Skema</span>
        </div>
        <button type="button" onclick="openAddMetodeModal()" class="bg-[#0070e0] hover:bg-blue-600 text-white font-bold text-xs px-3.5 py-2 rounded-xl shadow-sm transition-all flex items-center gap-1.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            <span>Tambah Metode Baru</span>
        </button>
    </div>

    <!-- Data Table -->
    <div class="white-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider text-[10px] border-b border-slate-200/80">
                        <th class="py-3 px-4">Kode</th>
                        <th class="py-3 px-4">Nama Metode Kesepakatan</th>
                        <th class="py-3 px-4">Deskripsi / Ruang Lingkup</th>
                        <th class="py-3 px-4 text-center">Program Terkait</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($metodes as $m)
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="py-3.5 px-4 font-mono font-bold text-blue-700 whitespace-nowrap">
                            {{ $m->kode_metode }}
                        </td>
                        <td class="py-3.5 px-4 font-bold text-slate-800 whitespace-nowrap">
                            {{ $m->nama_metode }}
                        </td>
                        <td class="py-3.5 px-4 text-slate-600 max-w-md">
                            {{ $m->deskripsi ?? '-' }}
                        </td>
                        <td class="py-3.5 px-4 text-center whitespace-nowrap">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-bold {{ $m->program_promos_count > 0 ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-slate-100 text-slate-500' }}">
                                {{ $m->program_promos_count }} Program
                            </span>
                        </td>
                        <td class="py-3.5 px-4 text-center whitespace-nowrap">
                            <div class="flex items-center justify-center gap-1.5">
                                <button 
                                    type="button" 
                                    onclick="openEditMetodeModal({{ $m->id }}, '{{ $m->kode_metode }}', '{{ addslashes($m->nama_metode) }}', '{{ addslashes($m->deskripsi ?? '') }}')"
                                    class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-[11px] px-2.5 py-1 rounded-lg transition-colors"
                                >
                                    Edit
                                </button>
                                <form method="POST" action="{{ route('master.metode.destroy', $m->id) }}" onsubmit="return confirmDelete(event, this, '{{ addslashes($m->nama_metode) }}')">
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
                        <td colspan="5" class="py-12 text-center text-slate-400">Belum ada metode kesepakatan terdaftar.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Modal Tambah / Edit Metode -->
<div id="metodeModal" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full overflow-hidden">
        <form id="metodeForm" method="POST" action="" class="space-y-4">
            @csrf
            <input type="hidden" name="_method" id="metodeFormMethod" value="POST">

            <div class="px-5 py-4 bg-gradient-to-r from-[#072147] to-[#0070e0] text-white flex items-center justify-between">
                <h4 id="metodeModalTitle" class="font-extrabold text-sm">Tambah Metode Kesepakatan</h4>
                <button type="button" onclick="closeMetodeModal()" class="text-white/80 hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="p-5 space-y-4 text-xs">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Kode Metode <span class="text-rose-500">*</span></label>
                    <input type="text" name="kode_metode" id="inputKodeMetode" required placeholder="Contoh: MK-SEWA-GONDOLA" class="w-full text-xs px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 font-mono">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Nama Metode <span class="text-rose-500">*</span></label>
                    <input type="text" name="nama_metode" id="inputNamaMetode" required placeholder="Contoh: Sewa Gondola Display Reguler" class="w-full text-xs px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Deskripsi &amp; Ketentuan</label>
                    <textarea name="deskripsi" id="inputDeskripsiMetode" rows="3" placeholder="Jelaskan ruang lingkup atau skema perhitungannya..." class="w-full text-xs p-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                </div>
            </div>

            <div class="px-5 py-3.5 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-2">
                <button type="button" onclick="closeMetodeModal()" class="px-4 py-2 rounded-xl text-slate-600 font-bold hover:bg-slate-100">Batal</button>
                <button type="submit" class="px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold shadow-sm">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function openAddMetodeModal() {
        document.getElementById('metodeForm').action = "{{ route('master.metode.store') }}";
        document.getElementById('metodeFormMethod').value = "POST";
        document.getElementById('metodeModalTitle').textContent = "Tambah Metode Kesepakatan";
        document.getElementById('inputKodeMetode').value = "";
        document.getElementById('inputNamaMetode').value = "";
        document.getElementById('inputDeskripsiMetode').value = "";
        document.getElementById('metodeModal').classList.remove('hidden');
    }

    function openEditMetodeModal(id, kode, nama, deskripsi) {
        document.getElementById('metodeForm').action = `/metode-kesepakatan/${id}`;
        document.getElementById('metodeFormMethod').value = "PUT";
        document.getElementById('metodeModalTitle').textContent = "Edit Metode Kesepakatan";
        document.getElementById('inputKodeMetode').value = kode;
        document.getElementById('inputNamaMetode').value = nama;
        document.getElementById('inputDeskripsiMetode').value = deskripsi;
        document.getElementById('metodeModal').classList.remove('hidden');
    }

    function closeMetodeModal() {
        document.getElementById('metodeModal').classList.add('hidden');
    }

    function confirmDelete(e, form, nama) {
        e.preventDefault();
        Swal.fire({
            title: 'Hapus Metode Kesepakatan?',
            text: `Yakin ingin menghapus metode "${nama}"? Tindakan ini tidak dapat dibatalkan.`,
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
