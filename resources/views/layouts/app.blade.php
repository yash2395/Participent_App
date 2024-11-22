<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Participent App')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* Add your custom styles here */
        body {
            padding-top: 20px;
        }
        .error {
            color: red;
            font-size: 0.875rem;
            margin-top: 5px;
        }
    </style>

    @stack('styles') <!-- For page-specific styles -->
</head>
<body>

    <div class="container">
        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="{{ url('/') }}">Participent App</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('participent.create') }}">Create Participent</a>
                    </li>
                    <!-- Add more navigation links as needed -->
                </ul>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="content mt-4">
            @yield('content') <!-- Page-specific content goes here -->
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-light text-center py-3">
        <p>&copy; {{ date('Y') }} Participent App. All Rights Reserved.</p>
    </footer>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>

    @stack('scripts') <!-- For page-specific scripts -->
</body>
</html>
