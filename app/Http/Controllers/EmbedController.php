<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmbedController extends Controller
{
     // Developers page
    public function index()
    {
        $city = request('city', 'Karachi');
    $country = request('country', 'Pakistan');
    return view('developers', compact('city','country'));
    }

    // JS widget response
    public function prayerWidget(Request $request)
    {
        $city = $request->get('city', 'Karachi');
        $country = $request->get('country', 'Pakistan');

        return response()->view(
            'embed.prayer-js',
            compact('city', 'country')
        )->header('Content-Type', 'application/javascript');
    }
}
