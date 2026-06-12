<?php

namespace App\Http\Controllers;

use App\Models\PrayerSearch;
use App\Models\RamadanSearch;
use App\Models\QiblaSearch; // Add Qibla model
use App\Models\Blog; // Add Blog model (assuming you have a Blog model)
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    /**
     * Generate sitemap for Prayer pages
     * Route: /s/prayer_sitemap.xml
     */
    public function prayer_searches_sitemap()
    {
        // Get all prayer search entries
        $prayerSearches = PrayerSearch::select('slug', 'updated_at')
            ->whereNotNull('slug')
            ->orderBy('updated_at', 'desc')
            ->get();

        // Generate sitemap XML
        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        // Add homepage
        $xml .= '<url>';
        $xml .= '<loc>' . url('/') . '</loc>';
        $xml .= '<lastmod>' . now()->toW3cString() . '</lastmod>';
        $xml .= '<changefreq>daily</changefreq>';
        $xml .= '<priority>1.0</priority>';
        $xml .= '</url>';

        // Add prayer search pages
        foreach ($prayerSearches as $search) {
            $xml .= '<url>';
            $xml .= '<loc>' . url('/' . $search->slug) . '</loc>';
            $xml .= '<lastmod>' . $search->updated_at->toW3cString() . '</lastmod>';
            $xml .= '<changefreq>weekly</changefreq>';
            $xml .= '<priority>0.8</priority>';
            $xml .= '</url>';
        }

        $xml .= '</urlset>';

        return response($xml, 200)
            ->header('Content-Type', 'text/xml');
    }

    /**
     * Generate sitemap for Ramadan pages
     * Route: /s/ramadhan_sitemap.xml
     */
    public function ramadhan_sitemap()
    {
        // Get all Ramadan search entries with slugs
        $ramadanSearches = RamadanSearch::select('slug', 'updated_at')
            ->whereNotNull('slug')
            ->orderBy('updated_at', 'desc')
            ->get();

        // Generate sitemap XML
        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        // Add each Ramadan slug as URL
        foreach ($ramadanSearches as $ramadan) {
            $xml .= '<url>';
            $xml .= '<loc>' . url($ramadan->slug) . '</loc>';
            $xml .= '<lastmod>' . $ramadan->updated_at->toW3cString() . '</lastmod>';
            $xml .= '<changefreq>daily</changefreq>';
            $xml .= '<priority>0.9</priority>';
            $xml .= '</url>';
        }

        $xml .= '</urlset>';

        return response($xml, 200)
            ->header('Content-Type', 'text/xml');
    }

    /**
     * Generate sitemap for Qibla pages
     * Route: /s/qibla_sitemap.xml
     */
    public function qibla_sitemap()
    {
        // Get all qibla search entries with slugs
        $qiblaSearches = QiblaSearch::select('slug', 'updated_at')
            ->whereNotNull('slug')
            ->orderBy('updated_at', 'desc')
            ->get();

        // Generate sitemap XML
        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        // Add each qibla slug as URL
        foreach ($qiblaSearches as $qibla) {
            $xml .= '<url>';
            $xml .= '<loc>' . url($qibla->slug) . '</loc>';
            $xml .= '<lastmod>' . $qibla->updated_at->toW3cString() . '</lastmod>';
            $xml .= '<changefreq>weekly</changefreq>';
            $xml .= '<priority>0.8</priority>';
            $xml .= '</url>';
        }

        $xml .= '</urlset>';

        return response($xml, 200)
            ->header('Content-Type', 'text/xml');
    }

    /**
     * Generate sitemap for Blog pages
     * Route: /s/blog_sitemap.xml
     */
    public function blog_sitemap()
    {
        // Get all blog entries with slugs
        // Assuming you have a Blog model - adjust according to your blog structure
        $blogs = Blog::select('slug', 'updated_at')
            ->whereNotNull('slug')
            ->where('status', 'published') // Only published blogs
            ->orderBy('updated_at', 'desc')
            ->get();

        // Generate sitemap XML
        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        // Add each blog slug as URL
        foreach ($blogs as $blog) {
            $xml .= '<url>';
            $xml .= '<loc>' . url('blog/' . $blog->slug) . '</loc>'; // Adjust URL structure
            $xml .= '<lastmod>' . $blog->updated_at->toW3cString() . '</lastmod>';
            $xml .= '<changefreq>monthly</changefreq>';
            $xml .= '<priority>0.7</priority>';
            $xml .= '</url>';
        }

        $xml .= '</urlset>';

        return response($xml, 200)
            ->header('Content-Type', 'text/xml');
    }
}