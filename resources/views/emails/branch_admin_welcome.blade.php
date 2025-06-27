<!DOCTYPE html>
<html>
<head>
    <title>Welcome to iTestLab</title>
</head>
<body>
    <h2>Hello {{ $name }},</h2>
    <p>You have been added as a Branch Admin on iTestLab!</p>

    <p><strong>Login Info:</strong></p>
    <ul>
        <li>Email: {{ $email }}</li>
        <li>Password: {{ $plainPassword }}</li>
    </ul>

    <p>Please log in and change your password.</p>
    <p>Thank you,<br>iTestLab Team</p>
</body>
</html>
