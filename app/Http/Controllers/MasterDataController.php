<?php

namespace App\Http\Controllers;

use App\Models\EventPromosi;
use App\Models\MetodeKesepakatan;
use App\Models\SaranaPromosi;
use App\Models\Supplier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MasterDataController extends Controller
{
    // =========================================================================
    // 1. METODE KESEPAKATAN
    // =========================================================================

    public function metodeIndex(): View
    {
        $metodes = MetodeKesepakatan::withCount('programPromos')->latest('id')->get();

        return view('master.metode', compact('metodes'));
    }

    public function metodeStore(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'kode_metode' => ['required', 'string', 'max:30', 'unique:metode_kesepakatan,kode_metode'],
            'nama_metode' => ['required', 'string', 'max:100'],
            'deskripsi' => ['nullable', 'string'],
        ], [
            'kode_metode.required' => 'Kode metode wajib diisi.',
            'kode_metode.unique' => 'Kode metode sudah digunakan.',
            'nama_metode.required' => 'Nama metode kesepakatan wajib diisi.',
        ]);

        MetodeKesepakatan::create($validated);

        return back()->with('success', "Metode kesepakatan '{$validated['nama_metode']}' berhasil ditambahkan.");
    }

    public function metodeUpdate(Request $request, MetodeKesepakatan $metode): RedirectResponse
    {
        $validated = $request->validate([
            'kode_metode' => ['required', 'string', 'max:30', 'unique:metode_kesepakatan,kode_metode,'.$metode->id],
            'nama_metode' => ['required', 'string', 'max:100'],
            'deskripsi' => ['nullable', 'string'],
        ]);

        $metode->update($validated);

        return back()->with('success', "Metode kesepakatan '{$metode->nama_metode}' berhasil diperbarui.");
    }

    public function metodeDestroy(MetodeKesepakatan $metode): RedirectResponse
    {
        if ($metode->programPromos()->exists()) {
            return back()->with('error', "Metode '{$metode->nama_metode}' tidak dapat dihapus karena masih digunakan oleh program promo aktif.");
        }

        $metode->delete();

        return back()->with('success', 'Metode kesepakatan berhasil dihapus.');
    }

    // =========================================================================
    // 2. EVENT PROMOSI
    // =========================================================================

    public function eventIndex(Request $request): View
    {
        $query = EventPromosi::withCount('programPromos')->orderByDesc('tahun')->orderBy('tanggal_mulai');

        if ($tahun = $request->input('tahun')) {
            $query->where('tahun', $tahun);
        }

        $events = $query->get();
        $years = EventPromosi::select('tahun')->distinct()->pluck('tahun');

        return view('master.event', compact('events', 'years'));
    }

    public function eventStore(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_event' => ['required', 'string', 'max:150'],
            'tahun' => ['required', 'integer', 'min:2020', 'max:2035'],
            'tanggal_mulai' => ['required', 'date'],
            'tanggal_selesai' => ['required', 'date', 'after_or_equal:tanggal_mulai'],
            'deskripsi' => ['nullable', 'string'],
        ], [
            'nama_event.required' => 'Nama event promosi wajib diisi.',
            'tanggal_selesai.after_or_equal' => 'Tanggal selesai tidak boleh sebelum tanggal mulai.',
        ]);

        EventPromosi::create($validated);

        return back()->with('success', "Event promosi '{$validated['nama_event']}' berhasil didaftarkan.");
    }

    public function eventUpdate(Request $request, EventPromosi $event): RedirectResponse
    {
        $validated = $request->validate([
            'nama_event' => ['required', 'string', 'max:150'],
            'tahun' => ['required', 'integer', 'min:2020', 'max:2035'],
            'tanggal_mulai' => ['required', 'date'],
            'tanggal_selesai' => ['required', 'date', 'after_or_equal:tanggal_mulai'],
            'deskripsi' => ['nullable', 'string'],
        ]);

        $event->update($validated);

        return back()->with('success', "Event promosi '{$event->nama_event}' berhasil diperbarui.");
    }

    public function eventDestroy(EventPromosi $event): RedirectResponse
    {
        if ($event->programPromos()->exists()) {
            return back()->with('error', "Event '{$event->nama_event}' tidak dapat dihapus karena masih terikat ke program promosi.");
        }

        $event->delete();

        return back()->with('success', 'Event promosi berhasil dihapus.');
    }

    // =========================================================================
    // 3. SARANA PROMOSI
    // =========================================================================

    public function saranaIndex(Request $request): View
    {
        $query = SaranaPromosi::orderBy('kategori_sarana')->orderBy('nama_sarana');

        if ($kategori = $request->input('kategori')) {
            $query->where('kategori_sarana', $kategori);
        }

        $saranas = $query->get();
        $categories = SaranaPromosi::select('kategori_sarana')->distinct()->pluck('kategori_sarana');

        return view('master.sarana', compact('saranas', 'categories'));
    }

    public function saranaStore(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'kode_sarana' => ['required', 'string', 'max:30', 'unique:sarana_promosi,kode_sarana'],
            'nama_sarana' => ['required', 'string', 'max:150'],
            'kategori_sarana' => ['required', 'string', 'max:100'],
            'lokasi' => ['required', 'string', 'max:100'],
            'tarif_standar' => ['required', 'numeric', 'min:0'],
        ], [
            'kode_sarana.required' => 'Kode sarana wajib diisi.',
            'kode_sarana.unique' => 'Kode sarana sudah digunakan.',
            'nama_sarana.required' => 'Nama sarana promosi wajib diisi.',
            'tarif_standar.required' => 'Tarif standar sewa wajib ditentukan.',
        ]);

        SaranaPromosi::create($validated);

        return back()->with('success', "Sarana promosi '{$validated['nama_sarana']}' berhasil ditambahkan.");
    }

    public function saranaUpdate(Request $request, SaranaPromosi $sarana): RedirectResponse
    {
        $validated = $request->validate([
            'kode_sarana' => ['required', 'string', 'max:30', 'unique:sarana_promosi,kode_sarana,'.$sarana->id],
            'nama_sarana' => ['required', 'string', 'max:150'],
            'kategori_sarana' => ['required', 'string', 'max:100'],
            'lokasi' => ['required', 'string', 'max:100'],
            'tarif_standar' => ['required', 'numeric', 'min:0'],
        ]);

        $sarana->update($validated);

        return back()->with('success', "Sarana promosi '{$sarana->nama_sarana}' berhasil diperbarui.");
    }

    public function saranaDestroy(SaranaPromosi $sarana): RedirectResponse
    {
        $sarana->delete();

        return back()->with('success', 'Sarana promosi berhasil dihapus.');
    }

    // =========================================================================
    // 4. SUPPLIER & CUSTOMER AR
    // =========================================================================

    public function supplierIndex(Request $request): View
    {
        $query = Supplier::withCount(['programPromos', 'tagihanAr'])->orderBy('nama_supplier');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('kode_supplier', 'like', "%{$search}%")
                    ->orWhere('nama_supplier', 'like', "%{$search}%")
                    ->orWhere('kategori', 'like', "%{$search}%");
            });
        }

        if ($statusAr = $request->input('status_customer_ar')) {
            $query->where('status_customer_ar', $statusAr);
        }

        if ($statusAlamat = $request->input('status_alamat_tagih')) {
            $query->where('status_alamat_tagih', $statusAlamat);
        }

        $suppliers = $query->paginate(10)->withQueryString();

        $stats = [
            'total' => Supplier::count(),
            'ar_terdaftar' => Supplier::where('status_customer_ar', 'terdaftar')->count(),
            'ar_belum' => Supplier::where('status_customer_ar', 'belum_terdaftar')->count(),
            'alamat_kurang' => Supplier::where('status_alamat_tagih', 'belum_lengkap')->count(),
        ];

        return view('master.supplier', compact('suppliers', 'stats'));
    }

    public function supplierStore(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'kode_supplier' => ['required', 'string', 'max:30', 'unique:supplier,kode_supplier'],
            'nama_supplier' => ['required', 'string', 'max:150'],
            'kategori' => ['required', 'string', 'max:100'],
            'kontak_person' => ['nullable', 'string', 'max:100'],
            'email' => ['nullable', 'email', 'max:100'],
            'telepon' => ['nullable', 'string', 'max:50'],
            'status_customer_ar' => ['required', 'in:terdaftar,belum_terdaftar'],
            'status_alamat_tagih' => ['required', 'in:lengkap,belum_lengkap'],
        ], [
            'kode_supplier.required' => 'Kode supplier wajib diisi.',
            'kode_supplier.unique' => 'Kode supplier sudah terdaftar.',
            'nama_supplier.required' => 'Nama supplier wajib diisi.',
        ]);

        Supplier::create($validated);

        return back()->with('success', "Supplier '{$validated['nama_supplier']}' berhasil didaftarkan.");
    }

    public function supplierUpdate(Request $request, Supplier $supplier): RedirectResponse
    {
        $validated = $request->validate([
            'kode_supplier' => ['required', 'string', 'max:30', 'unique:supplier,kode_supplier,'.$supplier->id],
            'nama_supplier' => ['required', 'string', 'max:150'],
            'kategori' => ['required', 'string', 'max:100'],
            'kontak_person' => ['nullable', 'string', 'max:100'],
            'email' => ['nullable', 'email', 'max:100'],
            'telepon' => ['nullable', 'string', 'max:50'],
            'status_customer_ar' => ['required', 'in:terdaftar,belum_terdaftar'],
            'status_alamat_tagih' => ['required', 'in:lengkap,belum_lengkap'],
        ]);

        $supplier->update($validated);

        return back()->with('success', "Data supplier '{$supplier->nama_supplier}' berhasil diperbarui.");
    }

    public function supplierToggleAr(Request $request, Supplier $supplier): RedirectResponse
    {
        $action = $request->input('action', 'ar');

        if ($action === 'ar') {
            $newStatus = $supplier->status_customer_ar === 'terdaftar' ? 'belum_terdaftar' : 'terdaftar';
            $supplier->update(['status_customer_ar' => $newStatus]);
            $msg = "Status Customer AR untuk {$supplier->nama_supplier} diubah menjadi '{$newStatus}'.";
        } else {
            $newStatus = $supplier->status_alamat_tagih === 'lengkap' ? 'belum_lengkap' : 'lengkap';
            $supplier->update(['status_alamat_tagih' => $newStatus]);
            $msg = "Status Alamat Tagih untuk {$supplier->nama_supplier} diubah menjadi '{$newStatus}'.";
        }

        return back()->with('success', $msg);
    }
}
