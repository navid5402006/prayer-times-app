<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PrayerSearch;
use Illuminate\Support\Facades\Storage;

class PrayerupdateController extends Controller
{
    /**
     * List all prayer searches
     */
    public function index()
    {
        $searches = PrayerSearch::latest()->paginate(50);
        return view('admin.prayer-searches.index', compact('searches'));
    }

    /**
     * Show edit page
     */
    public function edit($id)
    {
        $search = PrayerSearch::findOrFail($id);
        return view('admin.prayer-searches.edit', compact('search'));
    }

    /**
     * Update prayer city (ALL OPTIONAL)
     */
    public function update(Request $request, $id)
    {
        $search = PrayerSearch::findOrFail($id);

        $data = $request->validate([
            // BASIC INFO
            'city'        => 'sometimes|nullable|string|max:255',
            'country'     => 'sometimes|nullable|string|max:255',
            'state'       => 'nullable|string|max:255',
            'timezone'    => 'nullable|string|max:255',
            'slug'        => 'nullable|string|max:255',

            // SEO (NOT REQUIRED)
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords'    => 'nullable|string',

            // CONTENT
            'description' => 'nullable|string',

            // IMAGE (OPTIONAL)
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Image upload (optional)
        if ($request->hasFile('image')) {

            // delete old image if exists
            if ($search->image && Storage::disk('public')->exists($search->image)) {
                Storage::disk('public')->delete($search->image);
            }

            $data['image'] = $request->file('image')
                ->store('prayer-cities', 'public');
        }

        // MARK AS UPDATED (green status)
        $data['is_updated'] = 1;

        $search->update($data);

        return redirect()
            ->route('admin.prayer-searches.index')
            ->with('success', 'Prayer city updated successfully');
    }

    /**
 * Delete prayer city
 */
public function destroy($id)
{
    try {
        $search = PrayerSearch::findOrFail($id);
        
        // Delete image if exists
        if ($search->image && Storage::disk('public')->exists($search->image)) {
            Storage::disk('public')->delete($search->image);
        }
        
        $search->delete();
        
        return redirect()
            ->route('admin.prayer-searches.index')
            ->with('success', 'Prayer city deleted successfully');
            
    } catch (\Exception $e) {
        return redirect()
            ->route('admin.prayer-searches.index')
            ->with('error', 'Error deleting city: ' . $e->getMessage());
    }
}
}
