<?php

namespace App\Http\Controllers;

use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $regions = DB::select('
        select *
            from regions r
            order by r.region_id  asc
        ');
        return view('regions.regions-index', compact('regions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('regions.regions-create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'region_id'     => 'required|numeric|unique:regions,region_id',
            'region_name'     => 'required|string|max:255|unique:regions,region_name',
        ], [
            'region_id.unique' => 'ID Wilayah ini sudah ada, silakan buat yang lain.',
            'region_name.unique' => 'Wilayah ini sudah ada, silakan buat yang lain.',
        ]);
        
        // Region::create($validated);
        DB::insert('insert into regions (region_id, region_name) values (?, ?)', [
            $validated['region_id'],
            $validated['region_name'],
        ]);
        
        return redirect()
            ->route('regions.index')
            ->with('success', 'Wilayah berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Region $region)
    {
        return view('regions.regions-show', compact('region'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Region $region)
    {
        return view('regions.regions-edit', compact('region'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'region_id'   => 'required|numeric|unique:regions,region_id,' . $id . ',region_id',
            'region_name' => 'required|string|max:255|unique:regions,region_name,' . $id . ',region_id',
        ], [
            'region_id.unique' => 'ID Wilayah ini sudah ada, silakan buat yang lain.',
            'region_name.unique' => 'Wilayah ini sudah ada, silakan buat yang lain.',
        ]);
        
        // $region->update($validated);
        DB::update('
        update regions set region_id = ?, region_name = ?,
        where region_id = ?
        ', [
            $validated['region_id'],
            $validated['region_name'],
            $id
        ]);
        
        return redirect()
            ->route('regions.index')
            ->with('success', 'Wilayah berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        // $region->delete();
        DB::delete('delete from regions where region_id = ?', [$id]);

        return redirect()
            ->route('regions.index')
            ->with('success', 'Wilayah berhasil dihapus!');
    }
}
