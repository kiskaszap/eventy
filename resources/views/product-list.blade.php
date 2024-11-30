<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <x-navbar />
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
    @foreach ($events as $event)
        <x-event-card 
            :title="$event->title" 
            :image="$event->image_path" 
            :date="$event->event_date" 
            :startTime="$event->start_time" 
            :endTime="$event->end_time" 
            :location="$event->location" 
        />
    @endforeach
</div>

</body>
</html>