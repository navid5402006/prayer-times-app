<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Verify Email - NextPrayerTime</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #2E8B57 0%, #1B5E20 100%);
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            color: white;
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 40px;
        }
        .content h2 {
            color: #333;
            margin-top: 0;
        }
        .button {
            display: inline-block;
            background: #2E8B57;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }
        .footer {
            background: #f9f9f9;
            padding: 20px;
            text-align: center;
            color: #666;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>NextPrayerTime</h1>
        </div>
        <div class="content">
            <h2>Welcome {{ $user->name }}!</h2>
            <p>Thank you for registering at NextPrayerTime. Please verify your email address to complete your registration.</p>
            
            <a href="{{ $url }}" class="button">Verify Email Address</a>
            
            <p>If you did not create an account, no further action is required.</p>
            
            <hr>
            <p style="font-size: 12px; color: #999;">If the button doesn't work, copy and paste this link: <br>{{ $url }}</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} NextPrayerTime. All rights reserved.</p>
            <p>Your Islamic Prayer Time Companion</p>
        </div>
    </div>
</body>
</html>