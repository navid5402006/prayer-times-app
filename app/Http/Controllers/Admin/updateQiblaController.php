<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\QiblaSearch;

class updateQiblaController extends Controller
{
   /**
     * List all qibla searches
     */
    public function index()
    {
        $searches = QiblaSearch::latest()->paginate(50);
        return view('admin.qibla-searches.index', compact('searches'));
    }

    /**
     * Show edit page
     */
    public function edit($id)
    {
        $search = QiblaSearch::findOrFail($id);
        return view('admin.qibla-searches.edit', compact('search'));
    }

    /**
     * Update qibla city (ALL OPTIONAL)
     */
    public function update(Request $request, $id)
    {
        $search = QiblaSearch::findOrFail($id);

        $data = $request->validate([
            // BASIC INFO
            'city'        => 'sometimes|nullable|string|max:255',
            'state'       => 'nullable|string|max:255',
            'country'     => 'sometimes|nullable|string|max:255',
            'latitude'    => 'nullable|numeric',
            'longitude'   => 'nullable|numeric',
            'qibla_direction' => 'nullable|numeric',
            'slug'        => 'nullable|string|max:255|unique:qibla_searches,slug,' . $id,

            // SEO (NOT REQUIRED)
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords'    => 'nullable|string',

            // CONTENT
            'main_description' => 'nullable|string',
        ]);

        // MARK AS UPDATED (green status) - agar kuch bhi update kiya to
        $data['is_updated'] = 1;

        $search->update($data);

        return redirect()
            ->route('admin.qibla-searches.index')
            ->with('success', 'Qibla city updated successfully');
    }

    /**
 * Delete qibla city
 */
public function destroy($id)
{
    try {
        $search = QiblaSearch::findOrFail($id);
        $search->delete();
        
        return redirect()
            ->route('admin.qibla-searches.index')
            ->with('success', 'Qibla city deleted successfully');
            
    } catch (\Exception $e) {
        return redirect()
            ->route('admin.qibla-searches.index')
            ->with('error', 'Error deleting city: ' . $e->getMessage());
    }
}
}
