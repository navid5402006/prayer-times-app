<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Blog | IslamicPrayerTimes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- CKEditor CDN -->
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
    <style>
        /* Same CSS as in blog_index.blade.php */
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
        
        /* Rich text editor customization */
        .ck-editor {
            border-radius: 8px;
            overflow: hidden;
        }
        
        .ck-editor__editable {
            min-height: 300px;
            border-radius: 0 0 8px 8px !important;
        }
        
        .ck-toolbar {
            border-radius: 8px 8px 0 0 !important;
            background-color: #f8f9fa !important;
            border-bottom: 1px solid #ddd !important;
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
                <li class="active">
                    <a href="{{ url('/admin/blog-categories') }}">
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
                        <h2 class="mb-4">Edit Blog</h2>
                    </div>
                </div>

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="row">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Edit Blog Article</h5>
                            </div>
                            <div class="card-body">
                                <form id="editBlogForm" action="{{ route('admin.blogs.update', $blog->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label for="blogTitle" class="form-label">Article Title</label>
                                        <input type="text" class="form-control" id="blogTitle" name="title" value="{{ old('title', $blog->title) }}" placeholder="Enter article title" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="blogContent" class="form-label">Article Content</label>
                                        <textarea class="form-control" id="blogContent" name="content" rows="10" required>{{ old('content', $blog->content) }}</textarea>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="blogExcerpt" class="form-label">Short Excerpt</label>
                                        <textarea class="form-control" id="blogExcerpt" name="excerpt" rows="3" placeholder="Brief description of the article">{{ old('excerpt', $blog->excerpt) }}</textarea>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="mb-0">Publish</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="blogStatus" class="form-label">Status</label>
                                    <select class="form-select" id="blogStatus" name="status" form="editBlogForm" required>
                                        <option value="draft" {{ old('status', $blog->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                                        <option value="published" {{ old('status', $blog->status) == 'published' ? 'selected' : '' }}>Published</option>
                                    </select>
                                </div>
                                <div class="d-grid gap-2">
                                    <button type="submit" form="editBlogForm" class="btn btn-primary">Update</button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="mb-0">Categories</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <select class="form-select" id="blogCategory" name="category_id" form="editBlogForm" required>
                                        @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $blog->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="mb-0">Tags</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <select class="form-select" id="blogTags" name="tags[]" form="editBlogForm" multiple>
                                        @foreach($tags as $tag)
                                        <option value="{{ $tag->id }}" {{ in_array($tag->id, old('tags', $blog->tags->pluck('id')->toArray())) ? 'selected' : '' }}>{{ $tag->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="mb-0">Featured Image</h6>
                            </div>
                            <div class="card-body">
                                @if($blog->image)
                                <div class="mb-3">
                                    <img src="{{ Storage::url($blog->image) }}" class="img-fluid rounded mb-2" alt="Current image">
                                </div>
                                @endif
                                <div class="mb-3">
                                    <input class="form-control" type="file" id="blogImage" name="image" form="editBlogForm">
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="featuredArticle" name="featured" value="1" {{ old('featured', $blog->featured) ? 'checked' : '' }} form="editBlogForm">
                                    <label class="form-check-label" for="featuredArticle">Feature this article</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        // Sidebar toggle functionality
        document.getElementById('sidebarCollapse').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
            document.getElementById('content').classList.toggle('active');
        });
        
        // Initialize tag selection
        $(document).ready(function() {
            $('#blogTags').select2({
                placeholder: "Select tags...",
                allowClear: true
            });
            
            // Initialize CKEditor for the blog content
            CKEDITOR.replace('blogContent', {
                toolbar: [
                    { name: 'document', items: ['Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates'] },
                    { name: 'clipboard', items: ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo'] },
                    { name: 'editing', items: ['Find', 'Replace', '-', 'SelectAll', '-', 'Scayt'] },
                    { name: 'forms', items: ['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField'] },
                    '/',
                    { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'CopyFormatting', 'RemoveFormat'] },
                    { name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl'] },
                    { name: 'links', items: ['Link', 'Unlink', 'Anchor'] },
                    { name: 'insert', items: ['Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe'] },
                    '/',
                    { name: 'styles', items: ['Styles', 'Format', 'Font', 'FontSize'] },
                    { name: 'colors', items: ['TextColor', 'BGColor'] },
                    { name: 'tools', items: ['Maximize', 'ShowBlocks'] },
                    { name: 'about', items: ['About'] }
                ],
                height: 400,
                removeButtons: '',
                format_tags: 'p;h1;h2;h3;h4;h5;h6;pre;address;div',
                // Using only standard plugins that are available
                removePlugins: 'resize,elementspath,magicline',
                uiColor: '#f8f9fa',
                // Remove any plugins that might cause issues
                extraPlugins: '',
                // Ensure we're only using standard toolbar items
                allowedContent: true,
                // Basic font settings
                font_names: 'Arial/Arial, Helvetica, sans-serif;' +
                           'Times New Roman/Times New Roman, Times, serif;' +
                           'Verdana;' +
                           'Courier New/Courier New, Courier, monospace;' +
                           'Georgia;' +
                           'Trebuchet MS;' +
                           'Comic Sans MS;' +
                           'Impact;' +
                           'Tahoma'
            });
            
            // Update form with CKEditor content before submission
            $('#editBlogForm').on('submit', function() {
                for (var instance in CKEDITOR.instances) {
                    CKEDITOR.instances[instance].updateElement();
                }
            });
        });
    </script>
</body>
</html>