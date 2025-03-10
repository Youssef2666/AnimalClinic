<!DOCTYPE html>
<html>
<head>
    <title>Subscription Expired</title>
</head>
<body>
    <h1>Your subscription has expired!</h1>
    <p>Dear {{ $user->name }},</p>
    <p>Your subscription expired on {{ $expireDate }}. Please renew it at your earliest convenience.</p>
    <p>Thank you for choosing our service.</p>
</body>
</html>
