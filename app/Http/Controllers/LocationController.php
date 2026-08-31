<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class LocationController extends Controller
{
    /**
     * Menampilkan daftar lokasi.
     */
    public function index(Request $request)
    {
        // Nilai search dan filter diambil dari query string.
        $search = trim((string) $request->input('search', ''));
        $countryId = trim((string) $request->input('country_id', ''));

        $conditions = [];
        $bindings = [];

        if ($search !== '') {
            // ILIKE dipakai PostgreSQL untuk pencarian tanpa membedakan huruf besar/kecil.
            $conditions[] = '(
                l.street_address ILIKE ?
                OR l.city ILIKE ?
                OR l.state_province ILIKE ?
                OR l.postal_code ILIKE ?
            )';

            $keyword = "%{$search}%";

            array_push(
                $bindings,
                $keyword,
                $keyword,
                $keyword,
                $keyword
            );
        }

        if ($countryId !== '') {
            // Parameter binding (?) menjaga nilai input tidak ditempel langsung ke SQL.
            $conditions[] = 'l.country_id = ?';
            $bindings[] = $countryId;
        }

        // WHERE hanya ditambahkan jika user memakai search atau filter.
        $whereSql = $conditions
            ? 'WHERE '.implode(' AND ', $conditions)
            : '';

        // Menghitung total data untuk kebutuhan pagination.
        $total = DB::selectOne(
            "SELECT COUNT(*) AS total
             FROM locations l
             {$whereSql}",
            $bindings
        )->total;

        $perPage = 10;
        $page = LengthAwarePaginator::resolveCurrentPage();
        $offset = ($page - 1) * $perPage;

        // Raw SELECT + LEFT JOIN dipakai agar nama negara dapat ditampilkan.
        $locations = DB::select(
            "SELECT
                l.location_id,
                l.street_address,
                l.postal_code,
                l.city,
                l.state_province,
                l.country_id,
                c.country_name
             FROM locations l
             LEFT JOIN countries c
                ON l.country_id = c.country_id
             {$whereSql}
             ORDER BY l.location_id
             LIMIT ? OFFSET ?",
            [...$bindings, $perPage, $offset]
        );

        // DB::select() menghasilkan array, sehingga paginator dibuat manual.
        $locations = new LengthAwarePaginator(
            $locations,
            $total,
            $perPage,
            $page,
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ]
        );

        // Dropdown negara juga diambil dengan raw query.
        $countries = DB::select(
            'SELECT country_id, country_name
             FROM countries
             ORDER BY country_name'
        );

        return view('locations.index', compact('locations', 'countries'));
    }

    /**
     * Menampilkan form tambah lokasi.
     */
    public function create()
    {
        // Data country digunakan sebagai pilihan foreign key pada form.
        $countries = DB::select(
            'SELECT country_id, country_name
             FROM countries
             ORDER BY country_name'
        );

        return view('locations.create', compact('countries'));
    }

    /**
     * Menyimpan lokasi baru.
     */
    public function store(Request $request)
    {
        $validated = $this->validateLocation($request);

        // location_id tidak auto increment.
        // Pola data existing bertambah 100: 1000, 1100, 1200, dan seterusnya.
        $nextId = DB::selectOne(
            'SELECT COALESCE(MAX(location_id), 900) + 100 AS next_id
             FROM locations'
        )->next_id;

        // INSERT ditulis langsung dengan raw query dan parameter binding.
        DB::insert(
            'INSERT INTO locations (
                location_id,
                street_address,
                postal_code,
                city,
                state_province,
                country_id
             ) VALUES (?, ?, ?, ?, ?, ?)',
            [
                $nextId,
                $validated['street_address'] ?? null,
                $validated['postal_code'] ?? null,
                $validated['city'],
                $validated['state_province'] ?? null,
                $validated['country_id'] ?? null,
            ]
        );

        return redirect()
            ->route('locations.index')
            ->with('success', 'Data lokasi berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail lokasi.
     */
    public function show(int $location)
    {
        // JOIN countries dan regions dipakai untuk menampilkan informasi relasi.
        $locationData = DB::selectOne(
            'SELECT
                l.location_id,
                l.street_address,
                l.postal_code,
                l.city,
                l.state_province,
                l.country_id,
                c.country_name,
                r.region_name
             FROM locations l
             LEFT JOIN countries c
                ON l.country_id = c.country_id
             LEFT JOIN regions r
                ON c.region_id = r.region_id
             WHERE l.location_id = ?',
            [$location]
        );

        abort_if(!$locationData, 404);

        // Menampilkan departemen yang menggunakan location_id ini.
        $departments = DB::select(
            'SELECT department_id, department_name
             FROM departments
             WHERE location_id = ?
             ORDER BY department_id',
            [$location]
        );

        return view('locations.show', [
            'location' => $locationData,
            'departments' => $departments,
        ]);
    }

    /**
     * Menampilkan form edit lokasi.
     */
    public function edit(int $location)
    {
        // Data lokasi yang akan diedit diambil berdasarkan primary key.
        $locationData = DB::selectOne(
            'SELECT
                location_id,
                street_address,
                postal_code,
                city,
                state_province,
                country_id
             FROM locations
             WHERE location_id = ?',
            [$location]
        );

        abort_if(!$locationData, 404);

        $countries = DB::select(
            'SELECT country_id, country_name
             FROM countries
             ORDER BY country_name'
        );

        return view('locations.edit', [
            'location' => $locationData,
            'countries' => $countries,
        ]);
    }

    /**
     * Memperbarui data lokasi.
     */
    public function update(Request $request, int $location)
    {
        $validated = $this->validateLocation($request);

        // UPDATE dilakukan langsung ke tabel locations.
        $affected = DB::update(
            'UPDATE locations
             SET
                street_address = ?,
                postal_code = ?,
                city = ?,
                state_province = ?,
                country_id = ?
             WHERE location_id = ?',
            [
                $validated['street_address'] ?? null,
                $validated['postal_code'] ?? null,
                $validated['city'],
                $validated['state_province'] ?? null,
                $validated['country_id'] ?? null,
                $location,
            ]
        );

        abort_if($affected === 0 && !$this->locationExists($location), 404);

        return redirect()
            ->route('locations.index')
            ->with('success', 'Data lokasi berhasil diperbarui.');
    }

    /**
     * Menghapus lokasi jika tidak sedang digunakan departemen.
     */
    public function destroy(int $location)
    {
        abort_unless($this->locationExists($location), 404);

        // Cek relasi lebih dulu agar DELETE tidak melanggar foreign key.
        $departmentCount = DB::selectOne(
            'SELECT COUNT(*) AS total
             FROM departments
             WHERE location_id = ?',
            [$location]
        )->total;

        if ($departmentCount > 0) {
            return redirect()
                ->route('locations.index')
                ->with(
                    'error',
                    'Lokasi tidak dapat dihapus karena masih digunakan oleh departemen.'
                );
        }

        // DELETE dilakukan menggunakan primary key location_id.
        DB::delete(
            'DELETE FROM locations
             WHERE location_id = ?',
            [$location]
        );

        return redirect()
            ->route('locations.index')
            ->with('success', 'Data lokasi berhasil dihapus.');
    }

    /**
     * Mengecek keberadaan lokasi dengan raw query.
     */
    private function locationExists(int $locationId): bool
    {
        return DB::selectOne(
            'SELECT EXISTS(
                SELECT 1
                FROM locations
                WHERE location_id = ?
             ) AS exists',
            [$locationId]
        )->exists;
    }

    /**
     * Validasi input dipakai bersama oleh store() dan update().
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
