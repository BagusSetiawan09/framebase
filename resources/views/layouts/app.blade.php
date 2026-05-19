<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'FrameBase - Agensi Visual Profesional')</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body { 
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif; 
        }
    </style>
</head>
<body class="bg-white antialiased text-gray-900 selection:bg-gray-900 selection:text-white">

    <x-navbar />

    <main>
        @yield('content')
    </main>

    </body>
</html>