<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Management | IslamicPrayerTimes</title>
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
        }
        
        .form-control, .form-select, .form-check-input {
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
        
        /* Blog card styles */
        .blog-card {
            transition: all 0.3s ease;
            border-left: 4px solid var(--primary-color);
        }
        
        .blog-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        
        .blog-status-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            z-index: 1;
        }
        
        .blog-thumbnail {
            height: 180px;
            object-fit: cover;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
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
        
        /* Rich text editor simulation */
        .rich-text-toolbar {
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 8px 8px 0 0;
            border: 1px solid #ddd;
            border-bottom: none;
        }
        
        .rich-text-editor {
            min-height: 200px;
            border: 1px solid #ddd;
            border-radius: 0 0 8px 8px;
            padding: 15px;
        }
        
        /* Tag input */
        .tag-input {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }
        
        .tag {
            background-color: var(--primary-color);
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
        }
        
        .tag-remove {
            margin-left: 5px;
            cursor: pointer;
        }
        
        .tag-input-field {
            border: none;
            outline: none;
            flex-grow: 1;
            min-width: 80px;
        }

        /* Select2 customization */
        .select2-container--default .select2-selection--multiple {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 5px;
        }
        
        .select2-container--default.select2-container--focus .select2-selection--multiple {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 110, 0.25);
        }
    </style>
</head>
<body>
        <!-- Sidebar -->
     @include('admin.layout')
<div class="container-fluid col-10 ml-2 wrapper d-flex align-items-stretch p2">
    <h2 class="mb-4">Edit Prayer City</h2>

    <form method="POST" 
          action="{{ route('admin.prayer-searches.update',$search->id) }}"
          enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            <!-- LEFT -->
            <div class="col-lg-8">

                <div class="card mb-4">
                    <div class="card-header">City Information</div>
                    <div class="card-body">

                        <div class="mb-3">
                            <label class="form-label">City</label>
                            <input type="text" name="city" class="form-control"
                                   value="{{ old('city',$search->city) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Country</label>
                            <input type="text" name="country" class="form-control"
                                   value="{{ old('country',$search->country) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">State</label>
                            <input type="text" name="state" class="form-control"
                                   value="{{ old('state',$search->state) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Timezone</label>
                            <input type="text" name="timezone" class="form-control"
                                   value="{{ old('timezone',$search->timezone) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" rows="4"
                                      class="form-control">{{ old('description',$search->description) }}</textarea>
                        </div>

                    </div>
                </div>

                <div class="card">
                    <div class="card-header">SEO Settings</div>
                    <div class="card-body">

                        <div class="mb-3">
                            <label class="form-label">Meta Title</label>
                            <input type="text" name="meta_title" class="form-control"
                                   value="{{ old('meta_title',$search->meta_title) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Meta Description</label>
                            <textarea name="meta_description" rows="3"
                                      class="form-control">{{ old('meta_description',$search->meta_description) }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Meta Keywords</label>
                            <input type="text" name="meta_keywords" class="form-control"
                                   value="{{ old('meta_keywords',$search->meta_keywords) }}">
                        </div>

                    </div>
                </div>
            </div>

            <!-- RIGHT -->
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-header">Featured Image</div>
                    <div class="card-body">
                        @if($search->image)
                            <img src="{{ Storage::url($search->image) }}"
                                 class="img-fluid rounded mb-3">
                        @endif
                        <input type="file" name="image" class="form-control">
                        <small class="text-muted">Optional</small>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body d-grid">
                        <button class="btn btn-primary">
                            <i class="fas fa-save"></i> Update City
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>
