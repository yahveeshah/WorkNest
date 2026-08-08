<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'WorkNest - Employee Management System')</title>
  <link rel="stylesheet" href="{{ asset('assets/css/theme.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/layout.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  @stack('styles')
</head>
<body>

  <div class="app-wrapper">
    <!-- Sidebar Component -->
    @include('components.sidebar')

    <div class="main-wrapper">
      <!-- Top Navbar Component -->
      @include('components.navbar')

      <!-- Main Page Content -->
      <main class="content">
        @yield('content')
      </main>

      <footer class="footer">
        WorkNest Enterprise System &copy; {{ date('Y') }}. All rights reserved.
      </footer>
    </div>
  </div>

  <script src="{{ asset('assets/js/main.js') }}"></script>
  @stack('scripts')
</body>
</html>
