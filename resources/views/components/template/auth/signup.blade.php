<!DOCTYPE html>
<html>
<head>
    <title>Welcome to EDPLAN - Signup Confirmation</title>
</head>
<body>
    <h1>Hello, {{ $user->name }}!</h1>
    <p>Thank you for signing up for our application. Your account has been successfully created.</p>
    <p>Below are your sign in credentials:</p>
    <p>Username/Email: </p>{{ $user->email }}
    <p>Password: </p>
    <p>If you have any questions or need assistance, please feel free to contact our support team.</p>
    <p>c.nkunze@lgfug.org</p>
</body>
</html>
