<!DOCTYPE html>
<html>
<head>
    <title>Event Booking Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .header {
            background-color: #4caf50;
            color: #ffffff;
            padding: 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 20px;
            color: #333333;
        }
        .content p {
            line-height: 1.6;
            margin-bottom: 15px;
        }
        .content strong {
            color: #4caf50;
        }
        .footer {
            background-color: #f1f1f1;
            padding: 15px;
            text-align: center;
            font-size: 12px;
            color: #666666;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4caf50;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin-top: 20px;
        }
        .button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <h1>Event Booking Confirmation</h1>
        </div>
        
        <!-- Content -->
        <div class="content">
            <p>Hello <strong>{{ $user->name }}</strong>,</p>
            <p>We’re excited to confirm your booking for the event <strong>{{ $event->title }}</strong>!</p>
            <p><strong>Date:</strong> {{ $event->event_date }}</p>
            <p><strong>Time:</strong> {{ $event->start_time }} - {{ $event->end_time }}</p>
            <p><strong>Location:</strong> {{ $event->location }}</p>
            <p><strong>Address:</strong> {{ $event->address }}</p>
            <p>{{ $event->description }}</p>
            <p>We look forward to seeing you there! If you have any questions, feel free to reach out to us.</p>
           
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <p>Thank you for choosing us! If you need any assistance, please contact our support team.</p>
        </div>
    </div>
</body>
</html>
