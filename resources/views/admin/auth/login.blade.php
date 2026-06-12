<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #0d6e6e 0%, #054545 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-box {
            background: white;
            border-radius: 15px;
            padding: 40px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        .login-box h2 {
            color: #0d6e6e;
            text-align: center;
            margin-bottom: 30px;
        }
        .form-control {
            border-radius: 8px;
            padding: 10px 15px;
        }
        .btn-login {
            background: #0d6e6e;
            color: white;
            padding: 10px;
            border-radius: 8px;
            width: 100%;
            border: none;
        }
        .btn-login:hover {
            background: #054545;
        }
        .alert {
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <h2><i class="fas fa-shield-alt"></i> Admin Login</h2>
        
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        
        <form action="{{ route('admin.login.post') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-3">
                <input type="checkbox" name="remember" id="remember">
                <label for="remember"> Remember me</label>
            </div>
            <button type="submit" class="btn-login">Login</button>
        </form>
        
        <div class="text-center mt-3">
            <a href="{{ route('user.login') }}">User Login</a>
        </div>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
</body>
</html>