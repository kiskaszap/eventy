<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body class="dark:bg-gray-900">
    <x-navbar />
    <section class="bg-gray-50 dark:bg-gray-900 pt-16"> <!-- Added pt-16 for top padding -->
        <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
            <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                        Sign in to your account
                    </h1>
                    <form class="space-y-4 md:space-y-6" action="/login" method="POST">
                        @csrf <!-- Laravel's CSRF protection -->
                        @if (session('message'))
    <div class="mt-4 text-sm text-green-600 bg-green-100 p-3 rounded-lg">
        {{ session('message') }}
    </div>
@endif
                        
                        <!-- Validation Errors -->
                        @if ($errors->any())
                            <div class="bg-red-100 text-red-700 p-4 rounded">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                  


                        
                        <div>
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your email</label>
                            <input type="email" name="email" id="email" placeholder="name@company.com" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                        </div>

                        <div>
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                            <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                        </div>

                        <button type="submit" class="w-full text-white bg-blue-700 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Sign in</button>
                        
                        <div class="flex justify-between items-center">
                            <a href="/forgot-password" class="text-sm text-blue-700  hover:underline">
                                Forgot Password?
                            </a>
                            <a href="/register" class="text-sm text-blue-700 hover:underline dark:text-primary-500">
                                Create an account
                            </a>
                        </div>

                        <div class="relative flex justify-center items-center">
                            <span class="absolute bg-white dark:bg-gray-800 px-2 text-sm text-gray-500">Or</span>
                            <div class="w-full border-t border-gray-300 dark:border-gray-600"></div>
                        </div>

                        <a href="{{ route('google.login') }}" class="w-full flex items-center justify-center bg-white border border-gray-300 hover:bg-gray-100 dark:bg-gray-700 dark:border-gray-600 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 px-4 py-3 rounded-lg focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 text-sm font-medium">
                            <img src="https://www.svgrepo.com/show/303108/google-icon-logo.svg" alt="Google Logo" class="h-5 w-5 mr-2">
                            Continue with Google
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
