<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RamadanSearch;

class updateRamadanController extends Controller
{
    /**
     * List all ramadan searches
     */
    public function index()
    {
        $searches = RamadanSearch::latest()->paginate(50);
        return view('admin.ramadan-searches.index', compact('searches'));
    }

    /**
     * Show edit page
     */
    public function edit($id)
    {
        $search = RamadanSearch::findOrFail($id);
        return view('admin.ramadan-searches.edit', compact('search'));
    }

    /**
     * Update ramadan city (ALL OPTIONAL)
     */
    public function update(Request $request, $id)
    {
        $search = RamadanSearch::findOrFail($id);

        $data = $request->validate([
            // BASIC INFO
            'city'        => 'sometimes|nullable|string|max:255',
            'state'       => 'nullable|string|max:255',
            'country'     => 'sometimes|nullable|string|max:255',
            'latitude'    => 'nullable|numeric',
            'longitude'   => 'nullable|numeric',
            'timezone'    => 'nullable|string|max:255',
            'slug'        => 'nullable|string|max:255|unique:ramadan_searches,slug,' . $id,

            // SEO (NOT REQUIRED)
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords'    => 'nullable|string',

            // CONTENT
            'main_description' => 'nullable|string',
        ]);

        // MARK AS UPDATED (green status)
        $data['updated_at'] = 1;

        $search->update($data);

        return redirect()
            ->route('admin.ramadan-searches.index')
            ->with('success', 'Ramadan city updated successfully');
    }

    /**
     * Delete ramadan city
     */
    public function destroy($id)
    {
        try {
            $search = RamadanSearch::findOrFail($id);
            $search->delete();
            
            return redirect()
                ->route('admin.ramadan-searches.index')
                ->with('success', 'Ramadan city deleted successfully');
                
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.ramadan-searches.index')
                ->with('error', 'Error deleting city: ' . $e->getMessage());
        }
    }
}
