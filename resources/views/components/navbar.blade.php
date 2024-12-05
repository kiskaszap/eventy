<nav class="bg-white border-gray-200 dark:bg-gray-900">
  <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
    <a href="/" class="flex items-center space-x-3 rtl:space-x-reverse">
      <img src="{{ asset('images/logo-eventy.png') }}" class="h-24" alt="Logo" />
      <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Eventy</span>
    </a>
    <div class="flex md:order-2">
      <!-- Hamburger Button -->
      <button
        id="navbar-toggle"
        type="button"
        class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
        aria-controls="navbar-menu"
        aria-expanded="false"
      >
        <span class="sr-only">Toggle navigation</span>
        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
          <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>
    </div>

    <!-- Collapsible Navbar -->
    <div id="navbar-menu" class="hidden md:flex flex-col md:flex-row items-center justify-between w-full md:w-auto">
      <ul class="flex flex-col md:flex-row md:space-x-8 md:mt-0 font-medium p-4 md:p-0 border border-gray-100 md:border-0 rounded-lg bg-gray-50 md:bg-transparent dark:bg-gray-800 md:dark:bg-transparent dark:border-gray-700">
        <li>
          <a
            href="/"
            class="block py-2 px-3 rounded {{ request()->is('/') ? 'text-white bg-blue-700 md:text-blue-700 md:bg-transparent md:dark:text-blue-500' : 'text-gray-900 hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent' }}"
          >
            Home
          </a>
        </li>
        
     
        <li>
          <a
            href="/login"
            class="block py-2 px-3 rounded {{ request()->is('login') ? 'text-white bg-blue-700 md:text-blue-700 md:bg-transparent md:dark:text-blue-500' : 'text-gray-900 hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent' }}"
          >
            Login
          </a>
        </li>
        <li>
          <a
            href="/register"
            class="block py-2 px-3 rounded {{ request()->is('register') ? 'text-white bg-blue-700 md:text-blue-700 md:bg-transparent md:dark:text-blue-500' : 'text-gray-900 hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent' }}"
          >
            Register
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- JavaScript for Toggle -->
<script>
  const navbarToggle = document.getElementById('navbar-toggle');
  const navbarMenu = document.getElementById('navbar-menu');

  navbarToggle.addEventListener('click', () => {
    navbarMenu.classList.toggle('hidden');
  });
</script>
