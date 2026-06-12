<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Categories | IslamicPrayerTimes</title>
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
                    <a href="dashboard.html">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="blogs.html">
                        <i class="fas fa-blog"></i> Blog Management
                    </a>
                </li>
                <li class="active">
                    <a href="blog-categories.html">
                        <i class="fas fa-folder"></i> Blog Categories
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
                        <h2 class="mb-4">Blog Categories Management</h2>
                    </div>
                </div>

                <!-- Add New Category Form -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Add New Category</h5>
                            </div>
                            <div class="card-body">
                                <form id="addCategoryForm">
                                    <div class="mb-3">
                                        <label for="categoryName" class="form-label">Category Name</label>
                                        <input type="text" class="form-control" id="categoryName" placeholder="Enter category name" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="categorySlug" class="form-label">Category Slug</label>
                                        <input type="text" class="form-control" id="categorySlug" placeholder="URL-friendly slug">
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="categoryDescription" class="form-label">Description</label>
                                        <textarea class="form-control" id="categoryDescription" rows="3" placeholder="Brief description of the category"></textarea>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="categoryStatus" class="form-label">Status</label>
                                        <select class="form-select" id="categoryStatus" required>
                                            <option value="active" selected>Active</option>
                                            <option value="inactive">Inactive</option>
                                        </select>
                                    </div>
                                    
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-plus-circle me-2"></i> Add Category
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Categories Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <strong>About Blog Categories</strong>
                                    <p class="mb-0 mt-2">Categories help organize your blog content into logical groups. Each blog post can be assigned to one category, making it easier for visitors to find related content.</p>
                                </div>
                                
                                <div class="mt-4">
                                    <h6><i class="fas fa-lightbulb me-2 text-warning"></i> Best Practices</h6>
                                    <ul class="ps-3">
                                        <li>Keep category names clear and descriptive</li>
                                        <li>Limit the number of categories for better organization</li>
                                        <li>Use slugs that are URL-friendly (lowercase, hyphens instead of spaces)</li>
                                        <li>Inactive categories won't be shown on the website</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Categories List -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Blog Categories</h5>
                                <div class="d-flex">
                                    <input type="text" class="form-control me-2" placeholder="Search categories...">
                                    <button class="btn btn-primary"><i class="fas fa-search me-2"></i> Search</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Slug</th>
                                                <th>Description</th>
                                                <th>Posts</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Prayer</td>
                                                <td>prayer</td>
                                                <td>Articles about Islamic prayers and their significance</td>
                                                <td>12</td>
                                                <td><span class="badge bg-success">Active</span></td>
                                                <td>
                                                    <button class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></button>
                                                    <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Quran</td>
                                                <td>quran</td>
                                                <td>Teachings and explanations from the Holy Quran</td>
                                                <td>8</td>
                                                <td><span class="badge bg-success">Active</span></td>
                                                <td>
                                                    <button class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></button>
                                                    <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Ramadan</td>
                                                <td>ramadan</td>
                                                <td>Articles related to Ramadan and fasting</td>
                                                <td>5</td>
                                                <td><span class="badge bg-success">Active</span></td>
                                                <td>
                                                    <button class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></button>
                                                    <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Community</td>
                                                <td>community</td>
                                                <td>Islamic community events and activities</td>
                                                <td>7</td>
                                                <td><span class="badge bg-success">Active</span></td>
                                                <td>
                                                    <button class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></button>
                                                    <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Spirituality</td>
                                                <td>spirituality</td>
                                                <td>Islamic spiritual growth and development</td>
                                                <td>10</td>
                                                <td><span class="badge bg-success">Active</span></td>
                                                <td>
                                                    <button class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></button>
                                                    <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>History</td>
                                                <td>history</td>
                                                <td>Islamic history and historical events</td>
                                                <td>3</td>
                                                <td><span class="badge bg-secondary">Inactive</span></td>
                                                <td>
                                                    <button class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></button>
                                                    <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                
                                <!-- Pagination -->
                                <nav aria-label="Page navigation">
                                    <ul class="pagination justify-content-center">
                                        <li class="page-item disabled">
                                            <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                                        </li>
                                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                                        <li class="page-item">
                                            <a class="page-link" href="#">Next</a>
                                        </li>
                                    </ul>
                                </nav>
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
        
        // Simulate form submission
        document.getElementById('addCategoryForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const categoryName = document.getElementById('categoryName').value;
            if (!categoryName) {
                alert('Please enter a category name');
                return;
            }
            
            alert('Category "' + categoryName + '" has been added successfully!');
            this.reset();
        });
        
        // Auto-generate slug from category name
        document.getElementById('categoryName').addEventListener('blur', function() {
            const slugField = document.getElementById('categorySlug');
            if (!slugField.value) {
                const slug = this.value.toLowerCase()
                    .replace(/\s+/g, '-')           // Replace spaces with -
                    .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
                    .replace(/\-\-+/g, '-')         // Replace multiple - with single -
                    .replace(/^-+/, '')             // Trim - from start of text
                    .replace(/-+$/, '');            // Trim - from end of text
                slugField.value = slug;
            }
        });
    </script>
</body>
</html>