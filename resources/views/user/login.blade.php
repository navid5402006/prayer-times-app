@section('title', 'Login')
@section('description', 'Login to your account')
@section('keywords', 'login, sign in, account')
@section('robot', 'index, follow')
@section('googlebot', 'index, follow')
@section('meta_image', asset('images/default-profile.jpg'))
@include('header')

<style>
    .auth-card {
        background: white;
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        max-width: 450px;
        margin: 0 auto;
    }
    
    .auth-title {
        font-size: 1.8rem;
        font-weight: 600;
        margin-bottom: 10px;
        color: #2E8B57;
    }
    
    .form-control {
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        padding: 12px 15px;
    }
    
    .form-control:focus {
        border-color: #2E8B57;
        box-shadow: 0 0 0 3px rgba(46, 139, 86, 0.1);
    }
    
    .btn-primary {
        background: #2E8B57;
        border-color: #2E8B57;
        padding: 12px;
        border-radius: 10px;
        font-weight: 600;
    }
    
    .btn-primary:hover {
        background: #1B5E20;
        border-color: #1B5E20;
    }
</style>

<section class="section bg-light" style="min-height: calc(100vh - 400px);">
    <div class="container">
        <div class="auth-card">
            <h2 class="auth-title text-center">Welcome Back</h2>
            <p class="text-center text-muted mb-4">Login to your account</p>
            
            @if(session('info'))
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    {{ session('info') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            <form action="" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <input type="email" class="form-control" name="email" placeholder="Enter your email" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" placeholder="Enter your password" required>
                </div>
                
                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
            
            <div class="text-center mt-4">
                <p class="text-muted">Don't have an account? <a href="" class="text-success">Register</a></p>
            </div>
        </div>
    </div>
</section>

@include('footer')