<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Accurate Islamic prayer times (Salah times) for your location with beautiful Islamic design and features">
  <meta name="keywords" content="prayer times, salah times, islamic prayer, fajr, dhuhr, asr, maghrib, isha, muslim, islam">
  <title>@yield('title', 'Prayer Times | Accurate Islamic Salah Times Near You')</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="----------------------">
  <link href="https://fonts.googleapis.com/css2?family=Scheherazade+New:wght@400;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  @stack('styles')
  <style>
    /* Your CSS styles here (same as in your original file) */
  </style>
</head>
<body>
  @include('layouts.header')
  
  <div id="app">
    @yield('content')
  </div>
  
  @include('layouts.footer')

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  @stack('scripts')
</body>
</html>