@extends('layouts.app')

@section('title', 'Event Promosi')
@section('header_title', 'Master Event Promosi')
@section('header_subtitle', 'Kelola kalender dan agenda program promosi tematik tahunan MBS Group.')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div class="flex items-center gap-2">
            <h3 class="font-extrabold text-sm text-slate-800">Kalender Event Promosi</h3>
            <span class="text-xs bg-blue-50 text-blue-700 font-bold px-2.5 py-0.5 rounded-full border border-blue-200">{{ count($events) }} Event</span>
        </div>
        <div class="flex items-center gap-2">
            <!-- Filter Tahun -->
            <form method="GET" action="{{ route('master.event') }}" class="flex items-center gap-2">
                <select name="tahun" onchange="this.form.submit()" class="text-xs px-3 py-1.5 rounded-xl border border-slate-200 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 font-bold text-slate-700">
                    <option value="">Semua Tahun</option>
                    @foreach($years as $yr)
                        <option value="{{ $yr }}" {{ request('tahun') == $yr ? 'selected' : '' }}>Tahun {{ $yr }}</option>
                    @endforeach
                </select>
            </form>

            <button type="button" onclick="openAddEventModal()" class="bg-[#0070e0] hover:bg-blue-600 text-white font-bold text-xs px-3.5 py-2 rounded-xl shadow-sm transition-all flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span>Tambah Event Baru</span>
            </button>
        </div>
    </div>

    <!-- Data Table -->
    <div class="white-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider text-[10px] border-b border-slate-200/80">
                        <th class="py-3 px-4">Nama Event Promosi</th>
                        <th class="py-3 px-4 text-center">Tahun</th>
                        <th class="py-3 px-4">Periode Tanggal</th>
                        <th class="py-3 px-4">Deskripsi</th>
                        <th class="py-3 px-4 text-center">Program Promo</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($events as $ev)
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="py-3.5 px-4 font-bold text-slate-800 whitespace-nowrap">
                            {{ $ev->nama_event }}
                        </td>
                        <td class="py-3.5 px-4 text-center font-bold text-blue-700 whitespace-nowrap">
                            {{ $ev->tahun }}
                        </td>
                        <td class="py-3.5 px-4 whitespace-nowrap text-slate-600">
                            <div>{{ $ev->tanggal_mulai ? $ev->tanggal_mulai->format('d M Y') : '-' }}</div>
                            <div class="text-[10px] text-slate-400">s/d {{ $ev->tanggal_selesai ? $ev->tanggal_selesai->format('d M Y') : '-' }}</div>
                        </td>
                        <td class="py-3.5 px-4 text-slate-600 max-w-xs">
                            {{ $ev->deskripsi ?? '-' }}
                        </td>
                        <td class="py-3.5 px-4 text-center whitespace-nowrap">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-bold {{ $ev->program_promos_count > 0 ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-slate-100 text-slate-500' }}">
                                {{ $ev->program_promos_count }} Program
                            </span>
                        </td>
                        <td class="py-3.5 px-4 text-center whitespace-nowrap">
                            <div class="flex items-center justify-center gap-1.5">
                                <button 
                                    type="button" 
                                    onclick="openEditEventModal({{ $ev->id }}, '{{ addslashes($ev->nama_event) }}', {{ $ev->tahun }}, '{{ $ev->tanggal_mulai ? $ev->tanggal_mulai->format('Y-m-d') : '' }}', '{{ $ev->tanggal_selesai ? $ev->tanggal_selesai->format('Y-m-d') : '' }}', '{{ addslashes($ev->deskripsi ?? '') }}')"
                                    class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-[11px] px-2.5 py-1 rounded-lg transition-colors"
                                >
                                    Edit
                                </button>
                                <form method="POST" action="{{ route('master.event.destroy', $ev->id) }}" onsubmit="return confirmDeleteEvent(event, this, '{{ addslashes($ev->nama_event) }}')">
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
                        <td colspan="6" class="py-12 text-center text-slate-400">Belum ada agenda event promosi terdaftar.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Modal Tambah / Edit Event -->
<div id="eventModal" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full overflow-hidden">
        <form id="eventForm" method="POST" action="" class="space-y-4">
            @csrf
            <input type="hidden" name="_method" id="eventFormMethod" value="POST">

            <div class="px-5 py-4 bg-gradient-to-r from-[#072147] to-[#0070e0] text-white flex items-center justify-between">
                <h4 id="eventModalTitle" class="font-extrabold text-sm">Tambah Event Promosi</h4>
                <button type="button" onclick="closeEventModal()" class="text-white/80 hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="p-5 space-y-4 text-xs">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Nama Event Promosi <span class="text-rose-500">*</span></label>
                    <input type="text" name="nama_event" id="inputNamaEvent" required placeholder="Contoh: Gebyar Bangunan Ramadhan 2026" class="w-full text-xs px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Tahun <span class="text-rose-500">*</span></label>
                    <input type="number" name="tahun" id="inputTahunEvent" required value="{{ date('Y') }}" min="2020" max="2035" class="w-full text-xs px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 font-bold">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Tanggal Mulai <span class="text-rose-500">*</span></label>
                        <input type="date" name="tanggal_mulai" id="inputTglMulaiEvent" required class="w-full text-xs px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Tanggal Selesai <span class="text-rose-500">*</span></label>
                        <input type="date" name="tanggal_selesai" id="inputTglSelesaiEvent" required class="w-full text-xs px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Deskripsi &amp; Tema Event</label>
                    <textarea name="deskripsi" id="inputDeskripsiEvent" rows="3" placeholder="Rincian tema promosi pameran atau ketentuan khusus..." class="w-full text-xs p-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                </div>
            </div>

            <div class="px-5 py-3.5 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-2">
                <button type="button" onclick="closeEventModal()" class="px-4 py-2 rounded-xl text-slate-600 font-bold hover:bg-slate-100">Batal</button>
                <button type="submit" class="px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold shadow-sm">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function openAddEventModal() {
        document.getElementById('eventForm').action = "{{ route('master.event.store') }}";
        document.getElementById('eventFormMethod').value = "POST";
        document.getElementById('eventModalTitle').textContent = "Tambah Event Promosi";
        document.getElementById('inputNamaEvent').value = "";
        document.getElementById('inputTahunEvent').value = "{{ date('Y') }}";
        document.getElementById('inputTglMulaiEvent').value = "{{ now()->toDateString() }}";
        document.getElementById('inputTglSelesaiEvent').value = "{{ now()->addDays(30)->toDateString() }}";
        document.getElementById('inputDeskripsiEvent').value = "";
        document.getElementById('eventModal').classList.remove('hidden');
    }

    function openEditEventModal(id, nama, tahun, tglMulai, tglSelesai, deskripsi) {
        document.getElementById('eventForm').action = `/event-promosi/${id}`;
        document.getElementById('eventFormMethod').value = "PUT";
        document.getElementById('eventModalTitle').textContent = "Edit Event Promosi";
        document.getElementById('inputNamaEvent').value = nama;
        document.getElementById('inputTahunEvent').value = tahun;
        document.getElementById('inputTglMulaiEvent').value = tglMulai;
        document.getElementById('inputTglSelesaiEvent').value = tglSelesai;
        document.getElementById('inputDeskripsiEvent').value = deskripsi;
        document.getElementById('eventModal').classList.remove('hidden');
    }

    function closeEventModal() {
        document.getElementById('eventModal').classList.add('hidden');
    }

    function confirmDeleteEvent(e, form, nama) {
        e.preventDefault();
        Swal.fire({
            title: 'Hapus Event Promosi?',
            text: `Yakin ingin menghapus agenda event "${nama}"?`,
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
