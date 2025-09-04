<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Booking Confirmation</title>
</head>
<body>
    <h2>Booking Confirmed! 🎉</h2>

    <p>Hi {{ $booking->user->name }},</p>

    <p>Your booking at Mariott Hotel has been confirmed:</p>

    <ul>
        <li><strong>Room:</strong> {{ $booking->room->name }}</li>
        <li><strong>Type:</strong> {{ $booking->room->type }}</li>
        <li><strong>Capacity:</strong> {{ $booking->room->capacity }} person(s)</li>
        <li><strong>Check-in:</strong> {{ \Carbon\Carbon::parse($booking->check_in)->format('M d, Y') }}</li>
        <li><strong>Check-out:</strong> {{ \Carbon\Carbon::parse($booking->check_out)->format('M d, Y') }}</li>
        <li><strong>Total Price:</strong> ${{ number_format($booking->total_price, 2) }}</li>
    </ul>

    <p>Thank you for booking with us. We look forward to your stay!</p>

    <p>— Mariott Hotel Team</p>
</body>
</html>
