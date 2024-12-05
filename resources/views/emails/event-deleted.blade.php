<!DOCTYPE html>
<html>
<head>
    <title>Event Deleted</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6;">
    <h1>Event Deleted Notification</h1>
    <p>Dear {{ $vendor->name }},</p>

    <p>We want to inform you that the following event has been deleted by an admin:</p>

    <ul>
        <li><strong>Title:</strong> {{ $event->title }}</li>
        <li><strong>Date:</strong> {{ $event->event_date }}</li>
        <li><strong>Location:</strong> {{ $event->location }}</li>
    </ul>

    <p>If you have any questions, feel free to contact support.</p>

    <p>Regards,<br>The Event Management Team</p>
</body>
</html>
