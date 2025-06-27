<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Welcome Email</title>
</head>
<body>
    <h2>Hello {{ $name }},</h2>
    <p>Welcome to iTestLab! 🎉</p>
    <p>You have been added as a <strong>{{ ucfirst($role) }}</strong>. Here are your login credentials:</p>
    <ul>
        <li><strong>Email:</strong> {{ $email }}</li>
        <li><strong>Password:</strong> {{ $password }}</li>
    </ul>
    <p>Please change your password after logging in.</p>
    <p>Regards,<br>iTestLab Team</p>
</body>
</html>
