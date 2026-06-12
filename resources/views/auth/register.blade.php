@section('title', 'Register')
@section('description', 'Create your NextPrayerTime account')
@section('keywords', 'register, sign up, account')
@section('robot', 'index, follow')
@include('header')

<style>
    .auth-card {
        background: white;
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        max-width: 500px;
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
            <h2 class="auth-title text-center">Create Account</h2>
            <p class="text-center text-muted mb-4">Join our Islamic community</p>
            
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <form action="{{ route('user.register.post') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Full Name</label>
                    <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Enter your full name" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Enter your email" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" placeholder="Create a password" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm your password" required>
                </div>
                
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" name="terms" id="terms" required>
                    <label class="form-check-label" for="terms">I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a></label>
                </div>
                
                <button type="submit" class="btn btn-primary w-100">Register</button>
            </form>
            
            <div class="text-center mt-4">
                <p class="text-muted">Already have an account? <a href="{{ route('user.login') }}" class="text-success">Login</a></p>
            </div>
        </div>
    </div>
</section>

@include('footer')