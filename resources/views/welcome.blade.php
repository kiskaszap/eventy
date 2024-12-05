<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    

        <title>Eventy</title>
       
        <link href="{{ mix('css/app.css') }}" rel="stylesheet">


    </head>
    <body class=" h-full bg-gray-900">
        

    <x-navbar />
    <section class="px-2 py-5 bg-gray-900 md:px-0">
  <div class="container items-center max-w-6xl px-8 mx-auto xl:px-5">
    <div class="flex flex-wrap items-center sm:-mx-3">
      <div class="w-full md:w-1/2 md:px-3">
        <div class="w-full pb-6 space-y-6 sm:max-w-md lg:max-w-lg md:space-y-4 lg:space-y-8 xl:space-y-9 sm:pr-5 lg:pr-0 md:pb-0">
          <h1 class="text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl md:text-4xl lg:text-5xl xl:text-6xl">
            <span class="block xl:inline text-blue-700">Best App For</span>
            <span class="block text-blue-700 xl:inline">Booking Events</span>
          </h1>
          <p class="mx-auto text-base text-gray-500 sm:max-w-md lg:text-xl md:max-w-3xl">Simplify your event planning with Eventy, the ultimate event management platform. Discover, book, and manage events with ease. Whether it's a wedding, conference, or party, we've got you covered. Start planning your perfect event today! </p>
          <div class="relative flex flex-col sm:flex-row sm:space-x-4">
            <a href= "{{route('login') }}" class="flex items-center w-full px-6 py-3 mb-3 text-lg text-white bg-blue-700 rounded-md sm:mb-0 hover:bg-indigo-700 sm:w-auto">
              Book Now
              <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </a>
           
          </div>
        </div>
      </div>
      <div class="w-full md:w-1/2">
        <div class="w-full h-auto overflow-hidden rounded-md shadow-xl sm:rounded-xl">
            <img src= "{{asset('images/events.jpg') }}">
          </div>
      </div>
    </div>
  </div>
</section>
    </body>
</html>
