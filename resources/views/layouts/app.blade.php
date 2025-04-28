<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Commercial Freelance - @yield('title', 'Dashboard')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 font-sans">
    <style>
        /* Preloader styles */
        #preloader {
            position: fixed;
            left: 0;
            top: 0;
            z-index: 9999;
            width: 100%;
            height: 100%;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }

        .spinner {
            border: 6px solid #f3f3f3;
            border-top: 6px solid #3498db;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Sidebar styles */
        #sidebar {
            transition: all 0.3s ease-in-out;
            transform: translateX(-100%);
            width: 280px;
        }

        .sidebar-open #sidebar {
            transform: translateX(0);
        }

        /* Mobile overlay */
        #sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 40;
        }

        .sidebar-open #sidebar-overlay {
            display: block;
        }

        /* Responsive adjustments */
        @media (min-width: 1024px) {
            #sidebar {
                transform: translateX(0);
                width: 280px;
            }

            .main-content {
                margin-left: 280px;
            }

            #sidebar-overlay {
                display: none !important;
            }
        }

        /* Collapsed state styles */
        .sidebar-collapsed #sidebar {
            width: 80px;
        }

        .sidebar-collapsed .menu-text,
        .sidebar-collapsed #brandText {
            opacity: 0;
            position: absolute;
        }

        .sidebar-collapsed .main-content {
            margin-left: 80px;
        }

        .sidebar-collapsed #toggleSidebar i {
            transform: rotate(180deg);
        }
    </style>

    <!-- Preloader -->
    <div id="preloader">
        <div class="spinner"></div>
    </div>

    <div class="min-h-screen">
        <!-- Sidebar Overlay (Mobile) -->
        <div id="sidebar-overlay" class="lg:hidden"></div>

        <!-- Sidebar -->
        <nav id="sidebar"
            class="fixed top-0 left-0 h-full bg-gray-900 text-gray-100 p-5 flex flex-col z-50 border-r border-gray-700">
            <!-- Toggle Button -->
            <button id="toggleSidebar"
                class="text-gray-300 hover:text-white mb-8 focus:outline-none self-end transition-all duration-200">
                <i class="fas fa-chevron-left text-xl"></i>
            </button>

            <!-- Logo/Brand -->
            <div class="mb-10 flex items-center space-x-3 px-2">
                <span id="brandText" class="text-2xl font-semibold tracking-tight transition-all duration-200">Adlab
                    Hub</span>
            </div>

            <!-- Navigation Menu -->
            <ul class="space-y-2 flex-1 overflow-y-auto">
                <li>
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center px-4 py-3 rounded-lg hover:bg-gray-800 hover:text-indigo-300 transition-colors duration-200 group">
                        <i
                            class="fas fa-tachometer-alt text-lg w-6 text-center text-gray-400 group-hover:text-indigo-300"></i>
                        <span class="ml-3 menu-text font-medium transition-all duration-200">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('contacts.index') }}"
                        class="flex items-center px-4 py-3 rounded-lg hover:bg-gray-800 hover:text-indigo-300 transition-colors duration-200 group">
                        <i
                            class="fas fa-address-book text-lg w-6 text-center text-gray-400 group-hover:text-indigo-300"></i>
                        <span class="ml-3 menu-text font-medium transition-all duration-200">Contacts</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('rdvs.index') }}"
                        class="flex items-center px-4 py-3 rounded-lg hover:bg-gray-800 hover:text-indigo-300 transition-colors duration-200 group">
                        <i
                            class="fas fa-calendar-alt text-lg w-6 text-center text-gray-400 group-hover:text-indigo-300"></i>
                        <span class="ml-3 menu-text font-medium transition-all duration-200">Rendez-vous</span>
                    </a>
                </li>

                @role('Super Admin')
                <li class="pt-4 mt-4 border-t border-gray-800">
                    <span
                        class="text-xs uppercase tracking-wider text-gray-500 px-4 mb-2 block menu-text transition-all duration-200">Administration</span>
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('plans.index') }}"
                                class="flex items-center px-4 py-3 rounded-lg hover:bg-gray-800 hover:text-indigo-300 transition-colors duration-200 group">
                                <i
                                    class="fas fa-layer-group text-lg w-6 text-center text-gray-400 group-hover:text-indigo-300"></i>
                                <span class="ml-3 menu-text transition-all duration-200">Plans</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.data') }}"
                                class="flex items-center px-4 py-3 rounded-lg hover:bg-gray-800 hover:text-indigo-300 transition-colors duration-200 group">
                                <i
                                    class="fas fa-database text-lg w-6 text-center text-gray-400 group-hover:text-indigo-300"></i>
                                <span class="ml-3 menu-text transition-all duration-200">Data</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('users.index') }}"
                                class="flex items-center px-4 py-3 rounded-lg hover:bg-gray-800 hover:text-indigo-300 transition-colors duration-200 group">
                                <i
                                    class="fas fa-users-cog text-lg w-6 text-center text-gray-400 group-hover:text-indigo-300"></i>
                                <span class="ml-3 menu-text transition-all duration-200">Utilisateurs</span>
                            </a>
                        </li>
                    </ul>
                </li>
                @endrole

                <!-- Other role sections... -->
            </ul>

            <!-- Authentication Buttons -->
            <div class="mt-auto pt-4 border-t border-gray-800">
                @auth
                <a href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    class="flex items-center px-4 py-3 rounded-lg hover:bg-gray-800 hover:text-red-400 transition-colors duration-200 group">
                    <i class="fas fa-sign-out-alt text-lg w-6 text-center text-gray-400 group-hover:text-red-400"></i>
                    <span class="ml-3 menu-text transition-all duration-200">Déconnexion</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
                @else
                <a href="{{ route('login') }}"
                    class="flex items-center px-4 py-3 rounded-lg hover:bg-gray-800 hover:text-blue-400 transition-colors duration-200 group">
                    <i class="fas fa-sign-in-alt text-lg w-6 text-center text-gray-400 group-hover:text-blue-400"></i>
                    <span class="ml-3 menu-text transition-all duration-200">Connexion</span>
                </a>
                @endauth
            </div>
        </nav>

        <!-- Main Content -->
        <div class="main-content transition-all duration-300">
            <!-- Mobile Header -->
            <header class="lg:hidden bg-gray-800 text-white p-4 flex items-center justify-between sticky top-0 z-40">
                <button id="mobileSidebarToggle" class="p-2 focus:outline-none">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <h1 class="text-xl font-semibold">@yield('title', 'Dashboard')</h1>
                <div class="w-10"></div> <!-- Spacer for balance -->
            </header>

            <div class="p-6">
                @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const body = document.body;
            const preloader = document.getElementById('preloader');
            const sidebar = document.getElementById('sidebar');
            const mobileToggle = document.getElementById('mobileSidebarToggle');
            const desktopToggle = document.getElementById('toggleSidebar');
            const overlay = document.getElementById('sidebar-overlay');

            // Hide preloader when page loads
            window.addEventListener('load', function() {
                preloader.style.opacity = '0';
                preloader.style.visibility = 'hidden';
            });

            // Mobile sidebar toggle
            if (mobileToggle) {
                mobileToggle.addEventListener('click', function() {
                    body.classList.toggle('sidebar-open');
                });
            }

            // Desktop sidebar toggle (collapse/expand)
            if (desktopToggle) {
                desktopToggle.addEventListener('click', function() {
                    body.classList.toggle('sidebar-collapsed');
                    // Save state to localStorage
                    localStorage.setItem('sidebarCollapsed', body.classList.contains('sidebar-collapsed'));
                });
            }

            // Close sidebar when clicking on overlay
            if (overlay) {
                overlay.addEventListener('click', function() {
                    body.classList.remove('sidebar-open');
                });
            }

            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', function(event) {
                if (window.innerWidth < 1024 && !sidebar.contains(event.target) &&
                    event.target !== mobileToggle && !mobileToggle.contains(event.target)) {
                    body.classList.remove('sidebar-open');
                }
            });

            // Check for saved collapsed state
            if (localStorage.getItem('sidebarCollapsed') === 'true') {
                body.classList.add('sidebar-collapsed');
            }

            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 1024) {
                    body.classList.remove('sidebar-open');
                }
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>