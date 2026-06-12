<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Ramadan City | IslamicPrayerTimes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #0d6e6e;
            --secondary-color: #054545;
            --accent-color: #d4af37;
            --light-color: #f5f5f0;
            --text-color: #333;
            --light-text: #777;
            --sidebar-width: 250px;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            color: var(--text-color);
            overflow-x: hidden;
        }
        
        /* Sidebar */
        #sidebar {
            position: fixed;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--secondary-color);
            color: white;
            transition: all 0.3s;
            z-index: 1000;
        }
        
        #sidebar .sidebar-header {
            padding: 20px;
            background: var(--primary-color);
        }
        
        #sidebar ul.components {
            padding: 20px 0;
        }
        
        #sidebar ul li a {
            padding: 15px 25px;
            display: block;
            color: white;
            text-decoration: none;
            transition: all 0.3s;
        }
        
        #sidebar ul li a:hover {
            background: var(--primary-color);
        }
        
        #sidebar ul li.active > a {
            background: var(--primary-color);
            border-left: 4px solid var(--accent-color);
        }
        
        #sidebar ul li a i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        
        /* Content */
        #content {
            width: calc(100% - var(--sidebar-width));
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: all 0.3s;
        }
        
        .navbar {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 24px;
        }
        
        .card-header {
            background-color: white;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            font-weight: 600;
            padding: 15px 20px;
            border-radius: 10px 10px 0 0 !important;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }
        
        .table th {
            font-weight: 600;
            color: var(--secondary-color);
        }
        
        /* Status badges */
        .badge-updated {
            background-color: #28a745;
            color: white;
            padding: 8px 12px;
            border-radius: 30px;
            font-weight: 500;
            font-size: 0.85rem;
        }
        
        .badge-auto {
            background-color: #ffc107;
            color: #212529;
            padding: 8px 12px;
            border-radius: 30px;
            font-weight: 500;
            font-size: 0.85rem;
        }
        
        /* Form Styles */
        .form-section {
            background: white;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }
        
        .form-label {
            font-weight: 600;
            color: var(--secondary-color);
            margin-bottom: 8px;
        }
        
        .form-control, .form-select {
            border-radius: 8px;
            padding: 10px 15px;
            border: 1px solid #ddd;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 110, 0.25);
        }
        
        /* Container with margin-left */
        .main-container {
            margin-left: 100px;
            margin-right: 30px;
            width: calc(100% - 130px);
            padding: 20px;
        }
        
        /* Info box */
        .info-box {
            background-color: #e7f3ff;
            border-left: 4px solid var(--primary-color);
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .main-container {
                margin-left: 20px;
                width: calc(100% - 40px);
            }
        }
    </style>
</head>
<body>
    @include('admin.layout')

    <div class="main-container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Edit Ramadan City</h2>
            <a href="{{ route('admin.ramadan-searches.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i> Back to List
            </a>
        </div>

        <form method="POST" action="{{ route('admin.ramadan-searches.update', $search->id) }}">
            @csrf
            @method('PUT')

            <div class="row" style=" width: 90%; margin-left: 132px; ">
                <!-- LEFT COLUMN -->
                <div class="col-lg-8">
                    <!-- City Information Card -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-city me-2"></i> City Information
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">City <span class="text-danger">*</span></label>
                                    <input type="text" name="city" class="form-control @error('city') is-invalid @enderror"
                                           value="{{ old('city', $search->city) }}" required>
                                    @error('city')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Country <span class="text-danger">*</span></label>
                                    <input type="text" name="country" class="form-control @error('country') is-invalid @enderror"
                                           value="{{ old('country', $search->country) }}" required>
                                    @error('country')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">State / Region</label>
                                    <input type="text" name="state" class="form-control"
                                           value="{{ old('state', $search->state) }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Timezone</label>
                                    <input type="text" name="timezone" class="form-control"
                                           value="{{ old('timezone', $search->timezone) }}" 
                                           placeholder="e.g. Asia/Karachi">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Coordinates Card -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-map-marker-alt me-2"></i> Geographic Coordinates
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Latitude</label>
                                    <input type="number" step="any" name="latitude" class="form-control"
                                           value="{{ old('latitude', $search->latitude) }}" 
                                           placeholder="e.g. 21.422487">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Longitude</label>
                                    <input type="number" step="any" name="longitude" class="form-control"
                                           value="{{ old('longitude', $search->longitude) }}" 
                                           placeholder="e.g. 39.826206">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Main Description Card -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-align-left me-2"></i> Main Description
                        </div>
                        <div class="card-body">
                            <textarea name="main_description" rows="8"
                                      class="form-control"
                                      placeholder="Enter detailed description about Ramadan for this city...">{{ old('main_description', $search->main_description) }}</textarea>
                        </div>
                    </div>

                    <!-- SEO Card -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-search me-2"></i> SEO Settings
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Meta Title</label>
                                <input type="text" name="meta_title" class="form-control"
                                       value="{{ old('meta_title', $search->meta_title) }}" 
                                       placeholder="Ramadan Times in {{ $search->city }} | Sehar & Iftar Timings">
                                <small class="text-muted">Recommended: 50-60 characters</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Meta Description</label>
                                <textarea name="meta_description" rows="3"
                                          class="form-control"
                                          placeholder="Find accurate Ramadan times for {{ $search->city }}...">{{ old('meta_description', $search->meta_description) }}</textarea>
                                <small class="text-muted">Recommended: 150-160 characters</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Meta Keywords</label>
                                <input type="text" name="meta_keywords" class="form-control"
                                       value="{{ old('meta_keywords', $search->meta_keywords) }}" 
                                       placeholder="ramadan times, sehar time, iftar time, {{ $search->city }}">
                                <small class="text-muted">Comma separated keywords</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- RIGHT COLUMN -->
                <div class="col-lg-4">
                    <!-- Status Card -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-info-circle me-2"></i> Status
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="d-flex justify-content-between">
                                    <span>Current Status:</span>
                                    @if($search->is_updated ?? false)
                                        <span class="badge badge-updated">Manually Updated</span>
                                    @else
                                        <span class="badge badge-auto">Auto-generated</span>
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between">
                                    <span>Last Updated:</span>
                                    <span class="text-muted">{{ $search->updated_at?->diffForHumans() ?? 'Never' }}</span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between">
                                    <span>Created:</span>
                                    <span class="text-muted">{{ $search->created_at?->format('M d, Y') ?? '—' }}</span>
                                </div>
                            </div>
                            <hr>
                            <div class="alert alert-info mb-0">
                                <i class="fas fa-lightbulb me-2"></i>
                                <small>Saving this form will mark it as "Updated" (green status)</small>
                            </div>
                        </div>
                    </div>

                    <!-- Slug Card -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-link me-2"></i> URL Slug
                        </div>
                        <div class="card-body">
                            <input type="text" name="slug" class="form-control"
                                   value="{{ old('slug', $search->slug) }}" 
                                   placeholder="auto-generated">
                            <small class="text-muted">URL-friendly version of city name</small>
                        </div>
                    </div>

                    <!-- Save Button Card -->
                    <div class="card">
                        <div class="card-body">
                            <button type="submit" class="btn btn-primary w-100 py-3">
                                <i class="fas fa-save me-2"></i> Update Ramadan City
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>