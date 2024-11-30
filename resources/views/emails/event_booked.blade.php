<!DOCTYPE html>
<html>
<head>
    <title>Event Booking Confirmation</title>
</head>
<body>
    <h1>Thank you for booking the event!</h1>
    <p>Hello {{ $user->name }},</p>
    <p>You have successfully booked the event <strong>{{ $event->title }}</strong>.</p>
    <p><strong>Date:</strong> {{ $event->event_date }}</p>
    <p><strong>Time:</strong> {{ $event->start_time }} - {{ $event->end_time }}</p>
    <p><strong>Location:</strong> {{ $event->location }}</p>
    <p><strong>Address:</strong> {{ $event->address }}</p>
    <p>{{ $event->description }}</p>
    <p>We look forward to seeing you there!</p>
</body>
</html>
