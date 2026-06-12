@section('title', 'Edit Blog Post')
@section('description', 'Edit your blog post')
@section('keywords', 'edit blog, update post')
@section('robot', 'index, follow')
@section('googlebot', 'index, follow')
@section('meta_image', asset($blog->image ?? 'images/default-profile.jpg'))
@include('header')

<!-- jQuery (required for Summernote) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Summernote CSS & JS -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>

<style>
    :root {
        --primary: #2E8B57;
        --primary-dark: #1B5E20;
        --primary-light: rgba(46, 139, 86, 0.1);
        --dark: #2c3e50;
        --gray: #6c757d;
        --border: #eef2f6;
        --shadow: 0 10px 40px rgba(0,0,0,0.08);
        --shadow-sm: 0 2px 10px rgba(0,0,0,0.05);
    }

    .blog-form-container {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        min-height: calc(100vh - 400px);
        padding: 60px 0;
    }
    
    .form-card {
        background: white;
        border-radius: 28px;
        box-shadow: var(--shadow);
        overflow: hidden;
        transition: transform 0.3s, box-shadow 0.3s;
    }
    
    .form-card:hover {
        box-shadow: 0 20px 50px rgba(46, 139, 86, 0.15);
    }
    
    .form-header {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        padding: 40px;
        color: white;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    
    .form-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: pulse 8s ease-in-out infinite;
    }
    
    @keyframes pulse {
        0%, 100% { transform: scale(1); opacity: 0.5; }
        50% { transform: scale(1.1); opacity: 0.8; }
    }
    
    .form-header h2 {
        font-size: 2rem;
        font-weight: 700;
        margin: 0;
        color: white;
        position: relative;
        z-index: 1;
    }
    
    .form-header p {
        margin: 12px 0 0;
        opacity: 0.9;
        position: relative;
        z-index: 1;
        font-size: 1rem;
    }
    
    .form-body {
        padding: 40px;
    }
    
    .form-label {
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 8px;
        font-size: 0.9rem;
    }
    
    .form-label i {
        color: var(--primary);
        margin-right: 6px;
    }
    
    .form-control, .form-select {
        border-radius: 12px;
        border: 2px solid var(--border);
        padding: 12px 16px;
        transition: all 0.3s;
        font-size: 0.95rem;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 4px var(--primary-light);
        outline: none;
    }
    
    .note-editor.note-frame {
        border-radius: 12px;
        border: 2px solid var(--border);
        transition: all 0.3s;
    }
    
    .note-editor.note-frame:focus-within {
        border-color: var(--primary);
        box-shadow: 0 0 0 4px var(--primary-light);
    }
    
    .note-editor.note-frame .note-toolbar {
        background: #fafbfc;
        border-bottom: 1px solid var(--border);
        border-radius: 10px 10px 0 0;
    }
    
    .current-image {
        margin-top: 12px;
        padding: 12px;
        background: var(--primary-light);
        border-radius: 12px;
        display: inline-block;
        border: 1px solid var(--border);
    }
    
    .current-image small {
        display: block;
        margin-bottom: 8px;
        color: var(--gray);
    }
    
    .current-image img {
        max-width: 120px;
        border-radius: 8px;
        border: 2px solid white;
        box-shadow: var(--shadow-sm);
    }
    
    .btn-submit {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        border: none;
        padding: 14px 32px;
        border-radius: 40px;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s;
        color: white;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    
    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(46, 139, 86, 0.3);
    }
    
    .btn-cancel {
        background: #eef2f6;
        border: none;
        padding: 14px 28px;
        border-radius: 40px;
        font-weight: 600;
        color: #4a5568;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s;
    }
    
    .btn-cancel:hover {
        background: #e2e8f0;
        color: var(--dark);
        transform: translateY(-2px);
    }
    
    .image-preview {
        margin-top: 15px;
        display: none;
    }
    
    .image-preview img {
        max-width: 150px;
        border-radius: 12px;
        border: 2px solid var(--border);
        padding: 4px;
    }
    
    /* Tag Select Styling */
    select[multiple] {
        min-height: 120px;
    }
    
    select[multiple] option {
        padding: 8px 12px;
        border-radius: 6px;
        margin-bottom: 4px;
        transition: all 0.2s;
    }
    
    select[multiple] option:hover {
        background: var(--primary-light);
    }
    
    select[multiple] option:checked {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: white;
    }
    
    /* Toast Notification */
    .toast-notification {
        position: fixed;
        bottom: 30px;
        right: 30px;
        padding: 14px 24px;
        border-radius: 12px;
        color: white;
        font-size: 0.9rem;
        font-weight: 500;
        z-index: 9999;
        animation: slideInRight 0.3s ease;
        box-shadow: 0 5px 20px rgba(0,0,0,0.15);
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .toast-success {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    }
    
    .toast-error {
        background: linear-gradient(135deg, #dc2626, #b91c1c);
    }
    
    @keyframes slideInRight {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    
    @media (max-width: 768px) {
        .form-body {
            padding: 25px;
        }
        
        .form-header {
            padding: 30px;
        }
        
        .form-header h2 {
            font-size: 1.5rem;
        }
        
        .btn-submit, .btn-cancel {
            padding: 12px 24px;
        }
    }
</style>

<div class="blog-form-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="form-card">
                    <div class="form-header">
                        <h2><i class="fas fa-feather-alt me-2"></i> Edit Blog Post</h2>
                        <p>Update and improve your content</p>
                    </div>
                    
                    <div class="form-body">
                        <form id="blogForm" enctype="multipart/form-data" action="{{ route('user.blog.update', $blog->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                <div class="col-md-8 mb-4">
                                    <label class="form-label"><i class="fas fa-heading"></i> Title *</label>
                                    <input type="text" class="form-control" name="title" id="blogTitle" value="{{ $blog->title }}" required placeholder="Enter an engaging title">
                                </div>
                                
                                <div class="col-md-4 mb-4">
                                    <label class="form-label"><i class="fas fa-folder"></i> Category *</label>
                                    <select class="form-select" name="category_id" id="blogCategory" required>
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ $blog->category_id == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label"><i class="fas fa-file-alt"></i> Content *</label>
                                <textarea class="form-control" name="content" id="blogContent" rows="15" required>{{ $blog->content }}</textarea>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label"><i class="fas fa-quote-left"></i> Excerpt (Short Description)</label>
                                <textarea class="form-control" name="excerpt" id="blogExcerpt" rows="3" placeholder="Brief summary of your blog...">{{ $blog->excerpt }}</textarea>
                                <small class="text-muted">This will appear in blog listings and SEO meta description</small>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label class="form-label"><i class="fas fa-image"></i> Change Image</label>
                                    <input type="file" class="form-control" name="image" id="blogImage" accept="image/*">
                                    <small class="text-muted">JPG, PNG or GIF. Max size 2MB. Recommended size: 1200x630px</small>
                                    @if($blog->image)
                                        <div class="current-image">
                                            <small><i class="fas fa-image me-1"></i> Current Image:</small>
                                            <div class="mt-1">
                                                <img src="{{ asset($blog->image) }}" alt="Current">
                                            </div>
                                        </div>
                                    @endif
                                    <div class="image-preview" id="imagePreview">
                                        <img id="previewImg" src="" alt="Preview">
                                        <small class="text-muted mt-1 d-block">New image preview</small>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 mb-4">
                                    <label class="form-label"><i class="fas fa-tags"></i> Tags</label>
                                    <select class="form-select" name="tags[]" id="blogTags" multiple size="4">
                                        @foreach($tags as $tag)
                                            <option value="{{ $tag->id }}" {{ $blog->tags->contains($tag->id) ? 'selected' : '' }}>
                                                {{ $tag->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted">Hold Ctrl/Cmd to select multiple tags</small>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label"><i class="fas fa-globe"></i> Status</label>
                                <select class="form-select" name="status" id="blogStatus">
                                    <option value="draft" {{ $blog->status == 'draft' ? 'selected' : '' }}>📝 Save as Draft</option>
                                    <option value="published" {{ $blog->status == 'published' ? 'selected' : '' }}>🚀 Publish Now</option>
                                </select>
                            </div>
                            
                            <div class="alert alert-info" style="background: var(--primary-light); border-left: 4px solid var(--primary);">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Editing Guidelines:</strong>
                                <ul class="mt-2 mb-0">
                                    <li>Ensure your content remains authentic and beneficial</li>
                                    <li>Review for any errors or outdated information</li>
                                    <li>Update references if needed</li>
                                    <li>Preview your changes before publishing</li>
                                </ul>
                            </div>
                            
                            <div class="d-flex gap-3 justify-content-end mt-4">
                                <a href="{{ route('user.dashboard') }}" class="btn-cancel">
                                    <i class="fas fa-times me-2"></i> Cancel
                                </a>
                                <button type="submit" class="btn-submit" id="submitBtn">
                                    <i class="fas fa-save me-2"></i> Update Post
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('footer')

<script>
    // Initialize Summernote after DOM is ready
    $(document).ready(function() {
        $('#blogContent').summernote({
            height: 450,
            placeholder: 'Write your blog content here...',
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['fontname', ['fontname']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ],
            callbacks: {
                onImageUpload: function(files) {
                    uploadImage(files[0]);
                }
            }
        });
    });
    
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    
    // Image upload function for Summernote
    function uploadImage(file) {
        const formData = new FormData();
        formData.append('image', file);
        formData.append('_token', csrfToken);
        
        $.ajax({
            url: '{{ route("blog.upload-image") }}',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(data) {
                $('#blogContent').summernote('insertImage', data.url);
                showToast('Image uploaded successfully!', 'success');
            },
            error: function() {
                showToast('Error uploading image', 'error');
            }
        });
    }
    
    // Image preview for featured image
    const blogImage = document.getElementById('blogImage');
    if (blogImage) {
        blogImage.addEventListener('change', function(e) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const previewImg = document.getElementById('previewImg');
                const imagePreview = document.getElementById('imagePreview');
                if (previewImg) previewImg.src = e.target.result;
                if (imagePreview) imagePreview.style.display = 'block';
            }
            if (e.target.files[0]) {
                reader.readAsDataURL(e.target.files[0]);
            }
        });
    }
    
    // Submit form
    const blogForm = document.getElementById('blogForm');
    if (blogForm) {
        blogForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const content = $('#blogContent').summernote('code');
            formData.set('content', content);
            
            const submitBtn = document.getElementById('submitBtn');
            const originalText = submitBtn.innerHTML;
            
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Updating...';
            submitBtn.disabled = true;
            
            try {
                const response = await fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: formData
                });
                
                const data = await response.json();
                
                if (data.success) {
                    showToast('✨ Blog post updated successfully!', 'success');
                    setTimeout(() => {
                        window.location.href = '{{ route("user.dashboard") }}';
                    }, 1500);
                } else {
                    showToast(data.message || 'Error updating post.', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showToast('Error updating post. Please try again.', 'error');
            } finally {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }
        });
    }
    
    // Toast notification function
    function showToast(message, type) {
        const existingToasts = document.querySelectorAll('.toast-notification');
        existingToasts.forEach(toast => toast.remove());
        
        const toast = document.createElement('div');
        toast.className = `toast-notification toast-${type}`;
        toast.innerHTML = `<i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i><span>${message}</span>`;
        document.body.appendChild(toast);
        
        setTimeout(() => toast.remove(), 3000);
    }
    
    // Set current year
    const yearElement = document.getElementById('currentYear');
    if (yearElement) yearElement.textContent = new Date().getFullYear();
</script>