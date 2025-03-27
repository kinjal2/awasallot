<!-- resources/views/errors/403.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 Forbidden</title>
</head>
<body>
    <h1>Access Denied</h1>
    <p>{{ session('error') ?? 'You do not have permission to access this resource.' }}</p>
    <a href="{{ url('/') }}">Go to Homepage</a>
</body>
</html>
