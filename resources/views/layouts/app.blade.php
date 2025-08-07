<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            :root {
                --primary-blue: #033DFF;
                --hover-gray: #1C1C1C;
                --dark-bg: #0F172A;
                --dark-card: #1E293B;
                --dark-border: #334155;
            }
            
            body {
                background-color: #f1f1f1ff;
                color: #F8FAFC;
            }
            
            .btn-primary {
                background-color: var(--primary-blue);
                margin-left: .2em;
                margin-right: .2em;
                color: white;
                transition: all 0.3s ease;
            }

            .btn-danger {
                background-color: #C71A1A;
                color: white;
                transition: all 0.3s ease;
            }

            input, textarea, .text-status {
                color: #1c1c1cbe;
            }

            .modal-shadow {
                box-shadow: 0px 10px 15px -3px rgba(0,0,0,0.1);
            }

            .text-pending {
                color: #FFAC00;
            }
            .text-completed {
                color: #28C71A;
            }
            .text-incompleted {
                color: #C71A1A;
            }
            
            .btn-primary:hover {
                background-color: var(--hover-gray);
                color: white;
            }
            .btn-danger:hover {
                background-color: #0F172A;
                color: white;
                transition: all 0.3s ease;
            }
            
            .dark-card {
                background-color: var(--dark-card);
                border-color: var(--dark-border);
                color: #F8FAFC;
            }
            
            .dark-input {
                background-color: var(--dark-card);
                border-color: var(--dark-border);
                color: #F8FAFC;
            }
            
            .dark-input:focus {
                border-color: var(--primary-blue);
                box-shadow: 0 0 0 3px rgba(3, 61, 255, 0.1);
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-slate-900 text-slate-100">
        <div class="min-h-screen bg-slate-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-slate-800 shadow border-b border-slate-700">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>

