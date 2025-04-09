<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Commercial Freelance - @yield('title', 'Dashboard')</title>
    <!-- Utilisez uniquement une version de Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
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
        }

        .spinner {
            border: 6px solid #f3f3f3;
            border-top: 6px solid #3498db;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
        }

        /* Spinner animation */
        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>

    <div class="flex">
        @include('layouts.navigation')
        <!-- Preloader -->
        <div id="preloader">
            <div class="spinner"></div>
        </div>


        <div class="flex-1 p-6 ml-64">
            @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
            @endif

            @yield('content')

            @stack('scripts')
        </div>
    </div>
    <script>
        window.addEventListener('load', function () {
            const preloader = document.getElementById('preloader');
            preloader.style.opacity = '0';
            preloader.style.visibility = 'hidden';
            preloader.style.transition = 'opacity 0.3s ease';
        });
    </script>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>