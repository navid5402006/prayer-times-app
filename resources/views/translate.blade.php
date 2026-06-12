<!DOCTYPE html>
<html>
<head>
    <title>Translation Test</title>
</head>
<body>
    @isset($error)
        <div style="color:red; margin-bottom:20px;">
            Error: {{ $error }}
        </div>
    @endisset

    <h2>Original: {{ $original }}</h2>
    <h2>Translated: {{ $translated }}</h2>
    <p>Language: {{ $language ?? 'en' }}</p>
</body>
</html>