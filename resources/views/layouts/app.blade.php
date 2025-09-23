<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title', 'BarberShop - Sistema de Gerenciamento')</title>
  
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <link rel="stylesheet" href="{{asset('css/app.css')}}">
  <link rel="stylesheet" href="{{asset('css/header.css')}}">
  <link rel="stylesheet" href="{{asset('css/sidebar.css')}}">
  <link rel="stylesheet" href="{{ asset('css/searchable-select.css') }}">

  @stack('styles')
</head>
<body>
  <!-- Sidebar Overlay -->
  <div class="sidebar-overlay" id="sidebarOverlay"></div>
  
  @include('partials.header')

  <!-- Removendo botão duplicado de modo dark -->

  @include('partials.sidebar')

  <div class="main-content">
      @yield('content')
  </div>

  <!-- Bootstrap 5 JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="{{asset('js/app.js')}}"></script>
  <script src="{{asset('js/header.js')}}"></script>
  <script src="{{asset('js/sidebar.js')}}"></script>
  <script src="{{ asset('js/searchable-select.js') }}"></script>

  @stack('scripts')
</body>
</html>
