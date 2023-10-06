<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="{{ asset('css/google-fonts.css') }}">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Sidebar -->
            <aside class="bg-gray-800 text-white w-48 min-h-screen fixed top-16">
                <!-- Sidebar Content Goes Here -->
                <div class="p-4">
                    <!-- Sidebar Logo -->
                    <div class="text-2xl font-semibold">{{ __('Admin Page') }}</div>

                    <!-- Sidebar Links -->
                    <ul class="mt-6">
                        <li class="mb-2">
                            <a href="{{ route('books.index') }}" class="text-gray-300 hover:text-white">{{ __('Books') }}</a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('users.index') }}" class="text-gray-300 hover:text-white">{{ __('Users') }}</a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('orders.all') }}" class="text-gray-300 hover:text-white">{{ __('Orders') }}</a>
                        </li>
                        <!-- Add more sidebar links as needed -->
                    </ul>
                </div>
            </aside>

            <div class="max-w-full pt-16" style="display:inline-block;padding-left:220px;width:100vw;">
                <!-- Page Heading -->
                <header class="bg-white shadow max-w-full">
                    <div class="max-w-full mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header ?? '' }}
                    </div>
                </header>

                <!-- Page Content -->
                <main class="max-w-full">
                    {{ $slot ?? '' }}
                </main>
            </div>
        </div>
    </body>
</html>
