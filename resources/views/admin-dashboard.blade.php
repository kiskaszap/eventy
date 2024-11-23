<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script>
        function loadContent(contentId) {
            // Hide all components
            document.querySelectorAll('.content').forEach(content => {
                content.style.display = 'none';
            });
            // Show the selected component
            document.getElementById(contentId).style.display = 'block';
        }
    </script>
</head>
<body class="flex bg-gray-900">

    <!-- Sidebar -->
    <aside id="default-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen bg-gray-800">
        <div class="h-full px-3 py-4 overflow-y-auto">
            <ul class="space-y-2 font-medium">
                <li>
                    <div class="flex items-center p-2 cursor-pointer hover:text-gray-900 text-white rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <i class="fas fa-calendar"></i>
                        <span class="ms-3">Events</span>
      </div>
                </li>
                <li >
                    <div onclick="loadContent('event-create')" class="flex items-center hover:text-gray-900 p-2 cursor-pointer text-white rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <i class="fas fa-plus-circle"></i>
                        <span class="flex-1 ms-3 whitespace-nowrap">Create events</span>
      </div>
      
                </li>
                <li>
                    <div class="flex items-center p-2 cursor-pointer hover:text-gray-900 text-white rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <i class="fas fa-edit"></i>
                        <span class="flex-1 ms-3 whitespace-nowrap">Manage events</span>
      </div>
                </li>
                <li>
                    <div onclick="loadContent('users-list')"  class="flex items-center hover:text-gray-900 p-2 cursor-pointer text-white rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <i class="fas fa-users"></i>
                        <span class="flex-1 ms-3 whitespace-nowrap">Users</span>
      </div>
                </li>
                
                <li>
                    <div class="flex items-center p-2 cursor-pointer text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 hover:text-gray-900 dark:hover:bg-gray-700 group">
                        <i class="fas fa-sign-out-alt text-red-500"></i>
                        <span class="flex-1 ms-3 whitespace-nowrap text-red-500">Sign out</span>
      </div>
                </li>
            </ul>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="ml-64 flex-1 p-4">
    <div id="users-list" class="content">
            <x-users-list />
        </div>

        <!-- Event Create -->
        <div id="event-create" class="content" style="display: none;">
            <x-event-create />
        </div>
    </main>

</body>
</html>
