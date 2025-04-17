<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'E-Commerce site')</title>

    <link rel="stylesheet" href="{{ asset('/theme/CSS/style.css') }}">
    <link rel="stylesheet" href="{{ asset('/theme/JS/main.js') }}">
    <!-- Bootstrap JS & jQuery (required for carousel) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    @yield('styleCss')
    <style>
        .small-badge {
            font-size: 10px;
            padding: 2px 5px;
            line-height: 1;
            min-width: 16px;
            height: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transform: translate(-30%, -30%) !important;
            /* Move closer to icon */
        }
        .cart-badge.updated {
            animation: pulse 0.5s;
        }

        @keyframes pulse {
            0% { transform: scale(1); background-color: #ffc107; }
            50% { transform: scale(1.2); background-color: #28a745; }
            100% { transform: scale(1); background-color: #ffc107; }
        }

    </style>
</head>
