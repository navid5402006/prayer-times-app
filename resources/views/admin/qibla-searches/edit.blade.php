<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Qibla City | IslamicPrayerTimes</title>
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
        
        .badge-primary {
            background-color: var(--primary-color);
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
        
        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        /* Toggle button for sidebar */
        #sidebarCollapse {
            background: var(--primary-color);
            border: none;
            border-radius: 4px;
            color: white;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            #sidebar {
                margin-left: -250px;
            }
            #sidebar.active {
                margin-left: 0;
            }
            #content {
                width: 100%;
                margin-left: 0;
            }
            #content.active {
                width: calc(100% - 250px);
                margin-left: 250px;
            }
        }
        
        /* Tabs */
        .nav-tabs .nav-link {
            border: none;
            color: var(--text-color);
            font-weight: 500;
            padding: 12px 20px;
            border-radius: 8px 8px 0 0;
        }
        
        .nav-tabs .nav-link.active {
            color: var(--primary-color);
            background-color: white;
            border-bottom: 3px solid var(--primary-color);
        }
        
        /* Rich text editor */
        .rich-text-toolbar {
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 8px 8px 0 0;
            border: 1px solid #ddd;
            border-bottom: none;
        }
        
        .rich-text-editor {
            min-height: 300px;
            border: 1px solid #ddd;
            border-radius: 0 0 8px 8px;
            padding: 15px;
        }
        
        /* Info box */
        .info-box {
            background-color: #e7f3ff;
            border-left: 4px solid var(--primary-color);
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    @include('admin.layout')

    <div class="container-fluid col-10 ml-2 wrapper d-flex align-items-stretch p-4">
        <div class="w-100">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">Edit Qibla City</h2>
                <a href="{{ route('admin.qibla-searches.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i> Back to List
                </a>
            </div>

            <form method="POST" action="{{ route('admin.qibla-searches.update', $search->id) }}">
                @csrf
                @method('PUT')

                <div class="row" style="
    margin-left: 140px;
">
                    <!-- LEFT COLUMN - MAIN CONTENT -->
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
                                               value="{{ old('state', $search->state) }}" placeholder="e.g. Texas, Punjab">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Slug</label>
                                        <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror"
                                               value="{{ old('slug', $search->slug) }}" placeholder="auto-generated if empty">
                                        @error('slug')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">URL-friendly version of city name</small>
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
                                               value="{{ old('latitude', $search->latitude) }}" placeholder="e.g. 21.422487">
                                        <small class="text-muted">Decimal degrees</small>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Longitude</label>
                                        <input type="number" step="any" name="longitude" class="form-control"
                                               value="{{ old('longitude', $search->longitude) }}" placeholder="e.g. 39.826206">
                                        <small class="text-muted">Decimal degrees</small>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Qibla Direction</label>
                                        <input type="number" step="any" name="qibla_direction" class="form-control"
                                               value="{{ old('qibla_direction', $search->qibla_direction) }}" placeholder="e.g. 118.5">
                                        <small class="text-muted">Degrees from North</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Main Description Card -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-align-left me-2"></i> Main Description (Rich Content)
                            </div>
                            <div class="card-body">
                                <div class="info-box mb-3">
                                    <i class="fas fa-info-circle me-2 text-primary"></i>
                                    This content appears at the top of the Qibla page. You can use HTML for formatting.
                                </div>
                                <textarea name="main_description" rows="12"
                                          class="form-control rich-text-area"
                                          placeholder="Enter detailed description about Qibla direction for this city...">{{ old('main_description', $search->main_description) }}</textarea>
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
                                           placeholder="Qibla Direction in {{ $search->city }} | Accurate Direction to Kaaba">
                                    <small class="text-muted">Recommended: 50-60 characters</small>
                                    <div class="progress mt-2" style="height: 5px;">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 0%" id="titleProgress"></div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Meta Description</label>
                                    <textarea name="meta_description" rows="3"
                                              class="form-control" id="metaDescription"
                                              placeholder="Find accurate Qibla direction for {{ $search->city }}...">{{ old('meta_description', $search->meta_description) }}</textarea>
                                    <small class="text-muted">Recommended: 150-160 characters</small>
                                    <div class="d-flex justify-content-between mt-1">
                                        <span id="descCount">0</span>
                                        <span id="descStatus" class="text-muted"></span>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Meta Keywords</label>
                                    <input type="text" name="meta_keywords" class="form-control"
                                           value="{{ old('meta_keywords', $search->meta_keywords) }}" 
                                           placeholder="qibla direction, {{ $search->city }} prayer, kaaba direction">
                                    <small class="text-muted">Comma separated keywords</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- RIGHT COLUMN - SIDEBAR -->
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
                                        @if($search->is_updated)
                                            <span class="badge bg-success">Manually Updated</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Auto-generated</span>
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

                        <!-- Preview Card -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-eye me-2"></i> Preview
                            </div>
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    <i class="fas fa-compass fa-4x text-primary mb-3"></i>
                                    <h5>{{ $search->city }}, {{ $search->country }}</h5>
                                    @if($search->qibla_direction)
                                        <div class="display-6 text-primary">{{ $search->qibla_direction }}°</div>
                                        <small class="text-muted">Qibla Direction</small>
                                    @endif
                                </div>
                                <a href="/{{ $search->slug }}" target="_blank" class="btn btn-outline-primary w-100">
                                    <i class="fas fa-external-link-alt me-2"></i> View Live Page
                                </a>
                            </div>
                        </div>

                        <!-- Save Button Card -->
                        <div class="card">
                            <div class="card-body">
                                <button type="submit" class="btn btn-primary w-100 py-3">
                                    <i class="fas fa-save me-2"></i> Update Qibla City
                                </button>
                                <p class="text-muted text-center small mt-3">
                                    All fields are optional except City and Country
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Meta title character counter
        document.querySelector('input[name="meta_title"]')?.addEventListener('input', function() {
            const length = this.value.length;
            const progress = document.getElementById('titleProgress');
            if (progress) {
                let percent = (length / 60) * 100;
                if (percent > 100) percent = 100;
                progress.style.width = percent + '%';
                progress.classList.remove('bg-success', 'bg-warning', 'bg-danger');
                
                if (length < 50) progress.classList.add('bg-success');
                else if (length <= 60) progress.classList.add('bg-warning');
                else progress.classList.add('bg-danger');
            }
        });

        // Meta description character counter
        document.querySelector('textarea[name="meta_description"]')?.addEventListener('input', function() {
            const length = this.value.length;
            const countEl = document.getElementById('descCount');
            const statusEl = document.getElementById('descStatus');
            
            if (countEl) countEl.textContent = length + ' characters';
            if (statusEl) {
                if (length < 150) statusEl.textContent = 'Too short (min 150)';
                else if (length <= 160) statusEl.textContent = '✓ Perfect!';
                else statusEl.textContent = 'Too long (max 160)';
            }
        });

        // Trigger on page load
        window.addEventListener('load', function() {
            const titleInput = document.querySelector('input[name="meta_title"]');
            if (titleInput) {
                const event = new Event('input');
                titleInput.dispatchEvent(event);
            }
            
            const descInput = document.querySelector('textarea[name="meta_description"]');
            if (descInput) {
                const event = new Event('input');
                descInput.dispatchEvent(event);
            }
        });
    </script>
</body>
</html>