@section('title', 'Write a Blog Post')
@section('description', 'Share your Islamic knowledge with the community')
@section('keywords', 'write blog, create post, share knowledge')
@section('robot', 'index, follow')
@section('googlebot', 'index, follow')
@section('meta_image', asset('images/default-profile.jpg'))
@include('header')

<!-- jQuery (required for Summernote) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Summernote CSS & JS -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    :root {
        --primary-color: #2E8B57;
        --primary-dark: #1B5E20;
        --secondary-color: #f8f9fa;
        --text-dark: #2c3e50;
        --text-muted: #6c757d;
        --border-color: #eef2f6;
    }

    .blog-form-container {
        background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
        min-height: calc(100vh - 400px);
        padding: 60px 0;
    }
    
    .form-card {
        background: white;
        border-radius: 28px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.08);
        overflow: hidden;
        transition: transform 0.3s, box-shadow 0.3s;
    }
    
    .form-card:hover {
        box-shadow: 0 30px 50px rgba(46, 139, 86, 0.12);
    }
    
    .form-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
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
        color: var(--text-dark);
        margin-bottom: 8px;
        font-size: 0.9rem;
    }
    
    .form-label i {
        color: var(--primary-color);
        margin-right: 6px;
    }
    
    .form-control, .form-select {
        border-radius: 12px;
        border: 2px solid var(--border-color);
        padding: 12px 16px;
        transition: all 0.3s;
        font-size: 0.95rem;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 4px rgba(46, 139, 86, 0.1);
        outline: none;
    }
    
    .note-editor.note-frame {
        border-radius: 12px;
        border: 2px solid var(--border-color);
        transition: all 0.3s;
    }
    
    .note-editor.note-frame:focus-within {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 4px rgba(46, 139, 86, 0.1);
    }
    
    .note-editor.note-frame .note-toolbar {
        background: #fafbfc;
        border-bottom: 1px solid var(--border-color);
        border-radius: 10px 10px 0 0;
    }
    
    .guidelines-card {
        background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
        border-radius: 20px;
        padding: 25px;
        border-left: 4px solid var(--primary-color);
        margin: 25px 0;
    }
    
    .guidelines-card h4 {
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 15px;
        color: var(--primary-color);
    }
    
    .guidelines-card ul {
        margin: 0;
        padding-left: 20px;
    }
    
    .guidelines-card li {
        margin-bottom: 10px;
        color: #4a5568;
        font-size: 0.9rem;
        line-height: 1.5;
    }
    
    .btn-submit {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
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
        color: var(--text-dark);
        transform: translateY(-2px);
    }
    
    .image-preview {
        margin-top: 15px;
        display: none;
    }
    
    .image-preview img {
        max-width: 200px;
        border-radius: 12px;
        border: 2px solid var(--border-color);
        padding: 4px;
    }
    
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
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .toast-success { background: linear-gradient(135deg, #2E8B57, #1B5E20); }
    .toast-error { background: linear-gradient(135deg, #dc2626, #b91c1c); }
    
    @keyframes slideInRight {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    
    /* Tag Select Styling */
    select[multiple] {
        min-height: 120px;
    }
    
    select[multiple] option {
        padding: 8px 12px;
        border-radius: 6px;
        margin-bottom: 4px;
    }
    
    select[multiple] option:checked {
        background: var(--primary-color) linear-gradient(0deg, var(--primary-color) 0%, var(--primary-color) 100%);
        color: white;
    }
    
    @media (max-width: 768px) {
        .form-body { padding: 25px; }
        .form-header { padding: 30px; }
        .form-header h2 { font-size: 1.5rem; }
        .btn-submit, .btn-cancel { padding: 12px 24px; }
    }
</style>

<div class="blog-form-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="form-card">
                    <div class="form-header">
                        <h2><i class="fas fa-feather-alt me-2"></i> Write a Blog Post</h2>
                        <p>Share your knowledge and insights with the Islamic community</p>
                    </div>
                    
                    <div class="form-body">
                        <form id="blogForm" enctype="multipart/form-data" action="{{ route('user.blog.store') }}" method="POST">
                            @csrf
                            
                            <div class="row">
                                <div class="col-md-8 mb-4">
                                    <label class="form-label"><i class="fas fa-heading"></i> Title *</label>
                                    <input type="text" class="form-control" name="title" id="blogTitle" required placeholder="Enter an engaging title">
                                </div>
                                
                                <div class="col-md-4 mb-4">
                                    <label class="form-label"><i class="fas fa-folder"></i> Category *</label>
                                    <select class="form-select" name="category_id" id="blogCategory" required>
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label"><i class="fas fa-file-alt"></i> Content *</label>
                                <textarea class="form-control" name="content" id="blogContent" rows="15" required placeholder="Write your blog content here..."></textarea>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label"><i class="fas fa-quote-left"></i> Excerpt (Short Description)</label>
                                <textarea class="form-control" name="excerpt" id="blogExcerpt" rows="3" placeholder="A brief summary of your blog..."></textarea>
                                <small class="text-muted">This will appear in blog listings and SEO meta description</small>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label class="form-label"><i class="fas fa-image"></i> Featured Image</label>
                                    <input type="file" class="form-control" name="image" id="blogImage" accept="image/*">
                                    <small class="text-muted">JPG, PNG or GIF. Max size 2MB. Recommended size: 1200x630px</small>
                                    <div class="image-preview" id="imagePreview">
                                        <img id="previewImg" src="" alt="Preview">
                                    </div>
                                </div>
                                
                                <div class="col-md-6 mb-4">
                                    <label class="form-label"><i class="fas fa-tags"></i> Tags</label>
                                    <select class="form-select" name="tags[]" id="blogTags" multiple size="4">
                                        @foreach($tags as $tag)
                                            <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted">Hold Ctrl/Cmd to select multiple tags</small>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label"><i class="fas fa-globe"></i> Status</label>
                                <select class="form-select" name="status" id="blogStatus">
                                    <option value="draft">📝 Save as Draft</option>
                                    <option value="published">🚀 Publish Now</option>
                                </select>
                            </div>
                            
                            <div class="guidelines-card">
                                <h4><i class="fas fa-info-circle me-2"></i> Content Guidelines</h4>
                                <ul>
                                    <li><i class="fas fa-check-circle text-success me-2"></i> Write authentic and beneficial content for the Muslim community</li>
                                    <li><i class="fas fa-check-circle text-success me-2"></i> Include references from Quran and Hadith when citing Islamic sources</li>
                                    <li><i class="fas fa-check-circle text-success me-2"></i> Keep language respectful and professional</li>
                                    <li><i class="fas fa-check-circle text-success me-2"></i> Proofread before publishing to ensure quality</li>
                                    <li><i class="fas fa-check-circle text-success me-2"></i> Add relevant images to enhance readability</li>
                                    <li><i class="fas fa-check-circle text-success me-2"></i> Use headings and subheadings for better structure</li>
                                </ul>
                            </div>
                            
                            <div class="d-flex gap-3 justify-content-end mt-4">
                                <a href="{{ route('user.dashboard') }}" class="btn-cancel">
                                    <i class="fas fa-times me-2"></i> Cancel
                                </a>
                                <button type="submit" class="btn-submit" id="submitBtn">
                                    <i class="fas fa-paper-plane me-2"></i> Publish Post
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
    
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
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
    
    document.getElementById('blogImage')?.addEventListener('change', function(e) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('previewImg').src = e.target.result;
            document.getElementById('imagePreview').style.display = 'block';
        }
        if (e.target.files[0]) reader.readAsDataURL(e.target.files[0]);
    });
    
  document.getElementById('blogForm')?.addEventListener('submit', async function(e) {
    e.preventDefault();
    
    // Get Summernote content
    const content = $('#blogContent').summernote('code');
    
    // Create FormData
    const formData = new FormData(this);
    
    // Update content in form data
    formData.set('content', content);
    
    const submitBtn = document.getElementById('submitBtn');
    const originalText = submitBtn.innerHTML;
    
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Publishing...';
    submitBtn.disabled = true;
    
    try {
        const response = await fetch('{{ route("user.blog.store") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: formData
        });
        
        const data = await response.json();
        
        if (response.ok && data.success) {
            showToast('✨ Blog post created successfully!', 'success');
            setTimeout(() => window.location.href = data.redirect || '{{ route("user.dashboard") }}', 1500);
        } else {
            // Handle validation errors
            if (response.status === 422) {
                const errors = data.errors;
                let errorMessage = 'Please fix the following errors:\n';
                for (let key in errors) {
                    errorMessage += `- ${errors[key][0]}\n`;
                }
                showToast(errorMessage, 'error');
            } else {
                showToast(data.message || 'Error creating post. Please try again.', 'error');
            }
        }
    } catch (error) {
        console.error('Error:', error);
        showToast('Network error. Please check your connection and try again.', 'error');
    } finally {
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    }
});
    
    function showToast(message, type) {
        const existingToasts = document.querySelectorAll('.toast-notification');
        existingToasts.forEach(toast => toast.remove());
        const toast = document.createElement('div');
        toast.className = `toast-notification toast-${type}`;
        toast.innerHTML = `<i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i><span>${message}</span>`;
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 3000);
    }
    
    document.getElementById('currentYear').textContent = new Date().getFullYear();
</script>