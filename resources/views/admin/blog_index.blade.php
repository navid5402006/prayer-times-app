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
    <div class="wrapper d-flex align-items-stretch">
        <!-- Sidebar -->
     @include('admin.layout')

        <!-- Page Content -->
        <div id="content">
            <!-- Top Navigation -->
            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn">
                        <i class="fas fa-bars"></i>
                    </button>
                    
                    <div class="ms-auto d-flex align-items-center">
                        <div class="dropdown">
                            <a href="#" class="dropdown-toggle text-dark" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user-circle me-2"></i> Admin User
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i> Profile</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i> Settings</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Main Content -->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <h2 class="mb-4">Blog Management</h2>
                    </div>
                </div>

                <!-- Tabs Navigation -->
                <ul class="nav nav-tabs mb-4" id="blogTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="list-tab" data-bs-toggle="tab" data-bs-target="#list" type="button" role="tab" aria-controls="list" aria-selected="true">
                            <i class="fas fa-list me-2"></i> Blog List
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a href="{{ route('admin.blogs.create') }}" class="nav-link" id="add-tab">
                            <i class="fas fa-plus-circle me-2"></i> Add New Blog
                        </a>
                    </li>
                </ul>

                <!-- Tabs Content -->
                <div class="tab-content" id="blogTabsContent">
                    <!-- Blog List Tab -->
                    <div class="tab-pane fade show active" id="list" role="tabpanel" aria-labelledby="list-tab">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <form action="{{ route('admin.blogs.index') }}" method="GET">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="search" placeholder="Search blogs..." value="{{ request('search') }}">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-6 d-flex justify-content-end">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-filter me-2"></i> Filter
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{ route('admin.blogs.index') }}">All Blogs</a></li>
                                        <li><a class="dropdown-item" href="{{ route('admin.blogs.index', ['status' => 'published']) }}">Published</a></li>
                                        <li><a class="dropdown-item" href="{{ route('admin.blogs.index', ['status' => 'draft']) }}">Drafts</a></li>
                                        <li><a class="dropdown-item" href="{{ route('admin.blogs.index', ['featured' => 1]) }}">Featured</a></li>
                                    </ul>
                                </div>
                                <div class="btn-group ms-2">
                                    <button type="button" class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-sort me-2"></i> Sort
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{ route('admin.blogs.index', ['sort' => 'newest']) }}">Newest First</a></li>
                                        <li><a class="dropdown-item" href="{{ route('admin.blogs.index', ['sort' => 'oldest']) }}">Oldest First</a></li>
                                        <li><a class="dropdown-item" href="{{ route('admin.blogs.index', ['sort' => 'views']) }}">Most Viewed</a></li>
                                        <li><a class="dropdown-item" href="{{ route('admin.blogs.index', ['sort' => 'title']) }}">A-Z</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="row">
                            @foreach($blogs as $blog)
                            <div class="col-md-6 col-lg-4 mb-4">
                                <div class="card blog-card h-100">
                                    <span class="badge bg-{{ $blog->status == 'published' ? 'success' : 'warning' }} blog-status-badge">{{ ucfirst($blog->status) }}</span>
                                    @if($blog->image)
                                    <img src="{{ Storage::url($blog->image) }}" class="blog-thumbnail" alt="Blog thumbnail">
                                    @else
                                    <img src="https://images.unsplash.com/photo-1587132137050-8d0d13146f4e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1180&q=80" class="blog-thumbnail" alt="Blog thumbnail">
                                    @endif
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $blog->title }}</h5>
                                        <p class="card-text">{{ Str::limit($blog->excerpt, 100) }}</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-muted"><i class="fas fa-eye me-1"></i> {{ $blog->views }} views</small>
                                            <small class="text-muted">{{ $blog->created_at->format('M d, Y') }}</small>
                                        </div>
                                    </div>
                                    <div class="card-footer bg-white d-flex justify-content-between">
                                        <a href="{{ route('admin.blogs.edit', $blog->id) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit me-1"></i> Edit</a>
                                        <form action="{{ route('admin.blogs.destroy', $blog->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this blog?')"><i class="fas fa-trash me-1"></i> Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <nav aria-label="Blog pagination">
                            {{ $blogs->links() }}
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Sidebar toggle functionality
        document.getElementById('sidebarCollapse').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
            document.getElementById('content').classList.toggle('active');
        });
    </script>
</body>
</html>