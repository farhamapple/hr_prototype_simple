<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    /**
     * Menampilkan daftar lokasi.
     */
    public function index(Request $request)
    {
        // Mengambil lokasi sekaligus relasi country agar nama negara dapat ditampilkan.
        $locations = Location::with('country')
            ->when($request->filled('search'), function ($query) use ($request) {
                // Search alamat, kota, provinsi, atau kode pos tanpa membedakan kapital.
                $search = $request->string('search')->trim()->value();

                $query->where(function ($query) use ($search) {
                    $query->where('street_address', 'ILIKE', "%{$search}%")
                        ->orWhere('city', 'ILIKE', "%{$search}%")
                        ->orWhere('state_province', 'ILIKE', "%{$search}%")
                        ->orWhere('postal_code', 'ILIKE', "%{$search}%");
                });
            })
            ->when($request->filled('country_id'), function ($query) use ($request) {
                // Filter data berdasarkan negara yang dipilih.
                $query->where('country_id', $request->string('country_id')->value());
            })
            ->orderBy('location_id')
            ->paginate(10)
            ->withQueryString();

        // Data negara digunakan untuk filter.
        $countries = Country::orderBy('country_name')->get();

        return view('locations.index', compact('locations', 'countries'));
    }

    /**
     * Menampilkan form tambah lokasi.
     */
    public function create()
    {
        // Country menjadi pilihan foreign key pada form.
        $countries = Country::orderBy('country_name')->get();

        return view('locations.create', compact('countries'));
    }

    /**
     * Menyimpan lokasi baru.
     */
    public function store(Request $request)
    {
        $validated = $this->validateLocation($request);

        // Pola ID pada data HR adalah 1000, 1100, 1200, dan seterusnya.
        // Karena kolom tidak auto increment, ID baru dibuat dari ID terbesar + 100.
        $validated['location_id'] = (Location::max('location_id') ?? 900) + 100;

        Location::create($validated);

        return redirect()
            ->route('locations.index')
            ->with('success', 'Data lokasi berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail lokasi.
     */
    public function show(Location $location)
    {
        // departments ikut dimuat untuk melihat penggunaan lokasi pada organisasi.
        $location->load(['country.region', 'departments']);

        return view('locations.show', compact('location'));
    }

    /**
     * Menampilkan form edit lokasi.
     */
    public function edit(Location $location)
    {
        $countries = Country::orderBy('country_name')->get();

        return view('locations.edit', compact('location', 'countries'));
    }

    /**
     * Memperbarui data lokasi.
     */
    public function update(Request $request, Location $location)
    {
        $validated = $this->validateLocation($request);

        $location->update($validated);

        return redirect()
            ->route('locations.index')
            ->with('success', 'Data lokasi berhasil diperbarui.');
    }

    /**
     * Menghapus lokasi jika tidak sedang digunakan departemen.
     */
    public function destroy(Location $location)
    {
        // Foreign key departments.location_id mencegah lokasi yang masih dipakai dihapus.
        if ($location->departments()->exists()) {
            return redirect()
                ->route('locations.index')
                ->with('error', 'Lokasi tidak dapat dihapus karena masih digunakan oleh departemen.');
        }

        $location->delete();

        return redirect()
            ->route('locations.index')
            ->with('success', 'Data lokasi berhasil dihapus.');
    }

    /**
     * Aturan validasi dipakai bersama oleh store() dan update()
     * supaya tidak ada duplikasi rule.
     */
    private function validateLocation(Request $request): array
    {
        return $request->validate([
            'street_address' => ['nullable', 'string', 'max:40'],
            'postal_code' => ['nullable', 'string', 'max:12'],
            'city' => ['required', 'string', 'max:30'],
            'state_province' => ['nullable', 'string', 'max:25'],
            'country_id' => ['nullable', 'exists:countries,country_id'],
        ]);
    }
}
