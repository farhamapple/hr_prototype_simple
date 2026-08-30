<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CountryController extends Controller
{
    // READ: Tampil data negara + Join ke tabel regions
    public function index()
    {
        $countries = DB::select("
            SELECT c.country_id, c.country_name, r.region_name 
            FROM countries c
            LEFT JOIN regions r ON c.region_id = r.region_id
            ORDER BY c.country_id ASC
        ");

        return view('countries.index', compact('countries'));
    }

    // CREATE: Form Tambah Data
    public function create()
    {
        $regions = DB::select("SELECT region_id, region_name FROM regions ORDER BY region_name ASC");
        return view('countries.create', compact('regions'));
    }

    // STORE: Simpan Data Baru
    public function store(Request $request)
    {
        $request->validate([
            'country_id'   => 'required|max:2',
            'country_name' => 'required',
            'region_id'    => 'required|integer',
        ]);

        DB::insert("
            INSERT INTO countries (country_id, country_name, region_id) 
            VALUES (?, ?, ?)
        ", [$request->country_id, $request->country_name, $request->region_id]);

        return redirect()->route('countries.index')->with('success', 'Negara berhasil ditambahkan!');
    }

    // EDIT: Form Edit Data
    public function edit($id)
    {
        $country = DB::selectOne("SELECT * FROM countries WHERE country_id = ?", [$id]);
        $regions = DB::select("SELECT region_id, region_name FROM regions ORDER BY region_name ASC");

        return view('countries.edit', compact('country', 'regions'));
    }

    // UPDATE: Simpan Perubahan Data
    public function update(Request $request, $id)
    {
        $request->validate([
            'country_name' => 'required',
            'region_id'    => 'required|integer',
        ]);

        DB::update("
            UPDATE countries 
            SET country_name = ?, region_id = ? 
            WHERE country_id = ?
        ", [$request->country_name, $request->region_id, $id]);

        return redirect()->route('countries.index')->with('success', 'Negara berhasil diperbarui!');
    }

    // DELETE: Hapus Data
    public function destroy($id)
    {
        DB::delete("DELETE FROM countries WHERE country_id = ?", [$id]);

        return redirect()->route('countries.index')->with('success', 'Negara berhasil dihapus!');
    }
}