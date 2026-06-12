<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Tags Management | IslamicPrayerTimes</title>
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
        
        .form-control, .form-select {
            border-radius: 8px;
            padding: 10px 15px;
            border: 1px solid #ddd;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 110, 0.25);
        }
        
        /* Toggle button for sidebar */
        #sidebarCollapse {
            background: var(--primary-color);
            border: none;
            border-radius: 4px;
            color: white;
        }
        
        /* Tag Cloud Styles */
        .tag-cloud {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            padding: 15px;
            background: white;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        
        .tag-item {
            background: var(--light-color);
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
            color: var(--text-color);
            border: 1px solid #ddd;
        }
        
        .tag-item.active {
            background: var(--primary-color);
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
    </style>
</head>
<body>
    <div class="wrapper d-flex align-items-stretch">
        <!-- Sidebar -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3><i class="fas fa-mosque"></i> Admin Panel</h3>
            </div>

            <ul class="list-unstyled components">
                <li>
                    <a href="{{ url('/admin/dashboard') }}">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.blogs.index') }}">
                        <i class="fas fa-blog"></i> Blog Management
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.blog-categories.index') }}">
                        <i class="fas fa-folder"></i> Blog Categories
                    </a>
                </li>
                <li class="active">
                    <a href="{{ route('admin.blog-tags.index') }}">
                        <i class="fas fa-tags"></i> Blog Tags
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fas fa-calendar-alt"></i> Prayer Times
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fas fa-users"></i> Users
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fas fa-cog"></i> Settings
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </li>
            </ul>
        </nav>

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
                        <h2 class="mb-4">Blog Tags Management</h2>
                    </div>
                </div>

                <!-- Flash Messages -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Add New Tag Form -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Add New Tag</h5>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.blog-tags.store') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="tagName" class="form-label">Tag Name</label>
                                        <input type="text" class="form-control" id="tagName" name="name" value="{{ old('name') }}" placeholder="Enter tag name" required>
                                        @error('name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="tagSlug" class="form-label">Tag Slug</label>
                                        <input type="text" class="form-control" id="tagSlug" name="slug" value="{{ old('slug') }}" placeholder="URL-friendly slug">
                                        <div class="form-text">Leave blank to auto-generate from tag name</div>
                                        @error('slug')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="tagDescription" class="form-label">Description</label>
                                        <textarea class="form-control" id="tagDescription" name="description" rows="3" placeholder="Brief description of the tag">{{ old('description') }}</textarea>
                                        @error('description')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="tagStatus" class="form-label">Status</label>
                                        <select class="form-select" id="tagStatus" name="status" required>
                                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                        @error('status')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-plus-circle me-2"></i> Add Tag
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Tags Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <strong>About Blog Tags</strong>
                                    <p class="mb-0 mt-2">Tags help organize your blog content with specific keywords. Unlike categories, a blog post can have multiple tags, making it easier for visitors to find related content across different topics.</p>
                                </div>
                                
                                <div class="mt-4">
                                    <h6><i class="fas fa-lightbulb me-2 text-warning"></i> Best Practices</h6>
                                    <ul class="ps-3">
                                        <li>Use specific, relevant keywords</li>
                                        <li>Tags are typically lowercase with hyphens</li>
                                        <li>A post can have multiple tags</li>
                                        <li>Use tags to connect related content across categories</li>
                                        <li>Inactive tags won't be shown on the website</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tags List -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Blog Tags List</h5>
                                <div class="d-flex">
                                    <input type="text" class="form-control me-2" id="searchTags" placeholder="Search tags...">
                                    <button class="btn btn-primary" onclick="searchTags()">
                                        <i class="fas fa-search me-2"></i> Search
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                @if($tags->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-hover" id="tagsTable">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Slug</th>
                                                    <th>Description</th>
                                                    <th>Posts</th>
                                                    <th>Status</th>
                                                    <th>Created</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($tags as $tag)
                                                <tr>
                                                    <td>{{ $tag->name }}</td>
                                                    <td><code>{{ $tag->slug }}</code></td>
                                                    <td>{{ Str::limit($tag->description, 50) }}</td>
                                                    <td>
                                                        <span class="badge bg-primary">{{ $tag->blogs_count }}</span>
                                                    </td>
                                                    <td>
                                                        @if($tag->status == 'active')
                                                            <span class="badge bg-success">Active</span>
                                                        @else
                                                            <span class="badge bg-secondary">Inactive</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $tag->created_at->format('M d, Y') }}</td>
                                                    <td>
                                                        <a href="{{ route('admin.blog-tags.edit', $tag->id) }}" class="btn btn-sm btn-primary">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('admin.blog-tags.destroy', $tag->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger" 
                                                                    onclick="return confirm('Are you sure you want to delete this tag?')">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                    <!-- Pagination -->
                                    <div class="d-flex justify-content-center">
                                        {{ $tags->links() }}
                                    </div>
                                @else
                                    <div class="text-center py-5">
                                        <i class="fas fa-tags fa-3x text-muted mb-3"></i>
                                        <h3>No Tags Found</h3>
                                        <p class="text-muted">Start by adding your first tag using the form above.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
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
        
        // Auto-generate slug from tag name
        document.getElementById('tagName').addEventListener('input', function() {
            const slugField = document.getElementById('tagSlug');
            if (!slugField.value) {
                const slug = this.value.toLowerCase()
                    .replace(/\s+/g, '-')
                    .replace(/[^\w\-]+/g, '')
                    .replace(/\-\-+/g, '-')
                    .replace(/^-+/, '')
                    .replace(/-+$/, '');
                slugField.value = slug;
            }
        });
        
        // Search functionality
        function searchTags() {
            const searchTerm = document.getElementById('searchTags').value.toLowerCase();
            const rows = document.querySelectorAll('#tagsTable tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        }
        
        // Enter key for search
        document.getElementById('searchTags').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                searchTags();
            }
        });
    </script>
</body>
</html>