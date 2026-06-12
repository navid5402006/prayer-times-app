<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\PrayerTimeController;
use App\Http\Controllers\QiblaController;
use App\Http\Controllers\Admin\updateQiblaController;
use App\Http\Controllers\RamadanController;
use App\Http\Controllers\Admin\updateRamadanController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\TranslationController;
use App\Http\Controllers\UserSideBlogsController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\BlogCategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\MosqueController;
use App\Http\Controllers\Admin\PrayerupdateController;
use App\Http\Controllers\EmbedController;
use App\Http\Controllers\donationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\Auth\AdminAuthController;

// Define supported languages
$supportedLanguages = ['en','ar','zh','hi','es','fr','ru','pt','ur','bn','pa','ta','te','mr','gu','kn','ml','si','id','ms','th','vi','fil','fa','tr','ku','ps','sd','sw','ha','am','yo','ja','ko','de','it','nl','ug','az','kk','uz','ky','tg','tk','dv','so','ber'];

// ================== Routes WITHOUT language prefix ==================
Route::get('/', [PrayerTimeController::class, 'index'])->name('home');
Route::get('/blogs', [UserSideBlogsController::class, 'index'])->name('blogs');
Route::get('blog/{slug}', [UserSideBlogsController::class, 'blog_detail'])->name('blog_detail');

Route::get('/prayer-times-in-{city}', [PrayerTimeController::class, 'showBySlug'])
    ->where('city', '.*')
    ->name('prayer-times.show');
Route::post('/search', [PrayerTimeController::class, 'search'])->name('prayer-times.search');
Route::get('/api/world-prayer-times', [PrayerTimeController::class, 'getWorldPrayerTimes']);
Route::get('/prayer-times', [PrayerTimeController::class, 'Prayer_index'])->name('Prayer_index');

Route::get('/qibla-direction', [QiblaController::class, 'index'])->name('qibla.index');
Route::get('/{city}-qibla-direction', [QiblaController::class, 'showBySlug'])
    ->where('city', '.*')
    ->name('qibla.show');
Route::post('/qibla-search', [QiblaController::class, 'search'])->name('qibla.search');

Route::get('/islamic-calendar', function() {
    return view('IslamicCalendar');
})->name('islamic-calendar');

Route::get('/aboutus', function() {
    return view('about_us');
})->name('about_us');

Route::get('/Zakat-Calculator', function() {
    return view('Zakat-Calculator');
})->name('Zakat-Calculator');
 

// Mosque Routes
Route::get('/mosque-near-me', [MosqueController::class, 'index'])->name('mosque.index');
Route::get('/mosques-in-{city}', [MosqueController::class, 'showBySlug'])
    ->where('city', '.*')
    ->name('mosque.show');
Route::post('/mosque-search', [MosqueController::class, 'search'])->name('mosque.search');

Route::get('/write-for-us', function() {
    return view('write_for_us');
})->name('write_for_us');


Route::get('/Tasbeeh-counter', function() {
    return view('Tasbeehcounter');
})->name('Tasbeeh-counter');

Route::get('/ramadan-timing', [RamadanController::class, 'index'])->name('ramadan.index');
Route::get('/{city}-ramadan-timings', [RamadanController::class, 'showBySlug'])
    ->where('city', '.*')
    ->name('ramadan.show');
Route::post('/ramadan-search', [RamadanController::class, 'search'])->name('ramadan.search');


// Categories Routes
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('category.show');

// Tags Routes
Route::get('/tags', [TagController::class, 'index'])->name('tags.index');
Route::get('/tag/{slug}', [TagController::class, 'show'])->name('tag.show');

// If you want category-wise blog listing
Route::get('/category/{slug}/blogs', [CategoryController::class, 'categoryBlogs'])->name('category.blogs');
Route::get('/tag/{slug}/blogs', [TagController::class, 'tagBlogs'])->name('tag.blogs');

// ================== Routes WITH language prefix ==================
Route::group([
    'prefix' => '{lang}',
    'where' => ['lang' => implode('|', $supportedLanguages)],
], function() use ($supportedLanguages) {
    Route::get('/', [PrayerTimeController::class, 'index'])->name('lang.home');
    Route::get('/prayer-times-in-{city}', [PrayerTimeController::class, 'showBySlug'])
        ->where('city', '[a-zA-Z0-9\-]+')
        ->name('lang.prayer-times.show');
    Route::post('/search', [PrayerTimeController::class, 'search'])->name('lang.prayer-times.search');
    Route::get('/qibla', [QiblaController::class, 'index'])->name('lang.qibla.index');
    Route::get('/{city}-qibla-direction', [QiblaController::class, 'showBySlug'])
        ->where('city', '.*')
        ->name('lang.qibla.show');
    Route::post('/qibla-search', [QiblaController::class, 'search'])->name('lang.qibla.search');
    Route::get('/islamic-calendar', function() {
        return view('IslamicCalendar');
    })->name('lang.islamic-calendar');
    Route::get('/Tasbeeh-counter', function() {
        return view('Tasbeehcounter');
    })->name('lang.Tasbeeh-counter');
    Route::get('/ramadan', [RamadanController::class, 'index'])->name('lang.ramadan.index');
    Route::get('/{city}-ramadan-timings', [RamadanController::class, 'showBySlug'])
        ->where('city', '.*')
        ->name('lang.ramadan.show');
    Route::post('/ramadan-search', [RamadanController::class, 'search'])->name('lang.ramadan.search');
});

// for dev side
Route::get('/developers', [EmbedController::class, 'index']);
Route::get('/embed/prayer.js', [EmbedController::class, 'prayerWidget']);
Route::get('/donation', [donationController::class, 'index']);

// Sitemaps
Route::get('s/prayer_sitemap.xml', [SitemapController::class, 'prayer_searches_sitemap']);
Route::get('s/ramadhan_sitemap.xml', [SitemapController::class, 'ramadhan_sitemap']);
Route::get('s/qibla_sitemap.xml', [SitemapController::class, 'qibla_sitemap']);
Route::get('s/blog_sitemap.xml', [SitemapController::class, 'blog_sitemap']);

Route::get('/translate-example', [TranslationController::class, 'test']);

// ==================== ADMIN LOGIN ROUTES ====================
// Admin Login (No middleware - accessible to guests)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout')->middleware('auth');
});

// Admin Dashboard Routes (Protected by auth and admin middleware)
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/performance', [App\Http\Controllers\Admin\PerformanceController::class, 'index'])->name('performance');
    Route::resource('blog-tags', \App\Http\Controllers\Admin\BlogTagController::class);

    // Blog Categories Management
    Route::prefix('blog-categories')->name('blog-categories.')->group(function () {
        Route::get('/', [BlogCategoryController::class, 'index'])->name('index');
        Route::get('/create', [BlogCategoryController::class, 'create'])->name('create');
        Route::post('/', [BlogCategoryController::class, 'store'])->name('store');
        Route::get('/{blogCategory}/edit', [BlogCategoryController::class, 'edit'])->name('edit');
        Route::put('/{blogCategory}', [BlogCategoryController::class, 'update'])->name('update');
        Route::delete('/{blogCategory}', [BlogCategoryController::class, 'destroy'])->name('destroy');
    });
    
    // Blog Posts Management
    Route::prefix('blogs')->name('blogs.')->group(function () {
        Route::get('/', [BlogController::class, 'index'])->name('index');
        Route::get('/create', [BlogController::class, 'create'])->name('create');
        Route::post('/', [BlogController::class, 'store'])->name('store');
        Route::get('/{blog}', [BlogController::class, 'show'])->name('show');
        Route::get('/{blog}/edit', [BlogController::class, 'edit'])->name('edit');
        Route::put('/{blog}', [BlogController::class, 'update'])->name('update');
        Route::delete('/{blog}', [BlogController::class, 'destroy'])->name('destroy');
        Route::post('/{blog}/publish', [BlogController::class, 'publish'])->name('publish');
        Route::post('/{blog}/unpublish', [BlogController::class, 'unpublish'])->name('unpublish');
        Route::post('/{blog}/feature', [BlogController::class, 'feature'])->name('feature');
    });

    // Tag management routes
    Route::post('/tags/create', [BlogController::class, 'createTag'])->name('tags.create');
    Route::get('/tags/search', [BlogController::class, 'getTags'])->name('tags.search');

    Route::prefix('prayer-searches')->name('prayer-searches.')->group(function () {
        Route::get('/', [PrayerupdateController::class, 'index'])->name('index');
        Route::get('/{id}/edit', [PrayerupdateController::class, 'edit'])->name('edit');
        Route::put('/{id}', [PrayerupdateController::class, 'update'])->name('update');
        Route::delete('/{id}', [PrayerupdateController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('qibla-searches')->name('qibla-searches.')->group(function () {
        Route::get('/', [updateQiblaController::class, 'index'])->name('index');
        Route::get('/{id}/edit', [updateQiblaController::class, 'edit'])->name('edit');
        Route::put('/{id}', [updateQiblaController::class, 'update'])->name('update');
        Route::delete('/{id}', [updateQiblaController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('ramadan-searches')->name('ramadan-searches.')->group(function () {
        Route::get('/', [updateRamadanController::class, 'index'])->name('index');
        Route::get('/{id}/edit', [updateRamadanController::class, 'edit'])->name('edit');
        Route::put('/{id}', [updateRamadanController::class, 'update'])->name('update');
        Route::delete('/{id}', [updateRamadanController::class, 'destroy'])->name('destroy');
    });
});
// ==================== USER AUTHENTICATION ROUTES ====================
// Login & Registration Routes
Route::prefix('user')->name('user.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', [UserController::class, 'showLogin'])->name('login');
        Route::get('/register', [UserController::class, 'showRegister'])->name('register');
        Route::post('/login', [UserController::class, 'login'])->name('login.post');
        Route::post('/register', [UserController::class, 'register'])->name('register.post');
        Route::get('/verify-email', [UserController::class, 'verifyEmail'])->name('verify-email');
        Route::post('/resend-verification', [UserController::class, 'resendVerification'])->name('resend-verification');
    });
    Route::post('/logout', [UserController::class, 'logout'])->name('logout')->middleware('auth');
});

// Profile Routes (Authenticated)
Route::prefix('user')->name('user.')->middleware('auth')->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::get('/profile/edit', [UserController::class, 'editProfile'])->name('profile.edit');
    Route::put('/profile', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/password', [UserController::class, 'updatePassword'])->name('profile.password');
    Route::delete('/profile', [UserController::class, 'deleteAccount'])->name('profile.destroy');
    Route::get('/blog/create', [UserController::class, 'showCreateBlog'])->name('blog.create');
    Route::post('/blog', [UserController::class, 'storeBlog'])->name('blog.store');
    Route::get('/blog/{id}/edit', [UserController::class, 'editBlog'])->name('blog.edit');
    Route::put('/blog/{id}', [UserController::class, 'updateBlog'])->name('blog.update');
    Route::delete('/blog/{id}', [UserController::class, 'deleteBlog'])->name('blog.delete'); // Make sure this line exists
});

// Comments Routes - IMPORTANT: These must be outside the user prefix
Route::prefix('comments')->name('comments.')->middleware('auth')->group(function () {
    Route::post('/blog/{blog}', [UserController::class, 'storeComment'])->name('store');
    Route::post('/{comment}/reply', [UserController::class, 'storeReply'])->name('reply');
    Route::put('/{comment}', [UserController::class, 'updateComment'])->name('update');
    Route::delete('/{comment}', [UserController::class, 'deleteComment'])->name('destroy');
});

// Image upload route for Summernote
Route::post('/blog/upload-image', [UserController::class, 'uploadBlogImage'])->name('blog.upload-image')->middleware('auth');
